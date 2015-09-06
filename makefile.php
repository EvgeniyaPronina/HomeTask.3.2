<?php
require_once 'connect.php';
$table = $_POST['table'];
$bd = "SELECT * FROM $table";
$result = $connection->query($bd);
$records = $result->fetch_all(MYSQLI_ASSOC);
$connection->close();
//
$format = $_POST['format'];
global $newFileName;
switch ($format) {
    case 'xml':
        // создаем объект документа
        $dom = new DOMDocument('1.0', 'UTF-8');
        // создаем корневой элемент и помещаем его в DOM
        $rootEl = $dom->createElement($table);
        $dom->appendChild($rootEl);
        foreach($records as $record){//создаем элементы - аналог записей в БД
            $elementName = substr($table, 0, strlen($table) - 1);
            $element = $dom->createElement($elementName);
            // создаем поля для каждой записи
            foreach ($record as $key=>$value) {
                if ($key == 'id') {
                    // создаем аттрибут для каждой записи
                    $attr_id = $dom->createAttribute('id');
                    $attr_id->value = $record['id'];
                    $element->appendChild($attr_id);
                }else{
                    $child_element = $dom->createElement($key, $value);
                    $element->appendChild($child_element);
                }
            }
            //добавляем элемент со всеми полями к корневому элементу
            $rootEl->appendChild($element);
        }
        $newFileName = 'files/'.$table.'.xml';
        $dom->save($newFileName);
        break;
    case 'json':
        $newFileName = 'files/'.$table.'.json';
        $content = json_encode($records);
        file_put_contents($newFileName, $content);
        break;
    case 'csv':
        $newFileName = 'files/'.$table.'.csv';
        $csv = fopen($newFileName, 'w');//создали новый файл для записи
        //создаем первую строку с заголовками, как в таблице из БД
        $any_row = $records[0];
        foreach ($any_row as $key=>$value) {
            $table_header[] = $key;
        }
        fputcsv($csv, $table_header, ';');
        //заполняем данными из БД
        foreach ($records as $fields) {
            fputcsv($csv, $fields,';');
        }
        fclose($csv);
        break;
}
function file_force_download($file) {
    if (file_exists($file)) {
        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
        // если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level()) {
            ob_end_clean();
        }
        // заставляем браузер показать окно сохранения файла
        //header('Content-Description: File Transfer');
       // header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        //header('Content-Transfer-Encoding: binary');
       // header('Expires: 0');
        //header('Cache-Control: must-revalidate');
       // header('Pragma: public');
       // header('Content-Length: ' . filesize($file));
        // читаем файл и отправляем его пользователю
        readfile($file);
        exit;
    }
}
file_force_download($newFileName);
?>

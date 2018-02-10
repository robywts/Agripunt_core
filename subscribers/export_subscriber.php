<?php
/*
  Excel export for subscribers
 */
include "../control.inc";

// connect to the database
include("../config.php");

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="subscribers.xls"');
header('Cache-Control: max-age=0');

if (isset($_POST)) {
    $condition = '';
    if (isset($_SESSION['condition']))
        $condition = $_SESSION['condition'];
    $sql_export = "SELECT * FROM subscribers as s where 1=1 $condition";
    $result = mysqli_query($con, $sql_export);

    $spreadsheet = new Spreadsheet();

// Add column headers
    $spreadsheet->getActiveSheet()
        ->setCellValue('A1', 'Name')
        ->setCellValue('B1', 'Email')
        ->setCellValue('C1', 'Subscribed On')->getStyle("A1:C1")->getFont()->setBold(true);
    ;

//Put each record in a new cell
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        ++$i;
        $spreadsheet->getActiveSheet()->setCellValue('A' . $i, $row['name']);
        $spreadsheet->getActiveSheet()->setCellValue('B' . $i, $row['email']);
        $spreadsheet->getActiveSheet()->setCellValue('C' . $i, $row['subscribed_date']);
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
}

?>
<?php
require_once '../Classes/PHPExcel.php';
#require_once '/Classes/PHPExcel/IOFactory.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Articulo');
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'FF0000')) ));


$objPHPExcel->getActiveSheet()->setCellValue('B1', 'REP');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'ALM');

$objPHPExcel->getActiveSheet()->setCellValue('A2', '142424');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 22);
$objPHPExcel->getActiveSheet()->setCellValue('C2', 234);





// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('MON');

// Create a new worksheet, after the default sheet
$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
$objPHPExcel->setActiveSheetIndex(1);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'More data');

// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('ALU');





// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="name_of_file.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
<?php
require_once '../Classes/PHPExcel.php';
#require_once '/Classes/PHPExcel/IOFactory.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Create a first sheet, representing sales data
$objPHPExcel->setActiveSheetIndex(0);




$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);

$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(3);

$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setSize(7);
$objPHPExcel->getActiveSheet()->getStyle('D1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);



$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));

$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));




$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Articulos');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'REP');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'ALM');

$objPHPExcel->getActiveSheet()->setCellValue('D1', 'MON');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'ALU');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'ORE');
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(15);








$objPHPExcel->getActiveSheet()->setCellValue('A2', '14141414/ AVANT-GAR');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 22);
$objPHPExcel->getActiveSheet()->setCellValue('C2', 234);

$objPHPExcel->getActiveSheet()->setCellValue('D2', 3);
$objPHPExcel->getActiveSheet()->setCellValue('E2', 4);
$objPHPExcel->getActiveSheet()->setCellValue('F2', 2);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);

$objPHPExcel->getActiveSheet()->getStyle("A2:F2")->getFont()->setSize(7);
$objPHPExcel->getActiveSheet()->getStyle('D2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->getActiveSheet()->setBreak( 'A10' , PHPExcel_Worksheet::BREAK_ROW );

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('MON');

// Create a new worksheet, after the default sheet
#$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
#$objPHPExcel->setActiveSheetIndex(1);
#$objPHPExcel->getActiveSheet()->setCellValue('A1', 'More data');

// Rename 2nd sheet
#$objPHPExcel->getActiveSheet()->setTitle('ALU');





// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="name_of_file.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
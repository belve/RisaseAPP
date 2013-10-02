<?php
ini_set("memory_limit", "-1");
session_start();
$grid=$_SESSION['grid'];
$anchos=$_SESSION['anchos'];
$align=$_SESSION['align'];
$crang=$_SESSION['crang'];

$debug=0;

require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);

foreach ($grid as $fil => $colums) { foreach ($colums as $col => $val){ 
$cel=$col . $fil;
$objPHPExcel->getActiveSheet()->setCellValue($cel, $val);	
}}


$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(7);

foreach ($anchos as $col => $value) {$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setWidth($value);};
foreach ($align  as $rang => $value) {
	if($value=="C"){$objPHPExcel->getActiveSheet()->getStyle($rang)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);};
}

foreach ($crang  as $rang => $value){$objPHPExcel->getActiveSheet()->getStyle($rang)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => $value)) ));};




$objPHPExcel->getActiveSheet()->setTitle('GRID');


// Redirect output to a client’s web browser (Excel5)
if($debug==0){
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="HVentas.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
}

?>
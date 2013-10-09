<?php
ini_set("memory_limit", "-1");
session_start();
$grid=$_SESSION['grid'];
$anchos=$_SESSION['anchos'];
$align=$_SESSION['align'];
$crang=$_SESSION['crang'];
$Mrang=$_SESSION['Mrang'];
$BTrang=$_SESSION['BTrang'];
$nomfil=$_SESSION['nomfil'];
$format=$_SESSION['format'];

$debug=0;

require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();


$styleArray1 = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$styleArray2 = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);


foreach ($grid as $fil => $colums) { foreach ($colums as $col => $val){ 
$cel=$col . $fil;
$sheet->setCellValue($cel, $val);	
}}


$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(7);

foreach ($anchos as $col => $value) {$sheet->getColumnDimension($col)->setWidth($value);};
foreach ($align  as $rang => $value) {
	if($value=="C"){$sheet->getStyle($rang)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);};
	if($value=="R"){$sheet->getStyle($rang)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);};
}

foreach ($crang  as $rang => $value){$sheet->getStyle($rang)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => $value)) ));};

foreach ($Mrang as $rang => $value) {$sheet->mergeCells($rang);};
foreach ($BTrang as $rang => $value) {
	if($value==1){	
	$sheet->getStyle($rang)->applyFromArray($styleArray1);
	}else{
	$sheet->getStyle($rang)->applyFromArray($styleArray2);	
	}
}

foreach ($format as $rang => $value) {
	if($value==1){$sheet->getStyle($rang)->getNumberFormat()->setFormatCode('0,00 [$€-C0A];[RED]-0,00 [$€-C0A]');};
}


	
$sheet->setTitle('GRID');


// Redirect output to a client’s web browser (Excel5)
if($debug==0){
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $nomfil . '.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->setPreCalculateFormulas(false);
$objWriter->save('php://output');
}

?>
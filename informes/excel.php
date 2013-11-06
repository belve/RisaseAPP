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
$paginas=$_SESSION['paginas'];
$BOLDrang=$_SESSION['BOLDrang'];
if(array_key_exists('angle', $_SESSION)){$angle=$_SESSION['angle'];}else{$angle=array();};
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


$styleArray3 = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_MEDIUM
    )
  )
);


$bold1 = array(
    'font'  => array(
        'bold'  => true,
        'size'  => 10
        )
	);

$bold12 = array(
    'font'  => array(
        'bold'  => true,
        'size'  => 12
        )
	);

$bold120 = array(
    'font'  => array(
        'bold'  => false,
        'size'  => 12
        )
	);



$bold0 = array(
    'font'  => array(
        'bold'  => false,
        'size'  => 10
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
	if($value=="VC"){$sheet->getStyle($rang)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);};
	if($value=="R"){$sheet->getStyle($rang)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);};
	if($value=="L"){$sheet->getStyle($rang)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);};
}

foreach ($crang  as $rang => $value){$sheet->getStyle($rang)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => $value)) ));};

foreach ($angle as $cell => $angulo) {
$sheet->getStyle($cell)->getAlignment()->setTextRotation($angulo);	
}


foreach ($Mrang as $rang => $value) {$sheet->mergeCells($rang);};
foreach ($BTrang as $rang => $value) {
	if($value==1){$sheet->getStyle($rang)->applyFromArray($styleArray1);};
	if($value==2){$sheet->getStyle($rang)->applyFromArray($styleArray2);};
	if($value==3){$sheet->getStyle($rang)->applyFromArray($styleArray3);};
}

foreach ($BOLDrang as $rang => $value) {
	if($value==1){$sheet->getStyle($rang)->applyFromArray($bold1);}
	elseif($value==3){$sheet->getStyle($rang)->applyFromArray($bold12);}
	elseif($value==4){$sheet->getStyle($rang)->applyFromArray($bold120);}
	else{$sheet->getStyle($rang)->applyFromArray($bold0);};};






$for= '#,##0.00_-[$EUR ]';

$for2= '#,##0.00_-[$% ]';

foreach ($format as $rang => $value) {
	if($value==1){$sheet->getStyle($rang)->getNumberFormat()->setFormatCode($for);};
	if($value==2){$sheet->getStyle($rang)->getNumberFormat()->setFormatCode($for2);};
}

foreach ($paginas as $lin => $value) {
$sheet->setBreak( 'A' . $lin , PHPExcel_Worksheet::BREAK_ROW );	
}
	
$sheet->setTitle('GRID');


// Redirect output to a client’s web browser (Excel5)
if($debug==0){

header('Content-Type: application/vnd.ms-excel;  ');
header('Content-Disposition: attachment;filename="' . $nomfil . '.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->setPreCalculateFormulas(false);
$objWriter->save('php://output');
}

?>
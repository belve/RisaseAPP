<?php

set_time_limit(0);
ini_set("memory_limit", "-1");

$debug=0;
################## EXCEL  ###########################




session_start();

$cord=$_SESSION['cord'];
$codigos=$_SESSION['codigos'];
$enviados=$_SESSION['enviados'];
$vendidos=$_SESSION['vendidos'];
$stocks=$_SESSION['stocks'];
$tiendas=$_SESSION['tiendas'];

if($debug==1){print_r($_SESSION);};

$colu[1]='A';
$colu[2]='B';
$colu[3]='C';
$colu[4]='D';
$colu[5]='E';
$colu[6]='F';
$colu[7]='G';
$colu[8]='H';
$colu[9]='I';
$colu[10]='J';
$colu[11]='K';
$colu[12]='L';
$colu[13]='M';
$colu[14]='N';
$colu[15]='O';
$colu[16]='P';
$colu[17]='Q';
$colu[18]='R';
$colu[19]='S';
$colu[20]='T';
$colu[21]='U';
$colu[22]='V';
$colu[23]='W';
$colu[24]='x';
$colu[25]='Y';
$colu[26]='Z';

$colores['F']="00CC66";
$colores['N']="FFFFFF";

$fonts[1]=7;

$anchos['A']=25;
$anchos['B']=3;
$anchos['C']=3;

$anchos['T']=3;



require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);




$numti=count($tiendas);

$count=1;

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth($anchos['A']);


$col=1;
$objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(12);
$objPHPExcel->getActiveSheet()->getStyle('A' . $count)->getFont()->setSize($fonts[1]);
$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, 'Articulo');

foreach ($tiendas as $idt => $nom) {$col++;
$objPHPExcel->getActiveSheet()->getColumnDimension($colu[$col])->setWidth($anchos['B']);
$objPHPExcel->getActiveSheet()->getStyle($colu[$col] . $count)->getFont()->setSize($fonts[1]);
$objPHPExcel->getActiveSheet()->setCellValue($colu[$col] . $count, $nom);	
}
$count++;



ksort($cord); foreach ($cord as $gu => $subs) {ksort($subs); foreach ($subs as $sb => $ccs)	{ksort($ccs); foreach ($ccs as $cd => $codbar) {
	
$objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(12);
$objPHPExcel->getActiveSheet()->getStyle('A'  . $count)->getFont()->setSize($fonts[1]);
$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, $codigos[$codbar]);

$fil=$count+1;
$objPHPExcel->getActiveSheet()->getRowDimension($fil)->setRowHeight(12);
$objPHPExcel->getActiveSheet()->getStyle('A'  . $fil)->getFont()->setSize($fonts[1]);
$objPHPExcel->getActiveSheet()->setCellValue('A' . $fil, 'Vedidos');

$fil=$count+2;
$objPHPExcel->getActiveSheet()->getRowDimension($fil)->setRowHeight(12);
$objPHPExcel->getActiveSheet()->getStyle('A'  . $fil)->getFont()->setSize($fonts[1]);
$objPHPExcel->getActiveSheet()->setCellValue('A' . $fil, 'En tienda');

$fil=$count+3;
$objPHPExcel->getActiveSheet()->getRowDimension($fil)->setRowHeight(12);
$objPHPExcel->getActiveSheet()->getStyle('A'  . $fil)->getFont()->setSize($fonts[1]);
$objPHPExcel->getActiveSheet()->setCellValue('A' . $fil, 'Porcentaje');

    $col=1; 
	foreach ($tiendas as $idt => $nom) {
		$col++;
		
		$cant="0";
		if(array_key_exists($codbar,$enviados)){
		if(array_key_exists($idt, $enviados[$codbar])){
		$cant=$enviados[$codbar][$idt];	
		}}
	
		$objPHPExcel->getActiveSheet()->getColumnDimension($colu[$col])->setWidth($anchos['B']);
		$objPHPExcel->getActiveSheet()->getStyle($colu[$col] . $count)->getFont()->setSize($fonts[1]);
		$objPHPExcel->getActiveSheet()->setCellValue($colu[$col] . $count, $cant);	
		
		
				
		$ven="0";
		if(array_key_exists($codbar,$vendidos[$idt])){
		$ven=$vendidos[$idt][$codbar]['c'];	
		}
		
		$fil=$count+1;
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($colu[$col])->setWidth($anchos['B']);
		$objPHPExcel->getActiveSheet()->getStyle($colu[$col] . $fil)->getFont()->setSize($fonts[1]);
		$objPHPExcel->getActiveSheet()->setCellValue($colu[$col] . $fil, $ven);	
	
	
	
	
		$sto="0";
		if(array_key_exists($codbar,$stocks[$idt])){
		$sto=$stocks[$idt][$codbar];	
		}
		
		$fil=$count+2;
		
		$objPHPExcel->getActiveSheet()->getColumnDimension($colu[$col])->setWidth($anchos['B']);
		$objPHPExcel->getActiveSheet()->getStyle($colu[$col] . $fil)->getFont()->setSize($fonts[1]);
		$objPHPExcel->getActiveSheet()->setCellValue($colu[$col] . $fil, $sto);	
	
	
		$por=($cant/100)*$ven;
		$fil=$count+3;
		$objPHPExcel->getActiveSheet()->getColumnDimension($colu[$col])->setWidth($anchos['B']);
		$objPHPExcel->getActiveSheet()->getStyle($colu[$col] . $fil)->getFont()->setSize($fonts[1]);
		$objPHPExcel->getActiveSheet()->setCellValue($colu[$col] . $fil, $por);	
	
	
		
	}

	
$count=($count+4)*1;	
	
	
}}}



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
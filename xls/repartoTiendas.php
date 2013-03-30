<?php
require_once("../db.php");
require_once("../variables.php");

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};


if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select nomrep, estado, fecha from repartos where id=$id";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$nomrep=$row['nomrep'];$estado=$row['estado'];$fecha=$row['fecha'];};


$nomrep=strtoupper($nomrep);
$estado=strtoupper($equiEST[$estado]);
$reparto="REPARTO NÚMERO: $nomrep / ESTADO: $estado";


$queryp= "select 
(select codbarras from articulos where articulos.id=detreparto.id_articulo) as codbarras,
(select refprov from articulos where articulos.id=detreparto.id_articulo) as refprov, 
id_articulo, 
cantidad, 
estado, 
(select stock from articulos where articulos.id=detreparto.id_articulo) as stock, 
(select pvp from articulos where articulos.id=detreparto.id_articulo) as pvp, 
id_tienda
from detreparto where id_reparto=$id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$grid[$row['id_tienda']][$row['id_articulo']]['nom']=$row['codbarras'] . " / " .  $row['refprov'];
$grid[$row['id_tienda']][$row['id_articulo']]['cantidad']=$row['cantidad'];	
$grid[$row['id_tienda']][$row['id_articulo']]['pvp']=$row['pvp'];	
}
	



if (!$dbnivel->close()){die($dbnivel->error());};











require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$count=0;
foreach($grid as $id_tienda =>$reparto){
if(array_key_exists($id_tienda, $tiendas)){

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex($count);

$titlesheet=$tiendas[$id_tienda];
$objPHPExcel->getActiveSheet()->setTitle($titlesheet);

$objPHPExcel->setActiveSheetIndex($count)->mergeCells('A1:C1');

$objPHPExcel->setActiveSheetIndex($count)->mergeCells('F1:G1');

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);





$objPHPExcel->getActiveSheet()->setCellValue('A1', "Nº de Reparto: $nomrep");					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Tienda: ' . $tiendasN[$id_tienda]);		 	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
$objPHPExcel->getActiveSheet()->setCellValue('F1', $fecha);			 					$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);



$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(28);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);



$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Artículo');	
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Cant');	  	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
$objPHPExcel->getActiveSheet()->setCellValue('C3', 'PVP');		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
$objPHPExcel->getActiveSheet()->getStyle('A3:C3')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
$objPHPExcel->getActiveSheet()->getStyle('A3:C3')->getFont()->setSize(7);
$objPHPExcel->getActiveSheet()->getStyle('A3:C3')->applyFromArray($styleArray);



																$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(3);


$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Artículo');	
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Cant');	  	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
$objPHPExcel->getActiveSheet()->setCellValue('G3', 'PVP');		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5);
$objPHPExcel->getActiveSheet()->getStyle('E3:G3')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
$objPHPExcel->getActiveSheet()->getStyle('E3:G3')->getFont()->setSize(7);
$objPHPExcel->getActiveSheet()->getStyle('E3:G3')->applyFromArray($styleArray);


$grid[$row['id_tienda']][$row['id_articulo']]['nom']=$row['codbarras'] . " / " .  $row['refprov'];
$grid[$row['id_tienda']][$row['id_articulo']]['cantidad']=$row['cantidad'];	
$grid[$row['id_tienda']][$row['id_articulo']]['pvp']=$row['pvp'];	

$parimpar=2;$inifila=3;

$A[1]='A';$A[2]='E';
$B[1]='B';$B[2]='F';
$C[1]='C';$C[2]='G';


foreach ($reparto as $id_articulo => $valores){
if($parimpar==1){$parimpar=2;}else{$parimpar=1;$inifila++;};	


$objPHPExcel->getActiveSheet()->setCellValue($A[$parimpar] . $inifila, $valores['nom']);	
$objPHPExcel->getActiveSheet()->setCellValue($B[$parimpar] . $inifila, $valores['cantidad']);	  
$objPHPExcel->getActiveSheet()->setCellValue($C[$parimpar] . $inifila, $valores['pvp']);						

$objPHPExcel->getActiveSheet()->getStyle($A[$parimpar] . $inifila . ":" . $C[$parimpar] . $inifila)->getFont()->setSize(7);
$objPHPExcel->getActiveSheet()->getStyle($A[$parimpar] . $inifila . ":" . $C[$parimpar] . $inifila)->applyFromArray($styleArray);


	
	
}



$count++;
}}




// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reparto.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

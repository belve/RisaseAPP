<?php
require_once("../db.php");
require_once("../variables.php");


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

$anchos['A']=20;
$anchos['B']=5;
$anchos['C']=3;


$nomrep="";$id="2";$html="";$grid=array();$estado="";$nomrep2="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select nomrep, estado from repartos where id=$id";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$nomrep=$row['nomrep'];$estado=$row['estado'];};


$nomrep=strtoupper($nomrep);
$estado=strtoupper($equiEST[$estado]);
$reparto="REPARTO NÚMERO: $nomrep / ESTADO: $estado";

$filaXLS=1;
$queryp= "select id_articulo, cantidad, estado, id_tienda, 
(select codbarras from articulos where articulos.id=detreparto.id_articulo) as codbarras, 
(select stock from articulos where articulos.id=detreparto.id_articulo) as stock, 
(select refprov from articulos where articulos.id=detreparto.id_articulo) as refprov 
from detreparto where id_reparto=$id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$filaXLS++;
$datos[$row['id_articulo']]['nom']=$row['codbarras'] . " / " .  $row['refprov'];
$datos[$row['id_articulo']]['stok']=$row['stock'];

$grid[$row['id_articulo']][$row['id_tienda']]['cantidad']=$row['cantidad'];	
$grid[$row['id_articulo']][$row['id_tienda']]['estado']=$row['estado'];	
}
	



if (!$dbnivel->close()){die($dbnivel->error());};


require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);





$numti=count($tiendas);
$ultColu=$colu[$numti+3];


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth($anchos['A']);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($anchos['B']);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth($anchos['B']);


$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Articulos');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'REP');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'ALM');

$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


$rango="A2:" . $ultColu . "2";
$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
$objPHPExcel->getActiveSheet()->getStyle($rango)->getFont()->setSize(7);



$rango2="D2:" . $ultColu . "2";
$objPHPExcel->getActiveSheet()->getStyle($rango2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);




$count=3;
foreach ($tiendas as $idt => $nomt) {$count++;
$columna=$colu[$count];	
$celda=$colu[$count] .  "2";	
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($anchos['C']);
$objPHPExcel->getActiveSheet()->setCellValue($celda, $nomt);	
}

$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);




$filasR=2;
if(count($grid)>0){
foreach ($grid as $idarticulo => $dtiendas) {
$filasR++;$suma="";

$prov=$datos[$idarticulo]['nom'];
$stock=$datos[$idarticulo]['stok'];


$objPHPExcel->getActiveSheet()->setCellValue('A' . $filasR, $prov);
$objPHPExcel->getActiveSheet()->setCellValue('C' . $filasR, $stock);
$rango="A" . $filasR . ":C" . $filasR;
$objPHPExcel->getActiveSheet()->getStyle($rango)->getFont()->setSize(7);
$objPHPExcel->getActiveSheet()->getStyle($rango)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$count=3;	$estado="";
foreach ($tiendas as $idt => $nom) {$count++;

$col=$colu[$count];
$cell=$col . $filasR;

if(array_key_exists($idt, $dtiendas)){
$val=$dtiendas[$idt]['cantidad'];$suma=$suma+$val;
$estado=$dtiendas[$idt]['estado'];	
}else{$val='';$estado="";};

$objPHPExcel->getActiveSheet()->setCellValue($cell, $val);
$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setSize(7);
if($estado=='F'){
$objPHPExcel->getActiveSheet()->getStyle($cell)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '00CC66')) ));	
}

}

$objPHPExcel->getActiveSheet()->setCellValue('B' . $filasR, $suma);
$objPHPExcel->getActiveSheet()->getRowDimension($filasR)->setRowHeight(18);



}}


$rango="A1:$ultColu" . "1";
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($rango);
$objPHPExcel->getActiveSheet()->setCellValue('A1', $reparto);


#$objPHPExcel->getActiveSheet()->getStyle("A2:F2")->getFont()->setSize(7);
#$objPHPExcel->getActiveSheet()->getStyle('D2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
#$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);



// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('MON');





// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reparto.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

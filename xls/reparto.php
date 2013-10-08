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

$anchos['A']=25;
$anchos['B']=4;
$anchos['C']=4;

$anchos['T']=5;


$maxfil=1;
$pag=0;
global $colu; global $colores; global $anchos; global $pag;

$nomrep="";$id="2";$html="";$grid=array();$estado="";$nomrep2="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select nombre, estado  from agrupedidos where id=$id";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$nomrep=$row['nombre'];$estado=$row['estado'];};



$nomrep=strtoupper($nomrep);
$estado=strtoupper($equiEST[$estado]);
$reparto="REPARTO NÚMERO: $nomrep / ESTADO: $estado";

$filaXLS=1;


$queryp= "select 
(select codbarras from articulos where articulos.id=pedidos.id_articulo) as codbarras,
(select refprov from articulos where articulos.id=pedidos.id_articulo) as refprov, 
id_articulo, 
cantidad, 
estado, 
(select stock from articulos where articulos.id=pedidos.id_articulo) as stock, 
(select pvp from articulos where articulos.id=pedidos.id_articulo) as pvp, 
id_tienda
from pedidos where agrupar=$id ORDER BY prov, grupo, subgrupo, codigo;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
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
$minultcolu=$colu[$numti];
$minultcolu=$colu[$numti+1];

$count=1;
global $count;
global $ultColu;
global $objPHPExcel;
global $tiendas;
global $reparto;
global $numti;

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

global $styleArray;

function cabecera(){
global $count;global $numti;
global $ultColu;
global $colu; global $colores; global $anchos;
global $objPHPExcel;
global $tiendas;global $reparto;global $pag;global $styleArray;

$minultcolu=$colu[$numti];
$minultcolu2=$colu[$numti+1];

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth($anchos['A']);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth($anchos['B']);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth($anchos['C']);

$objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(30);

$pag++;
$rango="A" . $count . ":" . $minultcolu . $count;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($rango);
$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, $reparto);

$pagina="PAG: $pag";
$rango=$minultcolu2 . $count . ":" . $ultColu . $count;
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($rango);
$objPHPExcel->getActiveSheet()->setCellValue($minultcolu2 . $count, $pagina);



$count++;
$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, 'Articulos');
$objPHPExcel->getActiveSheet()->setCellValue('B' . $count, 'REP');
$objPHPExcel->getActiveSheet()->setCellValue('C' . $count, 'ALM');

$objPHPExcel->getActiveSheet()->getStyle('A' . $count . ':C' . $count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


$rango="A"  . $count . ":" . $ultColu  . $count;

$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
$objPHPExcel->getActiveSheet()->getStyle($rango)->getFont()->setSize(10);



$rango2="D"  . $count . ":" . $ultColu  . $count;
$objPHPExcel->getActiveSheet()->getStyle($rango2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$count2=3;

foreach ($tiendas as $idt => $nomt) {$count2++;
$columna=$colu[$count2];	
$celda=$colu[$count2] .  $count;	
$objPHPExcel->getActiveSheet()->setCellValue($celda, $nomt);
$objPHPExcel->getActiveSheet()->getColumnDimension($columna)->setWidth($anchos['T']);	
}


$objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(15);

$objPHPExcel->getActiveSheet()->getStyle('A' . $count . ':' . $ultColu . $count)->applyFromArray($styleArray);



}






$filasR=2;$first=1;
if(count($grid)>0){
foreach ($grid as $idarticulo => $dtiendas) {
$filasR++;$suma="";

if($maxfil>=26){
$objPHPExcel->getActiveSheet()->setBreak( 'A' . $count , PHPExcel_Worksheet::BREAK_ROW );	
$maxfil=1;$first=1;
$count++;
}

$maxfil++;
if($first){cabecera();$first=0;$count++;};


$prov=$datos[$idarticulo]['nom'];
$stock=$datos[$idarticulo]['stok'];

$objPHPExcel->getActiveSheet()->getStyle('A' . $count . ':' . $ultColu . $count)->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->setCellValue('A' . $count, $prov);
$objPHPExcel->getActiveSheet()->setCellValue('C' . $count, $stock);
$rango="A" . $count . ":C" . $count;

$objPHPExcel->getActiveSheet()->getStyle($rango)->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle($rango)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'EEEEEE')) ));


$count2=3;	$estado="";
foreach ($tiendas as $idt => $nom) {$count2++;

$col=$colu[$count2];
$cell=$col . $count;


if(array_key_exists($idt, $dtiendas)){
$val=$dtiendas[$idt]['cantidad'];$suma=$suma+$val;
$estado=$dtiendas[$idt]['estado'];	
}else{$val='';$estado="";};

$objPHPExcel->getActiveSheet()->setCellValue($cell, $val);
$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle($cell)->getFont()->setSize(10);
if($estado=='F'){
$objPHPExcel->getActiveSheet()->getStyle($cell)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '00CC66')) ));	
}

}

$objPHPExcel->getActiveSheet()->setCellValue('B' . $count, $suma);
$objPHPExcel->getActiveSheet()->getRowDimension($count)->setRowHeight(18);


$count++;
}



}





#$objPHPExcel->getActiveSheet()->getStyle("A2:F2")->getFont()->setSize(7);
#$objPHPExcel->getActiveSheet()->getStyle('D2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
#$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);



// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('GRID');





// Redirect output to a client’s web browser (Excel5)

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $nomrep . '.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
<?php
require_once("../db.php");
require_once("../variables.php");
$cb=array();
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select nombre, estado  from agrupedidos where id=$id";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$nomrep=$row['nombre'];$estado=$row['estado'];};


$nomrep=strtoupper($nomrep);
$estado=strtoupper($equiEST[$estado]);
$reparto="REPARTO NÚMERO: $nomrep / ESTADO: $estado";


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
$grid2[$row['id_tienda']][$row['id_articulo']]['nom']=$row['codbarras'] . " / " .  $row['refprov'];
$grid2[$row['id_tienda']][$row['id_articulo']]['cantidad']=$row['cantidad'];	
$grid2[$row['id_tienda']][$row['id_articulo']]['pvp']=$row['pvp'];	


$g=substr($row['codbarras'], 0,1); $sg=substr($row['codbarras'], 1,1); $cod=substr($row['codbarras'],4);
$cb[$row['id_tienda']][$g][$sg][$cod]=$row['id_articulo'];


}
	
if (!$dbnivel->close()){die($dbnivel->error());};


ksort($cb);
foreach ($cb as $idt => $gs) {ksort($gs); foreach ($gs as $g => $sgs) { ksort($sgs); foreach ($sgs as $sg => $cods) {ksort($cods); foreach ($cods as $cod => $codb) {
if(array_key_exists($codb, $grid2[$idt])){$grid[$idt][$codb]=$grid2[$idt][$codb];};
}}}}


function cabecera(){
	
global $objPHPExcel;
global $count;
global $tiendasN;
global $nomrep;
global $id_tienda;
global $styleArray;
global $inifila;global $firstfil;global $pag;

$inifila=$firstfil;

$objPHPExcel->setActiveSheetIndex($count)->mergeCells('A' . $inifila . ':C' .$inifila);
$objPHPExcel->setActiveSheetIndex($count)->mergeCells('F' . $inifila . ':G' .$inifila);

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
  ,
  'alignment' => array(
                                      'wrap'       => true,
                                      
                                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                        )
);

$styleArray2 = array(
    'font'  => array(
        'bold'  => true,
        'size'  => 12
       
    ),
	
	'alignment' => array(
                                      'wrap'       => true,
                                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                                        )
	
	);


$styleArray3 = array(
    'font'  => array(
        'bold'  => true,
        'size'  => 10
       
    )	
	);





$objPHPExcel->getActiveSheet()->setCellValue('A' . $inifila , "Nº de Reparto: $nomrep");					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(29);
$objPHPExcel->getActiveSheet()->setCellValue('E' . $inifila , 'Tienda: ' . $tiendasN[$id_tienda]);		 	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(29);
$objPHPExcel->getActiveSheet()->setCellValue('F' . $inifila , 'PAG: ' . $pag);		 						
$objPHPExcel->getActiveSheet()->getStyle('A' . $inifila . ':G' .$inifila)->applyFromArray($styleArray2);


$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);



$objPHPExcel->getActiveSheet()->getRowDimension($inifila)->setRowHeight(28);
$objPHPExcel->getActiveSheet()->getStyle('A' . $inifila . ':G' .$inifila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A' . $inifila . ':G' .$inifila)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$inifila=$inifila+2;

$objPHPExcel->getActiveSheet()->setCellValue('A' . $inifila, 'Artículo');	
$objPHPExcel->getActiveSheet()->setCellValue('B' . $inifila, 'Cant');	  	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
$objPHPExcel->getActiveSheet()->setCellValue('C' . $inifila, 'PVP');		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
$objPHPExcel->getActiveSheet()->getStyle('A' . $inifila . ':C' .$inifila)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
$objPHPExcel->getActiveSheet()->getStyle('A' . $inifila . ':C' .$inifila)->applyFromArray($styleArray3);
$objPHPExcel->getActiveSheet()->getStyle('A' . $inifila . ':C' .$inifila)->applyFromArray($styleArray);



$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(3);


$objPHPExcel->getActiveSheet()->setCellValue('E' . $inifila, 'Artículo');	
$objPHPExcel->getActiveSheet()->setCellValue('F' . $inifila, 'Cant');	  	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(5);
$objPHPExcel->getActiveSheet()->setCellValue('G' . $inifila, 'PVP');		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
$objPHPExcel->getActiveSheet()->getStyle('E' . $inifila . ':G' .$inifila)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
$objPHPExcel->getActiveSheet()->getStyle('E' . $inifila . ':G' .$inifila)->applyFromArray($styleArray3);
$objPHPExcel->getActiveSheet()->getStyle('E' . $inifila . ':G' .$inifila)->applyFromArray($styleArray);


$firstfil=$inifila;
}






require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();




$count=0;


global $objPHPExcel;
global $count;
global $tiendasN;
global $nomrep;
global $id_tienda;
global $styleArray;


$maxlin=44;



foreach($grid as $id_tienda =>$reparto){
if(array_key_exists($id_tienda, $tiendas)){

$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex($count);

$titlesheet=$tiendas[$id_tienda];
$objPHPExcel->getActiveSheet()->setTitle($titlesheet);



$A[1]='A';$A[2]='E';
$B[1]='B';$B[2]='F';
$C[1]='C';$C[2]='G';

$first=0;$firstfil=1;$countfil=0; $inifila=1; $pag=0;global $inifila;global $firstfil;global $pag;
foreach ($reparto as $id_articulo => $valores){


if(($countfil>$maxlin)&&($parimpar==1)){$parimpar=2;$countfil=0;$inifila=$firstfil;}
if(($countfil>$maxlin)&&($parimpar==2)){$countfil=0;$first=0;$objPHPExcel->getActiveSheet()->setBreak( 'A' . $inifila , PHPExcel_Worksheet::BREAK_ROW );$inifila++;$firstfil=$inifila; }	
if(!$first){$pag++;cabecera();$parimpar=1; $first=1;}


$inifila++;$countfil++;


	

$amount=$valores['pvp'] * 1;
$objPHPExcel->getActiveSheet()->setCellValue($A[$parimpar] . $inifila, $valores['nom']);
	
$objPHPExcel->getActiveSheet()->setCellValue($B[$parimpar] . $inifila, $valores['cantidad']);	  
$objPHPExcel->getActiveSheet()->setCellValue($C[$parimpar] . $inifila, $amount);						

$objPHPExcel->getActiveSheet()->getStyle($A[$parimpar] . $inifila . ":" . $C[$parimpar] . $inifila)->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle($A[$parimpar] . $inifila . ":" . $C[$parimpar] . $inifila)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle($C[$parimpar] . $inifila)->getNumberFormat()->setFormatCode('0.00');
$objPHPExcel->getActiveSheet()->getStyle($A[$parimpar] . $inifila)->getAlignment()->setWrapText(false); 

	
	
}



$count++;
}}




// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $nomrep . '.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

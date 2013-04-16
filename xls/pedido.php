<?php
require_once("../db.php");
require_once("../variables.php");

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};



if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "select nombre, estado  from agrupedidos where id=$id";
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){$nomrep=$row['nombre'];$estado=$row['estado'];};


$nomrep=strtoupper($nomrep);
$estado=strtoupper($equiEST[$estado]);
$reparto="REPARTO NÚMERO: $nomrep / ESTADO: $estado";


$queryp= "select 
id_tienda, 
(select nombre from grupos where grupos.id=pedidos.grupo) as grupo,
(select nombre from subgrupos where subgrupos.clave=pedidos.subgrupo and subgrupos.id_grupo=pedidos.grupo) as sgrupo,
(select codbarras from articulos where articulos.id=pedidos.id_articulo) as codbarras,
(select refprov from articulos where articulos.id=pedidos.id_articulo) as refprov, 
id_articulo, 
cantidad 
from pedidos where agrupar=$id ORDER BY  grupo, subgrupo, codigo;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$grid[$row['id_tienda']][$row['grupo'] . "/" . $row['sgrupo']][$row['codbarras'] . " / " .  $row['refprov']]=$row['cantidad'];

	
}
	

if (!$dbnivel->close()){die($dbnivel->error());};



require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$count=0;


$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);





foreach($grid as $id_tienda =>$reparto){
if(array_key_exists($id_tienda, $tiendas)){$count++;
$lastgroup="";$lin=1;$cont=1;$pag=1;	
$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex($count);
$titlesheet=$tiendas[$id_tienda];
$objPHPExcel->getActiveSheet()->setTitle($titlesheet);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(4);


	if(count($reparto)>0){
		
	$objPHPExcel->setActiveSheetIndex($count)->mergeCells('A' . $lin . ':C' .$lin);
	
	
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $lin , "Nº de Pedido: $nomrep");					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $lin , 'Tienda: ' . $tiendasN[$id_tienda]);		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $lin , 'PAG: ' . $pag);					 		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
	$objPHPExcel->getActiveSheet()->getRowDimension($lin)->setRowHeight(28);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ':G' .$lin)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ':G' .$lin)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$lin++;	
		
	foreach ($reparto as $grupo => $datos){foreach ($datos as $articulo => $cantidad){
		if($cont>=40){
		$cont=1;$lastgroup="";$pag++;
		$objPHPExcel->getActiveSheet()->setBreak( 'A' . $lin , PHPExcel_Worksheet::BREAK_ROW );	$lin++;
		
		$objPHPExcel->setActiveSheetIndex($count)->mergeCells('A' . $lin . ':C' .$lin);
	
	
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $lin , "Nº de Pedido: $nomrep");					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $lin , 'Tienda: ' . $tiendasN[$id_tienda]);		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $lin , 'PAG: ' . $pag);					 		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getRowDimension($lin)->setRowHeight(28);
		$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ':G' .$lin)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ':G' .$lin)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
		$lin++;	
			
			
		}
			if($grupo != $lastgroup){
			$rango="A" . $lin . ":B"  . $lin;
			$objPHPExcel->setActiveSheetIndex($count)->mergeCells($rango);
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $lin, $grupo);
			$objPHPExcel->getActiveSheet()->getRowDimension($lin)->setRowHeight(20);
			$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
			$objPHPExcel->getActiveSheet()->getStyle($rango)->getFont()->setSize(9);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $lin)->applyFromArray($styleArray);	
			$lastgroup=$grupo;$lin++;$cont++;
			}	
		
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $lin, $articulo);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $lin, $cantidad);
		$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ":" . 'B' . $lin)->getFont()->setSize(7);
		$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ":" . 'B' . $lin)->applyFromArray($styleArray);
		$lin++;	$cont++;	
		}}}

	
}}	






// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reparto.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');



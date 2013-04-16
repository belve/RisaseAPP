<?php
require_once("../db.php");
require_once("../variables.php");

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$grid=array();


if (!$dbnivel->open()){die($dbnivel->error());};


$queryp= "select 
(select codbarras from articulos where articulos.id=pedidos.id_articulo) as codbarras, 
(select nombre from grupos where grupos.id=pedidos.grupo) as grupo,
(select nombre from subgrupos where subgrupos.clave=pedidos.subgrupo and subgrupos.id_grupo=pedidos.grupo) as sgrupo, 
(select refprov from articulos where articulos.id=pedidos.id_articulo) as refprov, 
sum(cantidad) as rep, 
(select stock from articulos where articulos.id=pedidos.id_articulo) as stock
 from pedidos where tip=$tip and (estado='-' or estado like null) AND (agrupar !='' or agrupar NOT LIKE NULL) group by id_articulo ORDER BY grupo, subgrupo, codigo;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
if($row['stock'] < $row['rep']){	
$grid[$row['grupo'] . "/" . $row['sgrupo']][$row['codbarras'] . " / " .  $row['refprov']]['R']=$row['rep'];
$grid[$row['grupo'] . "/" . $row['sgrupo']][$row['codbarras'] . " / " .  $row['refprov']]['S']=$row['stock'];
}	
}
	

if (!$dbnivel->close()){die($dbnivel->error());};





require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$count=1;
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);




$lastgroup="";$lin=1;$cont=1;$pag=1;	
$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex($count);

$objPHPExcel->getActiveSheet()->setTitle('ROTURAS');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(4);




if(count($grid)>0){
		

		
	foreach ($grid as $grupo => $datos){foreach ($datos as $articulo => $cantidad){
		if($cont>=40){
		$cont=1;$lastgroup="";$pag++;
		$objPHPExcel->getActiveSheet()->setBreak( 'A' . $lin , PHPExcel_Worksheet::BREAK_ROW );	$lin++;
		}
			if($grupo != $lastgroup){
			$rango="A" . $lin . ":D"  . $lin;
			$objPHPExcel->setActiveSheetIndex($count)->mergeCells($rango);
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $lin, $grupo);
			$objPHPExcel->getActiveSheet()->getRowDimension($lin)->setRowHeight(20);
			$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
			$objPHPExcel->getActiveSheet()->getStyle($rango)->getFont()->setSize(9);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $lin)->applyFromArray($styleArray);	
			$lastgroup=$grupo;$lin++;$cont++;
			
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $lin, 'Artículo');
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $lin, 'Rep');
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $lin, 'Stock');
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $lin, 'Real');
			$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ":" . 'D' . $lin)->getFont()->setSize(7);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ":" . 'D' . $lin)->applyFromArray($styleArray);
			$lin++;	$cont++;
				
			
			}	
		
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $lin, $articulo);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $lin, $cantidad['R']);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $lin, $cantidad['S']);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $lin, '');
		$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ":" . 'D' . $lin)->getFont()->setSize(7);
		$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ":" . 'D' . $lin)->applyFromArray($styleArray);
		$lin++;	$cont++;	
		}}

}

	







// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reparto.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');



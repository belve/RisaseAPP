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


$queryp= "select id_grupo, clave, (select nombre from grupos where id=id_grupo) as ng, nombre as ns from subgrupos;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$g=$row['id_grupo'] . $row['clave'];	
$equig[$g]=$row['ng'] . "/" . $row['ns'];	
}


$queryp= "select 
id_tienda, 
(select codbarras from articulos where articulos.id=pedidos.id_articulo) as codbarras,
(select refprov from articulos where articulos.id=pedidos.id_articulo) as refprov, 
id_articulo, 
cantidad 
from pedidos where agrupar=$id ORDER BY  grupo, subgrupo, codigo;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
	

$sg=substr($row['codbarras'], 0,2);


$equis[$row['id_articulo']]=$equig[$sg];
$noms[$row['id_articulo']]=$row['codbarras'] . " / " .  $row['refprov'];
$cants[$row['id_articulo']]=$row['cantidad'];

$g=substr($row['codbarras'], 0,1); $sg=substr($row['codbarras'], 1,1); $cod=substr($row['codbarras'],4);
$cb[$row['id_tienda']][$g][$sg][$cod]=$row['id_articulo'];
	
}
	

if (!$dbnivel->close()){die($dbnivel->error());};


ksort($cb);
foreach ($cb as $idt => $gs) {ksort($gs); foreach ($gs as $g => $sgs) { ksort($sgs); foreach ($sgs as $sg => $cods) {ksort($cods); foreach ($cods as $cod => $codb) {
$grid[$idt][$equis[$codb]][$noms[$codb]]=$cants[$codb];
}}}}




require_once '../Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$count=0;


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




foreach($grid as $id_tienda =>$reparto){
if(array_key_exists($id_tienda, $tiendas)){$count++;
$lastgroup="";$lin=1;$cont=1;$pag=1;$inipag=$lin;	
$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex($count);
$titlesheet=$tiendas[$id_tienda];
$objPHPExcel->getActiveSheet()->setTitle($titlesheet);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(4);

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(4);


$cla[1]='A';
$clb[1]='B';
$cla[2]='E';
$clb[2]='F';
$colu=1;

	if(count($reparto)>0){
		
	$objPHPExcel->setActiveSheetIndex($count)->mergeCells('A' . $lin . ':C' .$lin);
	$objPHPExcel->setActiveSheetIndex($count)->mergeCells('D' . $lin . ':E' .$lin);	
	$objPHPExcel->setActiveSheetIndex($count)->mergeCells('F' . $lin . ':G' .$lin);
	
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $lin , "Pedido: $nomrep");						//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $lin , 'Tienda: ' . $tiendasN[$id_tienda]);		//$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $lin , 'PAG: ' . $pag);					 		//$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
	#$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
	$objPHPExcel->getActiveSheet()->getRowDimension($lin)->setRowHeight(28);
	#$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ':G' .$lin)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	#$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ':G' .$lin)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ':G' .$lin)->applyFromArray($styleArray2);	
	$lin++;	
		
	foreach ($reparto as $grupo => $datos){foreach ($datos as $articulo => $cantidad){
			
		if(($colu==1)&&($cont>=33)){
		$cont=1;$colu=2;$lastgroup="";$lin=$inipag+1;	
		}	
		
		if(($colu==2)&&($cont>=33)){$colu=1;
		$cont=1;$lastgroup="";$pag++;
		$objPHPExcel->getActiveSheet()->setBreak( 'A' . $lin , PHPExcel_Worksheet::BREAK_ROW );	$lin++;
		$inipag=$lin;	
		$objPHPExcel->setActiveSheetIndex($count)->mergeCells('A' . $lin . ':C' .$lin);
		$objPHPExcel->setActiveSheetIndex($count)->mergeCells('D' . $lin . ':E' .$lin);	
		$objPHPExcel->setActiveSheetIndex($count)->mergeCells('F' . $lin . ':G' .$lin);
	
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $lin , "Nº de Pedido: $nomrep");					//$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $lin , 'Tienda: ' . $tiendasN[$id_tienda]);		//$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $lin , 'PAG: ' . $pag);					 		//$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
		#$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
		$objPHPExcel->getActiveSheet()->getRowDimension($lin)->setRowHeight(35);
		#$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		#$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ':G' .$lin)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$objPHPExcel->getActiveSheet()->getStyle('A' . $lin . ':G' .$lin)->applyFromArray($styleArray2);	
		$lin++;	
			
		
		}
			if($grupo != $lastgroup){
			$rango=$cla[$colu] . $lin . ":" . $clb[$colu]  . $lin;
			$objPHPExcel->setActiveSheetIndex($count)->mergeCells($rango);
			$objPHPExcel->getActiveSheet()->setCellValue($cla[$colu] . $lin, $grupo);
			$objPHPExcel->getActiveSheet()->getRowDimension($lin)->setRowHeight(20);
			$objPHPExcel->getActiveSheet()->getStyle($rango)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC')) ));
			$objPHPExcel->getActiveSheet()->getStyle($rango)->getFont()->setSize(11);
			$objPHPExcel->getActiveSheet()->getStyle($cla[$colu] . $lin . ":" . $clb[$colu] . $lin)->applyFromArray($styleArray);	
			$lastgroup=$grupo;$lin++;$cont++;
			}	
		
		$objPHPExcel->getActiveSheet()->setCellValue($cla[$colu] . $lin, $articulo);
		$objPHPExcel->getActiveSheet()->getStyle($cla[$colu] . $lin)->getFont()->setSize(9);
		$objPHPExcel->getActiveSheet()->setCellValue($clb[$colu] . $lin, $cantidad);
		$objPHPExcel->getActiveSheet()->getStyle($clb[$colu] . $lin)->getFont()->setSize(11);
		$objPHPExcel->getActiveSheet()->getStyle($cla[$colu] . $lin . ":" . $clb[$colu] . $lin)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle($cla[$colu] . $lin)->getAlignment()->setWrapText(false); 
		$lin++;	$cont++;	
		}}}

	
}}	






// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $nomrep . '.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');



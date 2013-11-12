<?php
require_once("../db.php");
require_once("../variables.php");




foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$cc=1; $lids="";  $qert="";
if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select * from tickets where id > $iid ORDER BY id ASC limit 1000;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$id=$row['id'];
$idt=$row['id_tienda'];
$idtt=$row['id_ticket'];
$ide=$row['id_empleado'];
$fe=$row['fecha'];		
$ho=$row['hora'];	
$imp=$row['importe'];
$des=$row['descuento'];	

if(!array_key_exists($idt, $tnoRISASA)){
$cc++;

if($cc<$delT){
$qert.="($idt,'$idtt',$ide,'$fe','$ho','$imp','$des'),";	
$lids.=$id . ","; 
}else{
$cc=1;
//$dat[$id]="($idt,'--',$ide,'$fe','$ho','$imp','$des')";		
}

}else{
$qert.="($idt,'$idtt',$ide,'$fe','$ho','$imp','$des'),";
$lids.=$id . ",";
}


};
	
$lids=substr($lids,0,-1);




$qerdt="";	
$queryp= "select * from ticket_det where idt IN ($lids);"; 
$dbnivel->query($queryp); 
while ($row = $dbnivel->fetchassoc()){
	         
$idt=$row['idt'];          
$id_tienda=$row['id_tienda'];    
$id_ticket=$row['id_ticket'];    
$id_articulo=$row['id_articulo'];  
$g=$row['g'];            
$sg=$row['sg'];           
$cantidad=$row['cantidad'];     
$importe=$row['importe'];      
$fecha=$row['fecha'];        
$hora=$row['hora'];    
	
$qerdt.="($idt,'$id_tienda','$id_ticket','$id_articulo','$g','$sg','$cantidad','$importe','$fecha','$hora'),";	
}
	
if (!$dbnivel->close()){die($dbnivel->error());};






$dbnivel2=new DB('192.168.1.11','edu','admin','risasa');
if (!$dbnivel2->open()){die($dbnivel2->error());};
$qert=substr($qert,0,-1);
$queryp= "INSERT INTO tickets (id_tienda,id_ticket,id_empleado,fecha,hora,importe,descuento) VALUES $qert;"; 
$dbnivel2->query($queryp);


$qerdt=substr($qerdt,0,-1);
$queryp= "INSERT INTO ticket_det (idt,id_tienda,id_ticket,id_articulo,g,sg,cantidad,importe,fecha,hora) VALUES $qerdt;"; 
$dbnivel2->query($queryp);


if (!$dbnivel2->close()){die($dbnivel2->error());};

$vals[1]=0;
if ($id < $fid){$vals[1]=$id;};

echo json_encode($vals);
?>
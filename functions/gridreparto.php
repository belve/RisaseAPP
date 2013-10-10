<?php


function GenerateGrid($grid,$lastid,$dart){

global $tiendas;
global $dbnivel;

$html="";

foreach ($dart as $ida => $vdart) {
	
	
if(array_key_exists($ida,$grid)){$dtiendas=$grid[$ida];}else{$dtiendas=array();};	


$codbarras=$dart[$ida]['codbarras'];$refpro=$dart[$ida]['refprov'];$stock=$dart[$ida]['stock'];	



if($ida){$lastid++;
	
$prov="$codbarras / $refpro";



$htmlART="

<tr id='trC$lastid'>
<td style='border-bottom: 1px solid #dddddd;'>											<input id='CART$codbarras' value='$codbarras' type='hidden'>	<input type='text' class='camp_REP_art' value='$prov'></td>
<td style='width:28px;border-bottom: 1px solid #dddddd;'>								<input id='CR$lastid' onfocus='this.select();' type='text' class='camp_REP_rep' value=''></td>
<td style='width:28px;border-bottom: 1px solid #dddddd;border-right:2px solid orange;'>	<input id='CA$lastid' onfocus='this.select();' type='text' class='camp_REP_alm' value='$stock'></td>

";

$htmlALM="

<tr id='trA$lastid'>
<td style=''>												<input type='text' class='camp_REP_art' value='---- Alarma -----'></td>
<td style='width:28px;'>									<input type='hidden' id='idarti$lastid' value='$ida'><input type='hidden' id='$ida' value='$lastid'> </td>
<td style='width:28px;border-right:2px solid orange;'>		<input type='hidden' id='Stock$lastid' value='$stock'></td>

";

$sumcants=0;
$idti=0;
$numtiendastot=count($tiendas);
foreach ($tiendas as $id => $nom) {$idti++;
if(array_key_exists($id, $dtiendas)){
	

	
$canttienda=$dtiendas[$id]['cantidad'];
$alarm=$dtiendas[$id]['alarma'];
$estado="";#estRep_" . $dtiendas[$id]['estado'];
$idrep=$dtiendas[$id]['id'];
}else{
$canttienda="";
$alarm="";
$estado="";
$idrep="";
}	

$sumcants=$sumcants+$canttienda;

if($idti==$numtiendastot){$suma=$stock+$sumcants; 
$sumatorio="<input type='hidden' id='sumatorio$lastid' value='$suma'>";
$selector="<td style='width:13px;border:1px solid #C8C8C8;background-color:#C8C8C8;'><div id='F$lastid' onclick=\"selectFile('$lastid')\" class='selector'></div></td>";
$selector2="<td style='width:13px;border:1px solid #C8C8C8;background-color:#C8C8C8;'></td>";
}else{$sumatorio="";$selector="";$selector2="";};	

$almS='';
if(($canttienda > 0)&&($alarm==0)){$almS=1;};

if($canttienda==0){$canttienda='';};
$htmlART .="
<td style='width:24px;border-bottom: 1px solid #dddddd;' class='$estado'>
$sumatorio
<input type='hidden' id='BI$lastid" . "P" . "$idti' value='$idrep'>
<input onchange=\"cambiaFieldRep('CI$lastid" . "P" . "$idti')\" id='CI$lastid" . "P" . "$idti' type='text' class='camp_REP_tie' value='$canttienda' onfocus='this.select();'>
</td>
$selector
";	


if(($alarm==0)&&(!$almS)){$alarm='';};



$htmlALM .="
<td style='width:24px;' class='$estado'>								<input onchange=\"cambiaFieldRep('AI$lastid" . "P" . "$idti')\" id='AI$lastid" . "P" . "$idti' type='text' class='camp_REP_tie' value='$alarm' onfocus='this.select();'></td>
$selector2
";	
}



$html .="$htmlART </tr> $htmlALM </tr>";

}

}


$valores['html']=$html;$valores['ultfile']=$lastid;
return $valores;
	
}

?>
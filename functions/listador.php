<?php


if($id_proveedor){$options .=" AND id_proveedor=$id_proveedor";};

if($id_subgrupo){$options .=" AND id_subgrupo=$id_subgrupo";}
elseif($id_grupo){$options .=" AND id_subgrupo IN (select id from subgrupos where id_grupo=$id_grupo)";};


if($id_color){$options .=" AND id_color=$id_color";};
if($codigo){$options .=" AND codbarras=$codigo";};
if($pvp){
	if(strlen($pvp)>strlen(str_replace('-','', $pvp))){
	$rangos=explode('-', trim($pvp));	
	if(count($rangos)==2){
	$pvp1=$rangos[0];$pvp2=$rangos[1];
	$options .=" AND pvp >='$pvp1' AND pvp <='$pvp2'";		
	}
	}elseif(strlen($pvp)>strlen(str_replace(',','', $pvp))){
	
	
	$rangos=explode(',', trim($pvp));
	$options .=" AND (";$options2="";	
	foreach($rangos as $key => $pvp){
	$options2 .=" pvp ='$pvp' OR";		
	}
	$options2=substr($options2, 0, strlen($options2)-3);
	$options .=$options2 . ")";	
	}else{
	$options .=" AND pvp='$pvp'";
	}
}
if($temporada){
	
if(strlen($temporada)>strlen(str_replace('&&','', $temporada))){
	$rangos=explode('-', trim($temporada));	
	if(count($rangos)==2){
	$temporada1=$rangos[0];$temporada2=$rangos[1];
	$options .=" AND temporada >='$temporada1' AND temporada <='$temporada2'";		
	}
	}elseif(strlen($temporada)>strlen(str_replace(',','', $temporada))){
	
	
	$rangos=explode(',', trim($temporada));
	$options .=" AND (";$options2="";	
	foreach($rangos as $key => $temporada){
	$options2 .=" temporada ='$temporada' OR";		
	}
	$options2=substr($options2, 0, strlen($options2)-3);
	$options .=$options2 . ")";	
	}else{
	$options .=" AND temporada='$temporada'";
	}	
	
	
	
};

if(($desde)&&($hasta)){$options .=" AND codigo >= $desde AND codigo <= $hasta";};
if((!$desde)&&($hasta)){$options .="  AND codigo <= $hasta";};
if(($desde)&&(!$hasta)){$options .=" AND codigo >= $desde";};

if($detalles){$options .=" AND detalles LIKE '%$detalles%'";};
if($comentarios){$options .=" AND comentarios LIKE '%$comentarios%'";};


$options=substr($options, 4,strlen($options));

$campord="";$orden="";
if ($ord==1){$orden="DESC";};
if ($ord==2){$orden="ASC";};

if ($tab==1){$campord="ORDER BY (substring(codbarras,1,2)), (substring(codbarras,5))";};
if ($tab==3){$campord="ORDER BY stock $orden";};
if ($tab==4){$campord="ORDER BY pvp $orden";};
if ($tab==5){$campord="ORDER BY preciocosto $orden";};
if ($tab==6){$campord="ORDER BY temporada $orden";};
if ($tab==7){$campord="ORDER BY stockini $orden";};
if ($tab==8){$campord="ORDER BY congelado $orden";};
#echo $options;







?>
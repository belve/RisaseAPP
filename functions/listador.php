<?php

if($id_proveedor){$options .=" AND id_proveedor=$id_proveedor";};

if($id_subgrupo){$options .=" AND id_subgrupo=$id_subgrupo";}
elseif($id_grupo){$options .=" AND id_subgrupo IN (select id from subgrupos where id_grupo=$id_grupo)";};


if($id_color){$options .=" AND id_color=$id_color";};
if($codigo){$options .=" AND codbarras=$codigo";};
if($pvp){$pvp=str_replace(",",".",$pvp); $options .=" AND pvp='$pvp'";};
if($temporada){$options .=" AND temporada='$temporada'";};

if(($desde)&&($hasta)){$options .=" AND codigo >= $desde AND codigo <= $hasta";};
if((!$desde)&&($hasta)){$options .="  AND codigo <= $hasta";};
if(($desde)&&(!$hasta)){$options .=" AND codigo >= $desde";};

if($detalles){$options .=" AND detalles LIKE '%$detalles%'";};
if($comentarios){$options .=" AND comentarios LIKE '%$comentarios%'";};


$options=substr($options, 4,strlen($options));

#echo $options;







?>
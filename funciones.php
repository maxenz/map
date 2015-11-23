<?php

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
$xmlStr=str_replace("É",'&#201;',$xmlStr);
$xmlStr=str_replace("Á",'&#193;',$xmlStr);
$xmlStr=str_replace("Ó",'&#211;',$xmlStr);
$xmlStr=str_replace("Í",'&#205;',$xmlStr);
$xmlStr=str_replace("Ú",'&#218;',$xmlStr);
$xmlStr=str_replace("Ñ",'&#209;',$xmlStr);
$xmlStr=str_replace("¥",'&#209;',$xmlStr);
$xmlStr=str_replace("´",'',$xmlStr);
return $xmlStr;
}

?>
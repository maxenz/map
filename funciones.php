<?php

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
$xmlStr=str_replace("�",'&#201;',$xmlStr);
$xmlStr=str_replace("�",'&#193;',$xmlStr);
$xmlStr=str_replace("�",'&#211;',$xmlStr);
$xmlStr=str_replace("�",'&#205;',$xmlStr);
$xmlStr=str_replace("�",'&#218;',$xmlStr);
$xmlStr=str_replace("�",'&#209;',$xmlStr);
$xmlStr=str_replace("�",'&#209;',$xmlStr);
$xmlStr=str_replace("�",'',$xmlStr);
return $xmlStr;
}

?>
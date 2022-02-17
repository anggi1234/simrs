<?php 
ini_set('display_errors',0);	
ini_set('memory_limit' , '128M');
$hostname = '192.168.1.178';
$database = 'simrs2012';
$username = 'root';
$password = 'takonbudi';
$connect = mysql_connect($hostname, $username, $password,true,65536) or die(mysql_error()); 
mysql_select_db($database,$connect)or die(mysql_error());
define ('_BASE_','http://'.$_SERVER['HTTP_HOST'].'/simrs/');
define ('_POPUPTIME_','50000');

$rstitle = 'SISFO RSUD AJIBARANG';
$singrstitl = 'SISFO RSUD AJIBARANG';
$singhead1 = '';
$singsurat = 'SIMRSDITJENBUK';
$header1 = 'RSUD AJIBARANG';
$header2 = 'sistem informasi manajemen rumah sakit';
$header3 = '';
$header4 = '';
$KDRS = '1234567';
$KelasRS = 'A';
$NamaRS = 'RS NCC';
$KDTarifINACBG = 'A/ I / RSU';
<?php
$yourdate = '2016-03-22 14:30';
echo $yourdate;
echo '<br>';
$stamp = strtotime($yourdate); // get unix timestamp
$time_in_ms = $stamp*1000;

echo number_format($time_in_ms, 0, '.', '');
echo '<br>';
$micro = date('Y-m-d H:i:s', ($time_in_ms)/1000);

echo $micro;

?>
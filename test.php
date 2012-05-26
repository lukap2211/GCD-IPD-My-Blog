<?php

$out = 40;

function print_no(){
	global $out;
	$out = 30;
	echo $out;
}


print_no();
echo $out;

?>
<?php

	$string= 'Venkatesh';

	$subString= 'p';

	$substringCount= substr_count($string, $subString);

	$print= "\n".' Count= '.$substringCount."\n";

	echo $print;

	var_dump($substringCount);

?>
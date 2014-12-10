<?php

	$workingHandle= getcwd();

	$fileReturn= file('text.txt');

	$print= "\n".$fileReturn."\n";

	print_r($fileReturn);

?>
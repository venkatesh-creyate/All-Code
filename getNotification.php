<?php

	$fileName= PATHINFO(__FILE__, PATHINFO_FILENAME);
	$fileExt= PATHINFO(__FILE__, PATHINFO_EXTENSION);

	$print= '"Program Executed"';
	$print2= '"Go to '.$fileName.'.'.$fileExt.'"';

	$cmn= ' notify-send '.$print.' '.$print2;

	$cmn= ' notify-send -i "face-smile" "Program Executed" "Go to '.__FILE__.'"';

	exec($cmn);

?>
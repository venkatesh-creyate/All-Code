<?php

	$workingHandle= getcwd();

	$arrCurrPrev= array('.','..','Thumbs.db');

	define('PRT', DIRECTORY_SEPARATOR);

	$fabricHandle= 'Shirt-Structure'.PRT.'610'.PRT.'BOD001'.PRT.'front'.PRT.'left_front'.PRT.'fabric';

	$fabricArr= array_diff(scandir($fabricHandle), $arrCurrPrev);

	foreach($fabricArr as $fabricValue)
	{
		if(substr_count($fabricValue, '_') !== 0)
		{
			$print= $fabricValue."\n";
			echo $print;
		}
	}

?>



<?php

	$workingHandle= getcwd();

	$arrCurrPrev= array('.','..','Thumbs.db');

	define('PRT', DIRECTORY_SEPARATOR);


	$iconHandle= 'fullSleeve';
	$iconArr= array_diff(scandir($iconHandle), $arrCurrPrev);

	foreach($iconArr as $iconValue)
	{
		if(substr_count($iconValue, '_') != 0)
		{
			unlink($iconHandle.PRT.$iconValue);
		}
	}

?>
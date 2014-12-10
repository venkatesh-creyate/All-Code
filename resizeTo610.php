<?php

	$workingHandle= getcwd();

	define('PRT', DIRECTORY_SEPARATOR);

	$arrCurrPrev= array('.', '..', 'Thumbs.db');

	function getArray($handle)
	{
		global $arrCurrPrev;

		$arrHandle= array_diff(scandir($handle), $arrCurrPrev);

		if(!isset($arrHandle))
		{
			$print= ' Cannot get array '."\n";
			$print.= ' '.$handle."\n";

			echo $print;

			exit(0);
		}
		else
		{
			return $arrHandle;
		}
	}

	if(!isset($argv[1]))
	{
		$print= ' Argument not given '."\n";

		echo $print;

		exit(0);
	}

	$fabricHandle= $workingHandle.PRT.$argv[1];

	$fabricArr= getArray($fabricHandle);

	foreach($fabricArr as $fabricValue)
	{
		$fileHandle= $fabricHandle.PRT.$fabricValue;

		$cmn= ' convert '.$fileHandle.' -resize 610x610 '.$fileHandle;

		exec($cmn);
		
	}

	$print= ' Program executed '."\n";

	echo $print;

	exit(2);

?>
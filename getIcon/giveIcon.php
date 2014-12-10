<?php
	
	$arrCurrPrev= array('.','..','Thumbs.db');

	$lineArr= file('shirt.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	$print= "\n";
	echo $print;

	foreach ($lineArr as $lineValue)
	{
		$shirtArr= array_diff(scandir('halfSleeve'), $arrCurrPrev);

		$lineValueWithoutVersion= getValueWithoutVersion($lineValue);

		if(in_array($lineValueWithoutVersion, $shirtArr) == FALSE)
		{
			$print= ' Generating icon for '.$lineValue."\n";
			echo $print;

			$cmn= 'php getIconHalfSleeve.php '.$lineValue;
			exec($cmn, $arr, $bit);
		}


	}

	function getValueWithoutVersion($value)
	{
		$valueExtension= pathinfo($value, PATHINFO_EXTENSION);

		if(substr_count($value, '_') > 0)
		{
			$arr= explode('_', $value);

			$valueWithoutVersion= $arr[0].'.'.$valueExtension;

			return $valueWithoutVersion;
		}
	}

	$print= "\n".' Program executed successfully '."\n\n";
	echo $print;

	exit(2);

?>
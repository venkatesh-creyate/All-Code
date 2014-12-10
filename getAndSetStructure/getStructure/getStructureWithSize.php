<?php


	$workingHandle= getcwd();

	$arrCurrPrev= array('.', '..', 'Thumbs.db');

	define('PRT', DIRECTORY_SEPARATOR);

	$time= getTime();
	$date= getDay();

	$fileHandle= __FILE__;

	$fileParent= PATHINFO($fileHandle, PATHINFO_DIRNAME);

	if(!file_exists($fileParent.PRT.'getStructureArr.txt'))
	{
		$print= "\n".' Cannot find '."\n";
		$print.= ' getStructureArr.txt'."\n\n";

		echo $print;

		exit(0);
	}

	$sizeArr= array('1500', '610');

	$textArr= file($fileParent.PRT.'getStructureArr.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	$componentLine= explode('=', $textArr[0]);
	$componentLine= $componentLine[1];

	$componentArr= explode(',', $componentLine);
	$componentArr= array_map("trim", $componentArr);

	$viewLine= explode('=', $textArr[1]);
	$viewLine= $viewLine[1];

	$viewArr= explode(',', $viewLine);
	$viewArr= array_map("trim", $viewArr);

	$subcomponentLine= explode('=', $textArr[2]);
	$subcomponentLine= $subcomponentLine[1];

	$subcomponentArr= explode(',', $subcomponentLine);
	$subcomponentArr= array_map("trim", $subcomponentArr);

	$typeLine= explode('=', $textArr[3]);
	$typeLine= $typeLine[1];

	$typeArr= explode(',', $typeLine);
	$typeArr= array_map("trim", $typeArr);

	/*

	$print= "\n".' Component Line '."\n";
	$print.= ' '.$componentLine."\n\n";

	$print.=' View Line '."\n";
	$print.= ' '.$viewLine."\n\n";

	$print.=' Subcomponent Line '."\n";
	$print.=' '.$subcomponentLine."\n\n";

	$print.=' Type Line '."\n";
	$print.= ' '.$typeLine."\n\n";

	echo $print;
	
	*/
	
	varIsSet($argv[1], '$argv[1]', ' get argument ');

	$sizeHandle= $workingHandle.PRT.$argv[1];

	foreach($sizeArr as $sizeValue)
	{
		foreach($componentArr as $componentValue)
		{
			foreach($viewArr as $viewValue)
			{
				foreach($subcomponentArr as $subcomponentValue)
				{
					foreach($typeArr as $typeValue)
					{
						$lastHandle= $sizeHandle.PRT.$sizeValue.PRT.$componentValue;
						$lastHandle.= PRT.$viewValue.PRT.$subcomponentValue.PRT.$typeValue;

						getHandle($lastHandle);
					}
				}
			}
		}
	}

	$print= "\n".' Program executed '."\n\n";

	echo $print;

	exit(2);
	
	function getTime()
	{
		$time= date("his");

		return $time;
	}

	function getDay()
	{
		$date= date("Ymd");

		return $date;
	}

	function varIsSet($varChild, $varParent, $showMessage)
	{
		if(!isset($varChild))
		{
			$print= ' Cannot'.$showMessage."\n";
			$print.= ' '.$varParent."\n";

			echo $print;

			exit(0);
		}
		else
		{
			return 2;
		}

	}

	function getHandle($handle)
	{
		if(!file_exists($handle))
		{
			$handleReturn= mkdir($handle, 0777, true);
		}

		if($handleReturn === FALSE)
		{
			$print= ' Cannot create '."\n";
			$print.= ' '.$handle."\n";

			echo $print;

			exit(0);
		}
	}

	function getArray($handle)
	{
		global $arrCurrPrev;

		$arrHandle= array_diff(scandir($handle), $arrCurrPrev);

		$arrHandle= varIsSet($arrHandle, $handle, ' get array ');

		return $arrHandle;
	}

?>
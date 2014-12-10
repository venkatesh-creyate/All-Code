<?php


	$workingHandle= getcwd();

	$arrCurrPrev= array('.', '..', 'Thumbs.db');

	define('PRT', DIRECTORY_SEPARATOR);

	$time= getTime();
	$date= getDay();

	$argv[1]= varIsSet($argv[1], '$argv[1]', ' get argument ');

	$componentHandle= $workingHandle.PRT.$argv[1];
	$componentArr= getArray($componentHandle);

	foreach($componentArr as $componentValue)
	{
		$viewHandle= $componentHandle.PRT.$componentValue;
		$viewArr= getArray($viewHandle);

		foreach($viewArr as $viewValue)
		{
			$subcomponentHandle= $viewHandle.PRT.$viewValue;
			$subcomponentArr= getArray($subcomponentHandle);

			foreach($subcomponentArr as $subcomponentValue)
			{
				$typeHandle= $subcomponentHandle.PRT.$subcomponentValue;
				$typeArr= getArray($typeHandle);

				foreach($typeArr as $typeValue)
				{
					if($typeValue== 'fabric')
					{
						$fabricHandle= $typeHandle.PRT.$typeValue;
						$fabricArr= getArray($fabricHandle);

						foreach($fabricArr as $fabricValue)
						{
							//Operating on fabricValue
						}
					}
				}
			}
		}
	}
	



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
			return $varChild;
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
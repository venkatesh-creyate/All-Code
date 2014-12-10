<?php

	$print= "\n";
	echo $print;

	$jeansS3Handle= 's3://ail.bkts.creyate.images2/mens-jeans-new_3/1500/';

	$jeansHandleArr= getHandleArr($jeansS3Handle);

	$i= 0;

	foreach($jeansHandleArr as $jeansHandleValue)
	{
		$componentHandleArr= getHandleArr($jeansHandleValue);

		foreach($componentHandleArr as $componentHandleValue)
		{
			$viewHandleArr= getHandleArr($componentHandleValue);

			foreach($viewHandleArr as $viewHandleValue)
			{
				$subComponentHandleArr= getHandleArr($viewHandleValue);

				foreach($subComponentHandleArr as $subComponentHandleValue)
				{
					$typeHandleArr= getHandleArr($subComponentHandleValue);

					foreach($typeHandleArr as $typeHandleValue)
					{
						$typeValue= getValue($typeHandleValue);

						switch($typeValue)
						{
							case 'button':	
											$typeHandle= getHandleWithoutS3($typeHandleValue);
											setHandle($typeHandle);
											break;

							case 'fabric':
											$fabricHandleArr= getHandleArr($typeHandleValue);
											$fabricHandle= getHandleWithoutS3($typeHandleValue);
											setHandle($fabricHandle);
											break;

							case 'patch':	
							case 'waistband': 
											unset($fabricHandleArr);
											break;
						}

						if(isset($fabricHandleArr))
						{

							foreach($fabricHandleArr as $fabricHandleValue)
							{
								$fabricValue= getValue($fabricHandleValue);

								$valueExtension= pathinfo($fabricValue, PATHINFO_EXTENSION);

								if($valueExtension == 'txt')
								{
									$cmn= 's3cmd get --force '.$fabricHandleValue.' '.$fabricHandle;

									executeCommand($cmn);
								}
							}
						}
					}
				}
			}
		}
	}

	function setHandle($handle)
	{
		if(!file_exists($handle))
		{
			mkdir($handle, 0777, true);
		}
	}

	function getHandleWithoutS3($handleWithS3)
	{
		$handleWithoutS3= str_replace("s3://ail.bkts.creyate.images2/", "", $handleWithS3);

		return $handleWithoutS3;
	}

	function getValue($s3Handle)
	{
		$arr= explode('/', $s3Handle);

		$arrLength= count($arr);

		$value= $arr[($arrLength-1)];

		if($value == "")
		{
			$value= $arr[($arrLength-2)];
		}

		return $value;
	}

	function getHandleArr($handleValue)
	{
		$cmn= 's3cmd ls '.$handleValue;
		$executeArrReturn= executeCommand($cmn);

		$arrLength= count($executeArrReturn);
		$i= 0;

		foreach($executeArrReturn as $arrValue)
		{

			$arrValue= trim($arrValue);

			$s3Position= strpos($arrValue, "s3://ail.bkts.creyate.images2");

			$s3Value= substr($arrValue, $s3Position);

			if(!($s3Value == $handleValue))
			{
				$s3ValueArr[]= $s3Value;
			}

		}

		return $s3ValueArr;
	}

	function executeCommand($cmn)
	{
		$executeReturn= exec($cmn, $arr, $bit);

		if($bit!= 0)
		{
			$print= ' Cannot execute '."\n";
			$print= ' '.$cmn."\n\n";

			echo $print;
		}
		else
		{
			$print= ' Execute for '."\n";
			$print.= ' '.$cmn."\n\n";

			echo $print;
		}

		return $arr;
	}

	$print= "\n";
	echo $print;

?>
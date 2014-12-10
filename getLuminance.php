<?php

	$workingHandle= getcwd();

	$arrCommPrev= array('.', '..', 'Thumbs.db');

	define('PRT', DIRECTORY_SEPARATOR);

	$time= getTime();
	$date= getDay();

	$logsHandle= $workingHandle.PRT.'logs';

	getHandle($logsHandle);

	$argv[1]= varIsSet($argv[1], '$argv[1]', ' get argument ');

	$fabricArr= getArray($workingHandle.PRT.$argv[1]);

	foreach($fabricArr as $fabricValue)
	{
		$fileHandle= $workingHandle.PRT.$argv[1].PRT.$fabricValue;

		$luminanceValue= getLuminance($fileHandle);

		$print= ' Luminance of '.$fabricValue.' = '.$luminanceValue."\n";

		echo $print;

		$fileName= 'Luminance'.'.'.$date.'.'.$time.'.txt';

		file_put_contents($logsHandle.PRT.$fileName, $print, FILE_APPEND);
	}

	$print= "\n".' Program executed '."\n\n";

	echo $print;

	if(PHP_OS == 'Linux')
	{
		showNotification();
	}

	exit(2);


	function showNotification()
	{
		$fileName= getFilename(__FILE__);
		$fileExt= getFileExt(__FILE__);

		$cmn= ' notify-send -i terminal -u critical ';
		$cmn.='"'.$fileName.'.'.$fileExt.' Executed" "Go to '.__FILE__.'"';

		executeCommand($cmn);
	}


	function getHandle($handle)
	{
		if(!file_exists($handle))
		{
			$handleReturn= mkdir($handle, 0777, true);

			if($handleReturn === FALSE)
			{
				$print= ' Cannot create '."\n";
				$print.= ' '.$handle."\n";

				exit(0);
			}
		}
	}


	function getDay()
	{
		$date= date("Ymd");

		return $date;
	}


	function getTime()
	{
		$time= date("his");

		return $time;
	}

	function getArray($handle)
	{
		global $arrCommPrev;

		$arrHandle= array_diff(scandir($handle), $arrCommPrev);

		$arrHandle= varIsSet($arrHandle, $handle, ' get array ');

		return $arrHandle;
	}


	function getLuminance($fileHandle)
	{
		$cmn= 'convert '.$fileHandle.' -scale 1x1 -format %[fx:int\(255*r+0.5\)],';
		$cmn.='%[fx:int\(255*g+0.5\)],%[fx:int\(255*b+0.5\)] info:-';

		$fileRgb= executeCommand($cmn);

		$arrRgb= explode(',', $fileRgb);

		$luminanceValue= (0.2126 * $arrRgb[0]) + (0.7152 * $arrRgb[1]) + (0.0722 * $arrRgb[2]);

		if($luminanceValue == 0)
		{
			$fileName= getFilename($fileHandle);
			$fileExt= getFileExt($fileHandle);
			$fileParent= getFileParent($fileHandle);

			$fileHandleBW= $fileParent.PRT.$fileName.'BW'.'.'.$fileExt;

			$cmn= 'convert '.$fileHandle.' -type grayscale '.$fileHandleBW;

			executeCommand($cmn);

			$luminanceValue= getLuminance($fileHandleBW);

			$luminanceValue= 255 - $luminanceValue;

			unlink($fileHandleBW);

			return $luminanceValue;
		}
		else
		{
			return $luminanceValue;
		}

	}


	function executeCommand($cmn)
	{
		global $time, $date, $logsHandle;

		$execReturn= exec($cmn, $arr, $bit);
	
		if($bit != 0)
		{
			$print=' Cannot execute '."\n";
			$print.=' '.$cmn."\n\n";

			echo $print;

			$fileName= 'failedCommands'.'.'.$date.'.'.$time.'.txt';
			file_put_contents($logsHandle.PRT.$fileName, $print, FILE_APPEND);

			exit(0);
		}
		else
		{
			$print= ' Executed successfully '."\n";
			$print.= ' '.$cmn."\n\n";

			$fileName= 'successfulCommands'.'.'.$date.'.'.$time.'.txt';
			file_put_contents($logsHandle.PRT.$fileName, $print, FILE_APPEND);
		}

		return $execReturn;

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

	function getFilename($fileHandle)
	{
		$fileName= PATHINFO($fileHandle, PATHINFO_FILENAME);

		$showMessage= ' get filename ';
		$fileName= varIsSet($fileName, $fileHandle, $showMessage);

		return $fileName;

	}

	function getFileExt($fileHandle)
	{
		$fileExt= PATHINFO($fileHandle, PATHINFO_EXTENSION);

		$showMessage= ' get extension ';
		$fileExt= varIsSet($fileExt, $fileHandle, $showMessage);

		return $fileExt;
	}

	function getFileParent($fileHandle)
	{
		$fileParent= PATHINFO($fileHandle, PATHINFO_DIRNAME);

		$showMessage= ' get parent ';
		$fileParent= varIsSet($fileParent, $fileHandle, $showMessage);

		return $fileParent;
	}

?>
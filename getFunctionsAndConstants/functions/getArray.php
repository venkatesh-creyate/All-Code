<?php

	function getArray($handle)
	{
		//global $arrCurrPrev;

		$arrCurrPrev= array('.', '..', 'Thumbs.db');

		if(!file_exists($handle))
		{
			$print= "\n".' Cannot find and get array '."\n";
			$print.= ' '.$handle."\n\n";

			echo $print;

			exit(0);
		}

		$arrHandle= array_diff(scandir($handle), $arrCurrPrev);

		//$arrHandle= varIsSet($arrHandle, $handle, ' get array ');

		return $arrHandle;
	}

?>
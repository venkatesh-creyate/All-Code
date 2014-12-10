<?php

	function setHandle($handle)
	{
		if(!file_exists($handle))
		{
			$handleReturn= mkdir($handle, 0777, true);

			if($handleReturn === FALSE)
			{
				$print= ' Cannot set handle '."\n";
				$print.= ' '.$handle."\n\n";

				echo $print;

				exit(0);
			}
		}

	}

?>
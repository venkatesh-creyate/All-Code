<?php

define('PRT',DIRECTORY_SEPARATOR);

$wh= getcwd();

$curr_prev= array('.','..','Thumbs.db');

$view_handle=$wh.PRT.$argv[1];

$view_arr= array_diff(scandir($view_handle), $curr_prev);

$view_count= 0;
$jeans_count= 0;
$pocket_count= 0;
$fabric_count= 0;

if(!file_exists($wh.PRT.'waistband'))
{
	echo "\n".' No waistband '."\n\n";
	exit(0);
}


foreach($view_arr as $view_value)
{
	$view_count++;
	$jeans_count= 0;

	$jeans_handle= $view_handle.PRT.$view_value;
	$jeans_arr= array_diff(scandir($jeans_handle), $curr_prev);

	foreach($jeans_arr as $jeans_value)
	{
		$jeans_count++;
		$pocket_count= 0;

		$pocket_handle= $jeans_handle.PRT.$jeans_value;
		$pocket_arr= array_diff(scandir($pocket_handle), $curr_prev);

		foreach($pocket_arr as $pocket_value)
		{
			$pocket_count++;
			$fabric_count= 0;

			$fabric_handle= $pocket_handle.PRT.$pocket_value;
			$fabric_arr= array_diff(scandir($fabric_handle), $curr_prev);

			$new_handle= $wh.PRT.'Jeans_New_Structure'.PRT.$jeans_value.PRT.$pocket_value.PRT.$view_value.PRT.'dummy'.PRT.'fabric';
			if(!file_exists($new_handle))
			{
				mkdir($new_handle, 0777, true);
			}

			$new_button= $wh.PRT.'Jeans_New_Structure'.PRT.$jeans_value.PRT.$pocket_value.PRT.$view_value.PRT.'dummy'.PRT.'button';
			if(!file_exists($new_button))
			{
				mkdir($new_button, 0777, true);
			}

			if($view_value== 'front')
			{
				$new_waistband= $wh.PRT.'Jeans_New_Structure'.PRT.$jeans_value.PRT.$pocket_value;
				$new_waistband.=PRT.$view_value.PRT.'dummy'.PRT.'waistband';

				if(PHP_OS == 'Windows')
				{	
					$cmn= 'xcopy '.$wh.PRT.'waistband'.PRT.$jeans_value.' '.$new_waistband.' /e /i /s';
					exec($cmn);
				}
				else
					if(PHP_OS == 'Linux')
					{

						$cmn= 'cp -r '.$wh.PRT.'waistband'.PRT.$jeans_value.' '.$new_waistband;
						exec($cmn);
					}
			}
			else
			{
				$new_patch= $wh.PRT.'Jeans_New_Structure'.PRT.$jeans_value.PRT.$pocket_value.PRT.$view_value.PRT.'dummy'.PRT.'patch';

				if(!file_exists($fabric_handle.PRT.'patch') and !file_exists($fabric_handle.PRT.'Patch'))
				{
					echo "\n".' No patch in '."\n".' '.$view_value."\n".' '.$jeans_value."\n".' '.$pocket_value."\n";
				}
				else
				{

					if(PHP_OS == 'Windows')
					{				
						$cmn='xcopy '.$fabric_handle.PRT.'patch'.' '.$new_patch.' /e /i /s';
						exec($cmn);
					}
					else
						if(PHP_OS == 'Linux')
						{
							if(file_exists($fabric_handle.PRT.'patch'))
							{
								$cmn='cp -r '.$fabric_handle.PRT.'patch'.' '.$new_patch;
								exec($cmn);
							}
							else
							{
								$cmn='cp -r '.$fabric_handle.PRT.'Patch'.' '.$new_patch;
								exec($cmn);
							}
						}
				}
			}

			foreach($fabric_arr as $fabric_value)
			{
				$fabric_count++;

				if(is_file($fabric_handle.PRT.$fabric_value))
				{
					copy($fabric_handle.PRT.$fabric_value, $new_handle.PRT.$fabric_value);
				}				

				echo "\n".' View count= '.$view_count."\n";
				echo ' Jeans count = '.$jeans_count."\n";
				echo ' Pocket count = '.$pocket_count."\n";
				echo ' Fabric count = '.$fabric_count."\n\n";
			}

		}

	}

}

echo "\n".' Program executed '."\n\n";

exit(2);


#;;

?>
<?php

/*
	Created by Venkatesh
	Date: 6/8/2014
	Time: 2:56 PM
*/

define('SPR',DIRECTORY_SEPARATOR);

$wh= getcwd();

$curr_prev= array('.','..','Thumbs.db');

if(!isset($argv[1]))
{
	echo "\n".' Ip not given '."\n\n";
	exit();
}


if(PHP_OS == 'Windows')
{
	$cmn= 'xcopy '.$wh.SPR.$argv[1].' '.$wh.SPR.'Jeans_Components_Altered /e /i /s';
	exec($cmn);
}
else
if(PHP_OS == 'Linux')
{
	$cmn= 'cp -r '.$wh.SPR.$argv[1].' '.$wh.SPR.'Jeans_Components_Altered';
	exec($cmn);
}

$view_handle=$wh.SPR.'Jeans_Components_Altered';

$view_arr= array_diff(scandir($view_handle), $curr_prev);

$view_count= 0;
$jeans_count= 0;
$pocket_count= 0;
$fabric_count= 0;


foreach($view_arr as $view_value)
{
	$view_count++;
	$jeans_count= 0;

	$jeans_handle= $view_handle.SPR.$view_value;
	$jeans_arr= array_diff(scandir($jeans_handle), $curr_prev);

	foreach($jeans_arr as $jeans_value)
	{
		$jeans_count++;
		$pocket_count= 0;

		$pocket_handle= $jeans_handle.SPR.$jeans_value;
		$pocket_arr= array_diff(scandir($pocket_handle), $curr_prev);

		foreach($pocket_arr as $pocket_value)
		{
			$pocket_count++;
			$fabric_count= 0;

			$fabric_handle= $pocket_handle.SPR.$pocket_value;
			$fabric_arr= array_diff(scandir($fabric_handle), $curr_prev);

			foreach($fabric_arr as $fabric_value)
			{
				$fabric_count++;

				if(is_file($fabric_handle.SPR.$fabric_value) and PATHINFO($fabric_value, PATHINFO_EXTENSION)=='png')
				{

					if($view_value== 'front')
					{
						$pocket_name_new= 'JF'.substr($pocket_value, 0, 2).'-'.'JB'.substr($pocket_value, 2, 2);
					}
					else
						if($view_value== 'back')
						{
							$pocket_name_new= 'JF'.substr($pocket_value, 2, 2).'-'.'JB'.substr($pocket_value, 0, 2);
						}

					$fabric_name= $jeans_value.'-'.$pocket_name_new.'.png';
					rename($fabric_handle.SPR.$fabric_value, $fabric_handle.SPR.$fabric_name);

					echo "\n".' View count= '.$view_count."\n";
					echo ' Jeans count = '.$jeans_count."\n";
					echo ' Pocket count = '.$pocket_count."\n";
					echo ' Fabric count = '.$fabric_count."\n";
				}
			}

			if($view_value== 'front')
			{
				$pocket_name= 'JF'.substr($pocket_value, 0, 2).'-'.'JB'.substr($pocket_value, 2, 2);
			}
			else
				if($view_value== 'back')
				{
					$pocket_name= 'JF'.substr($pocket_value, 2, 2).'-'.'JB'.substr($pocket_value, 0, 2);
				}

			rename($fabric_handle, $pocket_handle.SPR.$pocket_name);

		}

	}

}



#;;

?>
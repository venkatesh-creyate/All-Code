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

function seeHandle($handle)
{
	if(!file_exists($handle))
	{
		$mk= mkdir($handle,0777,true);
		if($mk== FALSE)
		{
			return 0;
		}
		else
			return 1;
	}

}


function seeExtension($img)
{
	if(PATHINFO($img, PATHINFO_EXTENSION)== 'png')
	{
		return 'png';
	}
	else
		if(PATHINFO($img, PATHINFO_EXTENSION)== 'txt')
		{
			return 'txt';
		}
		else
			return 0;
}



$size_handle=$wh.SPR.$argv[2];

$handle_1500= $size_handle.SPR.'1500';
$handle_610= $size_handle.SPR.'610';

seeHandle($size_handle);

seeHandle($handle_1500);
seeHandle($handle_610);

$jeans_count= 0;
$component_count= 0;
$view_count= 0;
$subComp_count= 0;
$type_count= 0;
$img_count= 0;



$jeans_handle= $wh.SPR.$argv[1];
$jeans_arr= array_diff(scandir($jeans_handle), $curr_prev);

foreach($jeans_arr as $jeans_value)
{
	$jeans_count++;
	$component_count= 0;

	$component_handle= $jeans_handle.SPR.$jeans_value;
	$component_arr= array_diff(scandir($component_handle), $curr_prev);

	foreach($component_arr as $component_value)
	{
		$component_count++;
		$view_count= 0;

		$view_handle= $component_handle.SPR.$component_value;
		$view_arr= array_diff(scandir($view_handle), $curr_prev);

		foreach($view_arr as $view_value)
		{
			$view_count++;
			$subComp_value= 0;

			$subComp_handle= $view_handle.SPR.$view_value;
			$subComp_arr= array_diff(scandir($subComp_handle), $curr_prev);

			foreach($subComp_arr as $subComp_value)
			{
				$subComp_count++;
				$type_count= 0;

				$type_handle= $subComp_handle.SPR.$subComp_value;
				$type_arr= array_diff(scandir($type_handle), $curr_prev);

				foreach($type_arr as $type_value)
				{
					$type_count++;
					$img_count= 0;

						
					$handle_withoutC= $jeans_value.SPR.$component_value.SPR.$view_value.SPR.$subComp_value.SPR.$type_value;

					seeHandle($handle_1500.SPR.$handle_withoutC);
					seeHandle($handle_610.SPR.$handle_withoutC);
						
					$img_handle= $type_handle.SPR.$type_value;
					$img_arr= array_diff(scandir($img_handle), $curr_prev);


					foreach($img_arr as $img_value)
					{
						$img_count++;
														
						if(seeExtension($img_value)== 'png')
						{
							copy($img_handle.SPR.$img_value, $handle_1500.SPR.$handle_withoutC.SPR.$img_value);

							$cmn= 'convert '.$img_handle.SPR.$img_value.' -resize 610x610 '.$handle_610;
							$cmn.=SPR.$handle_withoutC.SPR.$img_value;
							exec($cmn);

							
							if($type_value== 'fabric' || $type_value== 'waistband')
							{
								$png_cmn='pngquant --force --quality 90-100 --speed 1 --output ';
								$png_cmn.=$handle_1500.SPR.$handle_withoutC.SPR.$img_value.' ';
								$png_cmn.=$handle_1500.SPR.$handle_withoutC.SPR.$img_value;
								exec($png_cmn);

								$png_cmn='pngquant --force --quality 90-100 --speed 1 --output ';
								$png_cmn.=$handle_610.SPR.$handle_withoutC.SPR.$img_value.' ';
								$png_cmn.=$handle_610.SPR.$handle_withoutC.SPR.$img_value;
								exec($png_cmn);
							}
							
						}
						else
							if(seeExtension($img_value)== 'txt')
						{
							copy($img_handle.SPR.$img_value, $handle_1500.SPR.$handle_withoutC.SPR.$img_value);
							copy($img_handle.SPR.$img_value, $handle_610.SPR.$handle_withoutC.SPR.$img_value);
						}
						else
							if(seeExtension($img_value)== 0)
							{
								echo "\n".' Extension cannot be given '."\n";
								exit(0);
							}

						echo "\n".' Jeans count = '.$jeans_count."\n";
						echo ' Component count = '.$component_count."\n";
						echo ' View count = '.$view_count."\n";
						echo ' subComp count = '.$subComp_count."\n";
						echo ' Type count = '.$type_count."\n";
						echo ' Img count = '.$img_count."\n\n";
					}

				}

			}

		}
			
	}

}






#;;

?>
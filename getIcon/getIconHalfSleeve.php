<?php

	$workingHandle= getcwd();

	$arrCurrPrev= array('.', '..', 'Thumbs.db');

	define('PRT', DIRECTORY_SEPARATOR);

	$print= "\n";
	echo $print;

	if(!isset($argv[1]))
	{
		$print= ' Cannot get argument '."\n";
		echo $print;

		setExit(0);
	}
	else
		if(substr_count($argv[1],'_')=== 0)
		{
			$print= ' Fabric should be given with version number '."\n";
			echo $print;

			setExit(0);
		}
		else
			if(substr_count($argv[1],'.png')=== 0)
			{
				$argv[1]= $argv[1].'.png';
			}


	$handle610= realpath('Shirt-Structure'.PRT.'610');

	ifFileExists($handle610);

	$website= "qa.creyate.com";
	$username= "presto";
	$password= "pr3st0";
	$table= "website";

	$subcomponentValue= "'left_front','inner_yoke','outer_yoke','top_collar','outer_collar_band'";
	$subcomponentValue.=",'inner_collar_band'";
	$subcomponentValue.=",'top_button_placket','top_buttonhole_placket','pocket','half_sleeve'";
	//$subcomponentValue.=",'half_sleeve'";

	$query= "SELECT DISTINCT(`sub_component`),`component_name` FROM `view_order`";
	$query.=" WHERE (`type`= 'Mens-Formal-Shirt' AND `view`= 'front'";
	$query.= "AND `sub_component` IN (".$subcomponentValue.") AND `zindex`>0) ORDER BY `zindex` ASC";


	$arrTable= connectSQL($website, $username, $password, $table, $query);

	//print_r($arrTable);

	setHandle('halfSleeve');
	//setHandle('halfSleeve');

	$halfSleeveHandle= realpath('halfSleeve');
	//$halfSleeveHandle= realpath('halfSleeve');

	$fabricName= $argv[1];

	$cmn= 'convert -resize 610x610 xc:none '.$halfSleeveHandle.PRT.$fabricName;

	executeCommand($cmn);


	foreach($arrTable as $tableRow)
	{

		$componentName= getComponentName($tableRow['component_name']);
		$subcomponentName= $tableRow['sub_component'];

		$print= ' '.$tableRow['component_name'].'= '.$componentName."\n";
		echo $print;
		
		$componentHandle= $handle610.PRT.$componentName;
		$subcomponentHandle= $componentHandle.PRT.'front'.PRT.$subcomponentName;
		$fabricHandle= $subcomponentHandle.PRT.'fabric';

		ifFileExists($componentHandle);
		ifFileExists($subcomponentHandle);
		ifFileExists($fabricHandle);
		ifFileExists($fabricHandle.PRT.$fabricName);

		composeOverlayBackground($fabricHandle.PRT.$fabricName, 'halfSleeve'.PRT.$fabricName);
	}

	$collarButtonsHandle= $handle610.PRT.'COL003'.PRT.'front'.PRT.'outer_collar_band'.PRT.'button';

	composeOverlayBackground($collarButtonsHandle.PRT.'BTN5.png', 'halfSleeve'.PRT.$fabricName);

	$placketButtonsHandle= $handle610.PRT.'PLA002_2'.PRT.'front'.PRT.'top_buttonhole_placket'.PRT.'button';

	composeOverlayBackground($placketButtonsHandle.PRT.'BTN5.png', 'halfSleeve'.PRT.$fabricName);

	$fabricNameWithoutVersion= getFabricNameWithoutVersion($fabricName);

	rename('halfSleeve'.PRT.$fabricName, 'halfSleeve'.PRT.$fabricNameWithoutVersion);

	setExit(2);


	function ifFileExists($handle)
	{
		if(!file_exists($handle))
		{
			$print= ' Cannot find the handle '."\n";
			$print.= ' '.$handle."\n";

			echo $print;

			setExit(0);
		}
		else
		{
			return 1;
		}
	}

	function getFabricNameWithoutVersion($fabricValue)
	{
		$fabricNameWithVersion= PATHINFO($fabricValue, PATHINFO_FILENAME);
		$fabricExtension= PATHINFO($fabricValue, PATHINFO_EXTENSION);

		$arrFabricName= explode('_', $fabricNameWithVersion);

		$fabricNameWithoutVersion= $arrFabricName[0].'.'.$fabricExtension;

		return $fabricNameWithoutVersion;
	}


	function getComponentName($componentRowValue)
	{
		switch($componentRowValue)
		{
			case '_back_yoke':
								$componentValue= 'BYK001';
								break;

			case '_collar':
								$componentValue= 'COL003';
								break;

			case '_body':
								$componentValue= 'BOD001';
								break;

			case '_cuff':
								$componentValue= 'CUF001_1';
								break;

			case '_sleeve':
								$componentValue= 'SLE002_5';
								break;

			case '_placket':
								$componentValue= 'PLA002_2';
								break;

			case '_pocket':
								$componentValue= 'POC002_1';
								break;

			default:
								$componentValue= 0;
								break;
		}

		return $componentValue;
	}

	function setExit($exitBit)
	{
		$print= "\n";
		echo $print;

		switch($exitBit)
		{
			case '0':
						$print= ' Exiting abruptly '."\n\n";
						break;

			case '2':
						$print= ' Exiting successfully '."\n\n";
						break;

			case '3':
						$print= ' Exiting on command '."\n\n";
						break;

			default:
						$print= ' Exiting bit is not defined '."\n\n";
						break;
		}

		echo $print;

		exit($exitBit);
	}

	function executeCommand($cmn)
	{
		exec($cmn, $arr, $bit);

		if($bit != 0)
		{
			$print= ' Cannot execute '."\n";
			$print.= ' '.$cmn."\n";

			echo $print;

			setExit(0);
		}
	}

	function setHandle($handle)
	{
		if(!file_exists($handle))
		{
			$handleReturn= mkdir($handle, 0777, true);

			if($handleReturn == FALSE)
			{
				$print= ' Cannot set handle '."\n";
				$print.= ' '.$handle."\n";

				echo $print;

				setExit(0);
			}
		}
	}

	function getArray($handle)
	{
		global $arrCurrPrev;

		$arrHandle= array_diff(scandir($handle), $arrCurrPrev);

		if(!isset($arrHandle))
		{
			$print= ' Cannot get array for handle '."\n";
			$print.= ' '.$handle."\n";

			echo $print;

			setExit(0);
		}
		else
		{
			return $arr;
		}

	}

	function connectSQL($website, $username, $password, $table, $query)
	{

		$connectionSQL= mysqli_connect($website, $username, $password, $table);

		if(!$connectionSQL)
		{
			$print= ' Connection failed: '."\n";
			$print.= ' '.mysqli_connect_error()."\n";

			echo $print;

			setExit(0);
		}
		else
		{
			$print= "\n".' Connection successful '."\n";

			echo $print;
		}

		$queryReturn= mysqli_query($connectionSQL, $query);

		while($row= mysqli_fetch_assoc($queryReturn))
		{
			$arr[]= $row;
		}

		if(!empty($arr))
		{
			$print= "\n".' Table has been received '."\n";

			echo $print;

			closeSQL($connectionSQL);

			return $arr;
		}
		else
		{
			$print= ' Cannot get table '."\n";
			$print.= ' '.$query."\n";

			echo $print;

			closeSQL($connectionSQL);

			setExit(0);
		}
	}

	function closeSQL($connectionSQL)
	{
		mysqli_close($connectionSQL);

		$print= ' Connection has been closed '."\n\n";
		echo $print;
	}

	function composeOverlayBackground($overlay, $background)
	{
		$cmn= ' composite '.$overlay.' '.$background.' '.$background;

		executeCommand($cmn);
	}



?>
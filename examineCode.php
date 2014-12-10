<?php

	set_include_path('/home/venkatesh/Videos/Code/getFunctionsAndConstants');

	include('getFunctionsAndConstants.php');

	$time=  getTime();
	$day= getDay();

	$handle= './examineCode';
	$handle2= './examineCode/examineSubCode';

	setHandle($handle2);

	$arrHandle= getArray($handle);

	var_dump($time);
	var_dump($day);
	var_dump($arrHandle);

	setExit(2);

?>
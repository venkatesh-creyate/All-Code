<?php

	$website= "qa.creyate.com";

	$username= "presto";

	$password= "pr3st0";

	$table= "website";

	$conn= mysqli_connect($website, $username, $password, $table);

	//$qry= "SELECT * FROM `view_order`";


	$qry= "SELECT * FROM `view_order` WHERE (`type`= 'Mens-Formal-Shirt' AND `view`= 'front'";
	$qry.= " AND `zindex`>0) ORDER BY `zindex` ASC";

	$qryReturn= mysqli_query($conn, $qry);

	while($row= mysqli_fetch_assoc($qryReturn))
	{

		$arr[]= $row;
	
	}

	print_r($arr);

?>
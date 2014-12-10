<?php

	$i=0;
	$j=0;

	for($i=1; $i<=5; $i++)
	{
		for($j=1; $j<=5; $j++)
		{	
			
			if($i==1 && $j==1)
			{
				$print= 'JF0'.$i.'-JB0'.$j;
			}
			else
			{
				$print.= 'JF0'.$i.'-JB0'.$j;
			}

			if(($i==5) && ($j==5))
			{
				continue;
			}
			else
			{
				$print.=',';
			}

		}
	}

	echo $print;

	file_put_contents('getLine.txt', $print);
?>
<?php

	$parentHandle= PATHINFO(__FILE__, PATHINFO_DIRNAME);

	define('PRT', DIRECTORY_SEPARATOR);

	$pathToAutoloader= $parentHandle.PRT.'PHPMailer'.PRT.'PHPMailerAutoload.php';

	require $pathToAutoloader;

	$print= "\n";
	echo $print;

	getInfo('./infoMail.txt');

	function getInfo($infoHandle)
	{
		$infoLineArr= file($infoHandle, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		foreach($infoLineArr as $infoLineValue)
		{
			$lineArr= explode('=', $infoLineValue);
			$lineValue= trim($lineArr[1]);

			$infoArr[]= $lineValue;
		}

		$from= $infoArr[0];
		$fromName= $infoArr[1];
		$to= $infoArr[2];
		$toName= $infoArr[3];
		$replyTo= $infoArr[4];
		$replyToName= $infoArr[5];

		isEmail($from);
		isEmail($to);

		if(!(strlen($replyTo)== 0))
		{
			isEmail($replyTo);
		}

		$print= ' from= '.$from."\n";
		$print.= ' fromName= '.$fromName."\n";
		$print.= ' to= '.$to."\n";
		$print.= ' toName= '.$toName."\n";
		$print.= ' replyTo= '.$replyTo."\n";
		$print.= ' replyToName= '.$replyToName."\n\n";

		echo $print;

		sendMail($from, $fromName, $to, $toName, $replyTo, $replyToName);

	}

	function isEmail($emailValue)
	{
		$countAtTheRate= substr_count($emailValue, '@');
		$countPoint= substr_count($emailValue, '.com');

		if(!(($countPoint == 1)&&($countAtTheRate >= 1)))
		{
			$print= ' Given email is wrong '."\n";
			$print.= ' '.$emailValue."\n\n";

			echo $print;

			exit(0);
		}
	}

	function sendMail($from, $fromName, $to, $toName, $replyTo, $replyToName)
	{

		$phpMail= new PHPMailer;

		$phpMail->isSMTP();

		$phpMail->SMTPDebug = 2;

		$phpMail->Debugoutput= 'html';

		$phpMail->Host= 'smtp.gmail.com';

		$phpMail->Port= 587;

		$phpMail->SMTPSecure= 'tls';

		$phpMail->SMTPAuth= true;

		$phpMail->Username= "venkatesh2.mail@gmail.com";

		$phpMail->Password= "rama";


		/*
		$phpMail->From= $from;

		$phpMail->FromName= $fromName;
		*/

		$phpMail->setFrom($from, $fromName);

		if(strlen($toName)== 0)
		{
			$phpMail->addAddress($to);
		}
		else
			if(strlen($toName)!= 0)
			{
				$phpMail->addAddress($to, $toName);
			}

		if(strlen($replyToName)== 0)
		{

			$phpMail->addReplyTo($replyTo);
		}
		else
			if(strlen($replyToName)!= 0)
			{
				$phpMail->addReplyTo($replyTo, $replyToName);
			}

		$phpMail->Subject= 'About phpMailer.';

		$phpMail->Body= ' This is html message body with <span style="color: green"> green color </span>.';

		$phpMail->AltBody= ' This is the body in plain text for non-html. ';

		$print= ' Email is being sent '."\n\n";
		echo $print;

		$sendReturn= $phpMail->send();

		if(!$sendReturn)
		{
			$print= "\n".' Cannot send the message '."\n";
			$print.= ' phpMailer error: '.$phpMail->ErrorInfo."\n\n";

			echo $print;
		}
		else
		{
			$print= "\n".' Sent the message '."\n\n";

			echo $print;
		}
	}

?>
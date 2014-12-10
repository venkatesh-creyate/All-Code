<!DOCTYPE html>

<html>

	<style>

		body
		{
			background-color:<?php echo $_GET['background-color'] ?>;
			color:<?php echo $_GET['text-color'] ?>;
			text-align: center;
		}

	</style>

	<body>

		<div id="header">

			<h1> Your text </h1>

		</div>

		<div id="content">

			<p> The text you have entered is <br/>
				<span style="font-size:20px; text-decoration: underline"> <?php echo $_GET['text'] ?> </span> </p>

			<form method="get" action="./../ht2.html">
				<input type="submit" value="Go back"/>
			</form>

		</div>


	</body>

</html>


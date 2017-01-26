<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Relay Control</title>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
<style>
body {
	font-family: Arial, Helvetica, sans-serif;
	text-align: center;
}


input {
	font-size: 70px;
}


</style>

</head>

<body>
<h1>Relay Control</h1>
<form action="btnclick.php" method="get">

<?php

if (isset($_GET['status'])) {
	if($_GET['status'] == "on")
	{
    	echo "<input type=\"submit\" name=\"on\" value=\"on\" disabled=\"disabled\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<input type=\"submit\" name=\"off\" value=\"off\">";
	}
	else
	{
		echo "<input type=\"submit\" name=\"on\" value=\"on\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<input type=\"submit\" name=\"off\" value=\"off\" disabled=\"disabled\">";
	}

}else{
    echo "<input type=\"submit\" name=\"on\" value=\"on\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<input type=\"submit\" name=\"off\" value=\"off\" disabled=\"disabled\">";
}

?>


</form>
</body>
</html>
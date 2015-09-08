<?php
require 'connect1.php';
require 'core.php';
if(loggedin())
{
	$name = getuserfield('name');
	echo "<div id='index'>
			<span id='logout'>$name</span><br><br>
			<div id='logout_button'>
				<a href='logout.php'>Logout</a>
			</div>
		</div><br><br>";
	include 'add_info.php';	
        include 'view.php';
}
else
{
	include 'login.php';
}
?>
<head>
	<link type="text/css" rel="stylesheet" href="stylesheet.css">
</head

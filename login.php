<?php
require 'connect1.php';
if (isset($_POST['email'])&&isset($_POST['password']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];	
	$password_hash = md5($password); 
	if (!empty($email)&&!empty($password))
	{
		$query = "SELECT id FROM User_info WHERE email='$email'";
		if ($query_run = mysql_query($query))
		{	
			$query_num_rows = mysql_num_rows($query_run);
			if ($query_num_rows==0)
			{
				echo "<div class='notify'>Email is not registerd!<br><br></div>";
			}
			else
			{
				$query1 = "SELECT id FROM User_info WHERE email='$email' AND password='$password_hash'";
				if ($query_run1 = mysql_query($query1))
				{	
					$query_num_rows1 = mysql_num_rows($query_run1);
					if ($query_num_rows1==0)
					{
						echo "<div class='notify'>Invalid Username/Password Combination!<br><br></div>";
					}
					else if($query_num_rows1==1)
					{
				 		$user_id = mysql_result($query_run1, 0, 'id');
				 		$_SESSION['user_id'] = $user_id;
				 		header('Location:index.php');
					}
				}
			}
		}
		else
		{
		}
	}
}
?>
<head>
	<link type="text/css" rel="stylesheet" href="stylesheet.css">
</head>
<body>
	<div id="form">
		<p><em>Login Form</em></p>
		<div id="login">
			<span id="first">&nbsp Register For New User &nbsp</span>
			<div id="register_button">
				<a href="register.php">Register</a>
			</div>
		</div>
		<br>
		<form action="<? echo $current_file ?>" method="POST">
			<span class="style"></span><br><input type="text" placeholder="Email" name="email" class="text" required value=""><br><br>
			<span class="style"></span><br><input placeholder="Password" type="password" name="password" class="text" required value=""><br><br>
			<br><input type="submit" value="Login" class="submit"><br><br>
		</form>
	</div>
</body>

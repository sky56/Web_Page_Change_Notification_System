<?php
require 'core.php';
require 'connect1.php';
if (!loggedin())
{
	if (isset($_POST['name'])&&isset($_POST['email'])&&isset($_POST['password'])&&isset($_POST['password_again']))
	{
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password_again = $_POST['password_again'];
		$password_hash = md5($password);
		if(!empty($name)&&!empty($email)&&!empty($password)&&!empty($password_again))
		{
			if($password!=$password_again)
			{
				echo "<div class='notify'>Passwords Do Not Match!<br><br></div>";
			}
			else
			{
				$query = "SELECT email FROM User_info where email='$email'";
				$query_run = mysql_query($query);	
				if (mysql_num_rows($query_run)==1)
				{
					echo "<div class='notify'>The Email <span id='email'>$email</span> Already Exists!</div><br><br>";
				}
				else
				{
					$query = "INSERT INTO User_info VALUES('','".mysql_real_escape_string($name)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($password_hash)."')";
					if ($query_run = mysql_query($query))
					{
						header('Location: register_success.php');
					}
					else
					{
						echo "<div class='notify'>We Could Not Register You At This Moment!<br><br></div>";
					}
				}
			}
		}
	}
?>
<head>
	<link type="text/css" rel="stylesheet" href="stylesheet.css">
</head>
<body>
	
	<div id="form">
		<p><em>Registration Form</em></p>
		<div id="login">
			<span id="first">&nbsp Already have an account? &nbsp</span>
			<div id="login_button">
				<a href="index.php">Login</a>
			</div>
		</div>
		<br>
		<form action="register.php"  method="POST">
			<span class="style"></span><br><input type="text" placeholder="Enter Name" name="name" class="text" required value=""><br><br>
			<span class="style"></span><br><input type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="Enter Email" name="email" class="text" required value=""><br><br>
			<span class="style"></span><br><input placeholder="Enter Password" type="password" name="password" class="text" required value=""><br><br>
			<span class="style"></span><br><input placeholder="Enter Confirm Password"  type="password" name="password_again" class="text" required value=""><br><br>
			<br><input type="submit" value="Register" class="submit"><br><br>
		</form>
<?php
}
else if(loggedin())
{
	echo "<div class='notify'>You Are Already Registered And Logged In<br><br></div>";
}
?>
	</div>
</body>

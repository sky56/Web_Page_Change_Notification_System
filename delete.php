<?php
include('connect1.php');
if(isset($_GET['trans_id']))
{
	if(isset($_POST['delete']))
	{
		$delete = $_POST['delete'];
		if(!empty($delete))
		{
			if($delete=="Yes")
			{
				$trans_id = $_GET['trans_id'];
				$query1 = "SELECT website_url,trans_freq FROM Transaction WHERE Transaction.trans_id='$trans_id'";
				$query_run1 = mysql_query($query1);
				while($row1 = mysql_fetch_array($query_run1))
				{
    					@$website_url = $row1[website_url];
    					@$trans_freq=$row1[trans_freq];
				}
				$query2 = "SELECT trans_user_id FROM Transaction WHERE Transaction.trans_id='$trans_id'";
				$query_run2 = mysql_query($query2);
				while($row2 = mysql_fetch_array($query_run2))
				{
    					@$trans_user_id = $row2[trans_user_id];
				}
				$query3 = "SELECT email FROM User_info WHERE User_info.id=$trans_user_id";
				$query_run3 = mysql_query($query3);
				while($row3 = mysql_fetch_array($query_run3))
				{
    					@$email = $row3[email];
				}
				if($trans_freq=='Hourly')
				{
					$trans_freq_sh = "00 * * * *";
					$trans_freq_php = "10 * * * *";
				}
				if($trans_freq=='Daily')
				{
					$trans_freq_sh = "00 00 * * *";
					$trans_freq_php = "10 00 * * *";
				}
				if($trans_freq=='Weekly')
				{
					$trans_freq_sh = "00 00 * * 0";
					$trans_freq_php = "10 00 * * 0";
				}
				if($trans_freq=='Monthly')
				{
					$trans_freq_sh = "00 00 1 * *";
					$trans_freq_php = "10 00 1 * *";
				}
				if($trans_freq=='Yearly')
				{
					$trans_freq_sh = "00 00 1 1 *";
					$trans_freq_php = "10 00 1 1 *";
				} 	
				$query1=mysql_query("DELETE FROM Transaction WHERE trans_id='$trans_id'");
				if($query1)
				{
					$website_url = preg_replace("(^https?://)", "", $website_url);
					$output1 = shell_exec('crontab -l');
					$cronjob = ("$trans_freq_sh /opt/lampp/htdocs/$email.$website_url.sh");
					$newcron = str_replace($cronjob,"",$output1);
					file_put_contents('/tmp/crontab.txt', $newcron.PHP_EOL);
					echo exec('crontab /tmp/crontab.txt');
					$output2 = shell_exec('crontab -l');
					$cronjob = ("$trans_freq_php /opt/lampp/bin/php /opt/lampp/htdocs/$email/$website_url/ch.php");
					$newcron = str_replace($cronjob,"",$output2);
					file_put_contents('/tmp/crontab.txt', $newcron.PHP_EOL);
					echo exec('crontab /tmp/crontab.txt');
					$output3 = "rm -rf /opt/lampp/htdocs/$email.$website_url.sh";
					shell_exec($output3);
					$output4 = "rm -rf /opt/lampp/htdocs/$email/$website_url/";
					shell_exec($output4);
					$output5 = "ps -ef | grep 'wget -r -P /opt/lampp/htdocs/$email/$website_url/ $website_url' | awk '{print $2}' | xargs kill";
					shell_exec($output5);
					
				}
			}
			header('location:index.php');
		}
	}
}
?>
<head>
	<link type="text/css" rel="stylesheet" href="stylesheet.css">
</head>
<body>
	<div id="form">
		<p><em>Delete Information</em></p>
		<form action="" method="POST">
		<input type="radio" name="delete" value="Yes" required value="" /><span class="add">Yes</span> <br><br>
		<input type="radio" name="delete" value="No" required value="" /><span class="add">No</span> <br><br>
		<br><input type="submit" value="Delete" class="submit"><br><br>
		</form>
	</div>
</body>

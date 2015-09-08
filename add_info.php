<?php
require 'connect1.php';
if (isset($_POST['trans_freq'])&&isset($_POST['website_url']))
{	
	$trans_freq = $_POST['trans_freq'];
	$website_url = $_POST['website_url'];
	if(!empty($trans_freq)&&!empty($website_url))
	{
		$query = "SELECT User_info.email from User_info WHERE User_info.id = '".$_SESSION['user_id']."'";
		$query_run = mysql_query($query);
		while($row = mysql_fetch_array($query_run))
		{
    			@$email = $row[email];
		}
                $query = "SELECT email,website_url FROM User_info,Transaction WHERE User_info.email='$email' AND Transaction.website_url='$website_url'";
               	$query_run = mysql_query($query);
		if(mysql_num_rows($query_run)==1)
                {
			echo "<span style='font-size:30px;font-family:Arial;color:dimgray'>The Website_Url $website_url already exists.</span><br>";
			echo "<span style='font-size:30px;font-family:Arial;color:dimgray'>You can update the old values.</span><br>";
                }
		else
		{
			$query = "INSERT INTO Transaction VALUES('','".mysql_real_escape_string($trans_freq)."','".mysql_real_escape_string($website_url)."',(SELECT id from User_info where id='".$_SESSION['user_id']."'))";
			if ($query_run = mysql_query($query))
			{
				$website_url = preg_replace("(^https?://)", "", $website_url);
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
				$output1 = "export http_proxy=http://gauravs_server:5bc046cf92@10.100.1.254:8080";
				shell_exec($output1);
				$output2 = "echo -e '#!/bin/bash' >> /opt/lampp/htdocs/$email.$website_url.sh";
				shell_exec($output2);
				$output3 = "chmod 777 /opt/lampp/htdocs/$email.$website_url.sh";
				shell_exec($output3);
				$file = fopen("/opt/lampp/htdocs/$email.$website_url.sh","w");
				fwrite($file,"#!/bin/bash \nwget -r -P /opt/lampp/htdocs/$email/$website_url/ $website_url \nrm -rf /opt/lampp/htdocs/$email/$website_url/backup.3 \nmv /opt/lampp/htdocs/$email/$website_url/backup.2 /opt/lampp/htdocs/$email/$website_url/backup.3 \nmv /opt/lampp/htdocs/$email/$website_url/backup.1 /opt/lampp/htdocs/$email/$website_url/backup.2  \ncp -al /opt/lampp/htdocs/$email/$website_url/backup.0 /opt/lampp/htdocs/$email/$website_url/backup.1 \nrsync -a --delete /opt/lampp/htdocs/$email/$website_url/$website_url/ /opt/lampp/htdocs/$email/$website_url/backup.0 \ndiff -r --brief /opt/lampp/htdocs/$email/$website_url/backup.0 /opt/lampp/htdocs/$email/$website_url/backup.1 > /opt/lampp/htdocs/$email/$website_url/change.txt \nmkdir /opt/lampp/htdocs/$email/$website_url/diff\nchmod 777 /opt/lampp/htdocs/$email/$website_url/diff \ncp /opt/lampp/htdocs/project/style.css /opt/lampp/htdocs/$email/$website_url/ \nchmod 777 /opt/lampp/htdocs/$email/$website_url/style.css \ncp /opt/lampp/htdocs/project/ch.php /opt/lampp/htdocs/$email/$website_url/ \nchmod 777 /opt/lampp/htdocs/$email/$website_url/ch.php \nsed -i \"3i '$email';\" /opt/lampp/htdocs/$email/$website_url/ch.php \nsed -i \"5i '$website_url';\" /opt/lampp/htdocs/$email/$website_url/ch.php");
				fclose($file);
				$output4 = shell_exec('crontab -l');
				file_put_contents('/tmp/crontab.txt', $output4."$trans_freq_sh /opt/lampp/htdocs/$email.$website_url.sh".PHP_EOL);
				echo exec('crontab /tmp/crontab.txt');
				$output5 = shell_exec('crontab -l');
				file_put_contents('/tmp/crontab.txt', $output5."$trans_freq_php /opt/lampp/bin/php /opt/lampp/htdocs/$email/$website_url/ch.php".PHP_EOL);
				echo exec('crontab /tmp/crontab.txt');
				header("location:index.php");
			}
			else
			{
				echo "<span class='notify'>We could not add your details at this time. Try again later.</span><br>";
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
		<p><em>Add Information</em></p>
		<form action="" method="POST">
			<input type="radio" name="trans_freq" value="Hourly" required value="" /><span class="add">Hourly</span> &nbsp
			<input type="radio" name="trans_freq" value="Daily" required value="" /><span class="add">Daily</span> &nbsp
			<input type="radio" name="trans_freq" value="Weekly" required value="" /><span class="add">Weekly</span> &nbsp
			<input type="radio" name="trans_freq" value="Monthly" required value="" /><span class="add">Monthly</span> &nbsp
			<input type="radio" name="trans_freq" value="Yearly" required value="" /><span class="add">Yearly</span><br>
			<span class="style"></span><br><input placeholder="Website_Url" type="url" name="website_url" class="text" required value=""><br><br>
			<input type="submit" value="Add" class="submit"><br><br>
		</form>
	</div>
</body>

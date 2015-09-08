<?php
include'connect1.php';
if(isset($_GET['trans_id']))
{
	$trans_id=$_GET['trans_id'];
	$query1 = "SELECT website_url,trans_freq FROM Transaction WHERE Transaction.trans_id='$trans_id'";
	$query_run1 = mysql_query($query1);
	while($row1 = mysql_fetch_array($query_run1))
	{
    		@$website_url_prev = $row1[website_url];
    		@$trans_freq_prev= $row1[trans_freq];
	}
	$website_url_prev = preg_replace("(^https?://)", "", $website_url_prev);
	if($trans_freq_prev=='Hourly')
	{
		$trans_freq_prev = "00 * * * *";
		$trans_freq_prev_php = "10 * * * *";
	}
	if($trans_freq_prev=='Daily')
	{
		$trans_freq_prev = "00 00 * * *";
		$trans_freq_prev_php = "10 00 * * *";
	}
	if($trans_freq_prev=='Weekly')
	{
		$trans_freq_prev = "00 00 * * 0";
		$trans_freq_prev_php = "10 00 * * 0";
	}
	if($trans_freq_prev=='Monthly')
	{
		$trans_freq_prev = "00 00 1 * *";
		$trans_freq_prev_php = "10 00 1 * *";
	}
	if($trans_freq_prev=='Yearly')
	{
		$trans_freq_prev="00 00 1 1 *";
		$trans_freq_prev_php = "10 00 1 1 *";
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
	if(isset($_POST['trans_freq'])&&isset($_POST['website_url']))
	{
		$trans_freq = $_POST['trans_freq'];
		$website_url = $_POST['website_url'];
		if(!empty($trans_freq)&&!empty($website_url))
		{
			$query3=mysql_query("UPDATE Transaction SET trans_freq='$trans_freq', website_url='$website_url' WHERE trans_id='$trans_id'");
			if($query3)
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
				if($trans_freq_prev==$trans_freq && $website_url==$website_url_prev)
				{
				}
				else if($trans_freq_sh!=$trans_freq_prev && $website_url_prev==$website_url)
				{
					$output1 = shell_exec('crontab -l');
					$cronjob = ("$trans_freq_prev /opt/lampp/htdocs/$email.$website_url_prev.sh");
					$newcron = str_replace($cronjob,"",$output1);
					file_put_contents('/tmp/crontab.txt', $newcron.PHP_EOL);
					echo exec('crontab /tmp/crontab.txt');
					$output2 = shell_exec('crontab -l');
					$cronjob = ("$trans_freq_prev_php /opt/lampp/bin/php /opt/lampp/htdocs/$email/$website_url/ch.php");
					$newcron = str_replace($cronjob,"",$output2);
					file_put_contents('/tmp/crontab.txt', $newcron.PHP_EOL);
					echo exec('crontab /tmp/crontab.txt');
					$output3 = shell_exec('crontab -l');
					file_put_contents('/tmp/crontab.txt', $output3."$trans_freq_sh /opt/lampp/htdocs/$email.$website_url.sh".PHP_EOL);
					echo exec('crontab /tmp/crontab.txt');	
					$output4 = shell_exec('crontab -l');
					file_put_contents('/tmp/crontab.txt', $output4."$trans_freq_php /opt/lampp/bin/php /opt/lampp/htdocs/$email/$website_url/ch.php".PHP_EOL);
					echo exec('crontab /tmp/crontab.txt');	
				}
				else
				{
					$output1 = shell_exec('crontab -l');
					$cronjob = ("$trans_freq_prev /opt/lampp/htdocs/$email.$website_url_prev.sh");
					$newcron = str_replace($cronjob,"",$output1);
					file_put_contents('/tmp/crontab.txt', $newcron.PHP_EOL);
					echo exec('crontab /tmp/crontab.txt');
					$output2 = shell_exec('crontab -l');
					$cronjob = ("$trans_freq_prev_php /opt/lampp/bin/php /opt/lampp/htdocs/$email/$website_url/ch.php");
					$newcron = str_replace($cronjob,"",$output2);
					file_put_contents('/tmp/crontab.txt', $newcron.PHP_EOL);
					echo exec('crontab /tmp/crontab.txt');
					$output3 = "rm -rf /opt/lampp/htdocs/$email.$website_url_prev.sh";
					shell_exec($output3);
					$output4 = "rm -rf /opt/lampp/htdocs/$email/$website_url_prev/";
					shell_exec($output4);
					$output5 = "ps -ef | grep 'wget -r -P /opt/lampp/htdocs/$email/$website_url_prev/ $website_url_prev' | awk '{print $2}' | xargs kill";
					shell_exec($output5);
					$output6 = "export http_proxy=http://gauravs_server:5bc046cf92@10.100.1.254:8080";
					shell_exec($output6);
					$output7 = "echo -e '#!/bin/bash' >> /opt/lampp/htdocs/$email.$website_url.sh";
					shell_exec($output7);
					$output8 = "chmod 777 /opt/lampp/htdocs/$email.$website_url.sh";
					shell_exec($output8);
					$file = fopen("/opt/lampp/htdocs/$email.$website_url.sh","w");
					fwrite($file,"#!/bin/bash \nwget -r -P /opt/lampp/htdocs/$email/$website_url/ $website_url \nrm -rf /opt/lampp/htdocs/$email/$website_url/backup.3 \nmv /opt/lampp/htdocs/$email/$website_url/backup.2 /opt/lampp/htdocs/$email/$website_url/backup.3 \nmv /opt/lampp/htdocs/$email/$website_url/backup.1 /opt/lampp/htdocs/$email/$website_url/backup.2  \ncp -al /opt/lampp/htdocs/$email/$website_url/backup.0 /opt/lampp/htdocs/$email/$website_url/backup.1 \nrsync -a --delete /opt/lampp/htdocs/$email/$website_url/$website_url/ /opt/lampp/htdocs/$email/$website_url/backup.0 \ndiff -r --brief /opt/lampp/htdocs/$email/$website_url/backup.0 /opt/lampp/htdocs/$email/$website_url/backup.1 > /opt/lampp/htdocs/$email/$website_url/change.txt \nmkdir /opt/lampp/htdocs/$email/$website_url/diff\nchmod 777 /opt/lampp/htdocs/$email/$website_url/diff \ncp /opt/lampp/htdocs/project/style.css /opt/lampp/htdocs/$email/$website_url/ \nchmod 777 /opt/lampp/htdocs/$email/$website_url/style.css \ncp /opt/lampp/htdocs/project/ch.php /opt/lampp/htdocs/$email/$website_url/ \nchmod 777 /opt/lampp/htdocs/$email/$website_url/ch.php \nsed -i \"3i '$email';\" /opt/lampp/htdocs/$email/$website_url/ch.php \nsed -i \"5i '$website_url';\" /opt/lampp/htdocs/$email/$website_url/ch.php");
					fclose($file);
					$output9 = shell_exec('crontab -l');
					file_put_contents('/tmp/crontab.txt', $output9."$trans_freq_sh /opt/lampp/htdocs/$email.$website_url.sh".PHP_EOL);
					echo exec('crontab /tmp/crontab.txt');
					$output10 = shell_exec('crontab -l');
					file_put_contents('/tmp/crontab.txt', $output10."$trans_freq_php /opt/lampp/bin/php /opt/lampp/htdocs/$email/$website_url/ch.php".PHP_EOL);
					echo exec('crontab /tmp/crontab.txt');
					
				}
				header("location:index.php");
			}
			else
			{
				echo "<span class='notify'>We Could Not Update Your Details At This Moment.</span><br><br>";
			}
		}
	}
	$query1=mysql_query("select * from Transaction where trans_id='$trans_id'");
	$query2=mysql_fetch_array($query1);
}
?>
<head>
	<link type="text/css" rel="stylesheet" href="stylesheet.css">
</head>
<body>
	<div id="form">
		<p><em>Update Information</em></p>
		<form action="" method="POST">
			<input type="radio" name="trans_freq" value="Hourly" required value="" <?php if($query2['trans_freq']=='Hourly'){?>checked="checked"<? }?>/><span class="add">Hourly</span> &nbsp
			<input type="radio" name="trans_freq" value="Daily" required value="" <?php if($query2['trans_freq']=='Daily'){?>checked="checked"<? }?>/><span class="add">Daily</span> &nbsp
			<input type="radio" name="trans_freq" value="Weekly" required value="" <?php if($query2['trans_freq']=='Weekly'){?>checked="checked"<? }?>/><span class="add">Weekly</span> &nbsp
			<input type="radio" name="trans_freq" value="Monthly" required value="" <?php if($query2['trans_freq']=='Monthly'){?>checked="checked"<? }?> /><span class="add">Monthly</span> &nbsp
			<input type="radio" name="trans_freq" value="Yearly" required value="" <?php if($query2['trans_freq']=='Yearly'){?>checked="checked"<? }?> /><span class="add">Yearly</span><br>
			<span class="style"></span><br><input value="<?php echo $query2['website_url']; ?>" placeholder="Website_Url" type="url" name="website_url" class="text" required value="" ><br><br>
			<input type="submit" value="Update" class="submit"><br><br>
		</form>
	</div>
</body>                           

<?php
$email = 
$website_url = 
$handle = fopen("/opt/lampp/htdocs/$email/$website_url/change.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
		$pieces = explode(" ", $line);
		$variable1 =  $pieces[0];
		if($variable1=="Files")
		{
			$variable2 =  $pieces[1];
			$variable3 =  $pieces[3];
			ob_start(); 
			require_once '/opt/lampp/htdocs/project/class.Diff2.php';

			$d =   Diff::toTable(Diff::compareFiles("$variable2", "$variable3"));
			echo "<iframe src='http://localhost/left.html' width='49%' height='100%'></iframe>";
			echo "<iframe src='http://localhost/right.html' width='49%' height='100%'></iframe>";

			require_once '/opt/lampp/htdocs/project/class.Diff.php';

			$d = Diff1::toTable(Diff1::compareFiles("$variable2", "$variable3"));
			echo $d; 
			$content = ob_get_contents();
 			ob_end_clean();
 			$variable2 = str_replace("/", ".", $variable2);
 			$variable3 = str_replace("/", ".", $variable3);
			$search = ".opt.lampp.htdocs.$email.$website_url.";
			$variable2 = str_replace($search, '', $variable2);
			$variable3 = str_replace($search, '', $variable3);
 			file_put_contents("/opt/lampp/htdocs/$email/$website_url/diff/$variable2.$variable3.html",$content); 
			
		}
		else
		{
			 $variable1 =  $pieces[2];
			 $variable2 =  $pieces[3];
			 $variable1 = str_replace(":", "/", $variable1);
			 $output1 = "cp $variable1$variable2 /opt/lampp/htdocs/$email/$website_url/diff/";
			 shell_exec($output1);
		}
	}
	fclose($handle);
	$output1 = "tar -czpf /opt/lampp/htdocs/$email/$website_url/diff.tar.gz /opt/lampp/htdocs/$email/$website_url/diff";
	shell_exec($output1);
	require_once('/opt/lampp/htdocs/project/PHPMailer/class.phpmailer.php');
	$bodytext= "this is a body";
	$email = new PHPMailer();
	$email->From      = 'elk.vecc.gov.in';
	$email->FromName  = 'elk';
	$email->Subject   = 'Changes';
	$email->Body      = 'The following changes are';
	$email->AddAddress( 'dibyendu@vecc.gov.in' );
	#$file_to_attach = '/opt/lampp/htdocs/img';
	$email->AddAttachment( "/opt/lampp/htdocs/$email/$website_url/diff.tar.gz" );

	return $email->Send();
}
?>

<?php

include 'connect1.php';
$query = "SELECT trans_id,trans_freq,website_url from Transaction where Transaction.trans_user_id='".$_SESSION['user_id']."'";
if ($query_run = mysql_query($query))
{
	$query_num_rows = mysql_num_rows($query_run);
	if ($query_num_rows==0)
	{
		echo "<div id='view'>You have not added any details. Please enter a detail!!</div><br>";
	}
	else
	{
		echo "
			<br><table border='5xp' width='100%' style='background-color:seagreen'>
		      		<thead>
					<tr>
						<th colspan='12' style='color:Lime ;font-size:25px;font-family:Courier New'>Details Of The User</th>
					<tr>
					<tr>
						<th style='color:MediumVioletRed;font-size:23px;font-family:Times New Roman'>Frequency</th>
						<th style='color:MediumVioletRed;font-size:23px;font-family:Times New Roman'>Website_Url</th>
						<th colspan='4' style='color:MediumVioletRed;font-size:23px;font-family:Times New Roman'>Action</th>
					</tr>	
				</thead>
				
				<tbody>";
		while($query2= mysql_fetch_array($query_run))
		{
			$trans_freq = $query2['trans_freq'];
			$website_url = $query2['website_url'];
			echo "<tr>
				<td style='color:Yellow  ;font-size:23px;font-family:Times New Roman'>$trans_freq</td>
				<td style='color:Yellow ;font-size:23px;font-family:Times New Roman'>$website_url</td>
				<td><a href='update.php?trans_id=".$query2['trans_id']."'><span style='color:Yellow ;font-size:23px;font-family:Times New Roman'>Update</span></a></td>
                        	<td><a href='delete.php?trans_id=".$query2['trans_id']."'><span style='color:Yellow ;font-size:23px;font-family:Times New Roman'>Delete</span></a></td><tr>
			      <tr>";
		} 
		echo	"</tbody>
			</table><br>";
	}
}
		
?>

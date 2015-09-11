
# Web_Page_Change_Notification_System
Web Page Change Notification System notifies the changes in the 2 versions of the corresponding web page of a website. It not only notifies the changes in the web page but also the changes in the source code of the corresponding web pages. It takes the following input from the user- <br>
<br><b>1.</b> Name of the website_url <br>
<b>2.</b> Frequency at which they want to get notified of their changes(hourly,daily,weekly,monthly,yearly)</br></br>

# Platform
The system is made on <b>Linux CentOS 6.5</b>. It uses a lot of linux tools like <b>wget</b> to download the website, <b>rysnc</b> to implement incremental backup of the 2 versions of the web pages, <b>diff</b> to compare 2 version trees and finally <b>crontab</b> to manage the frequencies. It also requires the following: <br>
<b><br>1.PHP version 5.6.8 </b><br>
<b>2.Apache web server 2.2.15(Unix). </b><br>
<b>3.phpMyAdmin for web database management using MySQL ver 14.14 Distrib 5.1.73. </b></br>
       <br>It reqiures a data base with 2 tables: <br>
<br><b>1.For storing the login details of the user. </b><br>
<b>2.For storing the transaction details of the user.</b>

# Usage

Suppose a user is logged in with $email as <b>email</b>. The user then types in the $website_url as <b>website_url</b> and selects $frequency as <b>frequency</b>. As soon as he clicks on the <b>add</b> button in the page <b>add_info.php</b>, a shell file named $email.$website_url.sh is created  with the following details - <br>
<br><i>#!/bin/bash<br>
<b>Downloading the website and saving it to a directory</b><br>
wget -r -P /opt/lampp/htdocs/$email.$website_url/ $website_url<br>
<b>Incremental backup</b><br>
rm -rf /opt/lampp/htdocs/$email.$website_url/backup.3<br>
mv /opt/lampp/htdocs/$email.$website_url/backup.2 /opt/lampp/htdocs/$email.$website_url/backup.3<br>
mv /opt/lampp/htdocs/$email.$website_url/backup.1 /opt/lampp/htdocs/$email.$website_url/backup.2<br>
cp -al /opt/lampp/htdocs/$email.$website_url/backup.0 /opt/lampp/htdocs/$email.$website_url/backup.1<br>
rsync -a --delete /opt/lampp/htdocs/$email.$website_url/ /opt/lampp/htdocs/$email.$website_url/backup.0<br>
<b>Implementing the diff command</b><br>
diff /opt/lampp/htdocs/$email.$website_url/backup.0 /opt/lampp/htdocs/$email.$website_url/backup.1 > /opt/lampp/htdocs/$email.$website_url/change.txt<br>
mkdir /opt/lampp/htdocs/$email.$website_url/diff/<br>
chmod 777 /opt/lampp/htdocs/$email.$website_url/diff/<br>
cp /opt/lampp/htdocs/project/style.css /opt/lampp/htdocs/$email.$website_url/<br>
chmod 777 /opt/lampp/htdocs/$email.$website_url/style.css<br>
cp /opt/lampp/htdocs/project/ch.php /opt/lampp/htdocs/$email.$website_url/<br>
chmod 777 /opt/lampp/htdocs/$email.$website_url/ch.php<br>
sed -i "3i '$email';" /opt/lampp/htdocs/$email.$website_url/ch.php<br>
sed -i "5i '$website_url';" /opt/lampp/htdocs/$email.$website_url/ch.php<br></i>

<br>Now suppose that the user has entered the frequency as hourly, that means the users will be notified their webpage changes hourly. Now the cron syntax for hourly is 0 * * * *.<br>
Therefore, in /var/spool/cron/crontabs file, the following wil be entered,<br>
<br><i><b>Managing the crontab<br></b>
<i>0 * * * * /opt/lampp/htdocs/$email.$website_url.sh</i><br>

In this way, for all users, it will work and control the entries for each user independently.

#Author
<b>Akash Choudhary</b>

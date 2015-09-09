
# Web_Page_Change_Notification_System
Web Page Change Notification System notifies the changes in the 2 versions of the corresponding web page of a website. It not only notifies the changes in the web page but also the chnages in the source code of the corresponding web pages. It takes the following input from the user- <br>
<br><b>1.</b> Name of the website_url <br>
<b>2.</b> Frequency at which they want to get notified of their changes(hourly,daily,weekly,monthly,yearly)</br></br>

# Platform
The system is made on Linux CentOS 6.5. It uses a lot of linux tools like <b>wget</b> to download the website, <b>rysnc</b> to implement incremental backup of the 2 versions of the web pages, <b>diff</b> to compare 2 version trees and finally # crontab to manage the frequencies. It also requires the following: <br>
<b><br>1.PHP version 5.6.8 </b><br>
<b>2.Apache web server 2.2.15(Unix). </b><br>
<b>3.phpMyAdmin for web database management using MySQL ver 14.14 Distrib 5.1.73. </br>
       <br>It reqiures a data base with 2 tables: <br>
<br><b>1.For storing the login details of the user. </b><br>
<b>2.For storing the transaction details of the user.</b>

# Usage
The primary file and the starting file in index.php.

#Author
<b>Akash Choudhary</b>

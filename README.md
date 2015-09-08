
# Web_Page_Change_Notification_System
Web Page Change Notification System notifies the changes in the 2 versions of the correspondingweb page of a website. It not only notifies the changes in the web page but also the chnages in the source code of the corresponding web pages. It takes the following input from the user-
1. Name of the website_url
2. Frequency at which they want to get notified of their changes(hourly,daily,weekly,monthly,yearly)

# Platform
The system is made on Linux CentOS 6.5. It uses a lot of linux tools like # wget to download the website, #rysnc to implement incremental backup of the 2 versions of the web pages, #diff to compare 2 version trees and finally # crontab to manage the frequencies. It also requires the following:
1.PHP version 5.6.8
2.Apache web server 2.2.15(Unix).
3.phpMyAdmin for web database management using MySQL ver 14.14 Distrib 5.1.73.
       It reqiures a data base with 2 tables:
1.For storing the login details of the user.
2.For storing the transaction details of the user.

# Usage
The primary file and the starting file in index.php.

#Author
Akash Choudhary

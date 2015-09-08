# Web_Page_Change_Notification_System
Due to increasing number of people that use the Web for shopping or on-line trading,services for searching information and identifying changes on the Web, have received
renewed attention from both industry and research community. Indeed, users of e-commerce or on-line trading sites frequently need to keep track of page changes, since
they want to access pages only when their information has been updated. The detection of changes across two different versions of the web pages and notifying the changes to the user is the core
operation of Web Page Change Notification System. Such system is useful for stock broker, job seekers who are continuously monitoring the changes in the web pages.
        It uses linux tools like 'wget' to download the website, 'rsync' to manage incremental backups of different versions of website, 'diff' command to compare 2 versions of webpages and 'crontab' to manage the frequencies of notification. It is build up on Linux CentOS 6.5 and uses PHP version 5.6.8, Apache web server 2.2.15(Unix), phpMyAdmin for web database management using MySQL ver 14.14 Distrib 5.1.73.

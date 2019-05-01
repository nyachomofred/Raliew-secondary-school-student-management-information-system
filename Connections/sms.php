<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_sms = "localhost";
$database_sms = "sms";
$username_sms = "root";

$password_sms = "";
$sms = mysql_pconnect($hostname_sms, $username_sms, $password_sms) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
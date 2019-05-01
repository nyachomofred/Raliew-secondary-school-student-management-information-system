<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php require_once('Admin_dash.html');?>
</head>

<body>
    <div class="content">
    <form action="" method="post" name="frmLogin"><table width="500" cellpadding="5">
  <tr>
    <td><label for="txtUsernam">Username</label></td>
    <td><input type="text" name="txtUsernam" id="txtUsernam" /></td>
  </tr>
  <tr>
    <td><label for="txtPasswd">Password</label></td>
    <td><input type="text" name="txtPasswd" id="txtPasswd" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="btnLogin" id="btnLogin" value="Login" /></td>
  </tr>
</table>
</form>
    </div><!--end of content div-->

</body>
</html>
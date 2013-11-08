<?PHP  /*
    
    PHPValley Micro Jobs Site Script
    Copyright (C) 2012  Ozgur Zeren (unity100@gmail.com)

    This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see http://www.gnu.org/licenses/gpl.html.
*/
 


session_start();  include "../connect.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login</title>
<link href="css/960.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/text.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/login.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<div class="container_16">
  <div class="grid_6 prefix_5 suffix_5">
   	  <h1>Admin - Login</h1>
    	<div id="login">
<?PHP      ob_start();
          if (isset($_POST['login'])) // name of submit button
{

$user_name= mysql_real_escape_string($_POST['user_name']);
	$password=mysql_real_escape_string($_POST['password']);
	$password=md5($password);

    $query = "select * from logintable where user_name='$user_name' and password='".$password."'";
	$result=mysql_query($query) or die("Could not Query");
	$result2=mysql_fetch_array($result);
	if($result2)
	{



    $_SESSION['user_name']=$user_name;
    echo "<center><p>Logging In....<p><br /><img src=\"../images/rating_loading.gif\" width=\"220\" height=\"19\" alt=\"\" /></center><META HTTP-EQUIV = 'Refresh' Content = '0; URL =adminindex.php'>";
    }
	else
{
echo '<p class="error">
Wrong username or password!
</p>';
}
}
ob_end_flush();
?>
    	  <form id="form1" name="form1" method="post" action="">
    	    <p>
    	      <label><strong>Username</strong>
<input type="text" class="inputText" id="username" name="user_name" value="admin" />
    	      </label>
  	      </p>
    	    <p>
    	      <label><strong>Password</strong>
  <input type="password" class="inputText" id="password" name="password" value="password" />
  	        </label>
    	    </p>
            <!--<input type="checkbox" name="remember" value="remember" /> Remember Me?-->
            <input type="submit" name="login" value="Login">
            <!--<button id="login" value="Login" type="submit" name="submit"></button>-->

    	  </form>
		  <br clear="all" />
    	</div>

  </div>
</div>
<br clear="all" />
</body>
</html>

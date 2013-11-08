<?PHP 

/*
    
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


include 'languages/'.$lang_file.'/'.$lang_file.'.php'; ?>
<div class="sidebar">
<script language="JavaScript" type="text/javascript">
<!--
function validate_Form ( )
{
valid = true;
        if ( document.suggest.text.value == "" )
        {
                alert ( "Try typing a suggestion" );
                valid = false;
        }
        return valid;
}

//-->
</script>
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
 function validate_Request ( )
{
valid = true;
        if ( document.request.amount.value == "" )
        {
                alert ( "Try typing an amount" );
                valid = false;
        }
        return valid;
}
/*]]>*/
</script>
<?PHP
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$currency_symbol =  $row["currency_symbol"];
$domain =  $row["domain"];
$site_email =  $row["site_email"];
$twitter_username =  $row["twitter_username"];
$latest_tweets =  $row["latest_tweets"];
$suggestions =  $row["suggestions"];

}
if (isset($_SESSION['userName'])) {?>
<h2><?PHP echo $lang['MY_ACCOUNT']?></h2>
<ul class="sb_menu">
<div class="user">
<p><?PHP echo $lang['WELCOME']?>: <?PHP echo $_SESSION['userName'] ?></p>
<?PHP $sql = "select * from members where userName='".$_SESSION['userName']."'";
$sql2=mysql_query($sql);
$myrow=mysql_fetch_array($sql2);
$abalance = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'balance')));
echo "<p>".$lang['YOUR_BALANCE'].":$currency_symbol$abalance</p></div>";
if ($abalance > $minbalance){

$sql = "select * from members where userName='".$_SESSION['userName']."'";
$sql2=mysql_query($sql);
$myrow=mysql_fetch_array($sql2);
$balance = $myrow['balance'];
$email = $myrow['ppemail'];

?>
<div class="pay_req" style="cursor: pointer;"><?PHP echo $lang["REQUEST_PAYMENT"] ?> <img src="images/tick.png" alt="" border="0"></div>
<div class="req" style="display: none;">
<div class="feedback">
<?PHP echo $lang['AM_REQ']?>  (Max <?PHP echo"$currency_symbol$balance"?>)
<form action="requests.php" method="post" name="request" onsubmit="return validate_Request ( );">
<input type="hidden" value="<?PHP echo $_SESSION['userName']?>" name="username">
<input type="hidden" value="<?PHP echo $balance?>" name="balance">
<input type="hidden" value="<?PHP echo $email?>" name="email">
<input type="text" size="8" name="amount">&nbsp;<input type="submit"  name="request" value="Submit">
</form>
</div>
</div>
<script>
    $("div.pay_req").click(function () {
      $("div.req").slideToggle("slow");
    });
</script>
<?PHP }?>
<li><a href="requests.php"><?PHP echo $lang['P_REQUESTS']?></a></li>
<li><a href="submit_job.php"><?PHP echo $lang['POST_A_JOB']?></a></li>
<li><a href="profile-<?PHP echo $_SESSION['userName'] ?>"><?PHP echo $lang['MY_JOBS']?></a></li>
<li><a href="sales.php"><?PHP echo $lang['MY_SALES']?></a></li>
<li><a href='my_orders.php'><?PHP echo $lang['MY_ORDERS']?></a></li>
<li><a href='bookmarks.php'><?PHP echo $lang['MY_BOOKMARKS']?></a></li>
<li><a href='edit_profile.php'><?PHP echo $lang['EDIT_PROFILE']?></a></li>
<li><a href='mailbox_inbox.php'><?PHP echo $lang['INBOX']?></a></li>
<li><a href='mailbox.php'><?PHP echo $lang['SENT_MAIL']?></a></li>
<li><a href='change_pass.php'><?PHP echo $lang['CHANGE_PASS']?></a></li>
</ul>
<?PHP }?>
          <h2><?PHP echo $lang['CATEGORIES'] ?></h2>
          <ul class="sb_menu">
            <?PHP include("php/categories.php");?>
          </ul><div class="clear"></div>
          <?PHP if($google_ads == 'yes') { echo '<div align="center">';
include("google_ads/google_125x125.php"); echo '</div>'; }
?>
          <div class="twitter">
          <object type="application/x-shockwave-flash" data="http://www.buzzbuttons.com/BUTTON8/twitbutton.swf" width="190" height="190">
          <param name="movie" value="http://www.buzzbuttons.com/BUTTON8/twitbutton.swf">
          </param><param name="allowscriptaccess" value="always"></param>
          <param name="menu" value="false"></param><param name="wmode" value="transparent"></param>
          <param name="flashvars" value="username=<?PHP echo $twitter_username?>"></param>
          <embed src="http://www.buzzbuttons.com/BUTTON8/twitbutton.swf" type="application/x-shockwave-flash" allowscriptaccess="always" width="190" height="190" menu="false" wmode="transparent" flashvars="username=phpvalley">
          </embed></object></div>
<?PHP if($latest_tweets == 'yes') { ?>
          <h2><?PHP echo $lang['LATEST_TWEETS']?><hr color="#42CCE6" />
<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 10,
  interval: 6000,
  width: 180,
  height: 220,
  theme: {
    shell: {
      background: '#81DCEF',
      color: '#444444'
    },
    tweets: {
      background: '#F6FEFF',
      color: '#404466',
      links: '#5b3dbd'
    }
  },
  features: {
    scrollbar: true,
    loop: true,
    live: false,
    hashtags: true,
    timestamp: true,
    avatars: false,
    behavior: 'default'
  }
}).render().setUser('<?PHP echo $twitter_username?>').start();
</script></h2>
<?PHP } ?>
<?PHP if($suggestions == 'yes') { ?>
          <h2><?PHP echo $lang['SUGGEST']?></h2>
          <div class="suggest">
          <form  method="post" name="suggest" onsubmit="return validate_Form ( );">
<?PHP
if(empty($_SESSION['userName'])) {
echo "<h2>".$lang['LOOKING'].":</h2>";
}else{echo "<h2>".$_SESSION['userName']." ".$lang["WANTS"].":</h2>";}?>
<input type="hidden" name="username" value="<?PHP echo $_SESSION['userName']?>"/>
<input type="hidden" name="postdate" value="<?PHP echo date("j, n, Y");?>"/>
<textarea class="suggestion-box" cols="19" rows="5" name="text"><?PHP if(empty($_SESSION['userName'])) {echo "Login to suggest a job";}?></textarea>
<?PHP
if(empty($_SESSION['userName'])) { ?>
<a class='Button' href="#" id="trigger_login"><?PHP echo $lang['SUGGEST']?></a>
<?PHP }else{ ?><input name="suggest" type="submit"  id="submitmsg" class="Button" value="<?PHP echo $lang['SUGGEST']?>"/>
<?PHP } ?>
</form>
<?PHP
if(isset($_POST['suggest'])){
$username = strip_tags($_POST['username']);
$text = strip_tags(nl2br($_POST['text']));
$postdate = strip_tags($_POST['postdate']);
$query = sprintf("INSERT INTO suggestions (username, text,postdate)
            VALUES( '%s', '%s', '%s')",
            mysql_real_escape_string($username),
            mysql_real_escape_string($text),
            mysql_real_escape_string($postdate));
// run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
else {

$to      = "lightsites@gmail.com";
$subject = "New suggestion";
$message = "New Suggestion on five.triplegood.co.za";
$headers = 'From: support@triplegood.co.za' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);

}
header( 'Location: ./' ) ;
}
$per_page = 20;
$sql = "select * from suggestions where active = 1";
$rsd = mysql_query($sql);
$count = mysql_num_rows($rsd);
$pages = ceil($count/$per_page)
?>
<div style="margin-top:10px;padding:0;"></div>
<div id="chatbox">
<div id="content"></div>
</div>
<div id="paging_button">
<ul>
<?PHP if(($count) < $per_page){echo "";}else{
for($i=1; $i<=$pages; $i++)
{
echo '<li id="'.$i.'">'.$i.'</li>';
}
}
?>
</ul><br /><br />
</div>
</div>
<?PHP } ?>
      </div>
      <div class="clr"></div>
    </div>
  </div>
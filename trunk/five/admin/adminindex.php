<? 

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
 

session_start(); ob_start();

$page = 'adminindex';
if(!empty($_SESSION['user_name'])) {
  include("header.php");
$passchangemsg ='';
$passusermsg ='';
if (isset($_POST['changeuser']))
{
  $username=trim(strtolower($_POST['auser']));
  if($username != ''){
   $Query = "UPDATE logintable SET user_name='".$username."'";
		$Result=mysql_query($Query) or die("Could not Query");
        if(mysql_affected_rows() > 0){
        $passusermsg = "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Username Changed Successfully. </span></p>";
        }else{
			$passusermsg ="<p class=\"info\" id=\"error\"><span class=\"info_inner\">Error! Username wasnt changed.</span></p>";
		}
  }
}


if (isset($_POST['changepass']))
{
	$cpass=md5($_POST['cpass']);
	$npass=trim($_POST['npass']);
	$npassc=trim($_POST['npassc']);

	if($npass == $npassc && !empty($npass)){
		$query = "UPDATE logintable SET password='".md5($npass)."' where user_name='".$_SESSION['user_name']."' and password='$cpass'";
		$result=mysql_query($query) or die("Could not Query");
		if(mysql_affected_rows() > 0){
			$_SESSION['userName'] = $username;
			$passchangemsg = "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Password Changed Successfully. </span></p>";
		}elseif (md5($npass) == $cpass){
			$passchangemsg = "<p class=\"info\" id=\"error\"><span class=\"info_inner\">The new password is the same as the old password.</span></p>";
		}else{
			$passchangemsg ="<p class=\"info\" id=\"error\"><span class=\"info_inner\">You have entered a wrong current password.</span></p>";
		}
	}else{
		$passchangemsg ="<p class=\"info\" id=\"error\"><span class=\"info_inner\">Password and Confirm Password are not the same.</span></p>";
}
}
?>
<!-- CONTENT START -->
    <div class="grid_16" id="content">
    <div class="grid_9">
<h1 class="dashboard">Admin Index</h1>
    </div>
    <div class="clear"></div>
    <div class="lang">
    <h3>This is where you change various settings for your site.<br />Please take a few minutes going through the options in the left hand column which are neccessary for the smooth running of your site.<br />
    In the right hand column you can change your admin username and password, there are also some stats relating to your site here also.</h3></div>
    <div class="clear">
    </div>
    <div id="portlets">
    <div class="column" id="left">

<?PHP
$sql="Select * from sitesettings WHERE config_id='".mysql_real_escape_string('1')."'";
        $sql2=mysql_query($sql);
        $myrow=mysql_fetch_array($sql2);
		if(!$myrow)
        {
			print "<p class=\"info\" id=\"error\"><span class=\"info_inner\"></span></p>";

		}
		else //if entry exists
             {
            $asite_url = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'site_url')));
            $adomain = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'domain')));
            $atagline = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'tagline')));
            $aslogan = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'slogan')));
            $adescription = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'description')));
			$akeywords = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'keywords')));
            $aprice = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'price')));
            $afee = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'fee')));
            $afeatured_fee = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'featured_fee')));
            $amin_balance = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'min_balance')));
            $agoogle_ads = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'google_ads')));
            $apubid = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'pubid')));
			$agoogle_channel = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'google_channel')));
            $aapikey = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'apikey')));
			$aapisecret = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'apisecret')));
            $atwitter_key = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'twitter_key')));
			$atwitter_sec = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'twitter_sec')));
            $appemail = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'ppemail')));
            $atwitter_username = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'twitter_username')));
            $asite_email = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'site_email')));
            $amod_job = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'mod_job')));
            $afeat_num = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'feat_num')));
            $acurrency = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'currency')));
            $acurrency_symbol = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'currency_symbol')));
            $aoauthkey = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'oauthkey')));
            $aoauthsecret = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'oauthsecret')));
            $atweet = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'tweet')));
            $alang = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'lang')));
            $aprice_range = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'price_range')));
            $adropdown = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'dropdown')));
            $alatest_tweets = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'latest_tweets')));
            $asuggestions = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'suggestions')));
            $ashow_alert = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'show_alert')));

if (isset($_POST['changesettings']))
	{
		$editid = mysql_real_escape_string($_POST['config_id']);

        $site_url=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['site_url']));
        $domain=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['domain']));
        $tagline=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['tagline']));
        $slogan=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['slogan']));
        $description=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['description']));
		$keywords=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['keywords']));
        $price=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['price']));
        $fee=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['fee']));
        $featured_fee=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['featured_fee']));
        $min_balance=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['min_balance']));
        $google_ads=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['google_ads']));
        $pubid=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['pubid']));
        $google_channel=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['google_channel']));
        $apikey=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['apikey']));
		$apisecret=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['apisecret']));
        $twitter_key=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['twitter_key']));
		$twitter_sec=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['twitter_sec']));
        $ppemail=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['ppemail']));
        $twitter_username=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['twitter_username']));
        $site_email=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['site_email']));
        $mod_job=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['mod_job']));
        $feat_num=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['feat_num']));
        $currency=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['currency']));
        $currency_symbol=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['currency_symbol']));
        $oauthkey=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['oauthkey']));
        $oauthsecret=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['oauthsecret']));
        $tweet=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['tweet']));
        $lang=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['lang']));
        $price_range=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['price_range']));
        $dropdown=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['dropdown']));
        $latest_tweets=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['latest_tweets']));
        $suggestions=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['suggestions']));
        $show_alert=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['show_alert']));
        $edit1 = "UPDATE sitesettings SET site_url='$site_url' WHERE config_id = '1'";
		mysql_query($edit1) or die("could not edit");
        $edit2 = "UPDATE sitesettings SET domain='$domain' WHERE config_id = '1'";
		mysql_query($edit2) or die("could not edit");
        $edit3 = "UPDATE sitesettings SET tagline='$tagline' WHERE config_id = '1'";
		mysql_query($edit3) or die("could not edit");
        $edit4 = "UPDATE sitesettings SET slogan='$slogan' WHERE config_id = '1'";
		mysql_query($edit4) or die("could not edit");
        $edit5 = "UPDATE sitesettings SET description='$description' WHERE config_id = '1'";
		mysql_query($edit5) or die("could not edit");
		$edit6 = "UPDATE sitesettings SET keywords='$keywords' WHERE config_id = '1'";
		mysql_query($edit6) or die("could not edit");
        $edit7 = "UPDATE sitesettings SET fee='$fee' WHERE config_id = '1'";
		mysql_query($edit7) or die("could not edit");
        $edit8 = "UPDATE sitesettings SET price='$price' WHERE config_id = '1'";
		mysql_query($edit8) or die("could not edit");
        $edit9 = "UPDATE sitesettings SET featured_fee='$featured_fee' WHERE config_id = '1'";
		mysql_query($edit9) or die("could not edit");
        $edit10 = "UPDATE sitesettings SET min_balance='$min_balance' WHERE config_id = '1'";
		mysql_query($edit10) or die("could not edit");
        $edit11 = "UPDATE sitesettings SET google_ads='google_ads' WHERE config_id = '1'";
		mysql_query($edit11) or die("could not edit");
        $edit12 = "UPDATE sitesettings SET pubid='$pubid' WHERE config_id = '1'";
		mysql_query($edit12) or die("could not edit");
        $edit13 = "UPDATE sitesettings SET google_channel='$google_channel' WHERE config_id = '1'";
		mysql_query($edit13) or die("could not edit");
        $edit14 = "UPDATE sitesettings SET apikey='$apikey' WHERE config_id = '1'";
		mysql_query($edit14) or die("could not edit");
		$edit15 = "UPDATE sitesettings SET apisecret='$apisecret' WHERE config_id = '1'";
		mysql_query($edit15) or die("could not edit");
        $edit16 = "UPDATE sitesettings SET twitter_key='$twitter_key' WHERE config_id = '1'";
		mysql_query($edit16) or die("could not edit");
		$edit17 = "UPDATE sitesettings SET twitter_sec='$twitter_sec' WHERE config_id = '1'";
		mysql_query($edit17) or die("could not edit");
        $edit18 = "UPDATE sitesettings SET ppemail='$ppemail' WHERE config_id = '1'";
		mysql_query($edit18) or die("could not edit");
        $edit19 = "UPDATE sitesettings SET twitter_username='$twitter_username' WHERE config_id = '1'";
		mysql_query($edit19) or die("could not edit");
        $edit20 = "UPDATE sitesettings SET site_email='$site_email' WHERE config_id = '1'";
		mysql_query($edit20) or die("could not edit");
        $edit21 = "UPDATE sitesettings SET mod_job='$mod_job' WHERE config_id = '1'";
		mysql_query($edit21) or die("could not edit");
        $edit22 = "UPDATE sitesettings SET feat_num='$feat_num' WHERE config_id = '1'";
		mysql_query($edit22) or die("could not edit");
        $edit23 = "UPDATE sitesettings SET currency='$currency' WHERE config_id = '1'";
		mysql_query($edit23) or die("could not edit");
        $edit24 = "UPDATE sitesettings SET currency_symbol='$currency_symbol' WHERE config_id = '1'";
		mysql_query($edit24) or die("could not edit");
        $edit25 = "UPDATE sitesettings SET oauthkey='$oauthkey' WHERE config_id = '1'";
		mysql_query($edit25) or die("could not edit");
        $edit26 = "UPDATE sitesettings SET oauthsecret='$oauthsecret' WHERE config_id = '1'";
		mysql_query($edit26) or die("could not edit");
        $edit27 = "UPDATE sitesettings SET lang='$lang' WHERE config_id = '1'";
		mysql_query($edit27) or die("could not edit");
        $edit28 = "UPDATE sitesettings SET price_range='$price_range' WHERE config_id = '1'";
		mysql_query($edit28) or die("could not edit");

  mysql_query("UPDATE sitesettings SET google_ads='$google_ads' WHERE config_id = '1'") or die(mysql_error());
  mysql_query("UPDATE sitesettings SET mod_job='$mod_job' WHERE config_id = '1'") or die(mysql_error());
  mysql_query("UPDATE sitesettings SET tweet='$tweet' WHERE config_id = '1'") or die(mysql_error());
  mysql_query("UPDATE sitesettings SET dropdown='$dropdown' WHERE config_id = '1'") or die(mysql_error());
  mysql_query("UPDATE sitesettings SET latest_tweets='$latest_tweets' WHERE config_id = '1'") or die(mysql_error());
  mysql_query("UPDATE sitesettings SET suggestions='$suggestions' WHERE config_id = '1'") or die(mysql_error());
  mysql_query("UPDATE sitesettings SET show_alert='$show_alert' WHERE config_id = '1'") or die(mysql_error());
  echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Settings updated successfully!</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '0; URL =adminindex.php'>";
}
?>
      <div class="portlet">
		<div class="portlet-header">Sitesettings</div>
		<div class="portlet-content">
		  <h3>Change site settings</h3>
		  <form id="form1" name="form1" method="post">
          <input type="hidden" name="auser" value="<?php echo $_SESSION['user_name']?>" >
		    <label>Site Url:</label>
		    <input type="text" name='site_url' value='<?php echo $asite_url?>' class="largeInput" />
			<label>Domain (No http://www.):</label>
            <input type="text" name='domain' value='<?php echo $adomain?>' class="largeInput" />
            <label>Site Tagline:</label>
            <input type="text" name='tagline' type='text' value='<?php echo $atagline = htmlspecialchars($atagline, ENT_QUOTES);?>' class="largeInput" /><br />
            <!--<label>Site Slogan:</label>
		    <input type="text" name='slogan' type='text' value='<?php echo $aslogan = htmlspecialchars($aslogan, ENT_QUOTES);?>' class="largeInput" />-->
			<label>Site Description:</label>
            <textarea name="description" cols="45" rows="3" class="largeInput" id="textarea"><?php echo $adescription = htmlspecialchars($adescription, ENT_QUOTES);?></textarea>
            <label>Site Keywords:</label>
            <textarea name="keywords" cols="45" rows="3" class="largeInput" id="textarea"><?php echo $akeywords = htmlspecialchars($akeywords, ENT_QUOTES);?></textarea><br />
            <label>Job Prices:(i:e 5,10,15 etc, seperating each one with a comma)</label>
            <textarea name="price_range" cols="45" rows="2" class="largeInput" id="textarea"><?php echo $aprice_range?></textarea><br />

            <label>Sellers Fee (Your profit, as a percentage %):</label>
		    <input name='fee' type='text' value='<?php echo $afee?>' class="smallInput" />
			<label>Featured Fee (For featured listings, as a percentage %):</label>
            <input name='featured_fee' type='text' value='<?php echo $afeatured_fee?>' class="smallInput" />
            <label>Featured Number (How many featured jobs to show on front page.):</label>
            <input name='feat_num' type='text' value='<?php echo $afeat_num?>' class="smallInput" /><br />
            <label>Default Language:</label>
            <?PHP
$sql2 = "select lang from sitesettings";
$rec2 = mysql_query($sql2) or die(mysql_error());
while($row2 = mysql_fetch_array($rec2)) {
$lang2 = $row2['lang'];
}
$sql3 = "select * from languages where abb= '$lang2'";
$rec3 = mysql_query($sql3) or die(mysql_error());
while($row3 = mysql_fetch_array($rec3)) {
$Language = $row3['language'];
$abb3 = $row3['abb'];
}
print "<select class=\"smallInput\"  name=\"lang\">\n";
$language = $post['language'];

print "<option value=\"".$abb3."\">".$Language."\n</option>";

$result = @mysql_query("select * from languages order by language asc");


while ($row = mysql_fetch_assoc($result))
{

$language = $row['language'];
$abb = $row['abb'];

print "<option value=\"".$abb."\">".$language."\n</option>";
}
print "</select>\n";

?>
            <label>Currency:</label>
		    <select name="currency" size="1" class="smallInput">
<option value="<?php echo $acurrency?>"><?php echo $acurrency?></option>
<option value="AUD">AUD ~ Australian Dollar</option>
<option value="BRL">BRL ~ Brazilian Real</option>
<option value="CAD">CAD ~ Canadian Dollar</option>
<option value="CZK">CZK ~ Czech Koruna</option>
<option value="DKK">DKK ~ Danish Krone</option>
<option value="EUR">EUR ~ Euro</option>
<option value="HKD">HKD ~ Hong Kong Dollar</option>
<option value="HUF">HUF ~ Hungarian Forint</option>
<option value="ILS">ILS ~ Israeli New Sheqel</option>
<option value="JPY">JPY ~ Japanese Yen</option>
<option value="MYR">MYR ~ Malaysian Ringgit</option>
<option value="MXN">MXN ~ Mexican Peso</option>
<option value="NOK">NOK ~ Norwegian Krone</option>
<option value="NZD">NZD ~ New Zealand Dollar</option>
<option value="PHP">PHP ~ Philippine Peso</option>
<option value="PLN">PLN ~ Polish Zloty</option>
<option value="GBP">GBP ~ Pound Sterling</option>
<option value="SGD">SGD ~ Singapore Dollar</option>
<option value="SEK">SEK ~ Swedish Krona </option>
<option value="CHF">CHF ~ Swiss Franc</option>
<option value="TWD">TWD ~ Taiwan New Dollar</option>
<option value="THB">THB ~ Thai Baht</option>
<option value="TRY">TRY ~ Turkish Lira</option>
<option value="USD">USD ~ U.S. Dollar</option>
</select>
			<label>Currency Symbol: </label>
            <select name="currency_symbol" size="1" class="smallInput">
<option value="<?php echo $acurrency_symbol?>"><?php echo $acurrency_symbol?></option>
<option value="$">$</option>
<option value="BRL">BRL</option>
<option value="CZK">CZK</option>
<option value="DKK">DKK</option>
<option value="&euro;">&euro;</option>
<option value="HKD">HKD</option>
<option value="HUF">HUF</option>
<option value="ILS">ILS</option>
<option value="&yen;">&yen;</option>
<option value="MYR">MYR</option>
<option value="MXN">MXN</option>
<option value="NOK">NOK</option>
<option value="PHP">PHP</option>
<option value="PLN">PLN</option>
<option value="&pound;">&pound;</option>
<option value="SGD">SGD</option>
<option value="SEK">SEK</option>
<option value="CHF">CHF</option>
<option value="TWD">TWD</option>
<option value="THB">THB</option>
<option value="TRY">TRY</option>
</select>
    <label>Minimum payout (Minimum payment threshold): <?php echo $acurrency?></label>
    <input name='min_balance' type='text' value='<?php echo $amin_balance?>' class="smallInput" /><br />
    <hr color="#808080" /><label>Show Dropdown?:(Show the price dropdown filter on the home page, set to 'No' if using just one price)</label>
    <input name="dropdown" type="radio" value="yes" <?php if($adropdown == 'yes') {?>checked="checked"<? }?> /> Yes
    <input name="dropdown" type="radio" value="no" <?php if($adropdown == 'no') {?>checked="checked"<? }?> /> No
    <hr color="#808080" /><label>Show Ads:</label>
    <input name="google_ads" type="radio" value="yes" <?php if($agoogle_ads == 'yes') {?>checked="checked"<? }?> /> yes
    <input name="google_ads" type="radio" value="no" <?php if($agoogle_ads == 'no') {?>checked="checked"<? }?> /> no
    <hr color="#808080" /><label>Show latest tweets module?:</label>
    <input name="latest_tweets" type="radio" value="Yes" <?php if($alatest_tweets == 'yes') {?>checked="checked"<? }?> /> Yes
    <input name="latest_tweets" type="radio" value="No" <?php if($alatest_tweets == 'no') {?>checked="checked"<? }?> /> No
    <hr color="#808080" /><label>Show suggestions module?:</label>
    <input name="suggestions" type="radio" value="Yes" <?php if($asuggestions == 'yes') {?>checked="checked"<? }?> /> Yes
    <input name="suggestions" type="radio" value="No" <?php if($asuggestions == 'no') {?>checked="checked"<? }?> /> No
    <hr color="#808080" /><label>Moderate Jobs?:</label>
    <input name="mod_job" type="radio" value="Yes" <?php if($amod_job == 'Yes') {?>checked="checked"<? }?> /> Yes
    <input name="mod_job" type="radio" value="No" <?php if($amod_job == 'No') {?>checked="checked"<? }?> /> No
    <hr color="#808080" /><label>Auto post to twitter?:</label>
    <input name="tweet" type="radio" value="Yes" <?php if($atweet == 'yes') {?>checked="checked"<? }?> /> Yes
    <input name="tweet" type="radio" value="No" <?php if($atweet == 'no') {?>checked="checked"<? }?> /> No
     <hr color="#808080" /><label>Google Pub Id (Just the numbers):</label>
            <input name='pubid' type='text' value='<?php echo $apubid?>' class="largeInput" />
            <label>Google Channel: (Optional)</label>
            <input name='google_channel' type='text' value='<?php echo $agoogle_channel?>' class="largeInput" /><br />
            <label>Facebook Apikey:</label>
		    <input name='apikey' type='text' value='<?php echo $aapikey?>' class="largeInput" />
			<label>Facebook Api Secret Key:</label>
            <input name='apisecret' type='text' value='<?php echo $aapisecret?>' class="largeInput" />
            <label>Twitter Consumer Key:</label>
            <input name='twitter_key' type='text' value='<?php echo $atwitter_key?>' class="largeInput" /><br />
            <label>Twitter consumer Secret:</label>
		    <input name='twitter_sec' type='text' value='<?php echo $atwitter_sec?>' class="largeInput" />
			<label>Twitter oauth Key:</label>
            <input name='oauthkey' type='text' value='<?php echo $aoauthkey?>' class="largeInput" />
            <label>Twitter oauth Secret:</label>
            <input name='oauthsecret' type='text' value='<?php echo $aoauthsecret?>' class="largeInput" /><br />
            <label>Paypal Email:</label>
		    <input name='ppemail' type='text' value='<?php echo $appemail?>' class="largeInput" />
			<label>Twitter Username:</label>
            <input name='twitter_username' type='text' value='<?php echo $atwitter_username?>' class="largeInput" />
            <label>Site Email:</label>
            <input name='site_email' type='text' value='<?php echo $asite_email?>' class="largeInput" /><p>&nbsp;</p>
            <input type="submit" class="submit" name='changesettings' value='Save Changes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' name='submit' class="submit" value='Reset Form' />
		  </form>
		  <p>&nbsp;</p>
		</div>
        </div>
      </div>
      <!-- FIRST SORTABLE COLUMN END -->
      <!-- SECOND SORTABLE COLUMN START -->
      <div class="column">
      <!--THIS IS A PORTLET-->

      <div class="portlet">
		<div class="portlet-header">Change admin username & password</div>
		<div class="portlet-content">

        <?php echo $passusermsg;?>
      <h3>Change admin username</h3>
<?php $res = mysql_query("SELECT user_name FROM logintable");
while($row = mysql_fetch_array($res))
{
$user_name = $row['user_name'];
} ?>
		  <form id="form1" name="form1" method="post">
            <label>Username:</label>
            <input type="text" name="auser" class="largeInput"value="<?php echo $user_name?>" ><p>&nbsp;</p>
            <input type="submit" class="submit" name="changeuser" value="Update Username">
		  </form><p>&nbsp;</p><hr>
          <?php echo $passchangemsg;?>
          <h3>Change admin password</h3>
          <form id="form1" name="form1" method="post">
            <label>Current Password:</label>
		    <input type="text" name="cpass" class="largeInput" />
			<label>new Password:</label>
            <input type="text" name="npass" class="largeInput" />
            <label>Confirm Password:</label>
            <input type="text" name="npassc" class="largeInput" /><p>&nbsp;</p>
            <input type="submit" class="submit" name="changepass" value="Update Password">
		  </form>
		  <p>&nbsp;</p>
		</div>
        </div>
<?PHP
$mem = mysql_query("SELECT * FROM members");
$members = mysql_num_rows($mem);
$job = mysql_query("SELECT * FROM jobs where `approved` = 'yes'");
$jobs = mysql_num_rows($job);
$nojob = mysql_query("SELECT * FROM jobs where `approved` = 'no'");
$nojobs = mysql_num_rows($nojob);
$sold = mysql_query("SELECT * FROM jobs_sold");
$jobs_sold = mysql_num_rows($sold);
$cats = mysql_query("SELECT * FROM categories");
$cat_no = mysql_num_rows($cats);
$suggs = mysql_query("SELECT * FROM suggestions");
$suggs_no = mysql_num_rows($suggs);
?>
      <div class="portlet">
            <div class="portlet-header"><img src="images/icons/chart_bar.gif" width="16" height="16" alt="Reports" /> Site Stats:</div>
            <div class="portlet-content">
            <table width="90%" cellpadding="2" cellspacing="3" >
              <tr>
                <td>Registered Members:</td>
                <td><b><?PHP echo $members;?></b></td>
              </tr>
              <tr>
                <td>Total Approved Jobs:</td>
                <td><b><?PHP echo $jobs;?></b></td>
              </tr>
              <tr>
                <td>Jobs waiting approval:</td>
                <td><b><?PHP echo $nojobs;?></b></td>
              </tr>
              <tr>
                <td>Total Orders:</td>
                <td><b><?PHP echo $jobs_sold;?></b></td>
              </tr>
              <tr>
                <td>Total Categories:</td>
                <td><b><?PHP echo $cat_no;?></b></td>
              </tr>
              <tr>
                <td>Total Suggestions:</td>
                <td><b><?PHP echo $suggs_no;?></b></td>
              </tr>
            </table>

            </div>
        </div>
       <div class="portlet">
            <div class="portlet-header"><img src="images/icons/chart_bar.gif" width="16" height="16" alt="Reports" /> Server Info:</div>
            <div class="portlet-content">

              <?php echo $_SERVER['SERVER_SOFTWARE'];?><br />
            <?php //echo lang('PHP_VER');?>Php version:
              <?php echo phpversion();?><br />
            <?php //echo lang('MYSQL_VERSION');?>Mysql Version:
              <?php echo mysql_get_server_info();?><br />
            <?php //echo lang('SERVER_TIME');?>Server Time:
             <?php echo date('h:i:sA m/d/Y');?>
            </div>
        </div>
    </div>

   </div>
    <div class="clear"> </div>
<!-- END CONTENT-->
  </div>
  <?PHP }} else{header( 'Location: index.php' ) ;}
 include("footer.php"); ob_flush();?>
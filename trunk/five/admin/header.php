<?PHP /*
    
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
 


session_start(); include "../connect.php";
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$siteurl = $row['site_url'];
$domain = $row['domain'];
$consumer_key = $row['twitter_key'];
$consumer_secret = $row['twitter_sec'];
$oAuthToken = $row['oauthkey'];
$oAuthSecret = $row['oauthsecret'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
<link rel="stylesheet" type="text/css" href="css/960.css" />
<link rel="stylesheet" type="text/css" href="css/reset.css" />
<link rel="stylesheet" type="text/css" href="css/text.css" />
<link rel="stylesheet" type="text/css" href="css/blue.css" />
<link type="text/css" href="css/smoothness/ui.css" rel="stylesheet" />
<link type="text/css" href="js/wysiwyg/jquery.wysiwyg.css" rel="stylesheet" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/wysiwyg/jquery.wysiwyg.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		$('#wysiwyg').wysiwyg();
	});
    </script>

    <script type="text/javascript" src="js/blend/jquery.blend.js"></script>
	<script type="text/javascript" src="js/ui.core.js"></script>
	<script type="text/javascript" src="js/ui.sortable.js"></script>    
    <script type="text/javascript" src="js/ui.dialog.js"></script>
    <script type="text/javascript" src="js/ui.datepicker.js"></script>
    <script type="text/javascript" src="js/effects.js"></script>
    <script type="text/javascript" src="js/flot/jquery.flot.pack.js"></script>
    <!--[if IE]>
    <script language="javascript" type="text/javascript" src="js/flot/excanvas.pack.js"></script>
    <![endif]-->
	<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" href="css/iefix.css" />
	<script src="js/pngfix.js"></script>
    <script>
        DD_belatedPNG.fix('#menu ul li a span span');
    </script>        
    <![endif]-->
    <script id="source" language="javascript" type="text/javascript" src="js/graphs.js"></script>

</head>

<body>
<!-- WRAPPER START -->
<div class="container_16" id="wrapper">	

  	<!--LOGO-->
	<div class="grid_8" id="logo"><?PHP echo $domain ?> - Administration</div>
    <div class="grid_8">
<!-- USER TOOLS START -->
      <div id="user_tools"><span><!-- GTranslate: http://gtranslate.net/ -->
 <select onchange="doGTranslate(this);"><option value="">Select Language</option><option value="en|af">Afrikaans</option><option value="en|sq">Albanian</option><option value="en|ar">Arabic</option><option value="en|hy">Armenian</option><option value="en|az">Azerbaijani</option><option value="en|eu">Basque</option><option value="en|be">Belarusian</option><option value="en|bg">Bulgarian</option><option value="en|ca">Catalan</option><option value="en|zh-CN">Chinese (Simplified)</option><option value="en|zh-TW">Chinese (Traditional)</option><option value="en|hr">Croatian</option><option value="en|cs">Czech</option><option value="en|da">Danish</option><option value="en|nl">Dutch</option><option value="en|en">English</option><option value="en|et">Estonian</option><option value="en|tl">Filipino</option><option value="en|fi">Finnish</option><option value="en|fr">French</option><option value="en|gl">Galician</option><option value="en|ka">Georgian</option><option value="en|de">German</option><option value="en|el">Greek</option><option value="en|ht">Haitian Creole</option><option value="en|iw">Hebrew</option><option value="en|hi">Hindi</option><option value="en|hu">Hungarian</option><option value="en|is">Icelandic</option><option value="en|id">Indonesian</option><option value="en|ga">Irish</option><option value="en|it">Italian</option><option value="en|ja">Japanese</option><option value="en|ko">Korean</option><option value="en|lv">Latvian</option><option value="en|lt">Lithuanian</option><option value="en|mk">Macedonian</option><option value="en|ms">Malay</option><option value="en|mt">Maltese</option><option value="en|no">Norwegian</option><option value="en|fa">Persian</option><option value="en|pl">Polish</option><option value="en|pt">Portuguese</option><option value="en|ro">Romanian</option><option value="en|ru">Russian</option><option value="en|sr">Serbian</option><option value="en|sk">Slovak</option><option value="en|sl">Slovenian</option><option value="en|es">Spanish</option><option value="en|sw">Swahili</option><option value="en|sv">Swedish</option><option value="en|th">Thai</option><option value="en|tr">Turkish</option><option value="en|uk">Ukrainian</option><option value="en|ur">Urdu</option><option value="en|vi">Vietnamese</option><option value="en|cy">Welsh</option><option value="en|yi">Yiddish</option></select><div id="google_translate_element2"></div>
<script type="text/javascript">
function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'en',autoDisplay: false}, 'google_translate_element2');}
</script><script type="text/javascript" src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>


<script type="text/javascript">
/* <![CDATA[ */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',43,43,'||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'),0,{}))
/* ]]> */
</script>
<script type="text/javascript" src="http://joomla-gtranslate.googlecode.com/svn/trunk/gt_update_notes0.js"></script>


<script type="text/javascript">
//<![CDATA[
if(jQuery.cookie('glang') && jQuery.cookie('glang') != 'en') jQuery(function($){$('body').translate('en', $.cookie('glang'), {toggle:true, not:'.notranslate'});});

//]]>
</script>
 Welcome Admin  |  <a href="logout.php">Logout</a></span></div>
    </div>
<!-- USER TOOLS END -->    
<div style="width : 100%;display: table-row;margin-bottom:5px;"><div style="width :200px; display :table-cell;color : #ffffff;vertical-align : top;font-size : 12px;">Consider a donation to facilitate development of our script</div><div style="width :auto; display :table-cell;color : #ffffff;">
 <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7E8C4VZM2C55S">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></div>
</div>
<div class="grid_16">
<!-- TABS START -->
    <div id="tabs">
         <div class="container">
            <ul>
                      <li><a href="adminindex.php" <?PHP if ($page == 'adminindex'){echo "class=\"current\""; }?>><span>Index</span></a></li>
                      <li><a href="#" class="more1"><span>Payments</span></a></li>
                      <li><a href="#" class="more2"><span>Jobs</span></a></li>
                      <li><a href="#" class="more3"><span>Cms</span></a></li>
                      <li><a href="#" class="more4"><span>Users</span></a></li>
                      <li><a href="#" class="more5"><span>Feedback</span></a></li>
                      <li><a href="managecategory.php" <?PHP if ($page == 'categories'){echo "class=\"current\""; }?>><span>Categories</span></a></li>
                      <li><a href="languages.php" <?PHP if ($page == 'languages'){echo "class=\"current\""; }?>><span>Languages</span></a></li>

                	  <li><a href="suggestions.php" <?PHP if ($page == 'suggestions'){echo "class=\"current\""; }?>><span>Suggestions</span></a></li>
                      <li><a href="messages.php" <?PHP if ($page == 'messages'){echo "class=\"current\""; }?>><span>User Messages</span></a></li>
                      <li><a href="attatchments.php" <?PHP if ($page == 'attatchments'){echo "class=\"current\""; }?>><span>Attachments</span></a></li>
                      <li><a href="http://phpvalley.com/forums/forum/phpvalley-scripts-plugins/phpvalley-micro-jobs-site-script/"><span>Get Support</span></a></li>					  
           </ul>
        </div>
    </div>
<!-- TABS END -->
</div>
<!-- HIDDEN SUBMENU START -->
<div class="grid_16" id="hidden_submenu1">
	  <ul class="more1_menu">
	   <li><a href="sales.php">Sales via Paypal</a></li>
       <li><a href="confirm_sales.php">Awaiting Payment Confirmation</a></li>
      </ul>
  </div>
  <div class="grid_16" id="hidden_submenu2">
	  <ul class="more2_menu">
		<li><a href="mod_job.php">Moderate Jobs</a></li>
        <li><a href="editjobs.php">Edit Jobs</a></li>
        <li><a href="jobs_sold.php">All Jobs Sold</a></li>
      </ul>
  </div>
<div class="grid_16" id="hidden_submenu3">
	  <ul class="more3_menu">
		<li><a href="editterms.php">Edit Terms & Conditions</a></li>
        <li><a href="editfaq.php">Edit FAQ's</a></li>
        <li><a href="editpriv.php">Edit Privacy Policy</a></li>
        <li><a href="edithelp.php">Edit Help Topics</a></li>
        <li><a href="alert.php">Edit Notification box</a></li>
      </ul>
  </div>
  <div class="grid_16" id="hidden_submenu4">
	  <ul class="more4_menu">
		<li><a href="view_users.php">User details</a></li>
        <li><a href="payment_requests.php">Payment Requests</a></li>
      </ul>
  </div>
  <div class="grid_16" id="hidden_submenu5">
	  <ul class="more5_menu">
		<li><a href="buyer_feedback.php">Buyers Feedback</a></li>
        <li><a href="seller_feedback.php">Sellers Feedback</a></li>
      </ul>
  </div>
  <!--<div class="grid_16" id="hidden_submenu6">
	  <ul class="more6_menu">
		<li><a href="managecategory.php">Category list</a></li>
        <li><a href="translate_category.php">Translate Categories</a></li>
      </ul>
  </div>-->
<!-- HIDDEN SUBMENU END -->




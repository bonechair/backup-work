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

 ?>
<div class="footer">
    <div class="footer_resize">
      <p class="lf">&copy; <?PHP echo $lang['COPYRIGHT']?> <?PHP echo $domain?>. Designed by <a href="http://www.phpvalley.com">phpvalley</a></p>
      <div class="lf">
        <a href="rss"><img src="images/rss.png" width="16" height="16" alt="" border="0"/></a> <a href="contact.php"><?PHP echo $lang['CONTACT_US']?></a> | <a href="terms.php"><?PHP echo $lang['TERMS']?></a> | <a href="faq.php"><?PHP echo $lang['FAQS']?></a> | <a href="privacy.php"><?PHP echo $lang['PRIVACY']?></a> | <a href="./"><?PHP echo $lang['HOME']?></a>
         </div>
      <div class="clr"></div>
    </div>
  </div>
</div>
<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" mce_src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
<script type="text/javascript">
FB_RequireFeatures(["XFBML"], function(){
    FB.Facebook.init("<? echo $apikey?>", "facebook/xd_receiver.htm", { permsToRequestOnConnect : "read_stream,publish_stream,status_update" });
});
</script>

</body>
</html>

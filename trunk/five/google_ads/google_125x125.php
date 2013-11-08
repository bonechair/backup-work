<?
$result = mysql_query("SELECT * from sitesettings");
while($row = mysql_fetch_array($result))
{
?><center>
<script type="text/javascript">
//<![CDATA[  <!--
google_ad_client = "<?php echo $row['pubid'];?>";
google_ad_width = 125;
google_ad_height = 125;
google_ad_format = "125x125_as";
google_ad_type = "text_image";
google_ad_channel ="<?php echo $row['google_channel'];?>";
google_color_border = "42CCE6";
google_color_link = "000000";
google_color_bg = "42CCE6";
google_color_text = "FFFFFF";
google_color_url = "000000";
//-->
//]]> </script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center>
<? } ?>
<?  include("connect.php");
$result = mysql_query("SELECT * from sitesettings");
while($row = mysql_fetch_array($result))
{
?>
<script type="text/javascript"><!--
google_ad_client = "<?php echo $row['pubid']?>";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text_image";
google_ad_channel ="<?php echo $row['google_channel']?>";
google_color_border = "FFFFFF";
google_color_link = "3399FF";
google_color_bg = "FFFFFF";
google_color_text = "3399FF";
google_color_url = "3399FF";
//--></script>

<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<? } ?>
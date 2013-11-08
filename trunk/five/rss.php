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


error_reporting(0);

    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');//header('Pragma: no-cache');
	header("Content-type: text/html; charset=UTF-8");// atkariba no template
	header("Content-Type: application/rss+xml; charset=UTF-8");

    include("connect.php");
    $myquery = "SELECT * FROM sitesettings";
    $myresult = mysql_query($myquery) or die ("Could not execute query");
    while($myrow = mysql_fetch_array($myresult)){
      extract($myrow);

    $rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
    $rssfeed .= '<rss version="2.0">';
    $rssfeed .= '<channel>';
    $rssfeed .= '<title> '.$site_url.'</title>';
    $rssfeed .= '<link>'.$site_url.'</link>';
    $rssfeed .= '<description>Latest jobs From '.$site_url.'</description>';
    $rssfeed .= '<language>en-us</language>';
    $rssfeed .= '<copyright>Copyright (C) 2010 '.$site_url.'</copyright>';
 }

    $query = "SELECT * FROM jobs WHERE `approved` = 'Yes' ORDER BY postdate DESC LIMIT 50";
    $result = mysql_query($query) or die ("Could not execute query");

    while($row = mysql_fetch_array($result)) {
        extract($row);
        $manal = str_replace(' ', '-', trim($willdo));
        $rssfeed .= '<item>';
        $rssfeed .= '<title>' . $willdo . '</title>';
        $rssfeed .= '<description>' . $job_description = stripslashes(str_replace('\r\n', '<br>',htmlspecialchars($job_description)))  . '&lt;img width="130px" height="110px" hspace="5" border="0" align="right" src="'.$img_path.'?v=1&amp;g=fs2|0|editorial25|31|665&amp;s=1" /&gt;</description><enclosure type="image/jpeg" length="+10" url="'.$site_url.'/'.$img_path.'"/>';
        $rssfeed .= '<link>' .$site_url. '/'.$manal.'-' .$id. '.html</link>';
        $rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($postdate)) . '</pubDate>';

        $rssfeed .= '</item>';
    }

    $rssfeed .= '</channel>';
    $rssfeed .= '</rss>';

    echo $rssfeed;
?>

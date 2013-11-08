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

include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$email = "".$row["site_email"]."";
}
    /************************************************************************
     *                                                                      *
     *  since: 25.02.2010   author: Kulikov Alexey <a.kulikov@gmail.com>    *
     *                                                                      *
     ************************************************************************/

    $sendToMailAddress = ''.$email.'';

    function cleanInput($string){ return strip_tags(rawurldecode($string));}
    mail($sendToMailAddress, '[FORM] Contact Form from Site', cleanInput($_REQUEST['mess'])."\n\nContact Phone: ".cleanInput($_REQUEST['phon']?$_REQUEST['phon']:'n/a'), "From: ".cleanInput($_REQUEST['name'])." <".cleanInput($_REQUEST['from']).">");
?>
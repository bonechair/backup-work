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

// seo_url_pv Formats strings for seo urls
function seo_link_pv($string)
{

	// Remove specified characters which may break urls

	filter_var($string,FILTER_SANITIZE_URL);

	$string = preg_replace( '/\s+/', ' ', $string );	
	$string = preg_replace( "/-/", ' ', $string );

	
	$string = preg_replace( "/[^A-Za-z0-9\s\s+]/", '', $string );

	// Remove multiple whitespaces with single one if above replacement caused any.
	$string = preg_replace( '/\s+/', ' ', $string );

	$seo = str_replace(' ', '-', trim($string));

	$seo = str_replace('profile', 'pro-file', trim($seo));
	
	$seo = htmlentities($seo, ENT_QUOTES);

	$seo = urlencode(html_entity_decode($seo));


	return $seo;
}

































?>
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
<div class="index_filter"><?PHP echo $lang['FILTER']?>:
<a href="featured.php"><?PHP echo $lang['FEATURED']?></a>&nbsp;|&nbsp;<a href="latest.php"><?PHP echo $lang['LATEST']?></a>&nbsp;|&nbsp;<a href="mostpopular.php"><?PHP echo $lang['POPULAR']?></a>&nbsp;|&nbsp;<a href="h_rated.php"><?PHP echo $lang['RATED']?></a>
<?PHP if($dropdown == 'yes') {?>
<form name=frmTest action="<?php echo $page_name; ?>" method=POST>
<span style="float: right;padding-right:10px;margin-top:-24px"> <?PHP echo $lang['JOB_PRICE']?>:
<select  name="job_cost" onChange="frmTest.submit();">
<?PHP if($_POST['job_cost']){  ?>
<option value="<?PHP echo $currency_symbol ?><?php echo $_POST['job_cost']?>"><?PHP echo $currency_symbol ?><?php echo $_POST['job_cost']?></option>
<?PHP  } else{ ?>
<option value=""><?PHP echo $lang['CHOOSE']?></option>
<?PHP }?>

<?PHP
$price_range = htmlentities($price_range, ENT_QUOTES);
$prc = explode(",",$price_range);
foreach ($prc AS $p_rc) {
echo "<option value='".$p_rc."' >".$currency_symbol." ".$p_rc."</option> ";
}
?>
</select></span></form>
<?PHP }?>
</div><div class="filter_shadow"><img src="images/shadow.png" width="692" height="5" alt="" /></div>
<?php
// http://amiworks.co.in/talk/akeditable-jquery-inplace-editor/
switch($_GET['mode'])
{
	case 'eg1':
			$data=$_POST['toggle1'];
			//now that you have data do whatever you want to do with it.
			echo $data; // so that users see the updated data and know that changes have been saved.
			break;
	case 'eg2':
			$data=$_POST['toggle2'];
			echo $data;
			break;

}

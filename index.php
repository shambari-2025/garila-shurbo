<?php

include('lib/header_file.php');


$option = empty($_REQUEST['option']) ? 'main' : $_REQUEST['option'];

include("modules/login/login_module.php");

if(!isset($_SESSION['user']['true'])){
	redirect(URL."?option=login");
}else{
	if($_SESSION['user']['access_type'] == 1){
		redirect(URL."admin/");
	}elseif($_SESSION['user']['access_type'] == 2){
		redirect(URL."teacher/");
	}elseif($_SESSION['user']['access_type'] == 3){
		redirect(URL."student/");
	}
}

?>
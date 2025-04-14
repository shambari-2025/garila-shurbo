<?php
include('../lib/header_file.php');

if (!isset($_SESSION['user']['true']) || !isset($_SESSION['user']['admin'])){
	redirect(URL."?option=login");
}



function deleteOldFiles(){
	$files = scandir($_SERVER['DOCUMENT_ROOT'] .'/sessions');
	$today = mktime(0,0,0,date('m'),date('d'),date('Y'));
	for($i = 2; $i < count($files); $i++){
		$file = $_SERVER['DOCUMENT_ROOT'] .'/sessions/'.$files[$i];
		if(filectime($file) < $today || filesize($file) == 0) unlink($file);
	}
}

deleteOldFiles();

$option = empty($_REQUEST['option']) ? 'students' : $_REQUEST['option'];
$action = empty($_REQUEST['action']) ? 'groupstatistic' : $_REQUEST['action'];
$file = 'universalfile';

define('MY_URL', URL.'admin/');





/*Вақти охирон амал*/
$now = date("Y-m-d H:i:s");
$query = update_query("UPDATE `users` SET `last_login` = '$now' WHERE `id` = '{$_SESSION['user']['id']}'");


//unset($_SESSION['superarr']);
if(!isset($_SESSION['superarr'])){
	$_SESSION['superarr'] = MakeAdminMenu();
	//$_SESSION['superarr'] = MakeMenu();
}


//unset($_SESSION['litsey']);
if(!isset($_SESSION['litsey'])){
	$_SESSION['litsey'] = MakeMenuLitsey();
}


$STUDY_YEARS = select("study_years", "*", "", "id", false, "");

$birthdays_teachers = query("SELECT `id`, `fullname_tj`, `birthday`, `jins`, `photo`, `access_type` FROM `users` WHERE `access_type` != '3' AND `birthday` LIKE '%".date("m-d")."%'");
$birthdays_students = query("SELECT `users`.`id`, `users`.`fullname_tj`, `users`.`birthday`, `users`.`jins`, `users`.`photo`, `users`.`access_type` FROM `users` 
INNER JOIN `students` ON `students`.`id_student` = `users`.`id`
WHERE `students`.`status` = 1 AND `students`.`s_y` = '".S_Y."' AND `students`.`h_y` = '".H_Y."'
AND `access_type` = '3' AND `birthday` LIKE '%".date("m-d")."%'");


$birthdays = array_merge($birthdays_teachers, $birthdays_students);

$nextDay = date('d', strtotime('+1 day'));
if($nextDay == 1){
	$m = date('m', strtotime('+1 month'));
}else $m = date('m');
$birthdays_next_day = query("SELECT * FROM `users` WHERE `birthday` LIKE '%".date("$m-$nextDay")."%' ORDER BY `access_type` ASC");

$menu_davrho = query("SELECT * FROM `davrho` WHERE `s_y` = '".S_Y."' ORDER BY `id`");

unset($_SESSION['commission']);
if(!isset($_SESSION['commission'])){
	$_SESSION['commission'] = MakeMenuCQ();
}



switch($option){
	case "sessions":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "ahmad":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "elonho":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "tests":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "commission":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "shubai2":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	case "joikor":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "biometric":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "bugalteria":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "kassa":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "khobgoh":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
		
	case "litsey":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "naqsha":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "imtihon":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "imtihonho":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "questions":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "vip":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "scores":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "soxtor":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "online":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "teachers":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "students":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "search":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "nt":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "jd":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "mylessons":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "helper":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "settings":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "print":
		include($_SERVER['DOCUMENT_ROOT']."/modules/$option/{$option}_module.php");
	break;
	
	case "change_syhy":
		$s_y = $_REQUEST['study_year'];
		$h_y = $_REQUEST['half_year'];
		$fields = array('s_y' => $s_y,
						'h_y' => $h_y
			);
		update("users", $fields, "`id` = '{$_SESSION['user']['id']}'");
		unset($_SESSION['superarr']);
		//MakeMenu();
		redirect();
	break;
}


/*Вақти онлайн будани истифодабаранда*/
setUserOnlineData($_SESSION['user']['id'], $_SERVER['REQUEST_URI'], $page_info['title']);


include("views/admin.php");
?>

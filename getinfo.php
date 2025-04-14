<?php

include('lib/header_file.php');
mb_internal_encoding("UTF-8");
define("LOGIN", 'amonatbonk');
define("SIGN", "test");


$login = trim($_REQUEST['login']);
$account = trim($_REQUEST['account']);
$sign = trim($_REQUEST['sign']);


if(LOGIN == $login && md5(SIGN) == $sign){
	$user = query("SELECT * FROM `users` WHERE `id` = '$account'");
	if(count($user) > 0){
		if($user[0]['access_type'] == 3){
			$res['result'] = 0;
			$res['name'] = $user[0]['fullname_tj'];
			$res['comment'] = "Донишҷӯ";
		}
		if($user[0]['access_type'] == 2){
			$res['result'] = 0;
			$res['name'] = $user[0]['fullname_tj'];
			$res['comment'] = "Омӯзгор";
		}
	}elseif(!empty($user = query("SELECT * FROM `users_2` WHERE `id` = '$account'"))){
		
		$res['result'] = 0;
		$res['name'] = $user[0]['fio'];
		$res['comment'] = "Хатмкардаи донишгоҳ";
		
	}else {
		$res['result'] = 1;
		$res['comment'] = "Донишҷӯ ёфт нашуд";
	}
	echo json_encode($res, JSON_UNESCAPED_UNICODE);
	
}else {
	exit;
}

?>
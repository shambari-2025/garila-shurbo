<?php
include('lib/header_file.php');

	$id_student = $_REQUEST['id_student'];
	$S_Y = $_REQUEST['s_y'];
	$H_Y = $_REQUEST['h_y'];
	$info_std = query("SELECT * FROM `students`
						WHERE `id_student` = '$id_student' AND	
							`s_y` = '$S_Y' AND
							`h_y` = '$H_Y'
					");
	//print_arr($info_std);
	
	
	$id_faculty = $info_std[0]['id_faculty'];
	$id_s_l = $info_std[0]['id_s_l'];
	$id_s_v = $info_std[0]['id_s_v'];
	$id_s_t = $info_std[0]['id_s_t'];
	$id_course = $info_std[0]['id_course'];
	$id_spec = $info_std[0]['id_spec'];
	$id_group = $info_std[0]['id_group'];
	
	$semestr = getSemestr($id_course, $H_Y);
	
	$id_nt = query("SELECT `id_nt` FROM `std_study_groups` 
						WHERE `id_faculty` = '$id_faculty'
							AND `id_s_l` = '$id_s_l'
							AND `id_s_v` = '$id_s_v'
							AND `id_course` = '$id_course'
							AND `id_spec` = '$id_spec'
							AND `id_group` = '$id_group'
							AND `s_y` = '$S_Y'
							AND `h_y` = '$H_Y'
				");
	$id_nt = $id_nt[0]['id_nt'];
	
	// Путь и имя файла, в который нужно сохранить QR-код
	$file = $_SERVER['DOCUMENT_ROOT']."/userfiles/qr-transcripts/$id_student.png";
	
	if(file_exists($file)){
		unlink($file);
		// Подключаем библиотеку QR Code
		include('phpqrcode/qrlib.php');
		
		// Ссылка, которую нужно закодировать в QR-код
		$link = URL."transcript.php?id_student=$id_student&s_y=$S_Y&h_y=$H_Y";
		
		// Размер QR-кода в пикселях
		$size = 3;
		// Генерируем QR-код и сохраняем его в файл
		QRcode::png($link, $file, QR_ECLEVEL_Q, $size);
	}else{
		// Подключаем библиотеку QR Code
		include('phpqrcode/qrlib.php');
		
		// Ссылка, которую нужно закодировать в QR-код
		$link = URL."transcript.php?id_student=$id_student&s_y=$S_Y&h_y=$H_Y";
		
		// Размер QR-кода в пикселях
		$size = 3;
		// Генерируем QR-код и сохраняем его в файл
		QRcode::png($link, $file, QR_ECLEVEL_Q, $size);
	}
	$page_info['title'] = 'Транскрипт: '.getUserName($id_student);
	include("modules/print/views/transcript2.php");
	exit;

?>
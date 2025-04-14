<?php

phpinfo();
exit;

include('lib/header_file.php');

//unset($_SESSION['datas']);

if(!isset($_SESSION['datas'])){

	
	// Запрос к базе данных
	$sql = query("SELECT * FROM `std_study_groups` ORDER BY `id_faculty`, `id_s_l`, `id_s_v`, `id_course`, `id_spec`, `id_group`");
	
	// Создание древовидной структуры
	$tree = [];

	foreach ($sql as $row) {
		$idFaculty = $row['id_faculty'];
		$idS_L = $row['id_s_l'];
		$idS_V = $row['id_s_v'];
		$idCourse = $row['id_course'];
		$idSpec = $row['id_spec'];
		$idGroup = $row['id_group'];

		// Построение древовидной структуры
		$tree[$idFaculty]['id'] = $idFaculty;
		$tree[$idFaculty]['title'] = getFaculty($idFaculty); // Замените на фактический заголовок
		$tree[$idFaculty]['short'] = getFacultyShort($idFaculty); // Замените на фактическое сокращение
		$tree[$idFaculty]['level'][$idS_L]['id'] = $idS_L;
		$tree[$idFaculty]['level'][$idS_L]['title'] = getStudyLevel($idS_L); // Замените на фактический заголовок
		$tree[$idFaculty]['level'][$idS_L]['view'][$idS_V]['id'] = $idS_V;
		$tree[$idFaculty]['level'][$idS_L]['view'][$idS_V]['title'] = getStudyView($idS_V); // Замените на фактический заголовок
		$tree[$idFaculty]['level'][$idS_L]['view'][$idS_V]['course'][$idCourse]['id'] = $idCourse;
		$tree[$idFaculty]['level'][$idS_L]['view'][$idS_V]['course'][$idCourse]['title'] = getCourse($idCourse); // Замените на фактический заголовок
		$tree[$idFaculty]['level'][$idS_L]['view'][$idS_V]['course'][$idCourse]['spec'][$idSpec]['id'] = $idSpec;
		$tree[$idFaculty]['level'][$idS_L]['view'][$idS_V]['course'][$idCourse]['spec'][$idSpec]['code'] = getSpecialtyCode($idSpec); // Замените на фактический код
		$tree[$idFaculty]['level'][$idS_L]['view'][$idS_V]['course'][$idCourse]['spec'][$idSpec]['title'] = getSpecialtyTitle($idSpec); // Замените на фактический заголовок
		$tree[$idFaculty]['level'][$idS_L]['view'][$idS_V]['course'][$idCourse]['spec'][$idSpec]['groups'][$idGroup]['id'] = $idGroup;
		$tree[$idFaculty]['level'][$idS_L]['view'][$idS_V]['course'][$idCourse]['spec'][$idSpec]['groups'][$idGroup]['title'] = getGroup2($idGroup); // Замените на фактический заголовок
	}

	// Закрываем соединение с базой данных
	
	$_SESSION['datas'] = $tree;
}

$tree = $_SESSION['datas'];

$counter = 0;
foreach($tree as $f_item){
	echo $f_item['title']."<br>";
	
	foreach($f_item['level'] as $l_item){
		echo str_repeat("&nbsp;", 3);
		echo $l_item['title']."<br>";
		
		foreach($l_item['view'] as $v_item){
			echo str_repeat("&nbsp;", 6);
			echo $v_item['title']."<br>";
			
			foreach($v_item['course'] as $c_item){
				echo str_repeat("&nbsp;", 9);
				echo $c_item['title']."<br>";
				
				foreach($c_item['spec'] as $s_item){
					echo str_repeat("&nbsp;", 12);
					echo $s_item['code']."<br>";
					
					foreach($s_item['groups'] as $g_item){
						echo str_repeat("&nbsp;", 15);
						echo $g_item['title']."<br>";
						$counter++;
					}
				}
			}
		
		}
	}
}


echo $counter;
// Вывод древовидной структуры
//echo json_encode($tree, JSON_PRETTY_PRINT);


?>
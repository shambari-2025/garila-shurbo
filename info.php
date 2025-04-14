<style>
	table, tr, td {
		border-collapse: collapse;
		border: 1px solid;
	}
	
	.center {
		text-align: center;
	}
	
	td {
		padding: 8px;
	}
</style>

<?php
include('lib/header_file.php');

$id_student = $_REQUEST['id_student'];
$S_Y = S_Y;
$H_Y = H_Y;




$student = query("SELECT 
	`user_udecation`.*,
	`user_passports`.*,
	
	`vazi_oilavi`.`title` as `vazi_oilavi_title`,
	
	`countries`.`title` as `country_title`,
	`regions`.`name` as `region_title`,
	`districts`.`name` as `district_title`,
	`nations`.`title` as `nation_title`,
	
	`faculties`.`title` as `faculty_title`,
	`faculties`.`short_title` as `faculty_short`,
	
	`specialties`.`code` as `spec_code`,
	`specialties`.`title_tj` as `spec_title_tj`,
	`specialties`.`title_ru` as `spec_title_ru`,
	`specialties`.`title_en` as `spec_title_en`,
	
	`groups`.`title` as `group_title`,
	
	`study_level`.`title` as `study_level_title`,
	`study_type`.`title` as `study_type_title`,
	`study_view`.`title` as `study_view_title`,
	
	`students`.*,
	`users`.* 
FROM `users`
INNER JOIN `students` ON `students`.`id_student` = `users`.`id`
LEFT JOIN `user_passports` ON `user_passports`.`id_user` = `users`.`id`
LEFT JOIN `user_udecation` ON `user_udecation`.`id_user` = `users`.`id`

LEFT JOIN `vazi_oilavi` ON `students`.`vazi_oilavi` = `vazi_oilavi`.`id`
LEFT JOIN `countries` ON `user_passports`.`id_country` = `countries`.`id`
LEFT JOIN `regions` ON `user_passports`.`id_region` = `regions`.`id`
LEFT JOIN `districts` ON `user_passports`.`id_district` = `districts`.`id`
LEFT JOIN `nations` ON `user_passports`.`id_nation` = `nations`.`id`


INNER JOIN `faculties` ON `students`.`id_faculty` = `faculties`.`id`
INNER JOIN `specialties` ON `students`.`id_spec` = `specialties`.`id`
INNER JOIN `groups` ON `students`.`id_group` = `groups`.`id`

INNER JOIN `study_type` ON `students`.`id_s_t` = `study_type`.`id`
INNER JOIN `study_level` ON `students`.`id_s_l` = `study_level`.`id`
INNER JOIN `study_view` ON `students`.`id_s_v` = `study_view`.`id`

WHERE `students`.`id_student` = '$id_student' AND `users`.`id` = '$id_student'
AND `students`.`s_y` = '$S_Y' AND `students`.`h_y` = '$H_Y'
");

//print_arr($student);


$specs = query("
	SELECT * FROM `std_study_groups` WHERE `id_course` = '{$student[0]['id_course']}' 
	AND `id_s_l`='{$student[0]['id_s_l']}' AND `s_y` = '$S_Y' AND `h_y` = '$H_Y'
	AND `id_nt`!='NULL'
	ORDER BY `id_spec` ASC, `id_s_v` ASC
");


$history = query("SELECT * FROM `students` 
WHERE `status` = 1 AND `id_student` = '$id_student' ORDER BY `s_y`, `h_y`");



$farmonho = query("SELECT * FROM `stds_farmonho` WHERE `id_student` = '$id_student' ORDER BY `farmon_date`");


$page_info['title'] = 'Маълумотномаи донишҷӯ: '.getUserName($id_student);
include("modules/students/ajax/getstudentinfo.php");
exit;

?>
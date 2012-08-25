<?php


if( isset($_POST['token']) && $_POST['token'] == 'ozan') {

	include_once 'DBclass.php';
	$db = new DB('localhost', 'ozantu5_work', 'xFM{s+1Gb&3O', 'painter');

	$sql = 'SELECT * FROM images ORDER BY adddate DESC LIMIT 20';
	$imagesArr = $db->query($sql);

	echo json_encode($imagesArr);
	exit;
}
<?php
require_once("../database/database_library.php");
if (!($_SESSION['user']['role_type']=='teacher')) {
    session_destroy();
    header("location:../login.php?class=danger&msg=Unauthorized access");
die;
}
$dobj = new database_library(); 
if (isset($_REQUEST['upload'])&&$_REQUEST['action']=='upload_topic_file') {
	echo"<pre/>";
	print_r($_POST);
	print_r($_FILES);
	$file_path = 'files';
	$file_name = $_FILES['topic_file']['name'];
	// $file_type = $_FILES['topic_file']['type'];
	// if ($_FILES['topic_file']['size']>80000000) {

	$file_extension = pathinfo($_FILES['topic_file']['name'],PATHINFO_EXTENSION);
	echo $file_extension;
	if (!($file_extension =='ppt'|| $file_extension=='doc'|| $file_extension=='pdf' || $file_extension=='jpg'||$file_extension=='jpeg' || $file_extension=='png')) {
		header("location:course_view.php?class=danger&msg=Unsupported file extension&batch_course_id=".$_REQUEST['batch_course_id']);
		die;
	}
	if ($_FILES['topic_file']['size']>2000000) {
		header("location:course_view.php?class=danger&msg=File size must be of 2MB&batch_course_id=".$_REQUEST['batch_course_id']);
		die;
	}
	echo $file_name."<br/>";
	echo $file_path."<br/>";
	// echo $file_type;
	if (!(is_dir($file_path))) {
		mkdir($file_path);
	}
	// die;
	if(move_uploaded_file($_FILES['topic_file']['tmp_name'], "files/".$_FILES['topic_file']['name'])){
		if($add_file = $dobj->add_topic_file($_REQUEST['topic_id'],$_FILES['topic_file']['name'],$file_path,$file_extension)){
			header("location:course_view.php?class=success&msg=FILE ADDED SUCCESSFULLY&batch_course_id=".$_REQUEST['batch_course_id']);
		}
		
	}
	else{
			header("location:course_view.php?class=danger&msg=FILE CAN'T BE ADDED&batch_course_id=".$_REQUEST['batch_course_id']);
	}
	
}


if (isset($_REQUEST['action'])&&$_REQUEST['action']=='update_topic') {
	// echo $_REQUEST['status_id'];
	// echo $_REQUEST['topic_id'];
	// die;
	$topic = $dobj->update_topic($_REQUEST['status_id'],$_REQUEST['topic_id']);
	if($topic){
		header("location:course_view.php?class=success&msg=Topic status updated&batch_course_id=".$_REQUEST['batch_course_id']);
	}
	else{
		header("location:course_view.php?class=danger&msg=Status updation failed&batch_course_id=".$_REQUEST['batch_course_id']);

	}
}


if (isset($_REQUEST['action'])&&$_REQUEST['action']=='update_file') {
	$file_update = $dobj->update_file($_REQUEST['topic_file_id'],$_REQUEST['status_id']);
	if ($file_update) {
		header("location:course_view.php?class=success&msg=File status updated&batch_course_id=".$_REQUEST['batch_course_id']);
	}
	else{
		header("location:course_view.php?class=danger&msg=Status updation failed&batch_course_id=".$_REQUEST['batch_course_id']);

	}

}
 ?>
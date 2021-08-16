<?php 
require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); 
require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php");
require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php");
require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php");
$_user_fetch_utils = new user_fetch_utils();
$_video_fetch_utils = new video_fetch_utils();
$_video_insert_utils = new video_insert_utils();
$_user_insert_utils = new user_insert_utils();
$_base_utils = new config_setup();

$_base_utils->initialize_db_var($conn);
$_video_fetch_utils->initialize_db_var($conn);
$_video_insert_utils->initialize_db_var($conn);
$_user_fetch_utils->initialize_db_var($conn);
$_user_insert_utils->initialize_db_var($conn);

require($_SERVER['DOCUMENT_ROOT'] . "/static/module/core/functions.php");
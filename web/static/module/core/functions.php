<?php

$functions_path = $_SERVER['DOCUMENT_ROOT'] . '/static/module/core/functions/';

$constructStars = function ($__carg0) use ($functions_path) {
	include($functions_path . 'construct_stars.php');
};

$constructVideoThumbnail = function ($__carg0) use($functions_path,
		$_video_fetch_utils) {
	include($functions_path . 'construct_video_thumbnail.php');
};

$constructVideoItem = function ($__carg0) use ($functions_path,
		$_user_fetch_utils, $_video_fetch_utils, $_base_utils, $constructStars, 
		$constructVideoThumbnail) {
	include($functions_path . 'construct_video_item.php');
};

$constructVideoGrid = function ($__carg0) use ($functions_path,
		$_user_fetch_utils, $_video_fetch_utils, $_base_utils, $constructStars, 
		$constructVideoThumbnail) {
	include($functions_path . 'construct_video_grid.php');
};
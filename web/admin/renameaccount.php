<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php"); ?>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php"); ?>
<?php
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
?>
<?php
if($_user_fetch_utils->is_admin($_SESSION['siteusername'])) {
    $_user_insert_utils->send_logs("RENAMEACCOUNT " . $_GET['username'] . " to " . $_GET['newname'] . " by " . $_SESSION['siteusername']);
	
	$dbWrite = (object) [
		'users' => 'username',
		'comments' => 'author',
		'comment_reply' => 'author',
		'videos' => 'author',
		'subscribers' => ['sender', 'reciever'],
		'channel_views' =>'channel',
		'favorite_video' => ['sender', 'reciever'],
		'friends' => ['reciever', 'sender'],
		'history' => 'author',
		'forum_thread' => 'author',
		'forum_replies' => 'author',
		'pms' => ['owner', 'touser'],
		'profile_comments' => ['toid', 'author'],
		'quicklist_videos' => 'author',
		'stars' => ['sender', 'reciever'],
		'comment_likes' => 'sender',
		'video_response' => 'author',
		'block' => ['sender', 'reciever'],
		'bans' => ['username', 'moderator'],
		'likes' => ['sender', 'reciever'],
		'playlists' => 'author',
		'reports' => 'sender',
		'views' => 'viewer'
	];
	
	function getKeys($obj) {
		$allkeys = array_keys((array)$obj);
		return $allkeys;
	}
	
	$updateDb = function ($obj) use (&$_base_utils, &$_user_insert_utils, &$_user_fetch_utils, &$_video_insert_utils, &$conn) {
		$keys = getKeys($obj);
		foreach ($keys as &$key) {
			if (is_array($obj->{$key})) {
				for ($i = 0, $j = count($obj->{$key}); $i < $j; $i++) {
					$stmt = $conn->prepare('UPDATE ' . $key . ' SET ' . $obj->{$key}[$i] . ' = ? WHERE ' . $obj->{$key}[$i] . ' = ?');
					$stmt->bind_param("ss", $_GET['newname'], $_GET['username']);
					$stmt->execute();
					$stmt->close();
				}
			} else {
				$stmt = $conn->prepare('UPDATE ' . $key . ' SET ' . $obj->{$key} . ' = ? WHERE ' . $obj->{$key} . ' = ?');
				$stmt->bind_param("ss", $_GET['newname'], $_GET['username']);
				$stmt->execute();
				$stmt->close();
			}
		}
	};
	
	$updateDb($dbWrite);

    header("Location: /admin/");
}
?>
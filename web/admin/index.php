<?php
	ob_start();
    require($_SERVER['DOCUMENT_ROOT'] . "/static/important/config.inc.php");
    require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/base.php");
    require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/fetch.php");
    require($_SERVER['DOCUMENT_ROOT'] . "/static/lib/new/insert.php");
	ini_set('display_errors', 0);
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

    $_base_utils->initialize_page_compass("Admin Panel");

    if(!$_user_fetch_utils->is_admin($_SESSION['siteusername']))
        header("Location: /");
?>
<?php

if (!isset($__admin_active_tab))
	$__admin_active_tab = 'main';

$__admin_tabs = (object) [
	'main' => (object) [
		'title' => 'Main',
		'href' => '/admin/',
		'srcFile' => '/admin/new/panels/main.php',
		'shortcut' => 'm0'
	],
	'users' => (object) [
		'title' => 'Users',
		'href' => '/admin/users',
		'srcFile' => '/admin/new/panels/users.php',
		'shortcut' => 'u1'
	],
	'videos' => (object) [
		'title' => 'Videos',
		'href' => '/admin/videos',
		'srcFile' => '/admin/new/panels/videos.php',
		'shortcut' => 'v2'
	],
	'forums' => (object) [
		'title' => 'Forums',
		'href' => '/admin/forums',
		'srcFile' => '/admin/new/panels/forums.php',
		'shortcut' => 'f3'
	],
	'groups' => (object) [
		'title' => 'Groups',
		'href' => '/admin/groups',
		'srcFile' => '/admin/new/panels/groups.php',
		'shortcut' => 'g4'
	]
];

$buildAdminNav = function() use ($__admin_active_tab, $__admin_tabs) {
	$outBuffer = '';
	foreach ($__admin_tabs as $key => $value) {
		$id = $key;
		$title = $__admin_tabs->{$key}->title;
		$href = $__admin_tabs->{$key}->href;
		$class = 'nav-item';
		if ($key == $__admin_active_tab) {
			$class .= ' selected';
		}
		if (isset($__admin_tabs->{$key}->shortcut)) {
			$shortcut = 'data-shortcut="' . $__admin_tabs->{$key}->shortcut . '"';
		}
		$outBuffer .= 
			"<a data-panel-id=\"admin-{$id}\" title=\"{$title}\" class=\"{$class}\"" .
			"{$shortcut} href=\"{$href}\">{$title}</a>";
	}
	return $outBuffer;
};

$buildAdminContent = function() use ($__admin_active_tab, $__admin_tabs,
	$_user_fetch_utils, $_video_fetch_utils, $_video_insert_utils, 
	$_user_insert_utils, $_base_utils
) {
	$outBuffer = '';
	foreach($__admin_tabs as $key => $value) {
		$id = $key;
		$src = $__admin_tabs->{$id}->srcFile;
		$class = "admin-panel admin-{$id}";
		if ($key == $__admin_active_tab) {
			$class .= ' selected';
		}
		$outBuffer .= "<div class=\"{$class}\">";
		ob_start();
		include($_SERVER['DOCUMENT_ROOT'] . $src);
		$outBuffer .= ob_get_clean();
		$outBuffer .= '</div>';
	}
	return $outBuffer;
};

?>
<!DOCTYPE html>
<html>
    <head>
        <title>SubRocks - <?php echo $_base_utils->return_current_page(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/static/css/new/www-core.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<style>
			body {
				overflow-y: scroll;
			}
			.loading-icon {
				display: inline-block;
				width: 20px;
				height: 20px;
				vertical-align: middle;
				background: url(/admin/spinner.gif) no-repeat center;
			}
			button.yt-uix-button.yt-uix-button-default.force-float-right, input[name="send"] {
				font-weight: 700;
				color: #039;
				border: 1px solid #a0b1dc;
				border-radius: 3px;
				padding: 3px .83em;
				margin-left: 2px;
			  margin-right: 2px;
				float: right !important;
				margin-bottom: 8px !important;
			}
			.loading-label {
			  margin-left: 4px;
			}
			.sr-loading {
			  margin-left: auto;
			  margin-right: auto;
			  width: max-content;
			  margin-top: 25px;
			  margin-bottom: 25px;
			}
			#admin-container {
				display: none;
			}
			.admin2-enabled #admin-container {
				display: block;
			}
			.admin2-enabled #admin-incompatible-message {
				display: none !important;
			}
			ul {
			  margin: 0;
			  padding: 0;
			}
			li {
			  list-style: none;
			}
			.nav-item {
			  color: #666;
			  display: inline-block;
			  text-decoration: none;
			  padding: 8px;
			  border-bottom: 3px solid transparent;
			}
			.nav-item a {
			  text-decoration: none;
			}
			.nav-item:hover {
			  text-decoration: none;
			  border-bottom-color: #999;
			}
			.nav-item.selected {
			  border-bottom-color: #666;
			  color: #000;
			}
			.admin-nav {
			  position: relative;
			  top: 1px;
			}
			.admin-content {
			  border-top: 1px solid #ccc;
			  padding-top: 6px;
			}
			.info-deemphasised, .info-deemphasised a{
			  margin-top: 6px;
			  color: #666;
			  font-size: 11px;
			}
			.admin-content li  {
			  border-bottom: 1px solid #ccc;
			  margin-bottom: 6px;
			  padding-bottom: 6px;
			}
			.admin-content li:last-child {
			  border-bottom: 0;
			  margin-bottom: 0;
			  padding-bottom: 0;
			}
			#server-info li {
			  border: 0;
			  padding: 0;
			  margin: 0;
			}
			#quick-actions li {
			  margin: 6px;
			  padding: 6px;
			  padding-bottom: 2px;
			  padding-top: 2px;
			  border-color: #eee;
			}
			#keyboard-shortcuts li {
			  border: 0;
			}
			#keyboard-shortcuts ul {
			  margin-top: 6px;
			  margin-left: 10px;
			}
			.keyboard-shortcut .keyboard-key {
			  display: inline-block;
			  font-size: 20px;
			  padding: 8px;
			  min-width: 24px;
			  border-radius: 8px;
			  text-align: center;
			  margin-right: 3px;
			  border: 2px solid #ccc;
			}
			.keyboard-shortcut .keyboard-subtitle {
			  display: block;
			  font-weight: 700;
			  color: #333;
			  margin-top: 3px;
			}
			.keyboard-shortcut {
			  display: inline-block;
			  text-align: center;
			  margin-right: 20px;
			}
			.info-key {
			  font-weight: 700;
			  margin-right: 5px;
			}
			#server-info span {
			  font-size: 14px;
			}
			.admin-panel {
			  display: none;
			}
			.admin-panel.selected {
			  display: block;
			}
			.getting-started {
			  margin-left: auto;
			  margin-right: auto;
			  text-align: center;
			  max-width: 340px;
			  color: #777;
			}
			.bucket {
			  margin-top: 6px;
			  margin-bottom: 6px;
			  border: 1px solid #ccc;
			}
			.bucket-header {
			  background-color: #eee;
			  border-bottom: 1px solid #ccc;
			}
			.bucket-content, .bucket-header {
			  padding: 6px;
			}
			.bucket-title {
			  font-size: 20px;
			}
			.searchbox {
			  width: max-content;
			  margin-left: auto;
			  margin-right: auto;
			}
			.admin-channel-tile {
			  max-width: 85px;
			  text-align: center;
			}
			.admin-channel-tile .thumb img {
			  width: 64px;
			  height: 64px;
			  border: 1px solid #ccc;
			}
			.admin-channel-tile .thumb {
			  position: relative;
			}
			.admin-channel-tile .add-to-queue {
			  color: #fff;
			  position: absolute;
			  width: 64px;
			  height: 64px;
			  top: -54px;
			  line-height: 64px;
			  left: 1px;
			  background: rgba(0, 128, 0, 0.50);
			  pointer-events: none;
			  display: none;
			}
			.admin-channel-tile .thumb:hover .add-to-queue {
			  display: inline-block;
			}
			.admin-channel-tile .username {
			  display: block;
			  overflow: hidden;
			  text-overflow: ellipsis;
			}
			.bucket-content li {
			  border: 0;
			  margin: 0;
			  padding: 0;
			  display: inline-block;
			}
			.editing-ribbon {
			  position: relative;
			  height: 40px;
			  top: -6px;
			  background: #eee;
			  border: 1px solid #ccc;
			  border-top-color: transparent;
			  border-bottom-left-radius: 6px;
			  border-bottom-right-radius: 6px;
			  line-height: 40px;
			  padding-left: 5px;
			  padding-right: 5px;
			  padding-bottom: 2px;
			}
			.editing-ribbon .title {
			  display: inline-block;
			  font-size: 16px;
			  font-weight: 600;
			  margin-left: 6px;
			  vertical-align: middle;
			  line-height: initial;
			}
			.editing-ribbon .title .subtitle {
			  display: inline-block;
			  margin: 0;
			  padding: 0;
			  margin-right:100%;
			  font-size: 11px;
			  font-weight: normal;
			  color: #666;
			  position: relative;
			  top: -3px;
			  width: 100%;
			}
			.editing-ribbon .thumb img {
			  width: 32px;
			  height: 32px;
			  border: 1px solid #ccc;
			  vertical-align: middle;
			  display: inline-block;
			}
			.editing-ribbon .thumb.multi img {
			  width: 20px;
			  height: 20px;
			  margin-right: 1px;
			}
			.admin-users .manage, .admin-users .editing-ribbon {
			  display: none;
			}
			.admin-users.managing .manage, .admin-users.managing .editing-ribbon {
			  display: block;
			}
			.admin-users.managing .searchbox, .admin-users.managing .getting-started, .admin-users.managing .bucket {
			  display: none;
			}
			.error {
			  color: #c00;
			  text-align: center;
			}
		</style>
		<script>
			var sr = sr || {};
			sr.config_ = sr.config_ || {};
			sr.getConfig = function(a) {
				return sr.config_[a];
			};
			sr.setConfig = function(a, b) {
				sr.config_[a] = b;
				return sr.config_[a];
			};
			sr.setConfig("PAGE_BUILD_TIMESTAMP", <?php echo mktime(); ?>);
		</script>
		<script>
			sr.setConfig("PAGE_TYPE", "admin");
			sr.www = sr.www || {};
			sr.www.bin = sr.www.bin || {};
			sr.www.bin.detectAdminCompatibility = {};
			sr.www.bin.detectAdminCompatibility.runBeforeBodyIsReady = function() {
				if (window.history.pushState) {
					document.head.parentNode.setAttribute("class", "admin2-enabled");
					var a = window.setInterval(function() {
						if (typeof document.getElementById("admin-incompatible-message") != null) {
							act();
						}
					}, 0)
					function act() {
						document.getElementById("admin-incompatible-message").remove();
						clearInterval(a);
					}
				}
			};
			sr.www.bin.detectAdminCompatibility.runBeforeBodyIsReady();
		</script>
		<script>
			sr.setConfig("LOADING_HTML", "<?php
				ob_start();
				include($_SERVER['DOCUMENT_ROOT'] . '/admin/loading.php');
				$temp = ob_get_clean();
				echo str_replace('"', '\\"', $temp);
			?>");
		</script>
		<script src="/admin/new/admin_new.js"></script>
    </head>
    <body>
        <div class="www-core-container">
            <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/header.php"); ?>
		 <div id="admin-incompatible-message">
			Hello. To use the new admin panel, you require at least Chrome 5, Firefox 4, or Internet Explorer 10 with JavaScript enabled. Sorry about that.
			<br>
			<br>
			<a href="/admin/old">Click here to go back to the old admin panel.</a>
		 </div>
         <div id="admin-container" class="admin-container">
			<h1 class="admin-heading">Admin Panel</h1>
            <div class="admin-nav">
				<?php
					echo $buildAdminNav();
				?>
			</div>
            <div class="admin-content">
				<?php
					echo $buildAdminContent();
				?>
            </div>
         </div>
        </div>
        <div class="www-core-container">
        <?php require($_SERVER['DOCUMENT_ROOT'] . "/static/module/footer.php"); ?>
        </div>

    </body>
</html>
<?php
	ob_end_flush();
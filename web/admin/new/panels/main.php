<?php
function processExists($processName) {
    $exists= false;
    exec("ps -A | grep -i $processName | grep -v grep", $pids);
    if (count($pids) > 0) {
        $exists = true;
    }
    return $exists;
}

$stat1 = file('/proc/stat'); 
sleep(1); 
$stat2 = file('/proc/stat'); 
$info1 = explode(" ", preg_replace("!cpu +!", "", $stat1[0])); 
$info2 = explode(" ", preg_replace("!cpu +!", "", $stat2[0])); 
$dif = array(); 
$dif['user'] = $info2[0] - $info1[0]; 
$dif['nice'] = $info2[1] - $info1[1]; 
$dif['sys'] = $info2[2] - $info1[2]; 
$dif['idle'] = $info2[3] - $info1[3]; 
$total = array_sum($dif); 
$cpu = array(); 
foreach($dif as $x=>$y) $cpu[$x] = round($y / $total * 100, 1);

function convert($size)
{
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

function abbreviateNumber($num) {
    if ($num >= 0 && $num < 1000) {
      $format = floor($num);
      $suffix = '';
    } 
    else if ($num >= 1000 && $num < 1000000) {
      $format = floor($num / 1000);
      $suffix = 'K+';
    } 
    else if ($num >= 1000000 && $num < 1000000000) {
      $format = floor($num / 1000000);
      $suffix = 'M+';
    } 
    else if ($num >= 1000000000 && $num < 1000000000000) {
      $format = floor($num / 1000000000);
      $suffix = 'B+';
    } 
    else if ($num >= 1000000000000) {
      $format = floor($num / 1000000000000);
      $suffix = 'T+';
    }
    
    return !empty($format . $suffix) ? $format . $suffix : 0;
  }

  function get_server_memory_usage(){

    $free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);
    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);
    $memory_usage = $mem[2]/$mem[1]*100;

    return $memory_usage;
}

$ffmpeg = processExists("ffmpeg"); 
if($ffmpeg == true) { $ffmpeg = "Active"; } else { $ffmpeg = "Inactive"; }
?>
<ul>
 <li id="rewrite-info">
	<h2>Welcome to the new SubRocks admin panel!</h2>
	This new rewrite of the admin panel is much more advanced and introduces more options for moderation than were previously available. Features introduced with this update include a brand new user interface, recommendations based on your watch history and recent activity on the site, and many new features previously unseen. I hope this update helps streamline the moderation process significantly. <a href="/admin/old">Still not sold on the new design? Click here to go back to the old admin panel.</a>
	<div class="info-deemphasised">Rewrite by <a href="/user/Nightlinbit">Daylin (Nightlinbit)</a><br>
	   Thanks to <a href="/user/bhief">chief bazinga</a> for SubRocks!
	</div>
 </li>
 <li id="keyboard-shortcuts">
	<h2>Keyboard shortcuts</h2>
	From the main tab, you can use the following keys as shortcuts to change to a different tab:
	<ul>
	   <li class="keyboard-shortcut"><span class="keyboard-key">M</span><span class="keyboard-key">0</span><span class="keyboard-subtitle">Main</span></li>
	   <li class="keyboard-shortcut"><span class="keyboard-key">U</span><span class="keyboard-key">1</span><span class="keyboard-subtitle">Users</span></li>
	   <li class="keyboard-shortcut"><span class="keyboard-key">V</span><span class="keyboard-key">2</span><span class="keyboard-subtitle">Videos</span></li>
	   <li class="keyboard-shortcut"><span class="keyboard-key">F</span><span class="keyboard-key">3</span><span class="keyboard-subtitle">Forums</span></li>
	   <li class="keyboard-shortcut"><span class="keyboard-key">G</span><span class="keyboard-key">4</span><span class="keyboard-subtitle">Groups</span></li>
	</ul>
 </li>
 <li id="server-info">
	<h2>Server information</h2>
	<ul>
	   <li><span class="info-key">CPU Usage:</span><span class="info-value"><?php echo $cpu['sys']; ?></span></li>
	   <li><span class="info-key">RAM allocated to PHP:</span><span class="info-value"><?php echo convert(memory_get_usage(true)); ?></span></li>
	   <li><span class="info-key">PHP Version:</span><span class="info-value"><?php echo phpversion(); ?></span></li>
	   <li><span class="info-key">FFmpeg status:</span><span class="info-value"><?php echo $ffmpeg; ?></span></li>
	</ul>
 </li>
</ul>
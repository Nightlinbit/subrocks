<?php
	$__carg0['stars'] = $_video_fetch_utils->get_video_stars($__carg0['rid']);
	$__carg0['star_1'] = $_video_fetch_utils->get_video_stars_level($__carg0['rid'], 1);
	$__carg0['star_2'] = $_video_fetch_utils->get_video_stars_level($__carg0['rid'], 2);
	$__carg0['star_3'] = $_video_fetch_utils->get_video_stars_level($__carg0['rid'], 3);
	$__carg0['star_4'] = $_video_fetch_utils->get_video_stars_level($__carg0['rid'], 4);
	$__carg0['star_5'] = $_video_fetch_utils->get_video_stars_level($__carg0['rid'], 5);

	if($__carg0['stars'] != 0) {
		@$__carg0['star_ratio'] = (
			$__carg0['star_5'] * 5 + 
			$__carg0['star_4'] * 4 + 
			$__carg0['star_3'] * 3 + 
			$__carg0['star_2'] * 2 + 
			$__carg0['star_1'] * 1
		) / (
			$__carg0['star_5'] + 
			$__carg0['star_4'] + 
			$__carg0['star_3'] + 
			$__carg0['star_2'] + 
			$__carg0['star_1']
		);

		$__carg0['star_ratio'] = floor($__carg0['star_ratio'] * 2) / 2;
	} else { 
		$__carg0['star_ratio'] = 0;
	}
?>

<div class="grid-item" style="animation: scale-up-recent 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;">
	<?php
		$constructVideoThumbnail($__carg0);
	?>
	<div class="video-info-grid">
		<a style="display: inline-block;width: 125px;word-wrap: break-word;" href="/watch?v=<?php echo $__carg0['rid']; ?>"><?php echo $_video_fetch_utils->parseTitle($__carg0['title']); ?></a><br>
		<span class="video-info-small">
			<span class="video-views"><?php echo $_video_fetch_utils->fetch_video_views($__carg0['rid']); ?> views</span>
			<?php
				$constructStars($__carg0);
			?>
			<br>
			<a href="/user/<?php echo htmlspecialchars($__carg0['author']); ?>"><?php echo htmlspecialchars($__carg0['author']); ?></a>
		</span>
	</div>
</div>
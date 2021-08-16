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

<div class="video-item">
	<?php
		$constructVideoThumbnail($__carg0);
	?>
	<div class="video-info">
		<a href="/watch?v=<?php echo $__carg0['rid']; ?>"><b><?php echo htmlspecialchars($__carg0['title']); ?></b></a><br>
		<div class="description-snippet">
		<?php echo $_video_fetch_utils->parseDescriptionSnippet($__carg0['description']); ?>
		</div>
		<span class="video-info-small-wide">
			<?php
				$constructStars($__carg0);
			?>
			<span style="padding-left: 13px;" class="video-views"><?php echo $_video_fetch_utils->fetch_video_views($__carg0['rid']); ?> views</span>
			<a class="video-author-wide" href="/user/<?php echo htmlspecialchars($__carg0['author']); ?>"><?php echo htmlspecialchars($__carg0['author']); ?></a>
		</span>
	</div>
</div>
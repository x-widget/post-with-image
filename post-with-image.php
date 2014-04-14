<?php
	widget_css();
?>
<div class='post-with-image'>
	<div class='title'><?=$widget_config['title']?></div>
	<div class='gallery_with_image'>
	<?
		$posts_with_image = g::posts(array( 'bo_table' => $widget_config['bo_table'],'wr_is_comment' => '0', 'limit' => '4', ));
		$board_subject = db::result("SELECT bo_subject FROM $g5[board_table] WHERE bo_table='$widget_config[bo_table]'");
		
		if ( $posts_with_image ) {
			$post_number = 1;

			foreach ( $posts_with_image as $post ) {
				$post_content = db::result("SELECT wr_content FROM $g5[write_prefix]$widget_config[bo_table] WHERE wr_id='$post[wr_id]'");
				$imgsrc = get_list_thumbnail($widget_config['bo_table'], $post['wr_id'], $widget_config['width'], $widget_config['height']);
				if ( $imgsrc['src'] ) {
					$img = $imgsrc['src'];
				} elseif ( $image_from_tag = g::thumbnail_from_image_tag( $post_content, $widget_config['bo_table'], $widget_config['width'], $widget_config['height'] )) {
					$img = $image_from_tag;
				} else $img = g::thumbnail_from_image_tag("<img src='".$latest_skin_url."/img/no-image.png'/>", $widget_config['bo_table'], $widget_config['width'], $widget_config['height']);
				?>
				<div class='image-post post_<?=$post_number++?>'>
					<?
							$url = $post['href'];
							$subject = cut_str($post['wr_subject'],15,'');
							$content = cut_str(strip_tags($post_content), 60,'');
					?>
					
					<div class='inner'>
						<div class='forum-name-wrapper'><div class='forum-name'><?=$board_subject?></div></div>
						<div class='post-image'><a href="<?=$url?>" ><img src="<?=$img?>"/></a></div>
						<div class='subject-wrapper'><div class='subject'><a href="<?=$url?>" ><?=$subject?></a></div></div>
						<div class='content-wrapper'><div class='content'><a href="<?=$url?>" ><?=$content?></a></div></div>
					</div>
					<a href='<?=$url?>' class='read_more'></a>
					</div>
				<?}?>
				<div style='clear: left'></div>
				<?if ( preg_match('/msie 7/i', $_SERVER['HTTP_USER_AGENT'] ) ) {?>
				<style>
					.bottom-left img, .bottom-middle img, .bottom-right img {
						width:auto;
					}
				</style>
				<?}?>
					
			<?}?>
	</div>
</div>
<?php
/**
 *  @file post-with-image.php
 *  @version 0.2
 */
	widget_css();
	
	$bo_table = $widget_config['forum1'];
	$height = $widget_config['height'];
	$width = $widget_config['width'];
	
	if ( empty($bo_table) ) $bo_table = bo_table(1);
	if ( empty($height) ) $height = 179;
	if ( empty($width) ) $width = 245;
	
	
	
?>
<div class='post-with-image'>
	<div class='title'><a href='<?=url_forum_list( $bo_table )?>'><?=$widget_config['title']?></a></div>
	<div class='gallery_with_image'>
	<?
		$posts_with_image = g::posts(array( 'bo_table' => $bo_table,'wr_is_comment' => '0', 'limit' => '4', ));
		$board_subject = db::result("SELECT bo_subject FROM $g5[board_table] WHERE bo_table='$bo_table'");
		
		if ( $posts_with_image ) {
			$post_number = 1;

			foreach ( $posts_with_image as $post ) {
				$post_content = db::result("SELECT wr_content FROM $g5[write_prefix]$bo_table WHERE wr_id='$post[wr_id]'");
				$imgsrc = get_list_thumbnail($bo_table, $post['wr_id'], $width, $height);
				if ( $imgsrc['src'] ) {
					$img = $imgsrc['src'];
				} elseif ( $image_from_tag = g::thumbnail_from_image_tag( $post_content, $bo_table, $width, $height )) {
					$img = $image_from_tag;
				} else $img = g::thumbnail_from_image_tag("<img src='".x::url()."/widget/$widget_config[name]/no-image.png'/>", $bo_table, $width, $height);
				?>
				<div class='image-post post_<?=$post_number++?>'>
					<?
							$url = g::url()."/bbs/board.php?bo_table=$bo_table&wr_id=$post[wr_id]";
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
					
			<?
				} else {
					echo "No data";
				}
			?>
	</div>
</div>
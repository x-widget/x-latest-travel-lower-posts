<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

widget_css();

$icon_url = widget_data_url( $widget_config['code'], 'icon' );

$file_headers = @get_headers($icon_url);

if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
    $icon_url = x::url()."/widget/".$widget_config['name']."/img/folded-paper.png";
}

if( $widget_config['forum1'] ) $_bo_table = $widget_config['forum1'];
else $_bo_table = $widget_config['default_forum_id'];

if ( empty($_bo_table) ) jsAlert('Error: empty $_bo_table ? on widget :' . $widget_config['name']);

if( $widget_config['no'] ) $limit = $widget_config['no'];
else $limit = 4;

$list = g::posts( array(
			"bo_table" 	=>	$_bo_table,
			"limit"		=>	$limit,
			"select"	=>	"idx,domain,bo_table,wr_id,wr_parent,wr_is_comment,wr_comment,ca_name,wr_datetime,wr_hit,wr_good,wr_nogood,wr_name,mb_id,wr_subject,wr_content"
				)
		);
		
$title = $widget_config['title'];
	if ( empty( $title ) ) {
		$cfg = g::config( $_bo_table, 'bo_subject' );
		$title = cut_str( $cfg['bo_subject'],10,"...");
	}

	if ( empty($title) ) {
		$title = "No title";
	}
?>


<div class="travel_lower_post">
    <div class='travel_lower_post_title'>
		
		<span class='board_subject'>
		<img class='icon' src='<?=$icon_url?>'/>
		<a href='<?=G5_BBS_URL?>/board.php?bo_table=<?=$_bo_table?>'><?php echo cut_str( $title, 20, "..." );?></a>
		
		</span>
		<a class='more_button' href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $_bo_table ?>">자세히</a>
	</div>
	<div class='travel_lower_items'>
    <?php for ($i=0; $i<count($list); $i++) { 
		if( $i+1 == count($list) ) $nomargin = 'no-margin';
		else $nomargin = null;
	?>     
		<div class='item <?=$nomargin?>'>
            <?php                        
				if( !$list[$i]['wr_comment'] ) $comments = 0;
				else $comments = $list[$i]['wr_comment'];							
            ?>
			<div class='subject'>
				<img class='bullet' src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/arrow-bullet.png' />
				<a href='<?=$list[$i]['url']?>'><?=$list[$i]['subject']?></a>
				<div class='comments'>[<?=$comments?>]</div>
			</div>			
		</div>
    <?php }  ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
		<div class='item'>
			<div class='subject'>
				<img class='bullet' src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/arrow-bullet.png' />
				<a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=5'>사이트 만들기 안내</a>
				<div class='comments'>[5]</div>
			</div>
		</div>
		<div class='item'>
			<div class='subject'>
				<img class='bullet' src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/arrow-bullet.png' />
				<a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=5'>블로그 만들기</a>
				<div class='comments'>[5]</div>
			</div>
		</div>
		<div class='item'>
			<div class='subject'>
				<img class='bullet' src='<?=x::url()?>/widget/<?=$widget_config['name']?>/img/arrow-bullet.png' />
				<a href='http://www.philgo.net/bbs/board.php?bo_table=help&wr_id=5'  style='color: #cc4235; font-weight: bold;'>여행사 사이트 만들기</a>
				<div class='comments'>[5]</div>
			</div>	
		</div>
    <?php }  ?>
	</div>   
</div>
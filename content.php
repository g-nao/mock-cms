<?php
$content_dir = "./cms-content/";
$scandir_array = scandir($content_dir);

//スキャンした配列を並び替え(ただし現在逆順)
sort($scandir_array,SORT_NATURAL);

//昇順に並び替え(配列を逆順に並び替える)
$scandir_array_reverse = array_reverse($scandir_array);

//ファイルの数を数える(ページ送りの際の頭出しのため)
$content_num = count($scandir_array_reverse) - 2;

require_once('functions/pager.php');

$get_page = (string)filter_input(INPUT_GET, 'p');
$page = empty($get_page)? 1:$get_page;//ページ番号

$page_top_contents_num = $page > 1?10 * ($page - 1):0;


$count = 0;
$pointer_increment = 0;
foreach($scandir_array_reverse as $line){
	$replace_line = str_replace(".php","",$line);
	//2ページ目以降ならその数分ポインタを強制的に進める
	if($page > 1 && $pointer_increment < $page_top_contents_num){
		next($scandir_array_reverse);
		$pointer_increment++;
		continue;
	}

	//$lineがディレクトリなら終了し次の要素を読み込み
	if(!is_file($content_dir.$line)){
		if($line === end($scandir_array_reverse)){
			paging($page);
		}
		continue;
	}
	
	require('functions/excerpt.php');
?>
<div class="content_ticket">
	<h3 class="post-title"><a href="/detail.php?archive=<?php echo $replace_line;?>"><?php echo $title;?></a></h3><hr />
	<div class="ticket_content">
		<?php
			echo $img_link.$excerpt.'<br /><a href="/detail.php?archive='.$replace_line.'"><span>...続きを見る</span></a>';
		?>
	</div>
	<div class="attached_info">
		<p class="postdate"><span><?php echo $postdate;?></span></p>
		<p class="tags"><span class="fa fa-tag"></span>タグ：<?php echo $tag_lists;?></p>
	</div>
</div>

<?php
	$count++;

	//コンテンツの表示数が10になったらページング
	if($count==10){
		paging($page);
		break;
	}
}

echo "<!-- [Content END] -->";

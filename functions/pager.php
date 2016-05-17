<?php

//http://tenderfeel.xsrv.jp/php/639/
function paging($page){
	global $page;
	global $content_num;
	 
	$next = $page+1;//前のページ番号
	$prev = $page-1;//次のページ番号
	 
	if($page == 2){//2ページめならGETではなくトップへ戻る
		$link_before = '<a href="/" class="link-arrow">&laquo; 前へ</a>';
	}elseif($page >= 3 ) {//最初のページ以外で「前へ」を表示
		$link_before = '<a href="?p='.$prev.'" class="link-arrow">&laquo; 前へ</a>';
	}else{
		$link_before = '';
	}
	//次へを表示のために全体のコンテンツからすでに表示させた分を引く
	$odd_pages = $content_num - (10 * $page);
	//最後のページ以外で「次へ」を表示
	$link_after = $odd_pages > 0?'<a href="?p='.$next.'" class="link-arrow">次へ &raquo;</a>':'';
	echo '<div id="pager_box">'.$link_before.$link_after.'</div>';
}

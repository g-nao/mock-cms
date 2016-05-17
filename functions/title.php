<?php
//https://blog.katty.in/1400
//http://sotarok.hatenablog.com/entry/20080725/php_study_34_simplexml_code

//個別のページならタイトルを取得してタイトルタグへ入れる

$get_archive = (string)filter_input(INPUT_GET, 'archive');
if($get_archive){
	$html = file_get_contents('./cms-content/'.$get_archive.'.php');
	$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'ASCII, JIS, UTF-8, EUC-JP, SJIS');
	$domDocument = new DOMDocument();
	
	libxml_use_internal_errors( true );//http://qiita.com/mgng/items/ffe82b5a0c3186770249
	$domDocument->loadHTML($html);
	libxml_clear_errors();
	
	$xmlString = $domDocument->saveXML();
	$xmlObject = simplexml_load_string($xmlString);
	$array_title = $xmlObject->xpath("//h3[@class='post-title']");
	$title_string = (string)$array_title[0];
	
	echo '<title>'.$title_string.' | mock-cms</title>';
}else{
	echo '<title>MOCK-CMS WEBSITE</title>';
}

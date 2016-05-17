<?php

$html = file_get_contents($content_dir.$line);
$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'ASCII, JIS, UTF-8, EUC-JP, SJIS');
$domDocument = new DOMDocument();

libxml_use_internal_errors( true );//http://qiita.com/mgng/items/ffe82b5a0c3186770249
$domDocument->loadHTML($html);
libxml_clear_errors();

$xmlString = $domDocument->saveXML();
$xmlObject = simplexml_load_string($xmlString);

//タイトル
$array_title = $xmlObject->xpath("//h3[@class='post-title']");
$title = (string)$array_title[0];

//本文抜粋
$array_excerpt = $xmlObject->xpath("//div[@class='ticket_content']");
$img_path = (string)$array_excerpt[0]->p[0]->img[@src];
$img_alt = (string)$array_excerpt[0]->p[0]->img[@alt];
$img_link = $img_path ? '<p class="image_content"><img src="'.$img_path.'" alt="'.$img_alt.'" /></p>' : false;
$excerpt = $img_path ? '<p>'.$array_excerpt[0]->p[1].'</p>' : '<p>'.$array_excerpt[0]->p[0].'</p>';

//タグ
$array_tags = $xmlObject->xpath("//p[@class='tags']");
$tag_lists ="";
foreach($array_tags[0]->span as $tag){
	$tag_lists .= '<span class="tag">'.(string)$tag.'</span>';
};

//日付
$array_date = $xmlObject->xpath("//p[@class='postdate']");
$postdate = (string)$array_date[0]->span;

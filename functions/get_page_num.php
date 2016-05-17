<?php

$str					= (string)filter_input(INPUT_GET, 'p');
$str_esc			= htmlentities($str, ENT_QUOTES, "utf-8");
$get_page			= preg_replace('/[^0-9]/', '', $str_esc);
$current_page	= empty($get_page)? 1:$get_page;//ページ番号

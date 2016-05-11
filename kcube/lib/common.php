<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/lib/web_lib.php";
include $server_root_path."/lib/f_dbcon.php";
include $server_root_path."/lib/f_string.php";
include $server_root_path."/lib/f_pageing.php";

include $server_root_path."/lib/class/class_mgr_cate.php";


//-- DB 연결
set_dbcon();
?>
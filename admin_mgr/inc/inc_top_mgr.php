<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/lib/web_lib.php";
include $server_root_path."/lib/f_dbcon.php";
include $server_root_path."/lib/f_string.php";
include $server_root_path."/lib/f_pageing.php";

include $server_root_path."/lib/admin_lib.php";

include $server_root_path."/lib/class/class_admin_mem.php";
include $server_root_path."/lib/class/class_admin_memu.php";
include $server_root_path."/lib/class/class_admin_mem_auth.php";
?>
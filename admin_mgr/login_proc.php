<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php" ?>
<?
//-- DB 연결
set_dbcon();


$userid = rqstr("userid", "");
$pwd = rqstr("pwd", "");



$login_yn = false;


get_tb_admin_mem_info_001( $userid );

if(!eqyn($db_am[result_cmd], "YESDATA") || !eqyn($db_am[am_status], "Y")){
}else{
	if( $db_am[am_userid] == $userid && $db_am[am_pwd] == $pwd){
		$db_am_kind = $db_am[am_kind];
		$db_am_name = $db_am[am_name];
		$login_yn = true;
	}
}


if($login_yn){
	set_admin($userid, $db_am_kind, $db_am_name);
	gourl( "top.", "./main.php" );
}else{
	printmsgback("일치하는 정보가 없습니다.");
}
?>
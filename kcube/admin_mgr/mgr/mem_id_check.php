<?
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";


//-- 로그인 체크
admin_check( "menuZ01" );

//-- DB 연결
set_dbcon();


//-- 데이타 가져오기
get_tb_admin_mem_rq();
$am_userid = $rq_am['am_userid'];
get_tb_admin_mem_info_001( $am_userid );


//-- DB 닫기
set_db_close();


printjs("parent.return_am_userid('". $db_am[result_cmd] ."')");
?>
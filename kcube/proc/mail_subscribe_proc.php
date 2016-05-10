<?
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_mail_subscribe.php";


//-- DB 연결
set_dbcon( true );

//-- 트랜젝션 시작
transtart();

//-- 데이타 가져오기
get_tb_mail_subscribe_rq();



//-- DB 처리
$cmd = "ins";
$db_result = set_tb_mail_subscribe_proc_001( $cmd, $rq_msr );


//-- 트랜젝션 처리
$db_proc_status = transproc();

//-- DB 종료
set_db_close();


if($db_proc_status){
	printmsg("등록되었습니다.");
	printjs("parent.location.reload();");
}else{
	printmsg("오류발생\\n다시 시도해주세요..");
}
?>
<?
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_mgr_cate.php";

$GLB_RETURN_PARAM = rqstr("return_param", "", "p");

//-- 로그인 체크
admin_check( "menuB01", "parent." );

//-- DB 연결
set_dbcon( true );

//-- 트랜젝션 시작
transtart();

//-- 데이타 가져오기
get_tb_mgr_cate_rq();
$rq_mct['fk_mct_am_userid'] = get_admin();

//-- DB 처리
if(eqyn($cmd, "del")){
	$db_result = set_tb_mgr_cate_proc_001( $cmd, $rq_mct );

}else{
	$db_result = set_tb_mgr_cate_proc_001( $cmd, $rq_mct );
}

//-- 트랜젝션 처리
$db_proc_status = transproc();

//-- DB 종료
set_db_close();


if($db_proc_status){
	printmsg("처리되었습니다.");
	printjs("parent.location.reload();");

}else{
	printmsg("오류발생\\n다시 시도해주세요..");
}
?>
<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/f_file.php";
include $server_root_path."/lib/class/class_mail_subscribe.php";

$GLB_RETURN_PARAM = rqstr("return_param", "", "p");

//-- 로그인 체크
admin_check( "menuF01", "parent." );

//-- DB 연결
set_dbcon( true );

//-- 트랜젝션 시작
transtart();

//-- 데이타 가져오기
get_tb_mail_subscribe_rq();



$cmd = "del";
for( $i = 0; $i < count( $_POST["msr_idx"] ); ++$i ){
	$rq_tm[msr_idx] = $_POST["msr_idx"][$i];

	$db_result = set_tb_mail_subscribe_proc_001( $cmd, $rq_tm );
	if(!get_db_proc_status()){
		break;
	}
}



//-- 트랜젝션 처리
$db_proc_status = transproc();

//-- DB 종료
set_db_close();


if($db_proc_status){
	printmsg("처리되었습니다.");
	if(eqyn($cmd, "upt")){
		printjs("parent.location.reload();");
	}else{
		gourl("top.", "msr_list.php?$GLB_RETURN_PARAM_DEC");
	}
}else{
	printmsg("오류발생\\n다시 시도해주세요..");
}
?>
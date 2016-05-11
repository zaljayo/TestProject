<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";


//-- 로그인 체크
admin_check( "menuZ01", "parent." );

//-- DB 연결
set_dbcon();

//-- 트랜젝션 시작
transtart();


//-- 데이타 가져오기
get_tb_admin_mem_rq();
$pre_cmd = rqstr("pre_cmd", "");


$id_check = true;
$db_proc_status = true;
if(eqyn($cmd, "ins")){
	$am_userid = $rq_am['am_userid'];
	get_tb_admin_mem_info_001( $am_userid );
	if(eqyn($db_am[result_cmd], "YESDATA")){
		$id_check = false;
		$db_proc_status = false;
	}
}


if($id_check){
	$db_result = set_tb_admin_mem_proc_001( $cmd, $rq_am );
}


//-- 트랜젝션 처리
$db_proc_status = transproc();


//-- DB 종료
set_db_close();


if($db_proc_status){
	printmsg("처리되었습니다.");

	if(eqyn($pre_cmd, "all")){ //--관리자 관리에서 수정시
		printjs("parent.location.href='mem_list.php?$GLB_RETURN_PARAM_DEC';");	
	}else{ //-- my page에서 수정시
		printjs("parent.location.reload();");
	}

}else{
	if(!$id_check){
		printmsg("사용하실수 없는 아이디 입니다.");	
	}else{
		printmsg("오류발생\\n다시 시도해주세요.");
	}
}
?>
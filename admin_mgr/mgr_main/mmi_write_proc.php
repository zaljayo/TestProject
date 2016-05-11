<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/f_file.php";
include $server_root_path."/lib/class/class_mgr_main.php";

$GLB_RETURN_PARAM = rqstr("return_param", "", "p");

//-- 로그인 체크
admin_check( "menuA01", "parent." );

//-- DB 연결
set_dbcon( true );

//-- 트랜젝션 시작
transtart();

//-- 데이타 가져오기
get_tb_mgr_main_rq();
$db_mmi_seq = rqint("db_mmi_seq", 0);

//-- 업로드 경로
get_updir( "mgr_main" );



if(eqyn($cmd, "up") || eqyn($cmd, "down")){
	$db_result = set_tb_mgr_main_seq_proc_001( $cmd, $rq_mmi[mmi_idx], $rq_mmi[mmi_seq] );

}else if(eqyn($cmd, "list_del")){
	$cmd = "del";
	for( $i = 0; $i < count( $_POST["mmi_idx"] ); ++$i ){
		$rq_mmi[mmi_idx] = $_POST["mmi_idx"][$i];

		$db_result = set_tb_mgr_main_proc_001( $cmd, $rq_mmi );
		if(!get_db_proc_status()){
			break;
		}
	}

	if(get_db_proc_status()){
		//-- 정렬순서 변경
		$db_result = set_tb_mgr_main_seq_proc_001( $cmd, 0, 0 );
	}

}else{
	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['mmi_img_pc'], $rq_mmi[db_mmi_img_pc], $rq_mmi[del_mmi_img_pc]);
	$rq_mmi[mmi_img_pc] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_mmi[mmi_img_pc] ); //-- 업로드 파일 체크
	}

	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['mmi_img_tb'], $rq_mmi[db_mmi_img_tb], $rq_mmi[del_mmi_img_tb]);
	$rq_mmi[mmi_img_tb] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_mmi[mmi_img_tb] ); //-- 업로드 파일 체크
	}

	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['mmi_img_mb'], $rq_mmi[db_mmi_img_mb], $rq_mmi[del_mmi_img_mb]);
	$rq_mmi[mmi_img_mb] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_mmi[mmi_img_mb] ); //-- 업로드 파일 체크
	}

	//-- DB 처리
	$db_result = set_tb_mgr_main_proc_001( $cmd, $rq_mmi );
	if(eqyn($cmd, "ins")){
		$rq_mmi[mmi_idx] = last_insert_id();
	}

	if(get_db_proc_status()){
		//-- 정렬순서 변경
		if($db_mmi_seq >= $rq_mmi[mmi_seq]){
			$db_result = set_tb_mgr_main_seq_proc_001( "up", $rq_mmi[mmi_idx], $rq_mmi[mmi_seq] );		
		}else{
			$db_result = set_tb_mgr_main_seq_proc_001( "down", $rq_mmi[mmi_idx], $rq_mmi[mmi_seq] );
		}
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
		gourl("top.", "mmi_list.php?$GLB_RETURN_PARAM_DEC");
	}
}else{
	printmsg("오류발생\\n다시 시도해주세요..");
}
?>
<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/f_file.php";
include $server_root_path."/lib/class/class_team.php";

$GLB_RETURN_PARAM = rqstr("return_param", "", "p");

//-- 로그인 체크
admin_check( "menuD01", "parent." );

//-- DB 연결
set_dbcon( true );

//-- 트랜젝션 시작
transtart();

//-- 데이타 가져오기
get_tb_team_rq();
$rq_tm['fk_tm_am_userid'] = get_admin();
$db_tm_seq = rqint("db_tm_seq", 0);

//-- 업로드 경로
get_updir( "team" );


if(eqyn($cmd, "up") || eqyn($cmd, "down")){
	$db_result = set_tb_team_seq_proc_001( $cmd, $rq_tm[tm_idx], $rq_tm[tm_seq] );

}else if(eqyn($cmd, "list_del")){
	$cmd = "del";
	for( $i = 0; $i < count( $_POST["tm_idx"] ); ++$i ){
		$rq_tm[tm_idx] = $_POST["tm_idx"][$i];

		$db_result = set_tb_team_proc_001( $cmd, $rq_tm );
		if(!get_db_proc_status()){
			break;
		}
	}

	if(get_db_proc_status()){
		//-- 정렬순서 변경
		$db_result = set_tb_team_seq_proc_001( $cmd, 0, 0 );
	}

}else{
	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['tm_list_img_pc'], $rq_tm[db_tm_list_img_pc], $rq_tm[del_tm_list_img_pc]);
	$rq_tm[tm_list_img_pc] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_tm[tm_list_img_pc] ); //-- 업로드 파일 체크
	}

	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['tm_list_img_mb'], $rq_tm[db_tm_list_img_mb], $rq_tm[del_tm_list_img_mb]);
	$rq_tm[tm_list_img_mb] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_tm[tm_list_img_mb] ); //-- 업로드 파일 체크
	}

	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['tm_det_img_pc'], $rq_tm[db_tm_det_img_pc], $rq_tm[del_tm_det_img_pc]);
	$rq_tm[tm_det_img_pc] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_tm[tm_det_img_pc] ); //-- 업로드 파일 체크
	}

	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['tm_det_img_mb'], $rq_tm[db_tm_det_img_mb], $rq_tm[del_tm_det_img_mb]);
	$rq_tm[tm_det_img_mb] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_tm[tm_det_img_mb] ); //-- 업로드 파일 체크
	}

	//-- DB 처리
	$db_result = set_tb_team_proc_001( $cmd, $rq_tm );
	if(eqyn($cmd, "ins")){
		$rq_tm[tm_idx] = last_insert_id();
	}


	if(get_db_proc_status()){
		//-- 정렬순서 변경
		if($db_tm_seq >= $rq_tm[tm_seq]){
			$db_result = set_tb_team_seq_proc_001( "up", $rq_tm[tm_idx], $rq_tm[tm_seq] );		
		}else{
			$db_result = set_tb_team_seq_proc_001( "down", $rq_tm[tm_idx], $rq_tm[tm_seq] );
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
		gourl("top.", "tm_list.php?$GLB_RETURN_PARAM_DEC");
	}
}else{
	printmsg("오류발생\\n다시 시도해주세요..");
}
?>
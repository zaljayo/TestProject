<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/f_file.php";
include $server_root_path."/lib/class/class_family.php";
include $server_root_path."/lib/class/class_family_img.php";

$GLB_RETURN_PARAM = rqstr("return_param", "", "p");

//-- 로그인 체크
admin_check( "menuC01", "parent." );

//-- DB 연결
set_dbcon( true );

//-- 트랜젝션 시작
transtart();

//-- 데이타 가져오기
get_tb_family_rq();
$rq_tm['fk_fm_am_userid'] = get_admin();
$db_fm_seq = rqint("db_fm_seq", 0);

//-- 업로드 경로
get_updir( "family" );



if(eqyn($cmd, "up") || eqyn($cmd, "down")){
	$db_result = set_tb_family_seq_proc_001( $cmd, $rq_fm[fm_idx], $rq_fm[fm_seq] );

}else if(eqyn($cmd, "list_del")){
	$cmd = "del";
	for( $i = 0; $i < count( $_POST["fm_idx"] ); ++$i ){
		$rq_fm[fm_idx] = $_POST["fm_idx"][$i];

		$db_result = set_tb_family_proc_001( $cmd, $rq_fm );
		if(!get_db_proc_status()){
			break;
		}
	}

	if(get_db_proc_status()){
		//-- 정렬순서 변경
		$db_result = set_tb_family_seq_proc_001( $cmd, 0, 0 );
	}

}else if(eqyn($cmd, "img_del")){
	$cmd = "del";
	get_tb_family_img_rq();
	$db_result = set_tb_family_img_proc_001( $cmd, $rq_fmi );
	$cmd = "upt";

}else{
	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['fm_img_list_pc'], $rq_fm[db_fm_img_list_pc], $rq_fm[del_fm_img_list_pc]);
	$rq_fm[fm_img_list_pc] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_fm[fm_img_list_pc] ); //-- 업로드 파일 체크
	}

	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['fm_img_list_mb'], $rq_fm[db_fm_img_list_mb], $rq_fm[del_fm_img_list_mb]);
	$rq_fm[fm_img_list_mb] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_fm[fm_img_list_mb] ); //-- 업로드 파일 체크
	}


	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['fm_img_ceo_pc'], $rq_fm[db_fm_img_ceo_pc], $rq_fm[del_fm_img_ceo_pc]);
	$rq_fm[fm_img_ceo_pc] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_fm[fm_img_ceo_pc] ); //-- 업로드 파일 체크
	}

	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['fm_img_ceo_mb'], $rq_fm[db_fm_img_ceo_mb], $rq_fm[del_fm_img_ceo_mb]);
	$rq_fm[fm_img_ceo_mb] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_fm[fm_img_ceo_mb] ); //-- 업로드 파일 체크
	}


	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['fm_ci_img_pc'], $rq_fm[db_fm_ci_img_pc], $rq_fm[del_fm_ci_img_pc]);
	$rq_fm[fm_ci_img_pc] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_fm[fm_ci_img_pc] ); //-- 업로드 파일 체크
	}
	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['fm_ci_img_mb'], $rq_fm[db_fm_ci_img_mb], $rq_fm[del_fm_ci_img_mb]);
	$rq_fm[fm_ci_img_mb] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_fm[fm_ci_img_mb] ); //-- 업로드 파일 체크
	}

	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['fm_logo_img_pc'], $rq_fm[db_fm_logo_img_pc], $rq_fm[del_fm_logo_img_pc]);
	$rq_fm[fm_logo_img_pc] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_fm[fm_logo_img_pc] ); //-- 업로드 파일 체크
	}
	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['fm_logo_img_mb'], $rq_fm[db_fm_logo_img_mb], $rq_fm[del_fm_logo_img_mb]);
	$rq_fm[fm_logo_img_mb] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_fm[fm_logo_img_mb] ); //-- 업로드 파일 체크
	}


	//-- DB 처리
	$db_result = set_tb_family_proc_001( $cmd, $rq_fm );
	if(eqyn($cmd, "ins")){
		$rq_fm[fm_idx] = last_insert_id();
	}




	//-- 대표 이미지 DB 처리
/*
	if(get_db_proc_status()){
		$pre_cmd = $cmd;
		$rq_fmi['fk_fmi_fm_idx'] = $rq_fm[fm_idx];


		//-- 업로드 경로
		get_updir( "family_img" );

		for($i=1; $i<5; $i++){
			$file_del = "N";

			$fmi_idx = "fmi_idx$i";
			$fmi_img_desc = "fmi_img_desc$i";

			$fmi_img_pc = "fmi_img_pc$i";
			$db_fmi_img_pc = "db_fmi_img_pc$i";

			$fmi_img_mb = "fmi_img_mb$i";
			$db_fmi_img_mb = "db_fmi_img_mb$i";


			$rq_fmi[fmi_idx] = setnull($_POST[$fmi_idx], 0);


			if(eqyn($rq_fmi[fmi_idx], 0)){
				$cmd = "ins";
			}else{
				$cmd = "upt";
			}

			if(eqyn($pre_cmd, "del")){
				$cmd = $pre_cmd;
				$file_del = "Y";
			}			
			
			$rq_fmi[fmi_img_desc] = $_POST[$fmi_img_desc];

//			$rq_fmi[fmi_img_pc] = $_POST[$fmi_img_pc];
			$rq_fmi[db_fmi_img_pc] = $_POST[$db_fmi_img_pc];

//			$rq_fmi[fmi_img_mb] = $_POST[$fmi_img_mb];
			$rq_fmi[db_fmi_img_mb] = $_POST[$db_fmi_img_mb];


			//-- 파일 업로드
			$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES[$fmi_img_pc], $rq_fmi[db_fmi_img_pc], $file_del);
			$rq_fmi[fmi_img_pc] = $tmp_file["name"];
//			echo $rq_fmi[fmi_img_pc]."<br>";
			if(!eqyn($cmd, "del")){
				get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_fmi[$fmi_img_pc] ); //-- 업로드 파일 체크
			}

			$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES[$fmi_img_mb], $rq_fmi[db_fmi_img_mb], $file_del);
			$rq_fmi[fmi_img_mb] = $tmp_file["name"];
			if(!eqyn($cmd, "del")){
				get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_fmi[$fmi_img_mb] ); //-- 업로드 파일 체크
			}


			if(!eqyn($rq_fmi[fmi_img_pc], "") || !eqyn($rq_fmi[fmi_img_mb], "")){
				$db_result = set_tb_family_img_proc_001( $cmd, $rq_fmi );
				if(!get_db_proc_status()){
					break;
				}
			}
		}

		$cmd = $pre_cmd;

	}
*/

	if(get_db_proc_status()){
		//-- 정렬순서 변경
		if($db_fm_seq >= $rq_fm[fm_seq]){
			$db_result = set_tb_family_seq_proc_001( "up", $rq_fm[fm_idx], $rq_fm[fm_seq] );		
		}else{
			$db_result = set_tb_family_seq_proc_001( "down", $rq_fm[fm_idx], $rq_fm[fm_seq] );
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
		gourl("top.", "fm_list.php?$GLB_RETURN_PARAM_DEC");
	}
}else{
	printmsg("오류발생\\n다시 시도해주세요..");
}
?>
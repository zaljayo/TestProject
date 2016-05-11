<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/f_file.php";
include $server_root_path."/lib/class/class_ins_news.php";
include $server_root_path."/lib/class/class_tag_dic.php";

$GLB_RETURN_PARAM = rqstr("return_param", "", "p");

//-- 로그인 체크
admin_check( "menuE01", "parent." );

//-- DB 연결
set_dbcon( true );

//-- 트랜젝션 시작
transtart();

//-- 데이타 가져오기
get_tb_ins_news_rq();
$rq_inw['fk_inw_am_userid'] = get_admin();

$str_tm_idx = "";
$tm_cnt = count($_POST[tm_idx]);
if($tm_cnt > 0){
	$cnt = 0;
	foreach($_POST[tm_idx] as $val){
		$cnt++;
		if($cnt == $tm_cnt){
			$str_tm_idx .= "$val";
		}else{
			$str_tm_idx .= "$val,";
		}
	}
}

$str_fm_idx = "";
$fm_cnt = count($_POST[fm_idx]);
if(count($_POST[fm_idx]) > 0){
	$cnt = 0;
	foreach($_POST[fm_idx] as $val){
		$cnt++;
		if($cnt == $fm_cnt){
			$str_fm_idx .= "$val";
		}else{
			$str_fm_idx .= "$val,";
		}
	}
}

//$str_tm_idx = substr($str_tm_idx, 0, strlen($str_tm_idx)-1);
//$str_fm_idx = substr($str_fm_idx, 0, strlen($str_fm_idx)-1);

$rq_inw[fk_inw_tm_idx] = $str_tm_idx;
$rq_inw[fk_inw_fm_idx] = $str_fm_idx;
/*
echo $str_tm_idx."<br>";
echo $str_fm_idx."<br>";
exit;
*/


//-- 업로드 경로
get_updir( "ins_news" );
$db_td_tag = rqstr("db_inw_tag", "");


if(eqyn($cmd, "list_del")){
	$cmd = "del";
	for( $i = 0; $i < count( $_POST["inw_idx"] ); ++$i ){
		$rq_inw[inw_idx] = $_POST["inw_idx"][$i];

		$db_result = set_tb_ins_news_proc_001( $cmd, $rq_inw );
		if(!get_db_proc_status()){
			break;
		}


		if(get_db_proc_status()){
			$sql = "select inw_tag from tb_ins_news where inw_idx=$rq_inw[inw_idx]";
			$ors = sql_array($sql);
			if($ors){
				$db_td_tag = $ors[0][0];
				/* 테그정보 DB 처리 */
				set_tb_tag_dic_proc_001( $db_td_tag, "");
				if(!get_db_proc_status()){
					break;
				}
			}
		}
	}

/*
	if(get_db_proc_status()){
		//-- 정렬순서 변경
		$db_result = set_tb_ins_news_seq_proc_001( $cmd, 0, 0 );
	}
*/

}else{
	//-- 파일 업로드
	$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['inw_img_list'], $rq_inw[db_inw_img_list], $rq_inw[del_inw_img_list]);
	$rq_inw[inw_img_list] = $tmp_file["name"];
	if(!eqyn($cmd, "del")){
		get_upload_file_check( $GLB_UP_FILE_ROOTDIR, $rq_inw[inw_img_list] ); //-- 업로드 파일 체크
	}

	//-- DB 처리
	$db_result = set_tb_ins_news_proc_001( $cmd, $rq_inw );


	if(get_db_proc_status()){
		/* 테그정보 DB 처리 */
		set_tb_tag_dic_proc_001( $db_td_tag, $rq_inw[inw_tag] );
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
		gourl("top.", "inw_list.php?$GLB_RETURN_PARAM_DEC");
	}
}else{
	printmsg("오류발생\\n다시 시도해주세요..");
}
?>
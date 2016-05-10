<?
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/f_file.php";


//-- 로그인 체크
admin_check( "menuZ01", "top.opener" );

//-- DB 연결
set_dbcon();

//-- 트랜젝션 시작
transtart();


//-- 데이타 가져오기
get_tb_admin_mem_auth_rq();
$am_userid = $rq_fk['fk_ama_am_userid'];



$sql = "delete from tb_admin_mem_auth where fk_ama_am_userid = '". $am_userid ."' ";
$db_proc_status = sql_query($sql);

if($db_proc_status){
	foreach( $_POST["amm_key"] as &$amm_key){
		if(isset($_POST["sub_amm_key_$amm_key"])){
			foreach( $_POST["sub_amm_key_$amm_key"] as &$fk_ama_amm_key){
				$sql = "insert into tb_admin_mem_auth(fk_ama_am_userid, fk_ama_amm_key) values('". $am_userid ."', '". $fk_ama_amm_key ."') ";
				$db_proc_status = sql_query($sql);
				if(!$db_proc_status){
					break;
				}

			}
		}
	}
}


//-- 트랜젝션 처리
$db_proc_status = transproc();


//-- DB 종료
set_db_close();

if($db_proc_status){
	printmsg("처리되었습니다.");
	printjs("parent.fm_load();");

}else{
	printmsg("오류발생\\n다시 시도해주세요..");
}
?>
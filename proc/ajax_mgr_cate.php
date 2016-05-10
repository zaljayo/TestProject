<?
include $_SERVER["DOCUMENT_ROOT"]."/lib/web_lib.php";
include $server_root_path."/lib/f_dbcon.php";
include $server_root_path."/lib/f_string.php";

include $server_root_path."/lib/class/class_mgr_cate.php";



//-- DB 연결
set_dbcon();



//-- 데이타 가져오기
get_tb_mgr_cate_rq();


$rs = get_tb_mgr_cate_list_001( $rq_mct[mct_cate], "mct_idx, mct_cate, mct_name, mct_name_eng" );
echo get_rs_json( $rs );


//-- DB 종료
set_db_close();
?>
<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/lib/web_lib.php";
include $server_root_path."/lib/f_dbcon.php";
include $server_root_path."/lib/f_string.php";
include $server_root_path."/lib/f_pageing.php";

include $server_root_path."/lib/class/class_family.php";



//-- DB 연결
set_dbcon();

$lng = rqstr("lng", "kor", "g");

//-- 리스트 가져오기
$sql_where = " and fm_status = 'Y'";


//$search_title = rqstr("search_title", "", "p");
//echo $search_title;
//$search_title = iconv('euc-kr', 'utf-8', $search_title);
//echo $search_title;
//$search_title = urldecode($search_title);

if($ser_fk_fm_mct_idx != ""){
	$search_yn = true;
	$sql_where .= " and fk_fm_mct_idx = $ser_fk_fm_mct_idx ";
}


if($search_title != ""){
	$search_yn = true;
	if(eqyn($fild, "tag")){
		$sql_where .= " and (
				fm_ceo like '%$search_title%'
				or fm_com like '%$search_title%' or fm_com_eng like '%$search_title%' 
				or fm_com like '%$search_title%' or fm_com_eng like '%$search_title%'
				or fm_service like '%$search_title%' or fm_service_eng like '%$search_title%'
				or fm_com_int like '%$search_title%' or fm_com_int_eng like '%$search_title%'
				or fm_svr_int like '%$search_title%' or fm_svr_int_eng like '%$search_title%'
				or fm_ceo like '%$search_title%'
			)
		";
	}
}

//echo $sql_where;
$cmd = rqstr("cmd", "", "g");
if(eqyn($cmd, "count")){
	echo sql_count("tb_family", $sql_where);

}else{
	$fild = "fm_idx, fm_com, fm_com_eng, fm_img_list_pc, fm_img_list_mb, fm_list_desc, fm_list_desc_eng, fm_home_url_type, fm_home_url, fm_brand_url_type, fm_brand_url, fm_com_int_eng";

	$arr_sql = array(
		"fild" => "$fild",
		"table" => "tb_family",
		"where" => $sql_where,
		"orderby" => "order by fm_seq asc, fm_idx desc"
	);
	$db_result = get_record( $arr_sql );
	//$rs = $db_result[result];


	//-- DB 닫기
	set_db_close();


	//print_r($rs);
	echo json_encode ( $db_result );
}
?>
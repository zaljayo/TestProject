<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/lib/web_lib.php";
include $server_root_path."/lib/f_dbcon.php";
include $server_root_path."/lib/f_string.php";
include $server_root_path."/lib/f_pageing.php";

include $server_root_path."/lib/class/class_ins_news.php";



//-- DB 연결
set_dbcon();

get_tb_ins_news_rq("g");
$lng = rqstr("lng", "kor", "g");
$ser_fk_inw_tm_idx = rqint("ser_fk_inw_tm_idx", 0, "g");
$ser_fk_inw_fm_idx = rqint("ser_fk_inw_fm_idx", 0, "g");

//-- 리스트 가져오기
$sql_where = " and inw_status = 'Y'";

if($ser_fk_inw_mct_cate != ""){
	$search_yn = true;
	$sql_where .= " and fk_inw_mct_cate = '$ser_fk_inw_mct_cate' ";
}

if($ser_fk_inw_mct_idx != ""){
	$search_yn = true;
	$sql_where .= " and fk_inw_mct_idx = '$ser_fk_inw_mct_idx' ";
}

if($ser_fk_inw_tm_idx != 0){
	$search_yn = true;
	$ser_fk_inw_tm_idx = ",$ser_fk_inw_tm_idx,";
	$sql_where .= " and CONCAT(  ',', fk_inw_tm_idx,  ',' ) like '%$ser_fk_inw_tm_idx%' ";
}


if($ser_fk_inw_fm_idx != 0){
	$search_yn = true;
	$ser_fk_inw_fm_idx = ",$ser_fk_inw_fm_idx,";
	$sql_where .= " and CONCAT(  ',', fk_inw_fm_idx,  ',' ) like '%$ser_fk_inw_fm_idx%' ";
}

if($search_title != ""){
	$search_yn = true;
	if(eqyn($fild, "tag")){
		$search_title = print_content("html", $search_title);

		$arr_tag = explode (",", $search_title);
		$tag = "";

		if(count($arr_tag) >= 1 && !eqyn($search_title, "")){
			for($i=0; $i<count($arr_tag); $i++){
				$tmp_tag = trim($arr_tag[$i]);
				if(!eqyn($tmp_tag, "")){
					$tmp_tag = addslashes($tmp_tag);
					$tag .= " inw_tag like '%$tmp_tag%' or ";
				}
			}
		}
		if(!eqyn($tag, "")){
			$tag = substr($tag, 0, strlen($tag)-4);
			$sql_where .= "
				and ($tag
					or inw_title like '%$search_title%'
					or inw_img_list_desc like '%$search_title%'
					or inw_content like '%$search_title%'
				)
			";
		}else{
			$sql_where .= "
				and (
					inw_title like '%$search_title%'
					or inw_img_list_desc like '%$search_title%'
					or inw_content like '%$search_title%'
				)
			";
		}

		if(!eqyn($rq_inw[inw_idx], 0)){
			$sql_where .= " and inw_idx != $rq_inw[inw_idx]";
		}

	}else if(!eqyn($fild, "")){
		$sql_where .= " and ".$fild." like '%$search_title%' ";

	}else{
		$sql_where .= " and (
				inw_tag like '%$search_title%'
				or inw_title like '%$search_title%'
				or inw_img_list_desc like '%$search_title%'
				or inw_content like '%$search_title%'
			)
		";
	}
}
//echo $sql_where;


$cmd = rqstr("cmd", "", "g");
if(eqyn($cmd, "count")){
	echo sql_count("tb_ins_news", $sql_where);

}else{
	$fild = "inw_idx, inw_wname, inw_title, fk_inw_mct_cate, fk_inw_mct_idx, fk_inw_tm_idx, fk_inw_fm_idx, inw_tag, inw_img_list, inw_img_list_desc, inw_ins_datetime";
	$arr_sql = array(
		"fild" => "$fild",
		"table" => "tb_ins_news",
		"where" => $sql_where,
		"orderby" => "order by inw_ins_datetime desc, inw_idx desc"
	);
	$db_result = get_record( $arr_sql );
	//$rs = $db_result[result];


	//print_r($rs);
	echo json_encode ( $db_result );
}

//-- DB 닫기
set_db_close();
?>
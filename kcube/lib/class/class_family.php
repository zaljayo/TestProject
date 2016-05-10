<?
$ser_fm_status = rqstr("ser_fm_status", "", "g");
$ser_fk_fm_mct_idx = rqstr("ser_fk_fm_mct_idx", "", "g");

$arr_fm_link_type = array("L"=>"View Website", "D"=>"Download");

$rq_fm = array(
	"fm_idx" => 0,
	"fm_status" => "H",
	"fk_fm_am_userid" => "",
	"fm_wname" => "",
	"fm_seq" => 0,
	"fk_fm_mct_idx" => 0,
	"fm_com" => "",
	"fm_com_eng" => "",
	"fm_ceo" => "",
	"fm_service" => "",
	"fm_service_eng" => "",
	"fm_home_url_type" => "L",
	"fm_home_url" => "",
	"fm_brand_url_type" => "D",
	"fm_brand_url" => "",
	"fm_email" => "",
	"fm_com_int" => "",
	"fm_com_int_eng" => "",
	"fm_svr_int" => "",
	"fm_svr_int_eng" => "",
	"fm_list_desc" => "",
	"fm_list_desc_eng" => "",
	"fm_svr_desc" => "",
	"fm_svr_desc_eng" => "",
	"fm_addr" => "",
	"fm_gps_addr" => "",
	"fm_gpsx" => "",
	"fm_gpsy" => "",
	"fm_img_com1_pc" => "",
	"db_fm_img_com1_pc" => "",
	"del_fm_img_com1_pc" => "N",
	"fm_img_com1_mb" => "",
	"db_fm_img_com1_mb" => "",
	"del_fm_img_com1_mb" => "N",
	"fm_img_com2_pc" => "",
	"db_fm_img_com2_pc" => "",
	"del_fm_img_com2_pc" => "N",
	"fm_img_com2_mb" => "",
	"db_fm_img_com2_mb" => "",
	"del_fm_img_com2_mb" => "N",
	"fm_img_com3_pc" => "",
	"db_fm_img_com3_pc" => "",
	"del_fm_img_com3_pc" => "N",
	"fm_img_com3_mb" => "",
	"db_fm_img_com3_mb" => "",
	"del_fm_img_com3_mb" => "N",
	"fm_img_com4_pc" => "",
	"db_fm_img_com4_pc" => "",
	"del_fm_img_com4_pc" => "N",
	"fm_img_com4_mb" => "",
	"db_fm_img_com4_mb" => "",
	"del_fm_img_com4_mb" => "N",
	"fm_img_list_pc" => "",
	"db_fm_img_list_pc" => "",
	"del_fm_img_list_pc" => "N",
	"fm_img_list_mb" => "",
	"db_fm_img_list_mb" => "",
	"del_fm_img_list_mb" => "N",
	"fm_img_ceo_pc" => "",
	"db_fm_img_ceo_pc" => "",
	"del_fm_img_ceo_pc" => "N",
	"fm_img_ceo_mb" => "",
	"db_fm_img_ceo_mb" => "",
	"del_fm_img_ceo_mb" => "N",
	"fm_ci_img_pc" => "",
	"db_fm_ci_img_pc" => "",
	"del_fm_ci_img_pc" => "N",
	"fm_ci_img_mb" => "",
	"db_fm_ci_img_mb" => "",
	"del_fm_ci_img_mb" => "N",
	"fm_logo_img_pc" => "",
	"db_fm_logo_img_pc" => "",
	"del_fm_logo_img_pc" => "N",
	"fm_logo_img_mb" => "",
	"db_fm_logo_img_mb" => "",
	"del_fm_logo_img_mb" => "N",
	"fm_read_cnt" => 0,
	"fm_ip" => "",
	"fm_ins_datetime" => "",
	"fm_proc_datetime" => "",
);


$db_fm = array(
	"result_cmd" => "",
	"fm_idx" => 0,
	"fm_status" => "H",
	"fk_fm_am_userid" => "",
	"fm_wname" => "",
	"fm_seq" => 0,
	"fk_fm_mct_idx" => 0,
	"fm_com" => "",
	"fm_com_eng" => "",
	"fm_ceo" => "",
	"fm_service" => "",
	"fm_service_eng" => "",
	"fm_home_url_type" => "L",
	"fm_home_url" => "",
	"fm_brand_url_type" => "D",
	"fm_brand_url" => "",
	"fm_email" => "",
	"fm_com_int" => "",
	"fm_com_int_eng" => "",
	"fm_svr_int" => "",
	"fm_svr_int_eng" => "",
	"fm_list_desc" => "",
	"fm_list_desc_eng" => "",
	"fm_svr_desc" => "",
	"fm_svr_desc_eng" => "",
	"fm_addr" => "",
	"fm_gps_addr" => "",
	"fm_gpsx" => "",
	"fm_gpsy" => "",
	"fm_img_com1_pc" => "",
	"fm_img_com1_mb" => "",
	"fm_img_com2_pc" => "",
	"fm_img_com2_mb" => "",
	"fm_img_com3_pc" => "",
	"fm_img_com3_mb" => "",
	"fm_img_com4_pc" => "",
	"fm_img_com4_mb" => "",
	"fm_img_list_pc" => "",
	"fm_img_list_mb" => "",
	"fm_img_ceo_pc" => "",
	"fm_img_ceo_mb" => "",
	"fm_ci_img_pc" => "",
	"fm_ci_img_mb" => "",
	"fm_logo_img_pc" => "",
	"fm_logo_img_mb" => "",
	"fm_read_cnt" => 0,
	"fm_ip" => "",
	"fm_ins_datetime" => "",
	"fm_proc_datetime" => "",
);


function get_tb_family_rq( $cmd = "p" ){
	global $rq_fm;

	$rq_fm['fm_idx'] = rqint("fm_idx", 0, $cmd);
	$rq_fm['fm_status'] = rqstr("fm_status", "H", $cmd);
	$rq_fm['fk_fm_am_userid'] = rqstr("fk_fm_am_userid", "", $cmd);
	$rq_fm['fm_wname'] = rqstr("fm_wname", "", $cmd);
	$rq_fm['fm_seq'] = rqint("fm_seq", 0, $cmd);
	$rq_fm['fk_fm_mct_idx'] = rqint("fk_fm_mct_idx", 0, $cmd);
	$rq_fm['fm_com'] = rqstr("fm_com", "", $cmd);
	$rq_fm['fm_com_eng'] = rqstr("fm_com_eng", "", $cmd);
	$rq_fm['fm_ceo'] = rqstr("fm_ceo", "", $cmd);
	$rq_fm['fm_service'] = rqstr("fm_service", "", $cmd);
	$rq_fm['fm_service_eng'] = rqstr("fm_service_eng", "", $cmd);
	$rq_fm['fm_home_url_type'] = rqstr("fm_home_url_type", "L", $cmd);	
	$rq_fm['fm_home_url'] = rqstr("fm_home_url", "", $cmd);
	$rq_fm['fm_brand_url_type'] = rqstr("fm_brand_url_type", "D", $cmd);
	$rq_fm['fm_brand_url'] = rqstr("fm_brand_url", "", $cmd);
	$rq_fm['fm_email'] = rqstr("fm_email", "", $cmd);
	$rq_fm['fm_com_int'] = rqstr("fm_com_int", "", $cmd);
	$rq_fm['fm_com_int_eng'] = rqstr("fm_com_int_eng", "", $cmd);
	$rq_fm['fm_svr_int'] = rqstr("fm_svr_int", "", $cmd);
	$rq_fm['fm_svr_int_eng'] = rqstr("fm_svr_int_eng", "", $cmd);
	$rq_fm['fm_list_desc'] = rqstr("fm_list_desc", "", $cmd);
	$rq_fm['fm_list_desc_eng'] = rqstr("fm_list_desc_eng", "", $cmd);
	$rq_fm['fm_svr_desc'] = rqstr("fm_svr_desc", "", $cmd);
	$rq_fm['fm_svr_desc_eng'] = rqstr("fm_svr_desc_eng", "", $cmd);
	$rq_fm['fm_addr'] = rqstr("fm_addr", "", $cmd);
	$rq_fm['fm_gps_addr'] = rqstr("fm_gps_addr", "", $cmd);
	$rq_fm['fm_gpsx'] = rqstr("fm_gpsx", "", $cmd);
	$rq_fm['fm_gpsy'] = rqstr("fm_gpsy", "", $cmd);
	$rq_fm['fm_img_com1_pc'] = rqstr("fm_img_com1_pc", "", $cmd);
	$rq_fm['db_fm_img_com1_pc'] = rqstr("db_fm_img_com1_pc", "", $cmd);
	$rq_fm['del_fm_img_com1_pc'] = rqstr("del_fm_img_com1_pc", "N", $cmd);
	$rq_fm['fm_img_com1_mb'] = rqstr("fm_img_com1_mb", "", $cmd);
	$rq_fm['db_fm_img_com1_mb'] = rqstr("db_fm_img_com1_mb", "", $cmd);
	$rq_fm['del_fm_img_com1_mb'] = rqstr("del_fm_img_com1_mb", "N", $cmd);
	$rq_fm['fm_img_com2_pc'] = rqstr("fm_img_com2_pc", "", $cmd);
	$rq_fm['db_fm_img_com2_pc'] = rqstr("db_fm_img_com2_pc", "", $cmd);
	$rq_fm['del_fm_img_com2_pc'] = rqstr("del_fm_img_com2_pc", "N", $cmd);
	$rq_fm['fm_img_com2_mb'] = rqstr("fm_img_com2_mb", "", $cmd);
	$rq_fm['db_fm_img_com2_mb'] = rqstr("db_fm_img_com2_mb", "", $cmd);
	$rq_fm['del_fm_img_com2_mb'] = rqstr("del_fm_img_com2_mb", "N", $cmd);
	$rq_fm['fm_img_com3_pc'] = rqstr("fm_img_com3_pc", "", $cmd);
	$rq_fm['db_fm_img_com3_pc'] = rqstr("db_fm_img_com3_pc", "", $cmd);
	$rq_fm['del_fm_img_com3_pc'] = rqstr("del_fm_img_com3_pc", "N", $cmd);
	$rq_fm['fm_img_com3_mb'] = rqstr("fm_img_com3_mb", "", $cmd);
	$rq_fm['db_fm_img_com3_mb'] = rqstr("db_fm_img_com3_mb", "", $cmd);
	$rq_fm['del_fm_img_com3_mb'] = rqstr("del_fm_img_com3_mb", "N", $cmd);
	$rq_fm['fm_img_com4_pc'] = rqstr("fm_img_com4_pc", "", $cmd);
	$rq_fm['db_fm_img_com4_pc'] = rqstr("db_fm_img_com4_pc", "", $cmd);
	$rq_fm['del_fm_img_com4_pc'] = rqstr("del_fm_img_com4_pc", "N", $cmd);
	$rq_fm['fm_img_com4_mb'] = rqstr("fm_img_com4_mb", "", $cmd);
	$rq_fm['db_fm_img_com4_mb'] = rqstr("db_fm_img_com4_mb", "", $cmd);
	$rq_fm['del_fm_img_com4_mb'] = rqstr("del_fm_img_com4_mb", "N", $cmd);
	$rq_fm['fm_img_list_pc'] = rqstr("fm_img_list_pc", "", $cmd);
	$rq_fm['db_fm_img_list_pc'] = rqstr("db_fm_img_list_pc", "", $cmd);
	$rq_fm['del_fm_img_list_pc'] = rqstr("del_fm_img_list_pc", "N", $cmd);
	$rq_fm['fm_img_list_mb'] = rqstr("fm_img_list_mb", "", $cmd);
	$rq_fm['db_fm_img_list_mb'] = rqstr("db_fm_img_list_mb", "", $cmd);
	$rq_fm['del_fm_img_list_mb'] = rqstr("del_fm_img_list_mb", "N", $cmd);
	$rq_fm['fm_img_ceo_pc'] = rqstr("fm_img_ceo_pc", "", $cmd);
	$rq_fm['db_fm_img_ceo_pc'] = rqstr("db_fm_img_ceo_pc", "", $cmd);
	$rq_fm['del_fm_img_ceo_pc'] = rqstr("del_fm_img_ceo_pc", "N", $cmd);
	$rq_fm['fm_img_ceo_mb'] = rqstr("fm_img_ceo_mb", "", $cmd);
	$rq_fm['db_fm_img_ceo_mb'] = rqstr("db_fm_img_ceo_mb", "", $cmd);
	$rq_fm['del_fm_img_ceo_mb'] = rqstr("del_fm_img_ceo_mb", "N", $cmd);
	$rq_fm['fm_ci_img_pc'] = rqstr("fm_ci_img_pc", "", $cmd);
	$rq_fm['db_fm_ci_img_pc'] = rqstr("db_fm_ci_img_pc", "", $cmd);
	$rq_fm['del_fm_ci_img_pc'] = rqstr("del_fm_ci_img_pc", "N", $cmd);
	$rq_fm['fm_ci_img_mb'] = rqstr("fm_ci_img_mb", "", $cmd);
	$rq_fm['db_fm_ci_img_mb'] = rqstr("db_fm_ci_img_mb", "", $cmd);
	$rq_fm['del_fm_ci_img_mb'] = rqstr("del_fm_ci_img_mb", "N", $cmd);
	$rq_fm['fm_logo_img_pc'] = rqstr("fm_logo_img_pc", "", $cmd);
	$rq_fm['db_fm_logo_img_pc'] = rqstr("db_fm_logo_img_pc", "", $cmd);
	$rq_fm['del_fm_logo_img_pc'] = rqstr("del_fm_logo_img_pc", "N", $cmd);
	$rq_fm['fm_logo_img_mb'] = rqstr("fm_logo_img_mb", "", $cmd);
	$rq_fm['db_fm_logo_img_mb'] = rqstr("db_fm_logo_img_mb", "", $cmd);
	$rq_fm['del_fm_logo_img_mb'] = rqstr("del_fm_logo_img_mb", "N", $cmd);
	$rq_fm['fm_read_cnt'] = rqint("fm_read_cnt", 0, $cmd);
	$rq_fm['fm_ip'] = host_ip();
	$rq_fm['fm_ins_datetime'] = rqstr("fm_ins_datetime", "", $cmd);
	$rq_fm['fm_proc_datetime'] = rqstr("fm_proc_datetime", "", $cmd);
}


function get_tb_family_info_001( $rq_fm_idx = 0){
	global $db_fm;

	$result_cmd = false;
	if(!eqyn($rq_fm_idx, 0)){
		$sql = "select * from tb_family where fm_idx = $rq_fm_idx";
//		echo $sql;
		$row = sql_fetch($sql);
		if($row){
			$db_fm[result_cmd] = "YESDATA";
			$db_fm['fm_idx'] = $row["fm_idx"];
			$db_fm['fm_status'] = $row["fm_status"];
			$db_fm['fk_fm_am_userid'] = $row["fk_fm_am_userid"];
			$db_fm['fm_wname'] = $row["fm_wname"];
			$db_fm['fm_seq'] = $row["fm_seq"];
			$db_fm['fk_fm_mct_idx'] = $row["fk_fm_mct_idx"];
			$db_fm['fm_com'] = $row["fm_com"];
			$db_fm['fm_com_eng'] = $row["fm_com_eng"];
			$db_fm['fm_ceo'] = $row["fm_ceo"];
			$db_fm['fm_service'] = $row["fm_service"];
			$db_fm['fm_service_eng'] = $row["fm_service_eng"];
			$db_fm['fm_home_url_type'] = $row["fm_home_url_type"];			
			$db_fm['fm_home_url'] = $row["fm_home_url"];
			$db_fm['fm_brand_url_type'] = $row["fm_brand_url_type"];			
			$db_fm['fm_brand_url'] = $row["fm_brand_url"];
			$db_fm['fm_email'] = $row["fm_email"];
			$db_fm['fm_com_int'] = $row["fm_com_int"];
			$db_fm['fm_com_int_eng'] = $row["fm_com_int_eng"];
			$db_fm['fm_svr_int'] = $row["fm_svr_int"];
			$db_fm['fm_svr_int_eng'] = $row["fm_svr_int_eng"];
			$db_fm['fm_list_desc'] = $row["fm_list_desc"];
			$db_fm['fm_list_desc_eng'] = $row["fm_list_desc_eng"];
			$db_fm['fm_svr_desc'] = $row["fm_svr_desc"];
			$db_fm['fm_svr_desc_eng'] = $row["fm_svr_desc_eng"];
			$db_fm['fm_addr'] = $row["fm_addr"];
			$db_fm['fm_gps_addr'] = $row["fm_gps_addr"];
			$db_fm['fm_gpsx'] = $row["fm_gpsx"];
			$db_fm['fm_gpsy'] = $row["fm_gpsy"];
			$db_fm['fm_img_com1_pc'] = $row["fm_img_com1_pc"];
			$db_fm['fm_img_com1_mb'] = $row["fm_img_com1_mb"];
			$db_fm['fm_img_com2_pc'] = $row["fm_img_com2_pc"];
			$db_fm['fm_img_com2_mb'] = $row["fm_img_com2_mb"];
			$db_fm['fm_img_com3_pc'] = $row["fm_img_com3_pc"];
			$db_fm['fm_img_com3_mb'] = $row["fm_img_com3_mb"];
			$db_fm['fm_img_com4_pc'] = $row["fm_img_com4_pc"];
			$db_fm['fm_img_com4_mb'] = $row["fm_img_com4_mb"];
			$db_fm['fm_img_list_pc'] = $row["fm_img_list_pc"];
			$db_fm['fm_img_list_mb'] = $row["fm_img_list_mb"];
			$db_fm['fm_img_ceo_pc'] = $row["fm_img_ceo_pc"];
			$db_fm['fm_img_ceo_mb'] = $row["fm_img_ceo_mb"];
			$db_fm['fm_ci_img_pc'] = $row["fm_ci_img_pc"];
			$db_fm['fm_ci_img_mb'] = $row["fm_ci_img_mb"];
			$db_fm['fm_logo_img_pc'] = $row["fm_logo_img_pc"];
			$db_fm['fm_logo_img_mb'] = $row["fm_logo_img_mb"];
			$db_fm['fm_read_cnt'] = $row["fm_read_cnt"];
			$db_fm['fm_ip'] = $row["fm_ip"];
			$db_fm['fm_ins_datetime'] = $row["fm_ins_datetime"];
			$db_fm['fm_proc_datetime'] = $row["fm_proc_datetime"];

		}else{
			$db_fm[result_cmd] = "NODATA";
		}

	}else{
		$db_fm[result_cmd] = "NODATA";
	}
}


function set_tb_family_read_cnt_proc_001( $idx = 0 ){
	$sql = "
		update tb_family set
			fm_read_cnt = fm_read_cnt + 1
		where fm_idx = $idx
	";
//	echo $sql;
	sql_query($sql);
}


function set_tb_family_proc_001( $cmd = "", $rq_fm ){
	if(eqyn($cmd, "ins")){
		$sql = "
			insert into tb_family(
				fm_status
				,fk_fm_am_userid
				,fm_wname
				,fm_seq
				,fk_fm_mct_idx
				,fm_com
				,fm_com_eng
				,fm_ceo
				,fm_service
				,fm_service_eng
				,fm_home_url_type
				,fm_home_url
				,fm_brand_url_type
				,fm_brand_url
				,fm_email
				,fm_com_int
				,fm_com_int_eng
				,fm_svr_int
				,fm_svr_int_eng
				,fm_list_desc
				,fm_list_desc_eng
				,fm_svr_desc
				,fm_svr_desc_eng
				,fm_addr
				,fm_gps_addr
				,fm_gpsx
				,fm_gpsy
				,fm_img_com1_pc
				,fm_img_com1_mb
				,fm_img_com2_pc
				,fm_img_com2_mb
				,fm_img_com3_pc
				,fm_img_com3_mb
				,fm_img_com4_pc
				,fm_img_com4_mb
				,fm_img_list_pc
				,fm_img_list_mb
				,fm_img_ceo_pc
				,fm_img_ceo_mb
				,fm_ci_img_pc
				,fm_ci_img_mb
				,fm_logo_img_pc
				,fm_logo_img_mb
				,fm_read_cnt
				,fm_ip
				,fm_ins_datetime
				,fm_proc_datetime

			) values (
				'$rq_fm[fm_status]'
				,'$rq_fm[fk_fm_am_userid]'
				,'$rq_fm[fm_wname]'
				,$rq_fm[fm_seq]
				,$rq_fm[fk_fm_mct_idx]
				,'$rq_fm[fm_com]'
				,'$rq_fm[fm_com_eng]'
				,'$rq_fm[fm_ceo]'
				,'$rq_fm[fm_service]'
				,'$rq_fm[fm_service_eng]'
				,'$rq_fm[fm_home_url_type]'				
				,'$rq_fm[fm_home_url]'
				,'$rq_fm[fm_brand_url_type]'				
				,'$rq_fm[fm_brand_url]'
				,'$rq_fm[fm_email]'
				,'$rq_fm[fm_com_int]'
				,'$rq_fm[fm_com_int_eng]'
				,'$rq_fm[fm_svr_int]'
				,'$rq_fm[fm_svr_int_eng]'
				,'$rq_fm[fm_list_desc]'
				,'$rq_fm[fm_list_desc_eng]'
				,'$rq_fm[fm_svr_desc]'
				,'$rq_fm[fm_svr_desc_eng]'
				,'$rq_fm[fm_addr]'
				,'$rq_fm[fm_gps_addr]'
				,'$rq_fm[fm_gpsx]'
				,'$rq_fm[fm_gpsy]'
				,'$rq_fm[fm_img_com1_pc]'
				,'$rq_fm[fm_img_com1_mb]'
				,'$rq_fm[fm_img_com2_pc]'
				,'$rq_fm[fm_img_com2_mb]'
				,'$rq_fm[fm_img_com3_pc]'
				,'$rq_fm[fm_img_com3_mb]'
				,'$rq_fm[fm_img_com4_pc]'
				,'$rq_fm[fm_img_com4_mb]'
				,'$rq_fm[fm_img_list_pc]'
				,'$rq_fm[fm_img_list_mb]'
				,'$rq_fm[fm_img_ceo_pc]'
				,'$rq_fm[fm_img_ceo_mb]'
				,'$rq_fm[fm_ci_img_pc]'
				,'$rq_fm[fm_ci_img_mb]'
				,'$rq_fm[fm_logo_img_pc]'
				,'$rq_fm[fm_logo_img_mb]'
				,$rq_fm[fm_read_cnt]
				,'$rq_fm[fm_ip]'
				,now()
				,now()

			);
		";

	}else if(eqyn($cmd, "upt")){
		$sql = "
			update tb_family set
				fm_status = '$rq_fm[fm_status]'
				,fk_fm_am_userid = '$rq_fm[fk_fm_am_userid]'
				,fm_wname = '$rq_fm[fm_wname]'
				,fm_seq = $rq_fm[fm_seq]
				,fk_fm_mct_idx = $rq_fm[fk_fm_mct_idx]
				,fm_com = '$rq_fm[fm_com]'
				,fm_com_eng = '$rq_fm[fm_com_eng]'
				,fm_ceo = '$rq_fm[fm_ceo]'
				,fm_service = '$rq_fm[fm_service]'
				,fm_service_eng = '$rq_fm[fm_service_eng]'
				,fm_home_url_type = '$rq_fm[fm_home_url_type]'
				,fm_home_url = '$rq_fm[fm_home_url]'
				,fm_brand_url_type = '$rq_fm[fm_brand_url_type]'				
				,fm_brand_url = '$rq_fm[fm_brand_url]'
				,fm_email = '$rq_fm[fm_email]'
				,fm_com_int = '$rq_fm[fm_com_int]'
				,fm_com_int_eng = '$rq_fm[fm_com_int_eng]'
				,fm_svr_int = '$rq_fm[fm_svr_int]'
				,fm_svr_int_eng = '$rq_fm[fm_svr_int_eng]'
				,fm_list_desc = '$rq_fm[fm_list_desc]'
				,fm_list_desc_eng = '$rq_fm[fm_list_desc_eng]'
				,fm_svr_desc = '$rq_fm[fm_svr_desc]'
				,fm_svr_desc_eng = '$rq_fm[fm_svr_desc_eng]'
				,fm_addr = '$rq_fm[fm_addr]'
				,fm_gps_addr = '$rq_fm[fm_gps_addr]'
				,fm_gpsx = '$rq_fm[fm_gpsx]'
				,fm_gpsy = '$rq_fm[fm_gpsy]'
				,fm_img_com1_pc = '$rq_fm[fm_img_com1_pc]'
				,fm_img_com1_mb = '$rq_fm[fm_img_com1_mb]'
				,fm_img_com2_pc = '$rq_fm[fm_img_com2_pc]'
				,fm_img_com2_mb = '$rq_fm[fm_img_com2_mb]'
				,fm_img_com3_pc = '$rq_fm[fm_img_com3_pc]'
				,fm_img_com3_mb = '$rq_fm[fm_img_com3_mb]'
				,fm_img_com4_pc = '$rq_fm[fm_img_com4_pc]'
				,fm_img_com4_mb = '$rq_fm[fm_img_com4_mb]'
				,fm_img_list_pc = '$rq_fm[fm_img_list_pc]'
				,fm_img_list_mb = '$rq_fm[fm_img_list_mb]'
				,fm_img_ceo_pc = '$rq_fm[fm_img_ceo_pc]'
				,fm_img_ceo_mb = '$rq_fm[fm_img_ceo_mb]'
				,fm_ci_img_pc = '$rq_fm[fm_ci_img_pc]'
				,fm_ci_img_mb = '$rq_fm[fm_ci_img_mb]'
				,fm_logo_img_pc = '$rq_fm[fm_logo_img_pc]'
				,fm_logo_img_mb = '$rq_fm[fm_logo_img_mb]'
				,fm_ip = '$rq_fm[fm_ip]'
				,fm_proc_datetime = now()

			where fm_idx = $rq_fm[fm_idx];
		";

	}else if(eqyn($cmd, "del")){
		$sql = "
			update tb_family set
				fm_status = 'D'
				,fm_ip = '$rq_fm[fm_ip]'
				,fm_proc_datetime = now()

			where fm_idx = $rq_fm[fm_idx]
		";

	}else{
		$sql = "";
	}

	if(eqyn($sql, "")){
		return false;
	}else{
//		echo "$sql<br>";
		return sql_query($sql);
	}
}



function set_tb_family_seq_proc_001( $cmd, $rq_fm_idx, $rq_fm_seq ){
	if(eqyn($cmd, "up")){
		$sql = "
			update tb_family 
				set fm_seq = fm_seq + 1
			where fm_status !='D'
				and fm_seq >= $rq_fm_seq
		";

	}else if(eqyn($cmd, "down")){
		$sql = "
			update tb_family 
				set fm_seq = fm_seq - 1
			where fm_status !='D'
				and fm_seq <= $rq_fm_seq
		";
	}


	if(eqyn($cmd, "up") || eqyn($cmd, "down")){
//		echo "$sql<br>";
		$db_result = sql_query($sql);

		$sql = "
			update tb_family 
				set fm_seq = $rq_fm_seq
			where fm_idx = $rq_fm_idx
		";
		$db_result = sql_query($sql);
	}


	if(get_db_proc_status()){
		$db_result = true;
		$sql = " select fm_idx from tb_family where fm_status !='D' order by fm_seq asc, fm_idx desc ";
		$rs = get_result($sql);
		$num = 0;
		while($row = mysql_fetch_array($rs)){
			$num++;
			$sql = "update tb_family set fm_seq=$num where fm_idx=". $row[fm_idx];
//			echo $sql."<br>";
			if(!sql_query($sql)){
				$db_result = sql_query($sql);
				break;
			}

		}
	}

	return $db_result;
}
?>
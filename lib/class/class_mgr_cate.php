<?
$ser_mct_cate = rqstr("ser_mct_cate", "", "g");

$arr_mct_cate = array( "FM" => "Family", "IS" => "Insight", "NW" => "News");

$rq_mct = array(
	"mct_idx" => 0,
	"mct_status" => "Y",
	"fk_mct_am_userid" => "",
	"mct_seq" => 0,
	"mct_cate" => "",
	"mct_name" => "",
	"mct_name_eng" => "",
	"mct_ip" => "",
	"mct_ins_datetime" => "",
	"mct_proc_datetime" => "",
);


$db_mct = array(
	"result_cmd" => "",
	"mct_idx" => 0,
	"mct_status" => "Y",
	"fk_mct_am_userid" => "",
	"mct_seq" => 0,
	"mct_cate" => "",
	"mct_name" => "",
	"mct_name_eng" => "",
	"mct_ip" => "",
	"mct_ins_datetime" => "",
	"mct_proc_datetime" => "",
);


function get_tb_mgr_cate_rq( $cmd = "p" ){
	global $rq_mct;

	$rq_mct['mct_idx'] = rqint("mct_idx", 0, $cmd);
	$rq_mct['mct_status'] = rqstr("mct_status", "Y", $cmd);
	$rq_mct['fk_mct_am_userid'] = rqstr("fk_mct_am_userid", "", $cmd);
	$rq_mct['mct_seq'] = rqint("mct_seq", 0, $cmd);
	$rq_mct['mct_cate'] = rqstr("mct_cate", "", $cmd);
	$rq_mct['mct_name'] = rqstr("mct_name", "", $cmd);
	$rq_mct['mct_name_eng'] = rqstr("mct_name_eng", "", $cmd);
	$rq_mct['mct_ip'] = host_ip();
	$rq_mct['mct_ins_datetime'] = rqstr("mct_ins_datetime", "", $cmd);
	$rq_mct['mct_proc_datetime'] = rqstr("mct_proc_datetime", "", $cmd);
}


function get_tb_mgr_cate_info_001( $rq_mct_idx = 0){
	global $db_mct;

	$result_cmd = false;
	if(!eqyn($rq_mct_idx, 0)){
		$sql = "select * from tb_mgr_cate where mct_idx=$rq_mct_idx";
//		echo $sql;
		$row = sql_fetch($sql);
		if($row){
			$db_mct[result_cmd] = "YESDATA";
			$db_mct['mct_idx'] = $row["mct_idx"];
			$db_mct['mct_status'] = $row["mct_status"];
			$db_mct['fk_mct_am_userid'] = $row["fk_mct_am_userid"];
			$db_mct['mct_seq'] = $row["mct_seq"];
			$db_mct['mct_cate'] = $row["mct_cate"];
			$db_mct['mct_name'] = $row["mct_name"];
			$db_mct['mct_name_eng'] = $row["mct_name_eng"];
			$db_mct['mct_ip'] = $row["mct_ip"];
			$db_mct['mct_ins_datetime'] = $row["mct_ins_datetime"];
			$db_mct['mct_proc_datetime'] = $row["mct_proc_datetime"];
		}else{
			$db_mct[result_cmd] = "NODATA";
		}

	}else{
		$db_mct[result_cmd] = "NODATA";
	}
}


function set_tb_mgr_cate_proc_001( $cmd = "", $rq_mct ){
	if(eqyn($cmd, "ins")){
		$sql = "
			insert into tb_mgr_cate(
				mct_status
				,fk_mct_am_userid
				,mct_seq
				,mct_cate
				,mct_name
				,mct_name_eng
				,mct_ip
				,mct_ins_datetime
				,mct_proc_datetime

			) values (
				'$rq_mct[mct_status]'
				,'$rq_mct[fk_mct_am_userid]'
				,$rq_mct[mct_seq]
				,'$rq_mct[mct_cate]'
				,'$rq_mct[mct_name]'
				,'$rq_mct[mct_name_eng]'
				,'$rq_mct[mct_ip]'
				,now()
				,now()

			);
		";

	}else if(eqyn($cmd, "upt")){
		$sql = "
			update tb_mgr_cate set
				mct_status = '$rq_mct[mct_status]'
				,fk_mct_am_userid = '$rq_mct[fk_mct_am_userid]'
				,mct_cate = '$rq_mct[mct_cate]'
				,mct_name = '$rq_mct[mct_name]'
				,mct_name_eng = '$rq_mct[mct_name_eng]'
				,mct_ip = '$rq_mct[mct_ip]'
				,mct_proc_datetime = now()

			where mct_idx = $rq_mct[mct_idx];
		";

	}else if(eqyn($cmd, "del")){
		$sql = "
			update tb_mgr_cate set
				mct_status = 'D'
				,mct_ip = '$rq_mct[mct_ip]'
				,mct_proc_datetime = now()

			where mct_idx = $rq_mct[mct_idx]
		";

	}else{
		$sql = "";
	}

	if(eqyn($sql, "")){
		return false;
	}else{
//		echo $sql;
		return sql_query($sql);
	}
}


function get_tb_mgr_cate_list_001($rq_mct_cate = "",  $fild = "*", $data_type = "rs" ){
	$sql = "
		select $fild from tb_mgr_cate
		where mct_cate = '". $rq_mct_cate ."'
			and mct_status = 'Y'
		order by mct_idx asc
	";
//	echo $sql;
	if(eqyn($data_type, "array")){
		$rs = sql_array( $sql );
	}else{
		$rs = get_result( $sql );
	}
	return $rs;
}
?>
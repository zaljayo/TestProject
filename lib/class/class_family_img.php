<?


$rq_fmi = array(
	"fmi_idx" => 0,
	"fmi_status" => "Y",
	"fk_fmi_fm_idx" => 0,
	"fmi_img_desc" => "",
	"db_fmi_img_desc" => "",
	"del_fmi_img_desc" => "N",
	"fmi_img_pc" => "",
	"db_fmi_img_pc" => "",
	"del_fmi_img_pc" => "N",
	"fmi_img_mb" => "",
	"db_fmi_img_mb" => "",
	"del_fmi_img_mb" => "N",
);


$db_fmi = array(
	"result_cmd" => "",
	"fmi_idx" => 0,
	"fmi_status" => "Y",
	"fk_fmi_fm_idx" => 0,
	"fmi_img_desc" => "",
	"fmi_img_pc" => "",
	"fmi_img_mb" => "",
);


function get_tb_family_img_rq( $cmd = "p" ){
	global $rq_fmi;

	$rq_fmi['fmi_idx'] = rqint("fmi_idx", 0, $cmd);
	$rq_fmi['fmi_status'] = rqstr("fmi_status", "Y", $cmd);
	$rq_fmi['fk_fmi_fm_idx'] = rqint("fk_fmi_fm_idx", 0, $cmd);
	$rq_fmi['fmi_img_desc'] = rqstr("fmi_img_desc", "", $cmd);
	$rq_fmi['db_fmi_img_desc'] = rqstr("db_fmi_img_desc", "", $cmd);
	$rq_fmi['del_fmi_img_desc'] = rqstr("del_fmi_img_desc", "N", $cmd);
	$rq_fmi['fmi_img_pc'] = rqstr("fmi_img_pc", "", $cmd);
	$rq_fmi['db_fmi_img_pc'] = rqstr("db_fmi_img_pc", "", $cmd);
	$rq_fmi['del_fmi_img_pc'] = rqstr("del_fmi_img_pc", "N", $cmd);
	$rq_fmi['fmi_img_mb'] = rqstr("fmi_img_mb", "", $cmd);
	$rq_fmi['db_fmi_img_mb'] = rqstr("db_fmi_img_mb", "", $cmd);
	$rq_fmi['del_fmi_img_mb'] = rqstr("del_fmi_img_mb", "N", $cmd);
}


function get_tb_family_img_info_001( $rq_fmi_idx = 0){
	global $db_fmi;

	$result_cmd = false;
	if(!eqyn($rq_fmi_idx, 0)){
		$sql = "select * from tb_family_img where fmi_idx = $rq_fmi_idx";
//		echo $sql;
		$row = sql_fetch($sql);
		if($row){
			$db_fmi[result_cmd] = "YESDATA";
			$db_fmi['fmi_idx'] = $row["fmi_idx"];
			$db_fmi['fmi_status'] = $row["fmi_status"];
			$db_fmi['fk_fmi_fm_idx'] = $row["fk_fmi_fm_idx"];
			$db_fmi['fmi_img_desc'] = $row["fmi_img_desc"];
			$db_fmi['fmi_img_pc'] = $row["fmi_img_pc"];
			$db_fmi['fmi_img_mb'] = $row["fmi_img_mb"];
		}else{
			$db_fmi[result_cmd] = "NODATA";
		}

	}else{
		$db_fmi[result_cmd] = "NODATA";
	}
}


function set_tb_family_img_proc_001( $cmd = "", $rq_fmi ){
	if(eqyn($cmd, "ins")){
		$sql = "
			insert into tb_family_img(
				fmi_status
				,fk_fmi_fm_idx
				,fmi_img_desc
				,fmi_img_pc
				,fmi_img_mb

			) values (
				'$rq_fmi[fmi_status]'
				,$rq_fmi[fk_fmi_fm_idx]
				,'$rq_fmi[fmi_img_desc]'
				,'$rq_fmi[fmi_img_pc]'
				,'$rq_fmi[fmi_img_mb]'

			);
		";

	}else if(eqyn($cmd, "upt")){
		$sql = "
			update tb_family_img set
				fmi_status = '$rq_fmi[fmi_status]'
				,fk_fmi_fm_idx = $rq_fmi[fk_fmi_fm_idx]
				,fmi_img_desc = '$rq_fmi[fmi_img_desc]'
				,fmi_img_pc = '$rq_fmi[fmi_img_pc]'
				,fmi_img_mb = '$rq_fmi[fmi_img_mb]'

			where fmi_idx = $rq_fmi[fmi_idx];
		";

	}else if(eqyn($cmd, "del")){
		$sql = "
			update tb_family_img set
				fmi_status = 'D'

			where fmi_idx = $rq_fmi[fmi_idx]
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

function get_tb_family_img_list_001( $rq_fm_idx ){
	$sql = "
		select
			*
		from tb_family_img
		where fk_fmi_fm_idx = $rq_fm_idx
			and fmi_status = 'Y'
		order by fmi_idx asc 
	";
	$rs = sql_array($sql);
	return $rs;
}
?>
<?

$rq_amm = array(
	"amm_idx" => 0,
	"amm_status" => "Y",
	"amm_key" => "",
	"fk_amm_amm_key" => "",
	"amm_seq" => 0,
	"amm_name" => "",
	"amm_fname" => "",
	"amm_link" => "",
);


$db_amm = array(
	"result_cmd" => "",
	"amm_idx" => 0,
	"amm_status" => "Y",
	"amm_key" => "",
	"fk_amm_amm_key" => "",
	"amm_seq" => 0,
	"amm_name" => "",
	"amm_fname" => "",
	"amm_link" => "",
);


function get_tb_admin_memu_rq( $cmd = "p" ){
	global $rq_amm;

	$rq_amm['amm_idx'] = rqint("amm_idx", 0, $cmd);
	$rq_amm['amm_status'] = rqstr("amm_status", "Y", $cmd);
	$rq_amm['amm_key'] = rqstr("amm_key", "", $cmd);
	$rq_amm['fk_amm_amm_key'] = rqstr("fk_amm_amm_key", "", $cmd);
	$rq_amm['amm_seq'] = rqint("amm_seq", 0, $cmd);
	$rq_amm['amm_name'] = rqstr("amm_name", "", $cmd);
	$rq_amm['amm_fname'] = rqstr("amm_fname", "", $cmd);
	$rq_amm['amm_link'] = rqstr("amm_link", "", $cmd);
}


function get_tb_admin_memu_info_001( $rq_amm_idx = 0){
	global $db_amm;

	$result_cmd = false;
	if($rq_amm_idx != 0 ){
		$sql = "select * from tb_admin_memu where amm_idx=$rq_amm_idx";
//		echo $sql;
		$row = sql_fetch($sql);
		if($row){
			$db_mb[result_cmd] = "YESDATA";
			$db_amm['amm_idx'] = $row["amm_idx"];
			$db_amm['amm_status'] = $row["amm_status"];
			$db_amm['amm_key'] = $row["amm_key"];
			$db_amm['fk_amm_amm_key'] = $row["fk_amm_amm_key"];
			$db_amm['amm_seq'] = $row["amm_seq"];
			$db_amm['amm_name'] = $row["amm_name"];
			$db_amm['amm_fname'] = $row["amm_fname"];
			$db_amm['amm_link'] = $row["amm_link"];
		}else{
			$db_mb[result_cmd] = "NODATA";
		}

	}else{
		$db_mb[result_cmd] = "NODATA";
	}
}


function set_tb_admin_memu_proc_001( $cmd = "", $rq_amm ){
	if(eqyn($cmd, "ins")){
		$sql = "
			insert into tb_admin_memu(
				amm_status
				,amm_key
				,fk_amm_amm_key
				,amm_seq
				,amm_name
				,amm_fname
				,amm_link

			) values (
				'$rq_amm[amm_status]'
				,'$rq_amm[amm_key]'
				,'$rq_amm[fk_amm_amm_key]'
				,$rq_amm[amm_seq]
				,'$rq_amm[amm_name]'
				,'$rq_amm[amm_fname]'
				,'$rq_amm[amm_link]'

			);
		";

	}else if(eqyn($cmd, "upt")){
		$sql = "
			update tb_admin_memu set
				amm_status = '$rq_amm[amm_status]'
				,amm_key = '$rq_amm[amm_key]'
				,fk_amm_amm_key = '$rq_amm[fk_amm_amm_key]'
				,amm_seq =$rq_amm[amm_seq]
				,amm_name = '$rq_amm[amm_name]'
				,amm_fname = '$rq_amm[amm_fname]'
				,amm_link = '$rq_amm[amm_link]'

			where amm_idx = $rq_amm[amm_idx];
		";

	}else if(eqyn($cmd, "del")){
		$sql = "
			update tb_admin_memu set
				amm_status = 'D'

			where amm_idx = $rq_amm[amm_idx]
		";

	}else{
		$sql = "";
	}

	if(eqyn($sql, "")){
		return false;
	}else{
		return sql_query($sql);
	}
}
?>
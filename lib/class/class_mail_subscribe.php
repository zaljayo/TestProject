<?

$rq_msr = array(
	"msr_idx" => 0,
	"msr_email" => "",
	"msr_ip" => "",
	"msr_ins_datetime" => "",
);


$db_msr = array(
	"result_cmd" => "",
	"msr_idx" => 0,
	"msr_email" => "",
	"msr_ip" => "",
	"msr_ins_datetime" => "",
);


function get_tb_mail_subscribe_rq( $cmd = "p" ){
	global $rq_msr;

	$rq_msr['msr_idx'] = rqint("msr_idx", 0, $cmd);
	$rq_msr['msr_email'] = rqstr("msr_email", "", $cmd);
	$rq_msr['msr_ip'] = host_ip();
	$rq_msr['msr_ins_datetime'] = rqstr("msr_ins_datetime", "", $cmd);
}


function get_tb_mail_subscribe_info_001( $rq_msr_idx = 0){
	global $db_msr;

	$result_cmd = false;
	if(!eqyn($rq_msr_idx, 0)){
		$sql = "select * from tb_mail_subscribe where msr_idx = $rq_msr_idx";
//		echo $sql;
		$row = sql_fetch($sql);
		if($row){
			$db_msr[result_cmd] = "YESDATA";
			$db_msr['msr_idx'] = $row["msr_idx"];
			$db_msr['msr_email'] = $row["msr_email"];
			$db_msr['msr_ip'] = $row["msr_ip"];
			$db_msr['msr_ins_datetime'] = $row["msr_ins_datetime"];
		}else{
			$db_msr[result_cmd] = "NODATA";
		}

	}else{
		$db_msr[result_cmd] = "NODATA";
	}
}


function set_tb_mail_subscribe_proc_001( $cmd = "", $rq_msr ){
	if(eqyn($cmd, "ins")){

		$table = "tb_mail_subscribe";
		$query = " and msr_email = '$rq_msr[msr_email]' ";
		if(sql_count($table, $query) == 0){
			$sql = "
				insert into tb_mail_subscribe(
					msr_email
					,msr_ip
					,msr_ins_datetime

				) values (
					'$rq_msr[msr_email]'
					,'$rq_msr[msr_ip]'
					,now()

				);
			";
		}

	}else if(eqyn($cmd, "upt")){
		$sql = "
			update tb_mail_subscribe set
				msr_email = '$rq_msr[msr_email]'
				,msr_ip = '$rq_msr[msr_ip]'
				,msr_ins_datetime = now()

			where msr_idx = $rq_msr[msr_idx];
		";

	}else if(eqyn($cmd, "del")){
		$sql = "
			delete from tb_mail_subscribe
			where msr_idx = $rq_msr[msr_idx]
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
?>
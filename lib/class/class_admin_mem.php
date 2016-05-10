<?
$ser_am_status = rqstr("ser_am_status", "", "g");
$ser_am_kind = rqstr("ser_am_kind", "", "g");


$arr_am_status = array(
	"Y" => "이용중",
	"S" => "이용중지"
);

$arr_am_kind = array(
	"A" => "슈퍼마스터",
	"M" => "마스터"
);




$rq_am = array(
	"am_idx" => 0,
	"am_status" => "Y",
	"am_kind" => "",
	"am_userid" => "",
	"am_pwd" => "",
	"am_name" => "",
	"am_email" => "",
	"am_tel" => "",
	"am_hp" => "",
	"am_memo" => "",
	"am_ins_datetime" => "",
	"am_upt_datetime" => "",
);


$db_am = array(
	"result_cmd" => "",
	"am_idx" => 0,
	"am_status" => "Y",
	"am_kind" => "",
	"am_userid" => "",
	"am_pwd" => "",
	"am_name" => "",
	"am_email" => "",
	"am_tel" => "",
	"am_hp" => "",
	"am_memo" => "",
	"am_ins_datetime" => "",
	"am_upt_datetime" => "",
);


function get_tb_admin_mem_rq( $cmd = "p" ){
	global $rq_am;

	$rq_am['am_idx'] = rqint("am_idx", 0, $cmd);
	$rq_am['am_status'] = rqstr("am_status", "Y", $cmd);
	$rq_am['am_kind'] = rqstr("am_kind", "", $cmd);
	$rq_am['am_userid'] = rqstr("am_userid", "", $cmd);
	$rq_am['am_pwd'] = rqstr("am_pwd", "", $cmd);
	$rq_am['am_name'] = rqstr("am_name", "", $cmd);
	$rq_am['am_email'] = rqstr("am_email", "", $cmd);
	$rq_am['am_tel'] = rqstr("am_tel", "", $cmd);
	$rq_am['am_hp'] = rqstr("am_hp", "", $cmd);
	$rq_am['am_memo'] = rqstr("am_memo", "", $cmd);
	$rq_am['am_ins_datetime'] = rqstr("am_ins_datetime", "", $cmd);
	$rq_am['am_upt_datetime'] = rqstr("am_upt_datetime", "", $cmd);
}


function get_tb_admin_mem_info_001( $rq_am_userid = ""){
	global $db_am;

	$result_cmd = false;
	if(!eqyn($rq_am_userid, "")){
		$sql = "select * from tb_admin_mem where am_userid = '$rq_am_userid'";
//		echo $sql;
		$row = sql_fetch($sql);
		if($row){
			$db_am[result_cmd] = "YESDATA";
			$db_am['am_idx'] = $row["am_idx"];
			$db_am['am_status'] = $row["am_status"];
			$db_am['am_kind'] = $row["am_kind"];
			$db_am['am_userid'] = $row["am_userid"];
			$db_am['am_pwd'] = $row["am_pwd"];
			$db_am['am_name'] = $row["am_name"];
			$db_am['am_email'] = $row["am_email"];
			$db_am['am_tel'] = $row["am_tel"];
			$db_am['am_hp'] = $row["am_hp"];
			$db_am['am_memo'] = $row["am_memo"];
			$db_am['am_ins_datetime'] = $row["am_ins_datetime"];
			$db_am['am_upt_datetime'] = $row["am_upt_datetime"];
		}else{
			$db_am[result_cmd] = "NODATA";
		}

	}else{
		$db_am[result_cmd] = "NODATA";
	}
}


function set_tb_admin_mem_proc_001( $cmd = "", $rq_am ){
	if(eqyn($cmd, "ins")){
		$sql = "
			insert into tb_admin_mem(
				am_status
				,am_kind
				,am_userid
				,am_pwd
				,am_name
				,am_email
				,am_tel
				,am_hp
				,am_memo
				,am_ins_datetime
				,am_upt_datetime

			) values (
				'$rq_am[am_status]'
				,'$rq_am[am_kind]'
				,'$rq_am[am_userid]'
				,'$rq_am[am_pwd]'
				,'$rq_am[am_name]'
				,'$rq_am[am_email]'
				,'$rq_am[am_tel]'
				,'$rq_am[am_hp]'
				,'$rq_am[am_memo]'
				,now()
				,now()

			);
		";

	}else if(eqyn($cmd, "upt")){
		$upt_sql = "";
		if(!eqyn($rq_am[am_pwd], "")){
			$upt_sql = ",am_pwd = '$rq_am[am_pwd]'";
		}

		$sql = "
			update tb_admin_mem set
				am_status = '$rq_am[am_status]'
				,am_kind = '$rq_am[am_kind]'
				,am_userid = '$rq_am[am_userid]'
				". $upt_sql ."				
				,am_name = '$rq_am[am_name]'
				,am_email = '$rq_am[am_email]'
				,am_tel = '$rq_am[am_tel]'
				,am_hp = '$rq_am[am_hp]'
				,am_memo = '$rq_am[am_memo]'
				,am_upt_datetime = now()

			where am_idx = $rq_am[am_idx];
		";

	}else if(eqyn($cmd, "del")){
		$sql = "
			update tb_admin_mem set
				am_status = 'D'
				,am_upt_datetime = now()

			where am_idx = $rq_am[am_idx]
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
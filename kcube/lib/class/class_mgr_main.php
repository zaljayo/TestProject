<?
$ser_mmi_status = rqstr("ser_mmi_status", "", "g");

$rq_mmi = array(
	"mmi_idx" => 0,
	"mmi_status" => "H",
	"mmi_seq" => 0,
	"mmi_title" => "",
	"mmi_desc" => "",
	"mmi_link" => "",
	"mmi_link_target" => "",
	"mmi_img_pc" => "",
	"db_mmi_img_pc" => "",
	"del_mmi_img_pc" => "N",
	"mmi_img_tb" => "",
	"db_mmi_img_tb" => "",
	"del_mmi_img_tb" => "N",
	"mmi_img_mb" => "",
	"db_mmi_img_mb" => "",
	"del_mmi_img_mb" => "N",
	"mmi_img_desc" => "",
	"db_mmi_img_desc" => "",
	"del_mmi_img_desc" => "N",
	"mmi_ip" => "",
	"mmi_ins_datetime" => "",
	"mmi_proc_datetime" => "",
	"mmi_desc_pc" => ""
);


$db_mmi = array(
	"result_cmd" => "",
	"mmi_idx" => 0,
	"mmi_status" => "H",
	"mmi_seq" => 0,
	"mmi_title" => "",
	"mmi_desc" => "",
	"mmi_link" => "",
	"mmi_link_target" => "_self",
	"mmi_img_pc" => "",
	"mmi_img_tb" => "",
	"mmi_img_mb" => "",
	"mmi_img_desc" => "",
	"mmi_ip" => "",
	"mmi_ins_datetime" => "",
	"mmi_proc_datetime" => "",
	"mmi_desc_pc"=> ""
);


function get_tb_mgr_main_rq( $cmd = "p" ){
	global $rq_mmi;

	$rq_mmi['mmi_idx'] = rqint("mmi_idx", 0, $cmd);
	$rq_mmi['mmi_status'] = rqstr("mmi_status", "H", $cmd);
	$rq_mmi['mmi_seq'] = rqint("mmi_seq", 0, $cmd);
	$rq_mmi['mmi_title'] = rqstr("mmi_title", "", $cmd);
	$rq_mmi['mmi_desc'] = rqstr("mmi_desc", "", $cmd);
	$rq_mmi['mmi_link'] = rqstr("mmi_link", "", $cmd);
	$rq_mmi['mmi_link_target'] = rqstr("mmi_link_target", "", $cmd);

	$rq_mmi['mmi_img_pc'] = rqstr("mmi_img_pc", "", $cmd);
	$rq_mmi['db_mmi_img_pc'] = rqstr("db_mmi_img_pc", "", $cmd);
	$rq_mmi['del_mmi_img_pc'] = rqstr("del_mmi_img_pc", "N", $cmd);

	$rq_mmi['mmi_img_tb'] = rqstr("mmi_img_tb", "", $cmd);
	$rq_mmi['db_mmi_img_tb'] = rqstr("db_mmi_img_tb", "", $cmd);
	$rq_mmi['del_mmi_img_tb'] = rqstr("del_mmi_img_tb", "N", $cmd);

	$rq_mmi['mmi_img_mb'] = rqstr("mmi_img_mb", "", $cmd);
	$rq_mmi['db_mmi_img_mb'] = rqstr("db_mmi_img_mb", "", $cmd);
	$rq_mmi['del_mmi_img_mb'] = rqstr("del_mmi_img_mb", "N", $cmd);
	$rq_mmi['mmi_img_desc'] = rqstr("mmi_img_desc", "", $cmd);
	$rq_mmi['db_mmi_img_desc'] = rqstr("db_mmi_img_desc", "", $cmd);
	$rq_mmi['del_mmi_img_desc'] = rqstr("del_mmi_img_desc", "N", $cmd);
	$rq_mmi['mmi_ip'] = host_ip();
	$rq_mmi['mmi_ins_datetime'] = rqstr("mmi_ins_datetime", "", $cmd);
	$rq_mmi['mmi_proc_datetime'] = rqstr("mmi_proc_datetime", "", $cmd);
	$rq_mmi['mmi_desc_pc'] = rqstr("mmi_desc_pc", "", $cmd);	
}


function get_tb_mgr_main_info_001( $rq_mmi_idx = 0){
	global $db_mmi;

	$result_cmd = false;
	if(!eqyn($rq_mmi_idx, 0)){
		$sql = "select * from tb_mgr_main where mmi_idx=$rq_mmi_idx";
//		echo $sql;
		$row = sql_fetch($sql);
		if($row){
			$db_mmi[result_cmd] = "YESDATA";
			$db_mmi['mmi_idx'] = $row["mmi_idx"];
			$db_mmi['mmi_status'] = $row["mmi_status"];
			$db_mmi['mmi_seq'] = $row["mmi_seq"];
			$db_mmi['mmi_title'] = $row["mmi_title"];
			$db_mmi['mmi_desc'] = $row["mmi_desc"];
			$db_mmi['mmi_link'] = $row["mmi_link"];
			$db_mmi['mmi_link_target'] = $row["mmi_link_target"];
			$db_mmi['mmi_img_pc'] = $row["mmi_img_pc"];
			$db_mmi['mmi_img_tb'] = $row["mmi_img_tb"];
			$db_mmi['mmi_img_mb'] = $row["mmi_img_mb"];
			$db_mmi['mmi_img_desc'] = $row["mmi_img_desc"];
			$db_mmi['mmi_ip'] = $row["mmi_ip"];
			$db_mmi['mmi_ins_datetime'] = $row["mmi_ins_datetime"];
			$db_mmi['mmi_proc_datetime'] = $row["mmi_proc_datetime"];
			$db_mmi['mmi_desc_pc'] = $row["mmi_desc_pc"];			
		}else{
			$db_mb[result_cmd] = "NODATA";
		}

	}else{
		$db_mb[result_cmd] = "NODATA";
	}
}


function set_tb_mgr_main_proc_001( $cmd = "", $rq_mmi ){
	if(eqyn($cmd, "ins")){
		$sql = "
			insert into tb_mgr_main(
				mmi_status
				,mmi_seq
				,mmi_title
				,mmi_desc
				,mmi_link
				,mmi_link_target
				,mmi_img_pc
				,mmi_img_tb
				,mmi_desc_pc
				,mmi_img_mb
				,mmi_img_desc
				,mmi_ip
				,mmi_ins_datetime
				,mmi_proc_datetime

			) values (
				'$rq_mmi[mmi_status]'
				,$rq_mmi[mmi_seq]
				,'$rq_mmi[mmi_title]'
				,'$rq_mmi[mmi_desc]'
				,'$rq_mmi[mmi_link]'
				,'$rq_mmi[mmi_link_target]'
				,'$rq_mmi[mmi_img_pc]'
				,'$rq_mmi[mmi_img_tb]'
				,'$rq_mmi[mmi_desc_pc]'				
				,'$rq_mmi[mmi_img_mb]'
				,'$rq_mmi[mmi_img_desc]'
				,'$rq_mmi[mmi_ip]'
				,now()
				,now()

			);
		";

	}else if(eqyn($cmd, "upt")){
		$sql = "
			update tb_mgr_main set
				mmi_status = '$rq_mmi[mmi_status]'
				,mmi_seq =$rq_mmi[mmi_seq]
				,mmi_title = '$rq_mmi[mmi_title]'
				,mmi_desc = '$rq_mmi[mmi_desc]'
				,mmi_link = '$rq_mmi[mmi_link]'
				,mmi_link_target = '$rq_mmi[mmi_link_target]'
				,mmi_img_pc = '$rq_mmi[mmi_img_pc]'
				,mmi_img_tb = '$rq_mmi[mmi_img_tb]'				
				,mmi_desc_pc = '$rq_mmi[mmi_desc_pc]'				
				,mmi_img_mb = '$rq_mmi[mmi_img_mb]'
				,mmi_img_desc = '$rq_mmi[mmi_img_desc]'
				,mmi_ip = '$rq_mmi[mmi_ip]'
				,mmi_ins_datetime = now()
				,mmi_proc_datetime = now()

			where mmi_idx = $rq_mmi[mmi_idx];
		";

	}else if(eqyn($cmd, "del")){
		$sql = "
			update tb_mgr_main set
				mmi_status = 'D'
				,mmi_ip = '$rq_mmi[mmi_ip]'
				,mmi_ins_datetime = now()
				,mmi_proc_datetime = now()

			where mmi_idx = $rq_mmi[mmi_idx]
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



function set_tb_mgr_main_seq_proc_001( $cmd, $rq_mmi_idx, $rq_mmi_seq ){
	if(eqyn($cmd, "up")){
		$sql = "
			update tb_mgr_main 
				set mmi_seq = mmi_seq + 1
			where mmi_status !='D'
				and mmi_seq >= $rq_mmi_seq
		";

	}else if(eqyn($cmd, "down")){
		$sql = "
			update tb_mgr_main 
				set mmi_seq = mmi_seq - 1
			where mmi_status !='D'
				and mmi_seq <= $rq_mmi_seq
		";
	}


	if(eqyn($cmd, "up") || eqyn($cmd, "down")){
		$db_result = sql_query($sql);

		$sql = "
			update tb_mgr_main 
				set mmi_seq = $rq_mmi_seq
			where mmi_idx = $rq_mmi_idx
		";
		$db_result = sql_query($sql);
	}


	if(get_db_proc_status()){
		$db_result = true;
		$sql = " select mmi_idx from tb_mgr_main where mmi_status !='D' order by mmi_seq asc, mmi_idx desc ";
		$rs = get_result($sql);
		$num = 0;
		while($row = mysql_fetch_array($rs)){
			$num++;
			$sql = "update tb_mgr_main set mmi_seq=$num where mmi_idx=". $row[mmi_idx];
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
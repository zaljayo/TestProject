<?
$ser_inw_status = rqstr("ser_inw_status", "", "g");
$ser_fk_inw_mct_cate = rqstr("ser_fk_inw_mct_cate", "", "g");
$ser_fk_inw_mct_idx = rqstr("ser_fk_inw_mct_idx", "", "g");


$ser_fk_inw_tm_idx = rqstr("ser_fk_inw_tm_idx", "", "g");
$ser_fk_inw_fm_idx = rqstr("ser_fk_inw_fm_idx", "", "g");

$rq_inw = array(
	"inw_idx" => 0,
	"inw_status" => "Y",
	"fk_inw_am_userid" => "",
	"inw_wname" => "",
	"inw_seq" => 0,
	"inw_title" => "",
	"fk_inw_mct_cate" => "",
	"fk_inw_mct_idx" => 0,
	"fk_inw_tm_idx" => "",
	"fk_inw_fm_idx" => "",
	"inw_tag" => "",
	"inw_img_list" => "",
	"db_inw_img_list" => "",
	"del_inw_img_list" => "N",
	"inw_img_list_desc" => "",
	"db_inw_img_list_desc" => "",
	"del_inw_img_list_desc" => "N",
	"inw_content" => "",
	"inw_read_cnt" => 0,
	"inw_ip" => "",
	"inw_ins_datetime" => "",
	"inw_proc_datetime" => "",
);


$db_inw = array(
	"result_cmd" => "",
	"inw_idx" => 0,
	"inw_status" => "Y",
	"fk_inw_am_userid" => "",
	"inw_wname" => "",
	"inw_seq" => 0,
	"inw_title" => "",
	"fk_inw_mct_cate" => "",
	"fk_inw_mct_idx" => 0,
	"fk_inw_tm_idx" => "",
	"fk_inw_fm_idx" => "",
	"inw_tag" => "",
	"inw_img_list" => "",
	"inw_img_list_desc" => "",
	"inw_content" => "",
	"inw_read_cnt" => 0,
	"inw_ip" => "",
	"inw_ins_datetime" => "",
	"inw_proc_datetime" => "",
);


function get_tb_ins_news_rq( $cmd = "p" ){
	global $rq_inw;

	$rq_inw['inw_idx'] = rqint("inw_idx", 0, $cmd);
	$rq_inw['inw_status'] = rqstr("inw_status", "Y", $cmd);
	$rq_inw['fk_inw_am_userid'] = rqstr("fk_inw_am_userid", "", $cmd);
	$rq_inw['inw_wname'] = rqstr("inw_wname", "", $cmd);
	$rq_inw['inw_seq'] = rqint("inw_seq", 0, $cmd);
	$rq_inw['inw_title'] = rqstr("inw_title", "", $cmd);
	$rq_inw['fk_inw_mct_cate'] = rqstr("fk_inw_mct_cate", "", $cmd);
	$rq_inw['fk_inw_mct_idx'] = rqint("fk_inw_mct_idx", 0, $cmd);
	$rq_inw['fk_inw_tm_idx'] = rqstr("fk_inw_tm_idx", "", $cmd);
	$rq_inw['fk_inw_fm_idx'] = rqstr("fk_inw_fm_idx", "", $cmd);
	$rq_inw['inw_tag'] = rqstr("inw_tag", "", $cmd);
	$rq_inw['inw_img_list'] = rqstr("inw_img_list", "", $cmd);
	$rq_inw['db_inw_img_list'] = rqstr("db_inw_img_list", "", $cmd);
	$rq_inw['del_inw_img_list'] = rqstr("del_inw_img_list", "N", $cmd);
	$rq_inw['inw_img_list_desc'] = rqstr("inw_img_list_desc", "", $cmd);
	$rq_inw['db_inw_img_list_desc'] = rqstr("db_inw_img_list_desc", "", $cmd);
	$rq_inw['del_inw_img_list_desc'] = rqstr("del_inw_img_list_desc", "N", $cmd);
	$rq_inw['inw_content'] = rqstr("inw_content", "", $cmd);
	$rq_inw['inw_read_cnt'] = rqint("inw_read_cnt", 0, $cmd);
	$rq_inw['inw_ip'] = host_ip();
	$rq_inw['inw_ins_datetime'] = rqstr("inw_ins_datetime", "", $cmd);
	$rq_inw['inw_proc_datetime'] = rqstr("inw_proc_datetime", "", $cmd);
}


function get_tb_ins_news_info_001( $rq_inw_idx = 0){
	global $db_inw;

	$result_cmd = false;
	if(!eqyn($rq_inw_idx, 0)){
		$sql = "select * from tb_ins_news where inw_idx = $rq_inw_idx";
//		echo $sql;
		$row = sql_fetch($sql);
		if($row){
			$db_inw[result_cmd] = "YESDATA";
			$db_inw['inw_idx'] = $row["inw_idx"];
			$db_inw['inw_status'] = $row["inw_status"];
			$db_inw['fk_inw_am_userid'] = $row["fk_inw_am_userid"];
			$db_inw['inw_wname'] = $row["inw_wname"];
			$db_inw['inw_seq'] = $row["inw_seq"];
			$db_inw['inw_title'] = $row["inw_title"];
			$db_inw['fk_inw_mct_cate'] = $row["fk_inw_mct_cate"];
			$db_inw['fk_inw_mct_idx'] = $row["fk_inw_mct_idx"];
			$db_inw['fk_inw_tm_idx'] = $row["fk_inw_tm_idx"];
			$db_inw['fk_inw_fm_idx'] = $row["fk_inw_fm_idx"];
			$db_inw['inw_tag'] = $row["inw_tag"];
			$db_inw['inw_img_list'] = $row["inw_img_list"];
			$db_inw['inw_img_list_desc'] = $row["inw_img_list_desc"];
			$db_inw['inw_content'] = $row["inw_content"];
			$db_inw['inw_read_cnt'] = $row["inw_read_cnt"];
			$db_inw['inw_ip'] = $row["inw_ip"];
			$db_inw['inw_ins_datetime'] = $row["inw_ins_datetime"];
			$db_inw['inw_proc_datetime'] = $row["inw_proc_datetime"];
		}else{
			$db_inw[result_cmd] = "NODATA";
		}

	}else{
		$db_inw[result_cmd] = "NODATA";
	}
}


function set_tb_ins_news_read_cnt_proc_001( $idx = 0 ){
	$sql = "
		update  tb_ins_news set
			inw_read_cnt = inw_read_cnt + 1
		where inw_idx = $idx
	";
//	echo $sql;
	sql_query($sql);
}


function set_tb_ins_news_proc_001( $cmd = "", $rq_inw ){

	$arr_tag = explode (",", $rq_inw[inw_tag]);
	$tag = "";

	if(count($arr_tag) >= 1 && !eqyn($rq_inw[inw_tag], "")){
		for($i=0; $i<count($arr_tag); $i++){
			$tmp_tag = trim($arr_tag[$i]);
			if(!eqyn($tmp_tag, "")){
				$tag .= $tmp_tag;
				$tag .=  ",";
			}
		}
	}

	if(!eqyn($tag, "")){
		$tag = substr($tag, 0, strlen($tag)-1);;
	}
	$rq_inw[inw_tag] = $tag;
	

	if(eqyn($cmd, "ins")){
		$sql = "
			insert into tb_ins_news(
				inw_status
				,fk_inw_am_userid
				,inw_wname
				,inw_seq
				,inw_title
				,fk_inw_mct_cate
				,fk_inw_mct_idx
				,fk_inw_tm_idx
				,fk_inw_fm_idx
				,inw_tag
				,inw_img_list
				,inw_img_list_desc
				,inw_content
				,inw_read_cnt
				,inw_ip
				,inw_ins_datetime
				,inw_proc_datetime

			) values (
				'$rq_inw[inw_status]'
				,'$rq_inw[fk_inw_am_userid]'
				,'$rq_inw[inw_wname]'
				,$rq_inw[inw_seq]
				,'$rq_inw[inw_title]'
				,'$rq_inw[fk_inw_mct_cate]'
				,$rq_inw[fk_inw_mct_idx]
				,'$rq_inw[fk_inw_tm_idx]'
				,'$rq_inw[fk_inw_fm_idx]'
				,'$rq_inw[inw_tag]'
				,'$rq_inw[inw_img_list]'
				,'$rq_inw[inw_img_list_desc]'
				,'$rq_inw[inw_content]'
				,$rq_inw[inw_read_cnt]
				,'$rq_inw[inw_ip]'
				,'$rq_inw[inw_ins_datetime]'
				,now()

			);
		";

	}else if(eqyn($cmd, "upt")){
		$sql = "
			update tb_ins_news set
				inw_status = '$rq_inw[inw_status]'
				,fk_inw_am_userid = '$rq_inw[fk_inw_am_userid]'
				,inw_wname = '$rq_inw[inw_wname]'
				,inw_seq = $rq_inw[inw_seq]
				,inw_title = '$rq_inw[inw_title]'
				,fk_inw_mct_cate = '$rq_inw[fk_inw_mct_cate]'
				,fk_inw_mct_idx = $rq_inw[fk_inw_mct_idx]
				,fk_inw_tm_idx = '$rq_inw[fk_inw_tm_idx]'
				,fk_inw_fm_idx = '$rq_inw[fk_inw_fm_idx]'
				,inw_tag = '$rq_inw[inw_tag]'
				,inw_img_list = '$rq_inw[inw_img_list]'
				,inw_img_list_desc = '$rq_inw[inw_img_list_desc]'
				,inw_content = '$rq_inw[inw_content]'
				,inw_ip = '$rq_inw[inw_ip]'
				,inw_ins_datetime = '$rq_inw[inw_ins_datetime]'
				,inw_proc_datetime = now()

			where inw_idx = $rq_inw[inw_idx];
		";

	}else if(eqyn($cmd, "del")){
		$sql = "
			update tb_ins_news set
				inw_status = 'D'
				,inw_ip = '$rq_inw[inw_ip]'
				,inw_proc_datetime = now()

			where inw_idx = $rq_inw[inw_idx]
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
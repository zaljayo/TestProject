<?
$ser_tm_status = rqstr("ser_tm_status", "", "g");

$arr_tm_web_tyle = array(
	"website"
	,"blog"
	,"email"
	,"facebook"
	,"twitter"
	,"linkedin"
	,"google"
	,"tumblr"
	,"yourube"
	,"vimeo"
	,"skype"
	,"instagram"
);

$rq_tm = array(
	"tm_idx" => 0,
	"tm_status" => "Y",
	"fk_tm_am_userid" => "",
	"tm_wname" => "",
	"tm_seq" => 0,
	"tm_name" => "",
	"tm_name_eng" => "",
	"tm_pos" => "",
	"tm_pos_eng" => "",
	"tm_rnk" => "",
	"tm_rnk_eng" => "",
	"tm_website" => "",
	"tm_blog" => "",
	"tm_email" => "",
	"tm_facebook" => "",
	"tm_twitter" => "",
	"tm_linkedin" => "",
	"tm_google" => "",
	"tm_tumblr" => "",
	"tm_yourube" => "",
	"tm_vimeo" => "",
	"tm_skype" => "",
	"tm_instagram" => "",
	"tm_int" => "",
	"tm_int_eng" => "",
	"tm_profile" => "",
	"tm_list_img_pc" => "",
	"db_tm_list_img_pc" => "",
	"del_tm_list_img_pc" => "N",
	"tm_list_img_mb" => "",
	"db_tm_list_img_mb" => "",
	"del_tm_list_img_mb" => "N",
	"tm_det_img_pc" => "",
	"db_tm_det_img_pc" => "",
	"del_tm_det_img_pc" => "N",
	"tm_det_img_mb" => "",
	"db_tm_det_img_mb" => "",
	"del_tm_det_img_mb" => "N",
	"tm_read_cnt" => 0,
	"tm_ip" => "",
	"tm_ins_datetime" => "",
	"tm_proc_datetime" => "",
);


$db_tm = array(
	"result_cmd" => "",
	"tm_idx" => 0,
	"tm_status" => "Y",
	"fk_tm_am_userid" => "",
	"tm_wname" => "",
	"tm_seq" => 0,
	"tm_name" => "",
	"tm_name_eng" => "",
	"tm_pos" => "",
	"tm_pos_eng" => "",
	"tm_rnk" => "",
	"tm_rnk_eng" => "",
	"tm_website" => "",
	"tm_blog" => "",
	"tm_email" => "",
	"tm_facebook" => "",
	"tm_twitter" => "",
	"tm_linkedin" => "",
	"tm_google" => "",
	"tm_tumblr" => "",
	"tm_yourube" => "",
	"tm_vimeo" => "",
	"tm_skype" => "",
	"tm_instagram" => "",
	"tm_int" => "",
	"tm_int_eng" => "",
	"tm_profile" => "",
	"tm_list_img_pc" => "",
	"tm_list_img_mb" => "",
	"tm_det_img_pc" => "",
	"tm_det_img_mb" => "",
	"tm_read_cnt" => 0,
	"tm_ip" => "",
	"tm_ins_datetime" => "",
	"tm_proc_datetime" => "",
);


function get_tb_team_rq( $cmd = "p" ){
	global $rq_tm;

	$rq_tm['tm_idx'] = rqint("tm_idx", 0, $cmd);
	$rq_tm['tm_status'] = rqstr("tm_status", "Y", $cmd);
	$rq_tm['fk_tm_am_userid'] = rqstr("fk_tm_am_userid", "", $cmd);
	$rq_tm['tm_wname'] = rqstr("tm_wname", "", $cmd);
	$rq_tm['tm_seq'] = rqint("tm_seq", 0, $cmd);
	$rq_tm['tm_name'] = rqstr("tm_name", "", $cmd);
	$rq_tm['tm_name_eng'] = rqstr("tm_name_eng", "", $cmd);
	$rq_tm['tm_pos'] = rqstr("tm_pos", "", $cmd);
	$rq_tm['tm_pos_eng'] = rqstr("tm_pos_eng", "", $cmd);
	$rq_tm['tm_rnk'] = rqstr("tm_rnk", "", $cmd);
	$rq_tm['tm_rnk_eng'] = rqstr("tm_rnk_eng", "", $cmd);
	$rq_tm['tm_website'] = rqstr("tm_website", "", $cmd);
	$rq_tm['tm_blog'] = rqstr("tm_blog", "", $cmd);
	$rq_tm['tm_email'] = rqstr("tm_email", "", $cmd);
	$rq_tm['tm_facebook'] = rqstr("tm_facebook", "", $cmd);
	$rq_tm['tm_twitter'] = rqstr("tm_twitter", "", $cmd);
	$rq_tm['tm_linkedin'] = rqstr("tm_linkedin", "", $cmd);
	$rq_tm['tm_google'] = rqstr("tm_google", "", $cmd);
	$rq_tm['tm_tumblr'] = rqstr("tm_tumblr", "", $cmd);
	$rq_tm['tm_yourube'] = rqstr("tm_yourube", "", $cmd);
	$rq_tm['tm_vimeo'] = rqstr("tm_vimeo", "", $cmd);
	$rq_tm['tm_skype'] = rqstr("tm_skype", "", $cmd);
	$rq_tm['tm_instagram'] = rqstr("tm_instagram", "", $cmd);
	$rq_tm['tm_int'] = rqstr("tm_int", "", $cmd);
	$rq_tm['tm_int_eng'] = rqstr("tm_int_eng", "", $cmd);
	$rq_tm['tm_profile'] = rqstr("tm_profile", "", $cmd);
	$rq_tm['tm_list_img_pc'] = rqstr("tm_list_img_pc", "", $cmd);
	$rq_tm['db_tm_list_img_pc'] = rqstr("db_tm_list_img_pc", "", $cmd);
	$rq_tm['del_tm_list_img_pc'] = rqstr("del_tm_list_img_pc", "N", $cmd);
	$rq_tm['tm_list_img_mb'] = rqstr("tm_list_img_mb", "", $cmd);
	$rq_tm['db_tm_list_img_mb'] = rqstr("db_tm_list_img_mb", "", $cmd);
	$rq_tm['del_tm_list_img_mb'] = rqstr("del_tm_list_img_mb", "N", $cmd);
	$rq_tm['tm_det_img_pc'] = rqstr("tm_det_img_pc", "", $cmd);
	$rq_tm['db_tm_det_img_pc'] = rqstr("db_tm_det_img_pc", "", $cmd);
	$rq_tm['del_tm_det_img_pc'] = rqstr("del_tm_det_img_pc", "N", $cmd);
	$rq_tm['tm_det_img_mb'] = rqstr("tm_det_img_mb", "", $cmd);
	$rq_tm['db_tm_det_img_mb'] = rqstr("db_tm_det_img_mb", "", $cmd);
	$rq_tm['del_tm_det_img_mb'] = rqstr("del_tm_det_img_mb", "N", $cmd);
	$rq_tm['tm_read_cnt'] = rqint("tm_read_cnt", 0, $cmd);
	$rq_tm['tm_ip'] = host_ip();
	$rq_tm['tm_ins_datetime'] = rqstr("tm_ins_datetime", "", $cmd);
	$rq_tm['tm_proc_datetime'] = rqstr("tm_proc_datetime", "", $cmd);
}


function get_tb_team_info_001( $rq_tm_idx = 0){
	global $db_tm;

	$result_cmd = false;
	if(!eqyn($rq_tm_idx, 0)){
		$sql = "select * from tb_team where tm_idx = $rq_tm_idx";
//		echo $sql;
		$row = sql_fetch($sql);
		if($row){
			$db_tm[result_cmd] = "YESDATA";
			$db_tm['tm_idx'] = $row["tm_idx"];
			$db_tm['tm_status'] = $row["tm_status"];
			$db_tm['fk_tm_am_userid'] = $row["fk_tm_am_userid"];
			$db_tm['tm_wname'] = $row["tm_wname"];
			$db_tm['tm_seq'] = $row["tm_seq"];
			$db_tm['tm_name'] = $row["tm_name"];
			$db_tm['tm_name_eng'] = $row["tm_name_eng"];
			$db_tm['tm_pos'] = $row["tm_pos"];
			$db_tm['tm_pos_eng'] = $row["tm_pos_eng"];
			$db_tm['tm_rnk'] = $row["tm_rnk"];
			$db_tm['tm_rnk_eng'] = $row["tm_rnk_eng"];
			$db_tm['tm_website'] = $row["tm_website"];
			$db_tm['tm_blog'] = $row["tm_blog"];
			$db_tm['tm_email'] = $row["tm_email"];
			$db_tm['tm_facebook'] = $row["tm_facebook"];
			$db_tm['tm_twitter'] = $row["tm_twitter"];
			$db_tm['tm_linkedin'] = $row["tm_linkedin"];
			$db_tm['tm_google'] = $row["tm_google"];
			$db_tm['tm_tumblr'] = $row["tm_tumblr"];
			$db_tm['tm_yourube'] = $row["tm_yourube"];
			$db_tm['tm_vimeo'] = $row["tm_vimeo"];
			$db_tm['tm_skype'] = $row["tm_skype"];
			$db_tm['tm_instagram'] = $row["tm_instagram"];
			$db_tm['tm_int'] = $row["tm_int"];
			$db_tm['tm_int_eng'] = $row["tm_int_eng"];
			$db_tm['tm_profile'] = $row["tm_profile"];
			$db_tm['tm_list_img_pc'] = $row["tm_list_img_pc"];
			$db_tm['tm_list_img_mb'] = $row["tm_list_img_mb"];
			$db_tm['tm_det_img_pc'] = $row["tm_det_img_pc"];
			$db_tm['tm_det_img_mb'] = $row["tm_det_img_mb"];
			$db_tm['tm_read_cnt'] = $row["tm_read_cnt"];
			$db_tm['tm_ip'] = $row["tm_ip"];
			$db_tm['tm_ins_datetime'] = $row["tm_ins_datetime"];
			$db_tm['tm_proc_datetime'] = $row["tm_proc_datetime"];
		}else{
			$db_tm[result_cmd] = "NODATA";
		}

	}else{
		$db_tm[result_cmd] = "NODATA";
	}
}


function set_tb_team_read_cnt_proc_001( $idx = 0 ){
	$sql = "
		update  tb_team set
			tm_read_cnt = tm_read_cnt + 1
		where tm_idx = $idx
	";
//	echo $sql;
	sql_query($sql);
}


function set_tb_team_proc_001( $cmd = "", $rq_tm ){
	if(eqyn($cmd, "ins")){
		$sql = "
			insert into tb_team(
				tm_status
				,fk_tm_am_userid
				,tm_wname
				,tm_seq
				,tm_name
				,tm_name_eng
				,tm_pos
				,tm_pos_eng
				,tm_rnk
				,tm_rnk_eng
				,tm_website
				,tm_blog
				,tm_email
				,tm_facebook
				,tm_twitter
				,tm_linkedin
				,tm_google
				,tm_tumblr
				,tm_yourube
				,tm_vimeo
				,tm_skype
				,tm_instagram
				,tm_int
				,tm_int_eng
				,tm_profile
				,tm_list_img_pc
				,tm_list_img_mb
				,tm_det_img_pc
				,tm_det_img_mb
				,tm_read_cnt
				,tm_ip
				,tm_ins_datetime
				,tm_proc_datetime

			) values (
				'$rq_tm[tm_status]'
				,'$rq_tm[fk_tm_am_userid]'
				,'$rq_tm[tm_wname]'
				,$rq_tm[tm_seq]
				,'$rq_tm[tm_name]'
				,'$rq_tm[tm_name_eng]'
				,'$rq_tm[tm_pos]'
				,'$rq_tm[tm_pos_eng]'
				,'$rq_tm[tm_rnk]'
				,'$rq_tm[tm_rnk_eng]'
				,'$rq_tm[tm_website]'
				,'$rq_tm[tm_blog]'
				,'$rq_tm[tm_email]'
				,'$rq_tm[tm_facebook]'
				,'$rq_tm[tm_twitter]'
				,'$rq_tm[tm_linkedin]'
				,'$rq_tm[tm_google]'
				,'$rq_tm[tm_tumblr]'
				,'$rq_tm[tm_yourube]'
				,'$rq_tm[tm_vimeo]'
				,'$rq_tm[tm_skype]'
				,'$rq_tm[tm_instagram]'
				,'$rq_tm[tm_int]'
				,'$rq_tm[tm_int_eng]'
				,'$rq_tm[tm_profile]'
				,'$rq_tm[tm_list_img_pc]'
				,'$rq_tm[tm_list_img_mb]'
				,'$rq_tm[tm_det_img_pc]'
				,'$rq_tm[tm_det_img_mb]'
				,$rq_tm[tm_read_cnt]
				,'$rq_tm[tm_ip]'
				,now()
				,now()

			);
		";

	}else if(eqyn($cmd, "upt")){
		$sql = "
			update tb_team set
				tm_status = '$rq_tm[tm_status]'
				,fk_tm_am_userid = '$rq_tm[fk_tm_am_userid]'
				,tm_wname = '$rq_tm[tm_wname]'
				,tm_seq = $rq_tm[tm_seq]
				,tm_name = '$rq_tm[tm_name]'
				,tm_name_eng = '$rq_tm[tm_name_eng]'
				,tm_pos = '$rq_tm[tm_pos]'
				,tm_pos_eng = '$rq_tm[tm_pos_eng]'
				,tm_rnk = '$rq_tm[tm_rnk]'
				,tm_rnk_eng = '$rq_tm[tm_rnk_eng]'
				,tm_website = '$rq_tm[tm_website]'
				,tm_blog = '$rq_tm[tm_blog]'
				,tm_email = '$rq_tm[tm_email]'
				,tm_facebook = '$rq_tm[tm_facebook]'
				,tm_twitter = '$rq_tm[tm_twitter]'
				,tm_linkedin = '$rq_tm[tm_linkedin]'
				,tm_google = '$rq_tm[tm_google]'
				,tm_tumblr = '$rq_tm[tm_tumblr]'
				,tm_yourube = '$rq_tm[tm_yourube]'
				,tm_vimeo = '$rq_tm[tm_vimeo]'
				,tm_skype = '$rq_tm[tm_skype]'
				,tm_instagram = '$rq_tm[tm_instagram]'
				,tm_int = '$rq_tm[tm_int]'
				,tm_int_eng = '$rq_tm[tm_int_eng]'
				,tm_profile = '$rq_tm[tm_profile]'
				,tm_list_img_pc = '$rq_tm[tm_list_img_pc]'
				,tm_list_img_mb = '$rq_tm[tm_list_img_mb]'
				,tm_det_img_pc = '$rq_tm[tm_det_img_pc]'
				,tm_det_img_mb = '$rq_tm[tm_det_img_mb]'
				,tm_ip = '$rq_tm[tm_ip]'
				,tm_proc_datetime = now()

			where tm_idx = $rq_tm[tm_idx];
		";

	}else if(eqyn($cmd, "del")){
		$sql = "
			update tb_team set
				tm_status = 'D'
				,tm_ip = '$rq_tm[tm_ip]'
				,tm_proc_datetime = now()

			where tm_idx = $rq_tm[tm_idx]
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


function set_tb_team_seq_proc_001( $cmd, $rq_tm_idx, $rq_tm_seq ){
	if(eqyn($cmd, "up")){
		$sql = "
			update tb_team 
				set tm_seq = tm_seq + 1
			where tm_status !='D'
				and tm_seq >= $rq_tm_seq
		";

	}else if(eqyn($cmd, "down")){
		$sql = "
			update tb_team 
				set tm_seq = tm_seq - 1
			where tm_status !='D'
				and tm_seq <= $rq_tm_seq
		";
	}


	if(eqyn($cmd, "up") || eqyn($cmd, "down")){
//		echo "$sql<br>";
		$db_result = sql_query($sql);

		$sql = "
			update tb_team 
				set tm_seq = $rq_tm_seq
			where tm_idx = $rq_tm_idx
		";
		$db_result = sql_query($sql);
	}


	if(get_db_proc_status()){
		$db_result = true;
		$sql = " select tm_idx from tb_team where tm_status !='D' order by tm_seq asc, tm_idx desc ";
		$rs = get_result($sql);
		$num = 0;
		while($row = mysql_fetch_array($rs)){
			$num++;
			$sql = "update tb_team set tm_seq=$num where tm_idx=". $row[tm_idx];
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
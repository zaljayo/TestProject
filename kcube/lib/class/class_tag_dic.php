<?

$rq_td = array(
	"td_idx" => 0,
	"td_tag" => "",
	"td_cnt" => 0,
);


$db_td = array(
	"result_cmd" => "",
	"td_idx" => 0,
	"td_tag" => "",
	"td_cnt" => 0,
);


function get_tb_tag_dic_rq( $cmd = "p" ){
	global $rq_td;

	$rq_td['td_idx'] = rqint("td_idx", 0, $cmd);
	$rq_td['td_tag'] = rqstr("td_tag", "", $cmd);
	$rq_td['td_cnt'] = rqint("td_cnt", 0, $cmd);
}

function set_tb_tag_dic_proc_001( $db_td_tag, $rq_td_tag ){

	if(!eqyn($db_td_tag, "")){
		$arr_tag = explode (",", $db_td_tag);
		$tag = "";

		if(count($arr_tag) >= 1 && !eqyn($db_td_tag, "")){
			for($i=0; $i<count($arr_tag); $i++){
				$tmp_tag = trim($arr_tag[$i]);
				if(!eqyn($tmp_tag, "")){
					$sql = "
						update tb_tag_dic set
							td_cnt = td_cnt - 1
						where td_tag = '$tmp_tag'
					";
					$result = sql_query($sql);
					if(!get_db_proc_status()){
						break;
					}
				}
			}
		}
	}



	if(!eqyn($rq_td_tag, "")){
		$arr_tag = explode (",", $rq_td_tag);
		$tag = "";

		if(count($arr_tag) >= 1 && !eqyn($rq_td_tag, "")){
			for($i=0; $i<count($arr_tag); $i++){
				$tmp_tag = trim($arr_tag[$i]);
				if(!eqyn($tmp_tag, "")){
					$table = "tb_tag_dic";
					$query = " and td_tag = '$tmp_tag' ";
					if(sql_count($table, $query) == 0){
						$sql = "
							insert into tb_tag_dic(td_tag, td_cnt)
							values('$tmp_tag', 1)
						";
			
					}else{
						$sql = "
							update tb_tag_dic set
								td_cnt = td_cnt + 1
							where td_tag = '$tmp_tag'
						";
					}
//					echo $sql."<br>";
					$result = sql_query($sql);
					if(!get_db_proc_status()){
						break;
					}
				}
			}
		}
	}


	if(get_db_proc_status()){
		$sql = "
			delete from tb_tag_dic
			where td_cnt = 0
		";
		$result = sql_query($sql);
	}

	return get_db_proc_status();
}
?>
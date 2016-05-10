<?


$rq_fk = array(
	"fk_ama_am_userid" => "",
	"fk_ama_amm_key" => "",
);


$db_fk = array(
	"result_cmd" => "",
	"fk_ama_am_userid" => "",
	"fk_ama_amm_key" => "",
);


function get_tb_admin_mem_auth_rq( $cmd = "p" ){
	global $rq_fk;

	$rq_fk['fk_ama_am_userid'] = rqstr("fk_ama_am_userid", "", $cmd);
	$rq_fk['fk_ama_amm_key'] = rqstr("fk_ama_amm_key", "", $cmd);
}


/* 기등록 데이타 확인 */
function get_tb_admin_mem_auth_info_001( $userid ){
	$arr_auth = array();
	$sql = "
		select fk_ama_amm_key from tb_admin_mem_auth
		where fk_ama_am_userid  = '". $userid ."'
	";
//	echo $sql;
	$row = sql_array($sql);
	if($row){
		foreach($row as &$value) {
			array_push($arr_auth, $value[0]); 
		}
	}
	return $arr_auth;
}
?>
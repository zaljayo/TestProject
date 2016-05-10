<?php
/*
//-- mysql myisam -> innodb로 변경
Alter table tb_menu_bg engine = InnoDB;
*/


/* DB 연결 */
$dbcon;
$result_cmd;
$tran_start = false;
$db_proc_status = true;
$arr_db_proc_status = array();

function set_dbcon( $transtart = false ){
	global $dbcon;
	$db_host = "us-cdbr-azure-southcentral-e.cloudapp.net";
	$db_id = "bacbe50c3b9d62";
	$db_pwd = "fb668bb3";
	$db_name = "dbjimmyrim";
	$dbcon = mysql_connect($db_host, $db_id, $db_pwd)  or die("Could not connect");
//	mysql_query("SET NAMES 'euckr'");
	$select_db = mysql_select_db($db_name); 

	mysql_query("set session character_set_connection=utf8;");
	mysql_query("set session character_set_results=utf8;");
	mysql_query("set session character_set_client=utf8;");
//	return $dbcon;

	if($transtart){
		transtart();
	}
}

/* 트랜젝션 시작 */
function transtart(){
	global $dbcon, $tran_start;

	/* set autocommit=0 수동 commit set autocommit=1 자동 commit */
	$tran_status = mysql_query("set autocommit=0", $dbcon);
	if($tran_status){
		$tran_status = mysql_query("begin", $dbcon);
	}

	if($tran_status){
		$tran_start = true;
	}
}

/* 트랜젝션 처리 */
function get_db_proc_status(){
	global $arr_db_proc_status;
	$db_commit = true;
	for($i=0; $i<count($arr_db_proc_status); $i++){
		if(!$arr_db_proc_status[$i]){
			$db_commit = false;
			break;
		}
	}
	return $db_commit;
}
function transproc(){
	global $dbcon;
	$db_commit = get_db_proc_status();

	if($db_commit){
		$result = mysql_query("commit", $dbcon);
		if($result){
			$db_commit = true;
		}else{
			$db_commit = false;
		}
	}else{
		$result = mysql_query("rollback", $dbcon);
		$db_commit = false;
	}
	return $db_commit;
}

/* DB 종료 */
function set_db_close(){
	global $dbcon;
	@mysql_close($dbcon);
}

/* 레코드셋 닫기 */
function set_rs_close( $rs ){
	@mysql_free_result( $rs );
}


// mysql_query 와 mysql_error 를 한꺼번에 처리
function sql_query($sql){
	global $dbcon, $tran_start;
	global $arr_db_proc_status;

//	$result = mysql_query($sql) or die(mysql_errno() . " : " .  mysql_error());
	$result = mysql_query($sql, $dbcon);

	if($tran_start){
//		echo $sql." -- ". mysql_affected_rows() ."<br>"; /* 데이타가 변경시에만 카운트 발생 - 데이타 변경없이 update시 카운트 0 */
//		if(!$result || mysql_affected_rows() == 0){
/*
		if(!$result){
			$tran_status = false;
		}
*/
	}
	
	array_push($arr_db_proc_status, $result);
    return $result;
}

//결과를 배열로 리턴
function sql_array($sql){
	global $dbcon;

	$rs = mysql_query($sql, $dbcon);

	while ($row = mysql_fetch_array($rs)){
		$var[] = $row;
	}
	set_rs_close($rs);
	return $var;
}

//결과를 리턴
function get_result($sql){
	global $dbcon;

	$rs = mysql_query($sql, $dbcon);
	return $rs;
}

// 한행을 얻는다.
function sql_fetch($sql){
//	echo $sql;
	global $dbcon;

    $rs = mysql_query($sql, $dbcon);
	if($rs){
	    $row = mysql_fetch_array($rs);
	}

	set_rs_close($rs);
    return $row;
}

// json 타입으로 가져오기
function get_rs_json( $rs ){
	$json = array( );
	while( $row = mysql_fetch_assoc( $rs ) ) {
		$json[] = $row;
	}
	return json_encode($json);
}

// 갯수를 구한다.
function sql_count($table, $query = ""){
	global $dbcon;

	$sql = "select count(*) as cnt from `". $table ."` where 1=1 ". $query;
//	echo $sql."<br>";
//	exit;
    $rs = mysql_query($sql, $dbcon);
	if($rs){
	    $row = mysql_fetch_array($rs);
		return $row[0];
	}else{
		return 0;
	}
}

// 최대값을 구한다.
function sql_max($what, $table, $query = ""){
	global $dbcon;

	$sql = "select max(".$what.") as max_data from `". $table ."` where 1=1 ". $query;
    $rs = mysql_query($sql, $dbcon);
	if($rs){
	    $row = mysql_fetch_array($rs);
		return $row[0];
	}else{
		return 0;
	}
}

// 최소값을 구한다.
function sql_min($what, $table, $query = ""){
	global $dbcon;

	$sql = "select min(".$what.") as min_data from `". $table ."` where 1=1 ". $query;
    $rs = mysql_query($sql, $dbcon);
	if($rs){
	    $row = mysql_fetch_array($rs);
		return $row[0];
	}else{
		return 0;
	}
}

// 마지막 입력된 identity 값을 구한다.
function last_insert_id(){
/*
	$sql="select LAST_INSERT_ID()";
	$val = sql_fetch($sql);
//	print_r($val);

	return $val[0];
*/
	return mysql_insert_id();

}

/* 레코드 가져오기 */
function get_record( $arr_sql ){
	global $recordcount;
	global $page_size;
	global $ilist_size;
	global $ipage;
	

	$array_statue = array("result" => false, "recordcount" => 0, "sql_cnt" => "", "sql_list" => "");

	//-- 레코드 카운트 가져오기
//	$array_statue[sql_cnt] = $sql;
	$recordcount = sql_count( $arr_sql[table], $arr_sql[where] );
	$array_statue[recordcount] = $recordcount;


	//-- list 가져오기
	if($recordcount > 0){
		$start_num = ($ipage-1) * $ilist_size;

		if($start_num < 0){
			$start_num = 0;
		}
		$end_num = $ilist_size;

		$query .= " limit $start_num, $end_num ";

		$sql = "
			select
				". $arr_sql[fild] ."
			from `". $arr_sql[table] ."`
			where 1=1 ". $arr_sql[where] ." ". $arr_sql[orderby] ." ". $query;
//		echo "$query<br>";
//		$result = mysql_query($sql); 
		$result = sql_array($sql); 
/*
		if (!$result){ 
			echo "질의 수행시 오류가 발생하였습니다.<br>"; 
			echo "<br>Error: ".mysql_error() ."<br>";
			echo "<br>query: $query <br>";
			exit; 
		} 
*/
		$array_statue[result] = $result;
		$array_statue[sql_list] = $sql;
	}
	return $array_statue;
}

// sql 구문 생성( insert, update, delete )
function sql_make( $query ){
	$cmd = $query[cmd];
	$array_statue = array("result" => false, "sql" => "");

	$arr_keys = array();
	$arr_values = array();
	$arr_wehreKeys = array();


	$fields = $query['fild'];
	$table = $query['table'];

	$table = $query['table'];
	$wheres = $query['where'];
	$ins_not = $query['ins_not'];
	$upt_not = $query['upt_not'];


	if($cmd == "ins"){
		foreach ($fields as $key => $value){
			$ser_st = array_search($key, $ins_not);
			$ser_st = setnull($ser_st, -1);
			if($ser_st < 0){
				array_push($arr_keys, $key);

				if(substr($key, strlen($key)-5, strlen($key)) == "_date"){
					array_push($arr_values, 'DATE_FORMAT(now(), "%Y-%m-%d")');
				}else if(substr($key, strlen($key)-9, strlen($key)) == "_datetime"){
					array_push($arr_values, 'now()');
				}else{
					array_push($arr_values, mysql_real_escape_string($value));
				}
			}
		}
		$sQuery = 'insert into `' . $table . '` (`'. implode('`,`', $arr_keys) . '`) values(\''. implode('\',\'', $arr_values) .'\')';
//		echo $sQuery;
		$array_statue[result] = sql_query($sQuery);


		$array_statue[sql] = $sQuery;
		return $array_statue;

	}else if($cmd == "upt"){
		foreach ($fields as $key => $value){
			$ser_st = array_search($key, $upt_not);
			$ser_st = setnull($ser_st, -1);
			if($ser_st < 0){
				if(substr($key, strlen($key)-5, strlen($key)) == "_date"){
					array_push($arr_keys, "`". $key ."`=DATE_FORMAT(now(), '%Y-%m-%d')");
				}else if(substr($key, strlen($key)-9, strlen($key)) == "_datetime"){
					array_push($arr_keys, '`'. $key .'`=now()');
				}else{
					array_push($arr_keys, '`'. $key .'`=\''. mysql_real_escape_string($value) .'\'');
				}
			}
		}
		
		$sQuery = 'update `'. $table .'` set '.implode(',', $arr_keys).' where 1=1 '. $wheres;
//		echo $sQuery."<br>";
		$array_statue[result] = sql_query($sQuery);
		$array_statue[sql] = $sQuery;
		return $array_statue;

	}else if($cmd == "del"){
		$sQuery = 'update `'. $table .'` set '.$query['status'].' = \'D\' where 1=1 '. $wheres;
		//$sQuery = 'delete from `'. $table .'` where 1=1 '. $wheres;
//		echo $sQuery;
		$array_statue[result] = sql_query($sQuery);
		$array_statue[sql] = $sQuery;
		return $array_statue;
	
	}else{
		return $array_statue;
	}	
}
?>
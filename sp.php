<?
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";


//-- 로그인 체크
//admin_check( "" );


//-- DB 연결
set_dbcon();


$table_name = strtolower(rqstr("table_name",  ""));
$dtype = strtolower(rqstr("dtype",  ""));

echo "class_". str_replace("tb_", "", $table_name) .".php";


function num_fild( $type ){
	if(strpos( $type, "int" ) === false && strpos( $type, "double" ) === false && strpos( $type, "real" ) === false && strpos( $type, "float" ) === false){
		return false;
	}else{
		return true;
	}
}
?>
<html>
<head>
<title>sp 생성기</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<form name="form1" method="post" action="sp.php">
	테이블 이름
	<input type="text" name="table_name" value="<?= $table_name ?>" onFocus="this.value='';">
	<br>
	<input type="submit" name="Submit" value="Submit">
	<br>날짜 관련 필드1 : YYYY-MM-DD 형태의 날짜 필드명의 마지막은 _date
	<br>날짜 관련 필드2 : YYYY-MM-DD HH:MM:SS 형태의 날짜 필드명의 마지막은 _datetime

	<br>파일 관련 필드 : _img, _file, _thumb 텍스트를 포함 시켜야함

</form>
<table width="100%" height="80%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>
	<textarea style="width:100%; height:100%">

<?
if($table_name != ""){
	$sql = "show columns from $table_name ";
	$result = get_result( $sql );

	$num = 0;
	$fild_pk = "";
	$rq_data = "";
	$db_data = "";

	$rqp_data = "";
	$reg_data = "";

	$info_data = "";

	$sql_ins_fild = array();
	$sql_ins_val = array();

	$sql_upt_fild = array();
	$sql_del_fild = array();

	$tab = "\t\t\t\t";
	$tab2 = "\t\t\t";

	while($row = mysql_fetch_array($result)){
		$num++;

		$fild = $row['Field'];
		$type = $row['Type'];
		$pk = $row['Key'];
		$def = $row['Default'];

		
		if($num == 1){
			$arr_file = explode ("_", $fild);
			$fkind = $arr_file[0] ."_";
			$fkind2 = $arr_file[0];
		}

		if($pk == "PRI"){
			$fild_pk = $fild;
		}else{
			array_push($sql_ins_fild, "$tab,$fild\n");

			if(substr($fild, strlen($fild)-5, strlen($fild)) == "_date"){
				array_push($sql_ins_val, "$tab,DATE_FORMAT(now(), '%Y-%m-%d')\n");
				array_push($sql_upt_fild, "$tab,$fild=DATE_FORMAT(now(), '%Y-%m-%d')\n");
				array_push($sql_del_fild, "$tab,$fild=DATE_FORMAT(now(), '%Y-%m-%d')\n");

			}else if(substr($fild, strlen($fild)-9, strlen($fild)) == "_datetime"){
				array_push($sql_ins_val, "$tab,now()\n");
				array_push($sql_upt_fild, "$tab,$fild = now()\n");
				array_push($sql_del_fild, "$tab,$fild = now()\n");
			}else{
				if(num_fild( $type ) == false){
					array_push($sql_ins_val, "$tab,'\$rq_". $fkind2 ."[$fild]'\n");
					array_push($sql_upt_fild, "$tab,$fild = '\$rq_". $fkind2 ."[$fild]'\n");
					if(substr($fild, strlen($fild)-3, strlen($fild)) == "_ip"){
						array_push($sql_del_fild, "$tab,$fild = '\$rq_". $fkind2 ."[$fild]'\n");
					}
				}else{
					array_push($sql_ins_val, "$tab,\$rq_". $fkind2 ."[$fild]\n");
					array_push($sql_upt_fild, "$tab,$fild = \$rq_". $fkind2 ."[$fild]\n");
				}
			}
		}


		if(num_fild( $type ) == false){
			if(substr($fild, strlen($fild)-3, strlen($fild)) == "_ip"){
				$rq_data .= "	\"$fild\" => \"\",\n";

				$db_data .= "	\"$fild\" => \"\",\n";

				$rqp_data .= "	\$rq_". $fkind2 ."['$fild'] = host_ip();\n";
				$rqg_data .= "	\$rq_".$fkind2 ."['$fild'] = host_ip();\n";

			}else if(strpos( $fild, "_img" ) === false && strpos( $fild, "_file" ) === false && strpos( $fild, "_thumb" ) === false){
				$rq_data .= "	\"$fild\" => \"\",\n";

				$db_data .= "	\"$fild\" => \"\",\n";

				$rqp_data .= "	\$rq_". $fkind2 ."['$fild'] = rqstr(\"$fild\", \"\", \$cmd);\n";
				$rqg_data .= "	\$rq_".$fkind2 ."['$fild'] = rqstr(\"$fild\", \"\", \"g\");\n";

			}else{
				$rq_data .= "	\"$fild\" => \"\",\n";
				$rq_data .= "	\"db_$fild\" => \"\",\n";
				$rq_data .= "	\"del_$fild\" => \"N\",\n";

				$db_data .= "	\"$fild\" => \"\",\n";

				$rqp_data .= "	\$rq_". $fkind2 ."['$fild'] = rqstr(\"$fild\", \"\", \$cmd);\n";
				$rqp_data .= "	\$rq_". $fkind2 ."['db_$fild'] = rqstr(\"db_$fild\", \"\", \$cmd);\n";
				$rqp_data .= "	\$rq_". $fkind2 ."['del_$fild'] = rqstr(\"del_$fild\", \"N\", \$cmd);\n";

				$rqg_data .= "	\$rq_". $fkind2 ."['$fild'] = rqstr(\"$fild\", \"\", \"g\");\n";
//				$rqg_data .= "	\$rq_". $fkind2 ."['db_$fild'] = rqstr(\"db_$fild\", \"\", \"g\");\n";
//				$rqg_data .= "	\$rq_". $fkind2 ."['del_$fild'] = rqstr(\"del_$fild\", \"N\", \"g\");\n";
			}
		}else{
			$rq_data .= "	\"$fild\" => 0,\n";

			$db_data .= "	\"$fild\" => 0,\n";

			$rqp_data .= "	\$rq_". $fkind2 ."['$fild'] = rqint(\"$fild\", 0, \$cmd);\n";

			$rqg_data .= "	\$rq_". $fkind2 ."['$fild'] = rqint(\"$fild\", 0, \"g\");\n";
		}

		$info_data .= "			\$db_". $fkind2 ."['$fild'] = \$row[\"$fild\"];\n";
	}
?>

$rq_<?= $fkind2 ?> = array(
<?= $rq_data ?>
);


$db_<?= $fkind2 ?> = array(
	"result_cmd" => "",
<?= $db_data ?>
);


function get_<?=$table_name?>_rq( $cmd = "p" ){
	global $rq_<?= $fkind2 ?>;

<?= $rqp_data ?>
}


function get_<?= $table_name ?>_info_001( $rq_<?= $fild_pk ?> = 0){
	global $db_<?= $fkind2 ?>;

	$result_cmd = false;
	if(!eqyn($rq_<?= $fild_pk ?>, 0)){
		$sql = "select * from <?= $table_name ?> where <?= $fild_pk ?> = $rq_<?= $fild_pk ?>";
//		echo $sql;
		$row = sql_fetch($sql);
		if($row){
			$db_<?= $fkind2 ?>[result_cmd] = "YESDATA";
<?= $info_data ?>
		}else{
			$db_<?= $fkind2 ?>[result_cmd] = "NODATA";
		}

	}else{
		$db_<?= $fkind2 ?>[result_cmd] = "NODATA";
	}
}


function set_<?=$table_name?>_proc_001( $cmd = "", $rq_<?= $fkind2 ?> ){
	if(eqyn($cmd, "ins")){
		$sql = "<?
$sql_ins_fild[0] = str_replace(",", "", $sql_ins_fild[0]);
$sql_ins_val[0] = str_replace(",", "", $sql_ins_val[0]);
echo "
".$tab2."insert into $table_name(
". implode('', $sql_ins_fild) ."
".$tab2.") values (
". implode('', $sql_ins_val) ."
".$tab2.");
";
?>		";

	}else if(eqyn($cmd, "upt")){
		$sql = "<?
$sql_upt_fild[0] = str_replace(",", "", $sql_upt_fild[0]);
echo "
".$tab2."update $table_name set
". implode('', $sql_upt_fild) ."
".$tab2."where $fild_pk = \$rq_". $fkind2 ."[$fild_pk];
";
?>
		";

	}else if(eqyn($cmd, "del")){
		$sql = "<?
echo "
".$tab2."update $table_name set
".$tab. $fkind2 ."_status = 'D'
". implode('', $sql_del_fild) ."
".$tab2."where $fild_pk = \$rq_". $fkind2 ."[$fild_pk]
";
?>		";

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
<?
}
?>
</textarea>

<!--
function set_<?=$table_name?>_proc_001( $cmd = "", $rq_<?= $fkind2 ?> ){
	$db_query = array(
		'cmd' => $cmd
		,'status' => '<?= $fkind2 ?>_status'
		,'table' => '<?= $table_name ?>'
		,'where' => ' and <?= $fild_pk ?>='. $rq_<?= $fkind2 ?>[<?= $fild_pk ?>]
		,'fild' => $rq_<?= $fkind2 ?>

		,'ins_not'=> array('<?= implode('\', \'', $ins_not) ?>')
		,'upt_not'=> array('<?= implode('\', \'', $upt_not) ?>')
	);

	return sql_make($db_query);
}
//-->

	</td>
  </tr>
</table>
</body>
</html>
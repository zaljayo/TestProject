<?
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_mail_subscribe.php";

//-- 로그인 체크
admin_check( "menuF01" );


//-- DB 연결
set_dbcon();

//-- 리스트 가져오기
$sql_where = "";

if( $search_title != "" ){
	$search_yn = true;
	$sql_where .= " and msr_email like '%$search_title%' ";
}

$ilist_size = 999999;
$arr_sql = array(
	"fild" => "*",
	"table" => "tb_mail_subscribe",
	"where" => $sql_where,
	"orderby" => "order by msr_idx desc"
);
$db_result = get_record( $arr_sql );
$rs = $db_result[result];


/* DB 종료 */
set_db_close();

header( "Content-type: application/vnd.ms-excel" );   
header( "Content-type: application/vnd.ms-excel; charset=utf-8");  
header( "Content-Disposition: attachment; filename = email_list.xls" );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>- 관리자 -</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>					
<table border="1" cellspacing="0" cellpadding="0">
<tr>
	<th width="70" bgcolor="#cecece">번호</th>
	<th width="200" bgcolor="#cecece">메일주소</th>
	<th width="100" bgcolor="#cecece">등록일</th>
</tr>
<?
if($recordcount == 0){
?>
	<tr>
		<td colspan="3" height="100">
			검색된 내용이 없습니다.<br>
			<?
			if($search_yn != ""){
			?>
				<a href="<?= $GLB_SELFPAGE ?>"><img src="/admin_mgr/images/btn/all_list.gif"></a>							
			<?
			}
			?>
		</td>
	</tr>
<?
}else{
	$NO = 0;
	foreach($rs as $ors) {
		$NO++;
		$db_msr_idx			= $ors["msr_idx"];
		$db_msr_email		= $ors["msr_email"];
		$msr_ins_datetime	= substr($ors["msr_ins_datetime"], 0, 10);
?>
		<tr>
			<td style="mso-number-format:'\@'"><?= get_recordnum($NO) ?></td>
			<td style="mso-number-format:'\@'"><?= $db_msr_email ?></td>
			<td style="mso-number-format:'\@'"><?= $msr_ins_datetime ?></td>
		</tr>
<?
	}
}
?>
</table>
</body>
</html>
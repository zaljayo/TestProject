<?
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_team.php";

//-- 로그인 체크
admin_check( "menuE01" );


//-- DB 연결
set_dbcon();

//-- 리스트 가져오기
$sql_where = " and tm_status != 'D'";

if($ser_tm_status != ""){
	$search_yn = true;
	$sql_where .= " and tm_status = '$ser_tm_status' ";
}

if( $search_title != "" ){
	$search_yn = true;
	if(eqyn($fild, "tm_com")){
		$sql_where .= " and (tm_com like '%$search_title%' or tm_com_eng like '%$search_title%') ";
	}else if(eqyn($fild, "tm_service")){
		$sql_where .= " and (tm_service like '%$search_title%' or tm_service_eng like '%$search_title%') ";			
	}else{
		$sql_where .= " and ".$fild." like '%$search_title%' ";
	}
}

$arr_sql = array(
	"fild" => "*",
	"table" => "tb_team",
	"where" => $sql_where,
	"orderby" => "order by tm_seq asc, tm_idx desc"
);
$db_result = get_record( $arr_sql );
$rs = $db_result[result];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>- 관리자 -</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<? include $server_root_path."/admin_mgr/inc/inc_header.php"; ?>
<script type="text/javascript">
function sel_ok( idx ){
	var name = $("#tm_name"+ idx).val();
	opener.set_team( idx, name);
}
//-->
</script>
</head>
<body style="padding: 10px">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />Team 관련 글 검색 > 목록</td>
</tr>
</table>

<form id="pagefm" name="pagefm" method="get" action="<?= $GLB_SELFPAGE ?>">
	<input type="hidden" name="page" id="page" value='<?= $ipage ?>' />
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
	<tr>
		<th width="150" class="mu">공개여부</th>
		<td class="left02">
			<select name="ser_tm_status">
				<option value="">전체</option>
				<option value="Y" <?= selected($ser_tm_status, "Y") ?>>공개</option>
				<option value="H" <?= selected($ser_tm_status, "H") ?>>비공개</option>
			</select>
		</td>
	</tr>
	
	<tr>
		<th class="mu">검색</th>
		<td class="left02">
			<select name="fild" id="fild">
				<option value='tm_name' <?= selected($fild, "tm_name") ?>>이름</option>
			</select>
			<input type="text" name="search_title" id="search_title" value='<?= $search_title_str ?>' class="input_03 " size="20"/>
		</td>
	</tr>
	</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="right" height="40">
			<button type="button" class="btn btn01" onclick="goto_page(1);"> 검 색 </button>
		</td>
	</tr>
	</table>
</form>


				<form id="delfm" name="delfm" method="post" action="tm_write_proc.php" target="_proc">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
					<tr>
						<th width="70" class="mu">번호</th>
						<th width="100" class="mu">이름</th>
						<th width="" class="mu">직책</th>
						<th width="100" class="mu">직급</th>
						<th width="80" class="mu">공개여부</th>
						<th width="100" class="mu">관리</th>
					</tr>
<?
if($recordcount == 0){
?>
					<tr>
						<td colspan="6" height="100">
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
		$db_tm_idx			= $ors["tm_idx"];
		$db_tm_status		= $ors["tm_status"];
		$db_tm_seq			= $ors["tm_seq"];	
		$db_tm_name			= $ors["tm_name"];
		$db_tm_pos			= $ors["tm_pos"];
		$db_tm_rnk 			= $ors["tm_rnk"];
		$tm_ins_datetime	= substr($ors["tm_ins_datetime"], 0, 10);
?>
					<tr>
						<td><?= get_recordnum($NO) ?></td>
						<td>
							<a href="tm_write.php?tm_idx=<?=$db_tm_idx?>&return_param=<?=$GLB_QUERY_PARAM_ENC?>"><?= $db_tm_name ?></a>
						</td>
						<td class="text_left left_padding10"><?= $db_tm_pos ?></td>
						<td><?= $db_tm_rnk ?></td>
						<td><?= $arr_status[$db_tm_status]?></td>
						<td>
							<input type="hidden" id="tm_name<?= $db_tm_idx ?>" value="<?= print_content( "input" , $db_tm_name) ?>">
							<button type="button" class="btn btn02" onclick="sel_ok(<?= $db_tm_idx ?>);"> 선택</button>
						</td>
					</tr>
<?
	}
}
?>
					</table>
				</form>

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr align="center">
					<td height="40"><?= pageing_admin() ?></td>
				</tr>
				</table>

</body>
</html>
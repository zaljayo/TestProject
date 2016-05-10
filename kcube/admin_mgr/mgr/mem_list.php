<? include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php" ?>
<?
//-- 로그인 체크
admin_check( "menuZ01" );


//-- DB 연결
set_dbcon();


//$ilist_size = 1;
$sql_where = " and am_status != 'D' ";

if($ser_am_status != ""){
	$search_yn = true;
	$sql_where .= " and am_status='$ser_am_status' ";
}

if($search_title != ""){
	$search_yn = true;
	$sql_where .= " and $fild like '%$search_title%' ";
}

$arr_sql = array(
	"fild" => "*",
	"table" => "tb_admin_mem",
	"where" => $sql_where,
	"orderby" => "order by am_idx desc"
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
<!--
function auth_popup( v_am_userid ){
	var fm = document.getElementById("actfm");
	fm.am_userid.value = v_am_userid;

	window.open("about:blank", "memauthpopup", "width=480, height=600, scrollbars=yes")
	fm.target = "memauthpopup";
	fm.action = "mem_auth.php";
	fm.submit();
}
//-->
</script>
</head>

<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td height="40" background="/admin_mgr/images/top_bg.gif">&nbsp;</td>
</tr>
<tr>
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr height="70">
			<td width="175" colspan="2"  align="center">
				<? include $server_root_path."/admin_mgr/inc/inc_logo.php" ?>
			</td>
			<td style="padding-right:20px;">
				<? include $server_root_path."/admin_mgr/inc/inc_top.php" ?>
			</td>
		</tr>
		<tr>
			<td height="1" colspan="3" bgcolor="#c4c4c4"></td>
		</tr>
		<tr>
			<td width="180" valign="top" style="padding-left:20px;padding-bottom:200px;">
				<? include $server_root_path."/admin_mgr/inc/inc_menu.php" ?>
			</td>
			<td width="1" bgcolor="#c4c4c4"></td>
			<td valign="top" style="padding:10px 15px;">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />관리자관리 > 목록</td>
				</tr>
				</table>

				<form id="pagefm" name="pagefm" method="get" action="<?= $GLB_SELFPAGE ?>">
					<input type="hidden" name="page" id="page" value='<?= $ipage ?>' />
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
					<tr>
						<th width="150" class="mu">이용상태</th>
						<td class="left02">
							<input type="radio" name="ser_am_status" id="ser_am_status" value="" <?= checked($ser_am_status, "") ?>><label for="ser_am_status">전체</label>
							<input type="radio" name="ser_am_status" id="ser_am_statusY" value="Y" <?= checked($ser_am_status, "Y") ?>><label for="ser_am_statusY">이용중</label>
							<input type="radio" name="ser_am_status" id="ser_am_statusS" value="S" <?= checked($ser_am_status, "S") ?>><label for="ser_am_statusS">이용정지</label>
						</td>
					</tr>
					<tr>
						<th class="mu">검색</th>
						<td class="left02">
							<select name="fild" id="file">
								<option value='am_userid'<?= selected($fild, "am_userid") ?>>관리자 아이디</option>
								<option value='am_name'<?= selected($fild, "am_name") ?>>관리자명</option>
							</select>
							<input type="text" name="search_title" id="search_title" value='<?= $search_title_str ?>' class="input_03 " size="20"/>
						</td>
					</tr>
					</table>

					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" height="40">
							<!--a href="javascript:xls_down();"><img src="../images/btn/excel.gif"></a-->
						</td>
						<td align="right">
							<button type="button" class="btn btn01" onclick="goto_page(1);"> 검 색 </button>
						</td>
					</tr>
					</table>
				</form>


				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
				<tr>
					<th width="80" class="mu">번호</th>
					<th width="80" class="mu">구분</th>
					<th width="" class="mu">관리자 아이디</th>
					<th width="" class="mu">관리자명</th>
					<th width="100" class="mu">상태</th>
					<th width="100" class="mu">권한관리</th>
				</tr>
<?
if($recordcount == 0){
?>
				<tr>
					<td colspan="7" height="100">
						검색된 내용이 없습니다.<br>
						<a href="<?= $GLB_SELFPAGE ?>"><img src="/admin_mgr/images/btn/all_list.gif"></a>
					</td>
				</tr>
<?
}else{
	$NO = 0;
	foreach($rs as $ors) {
		$NO++;

		$db_am_idx = $ors["am_idx"];
		$db_am_kind = $ors["am_kind"];
		$db_am_userid = $ors["am_userid"];
		$db_am_name = $ors["am_name"];
		$db_am_status = $ors["am_status"];
?>
				<tr>
					<td><?= get_recordnum($NO) ?></td>
					<td><?= $arr_am_kind[$db_am_kind] ?></td>
					<td><a href="mem_write.php?am_userid=<?= $db_am_userid ?>&return_param=<?= $GLB_QUERY_PARAM_ENC ?>"><?= $db_am_userid ?></a></td>
					<td><?= $db_am_name ?></td>
					<td><?= $arr_am_status[$db_am_status] ?></td>
					<td>
						<?
						if(eqyn($db_am_kind, "A")){
							echo "-";
						}else{
						?>
							<button type="button" class="btn btn04" onclick="auth_popup('<?= $db_am_userid ?>')"> 수 정 </button>
						<?
						}
						?>						
					</td>
				</tr>
<?
	}
}
?>
				</table>
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr align="right">
					<td height="40">
						<button type="button" class="btn btn02" onclick="goto_url('mem_write.php');"> 등록</button>
					</td>
				</tr>
				<tr align="center">
					<td height="40"><?= pageing_admin() ?></td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<form method="post" name="actfm" id="actfm">
	<input type="hidden" name="am_userid" id="am_userid" value=''>
</form>

<? include $server_root_path."/admin_mgr/inc/inc_footer.php" ?>
</body>
</html>
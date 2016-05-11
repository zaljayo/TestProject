<?
error_reporting(E_ALL ^ E_NOTICE);
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

$arr_sql = array(
	"fild" => "*",
	"table" => "tb_mail_subscribe",
	"where" => $sql_where,
	"orderby" => "order by msr_idx desc"
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
function del(){
	var fm = document.getElementById("delfm");
	if(confirm("삭제한 데이타는 복구할수 없습니다.\n삭제하시겠습니까?")){
		fm.cmd.value = "list_del";
		fm.submit();
	}
}

function xls_down(){
	var fm = document.getElementById("pagefm");
	fm.action = "msr_list_xls.php";
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
					<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />구독회원 > 목록</td>
				</tr>
				</table>


				<form id="pagefm" name="pagefm" method="get" action="<?= $GLB_SELFPAGE ?>">
					<input type="hidden" name="page" id="page" value='<?= $ipage ?>' />
					<input type="hidden" name="act_url" id="act_url" value='<?= $GLB_SELFPAGE ?>' />
					
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
					<tr>
						<th width="150" class="mu">검색</th>
						<td class="left02">
							<select name="fild" id="fild">
								<option value='msr_email' <?= selected($fild, "msr_email") ?>>메일주소</option>
							</select>
							<input type="text" name="search_title" id="search_title" value='<?= $search_title_str ?>' class="input_03 " size="20"/>
						</td>
					</tr>
					</table>

					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" height="40">
							<button type="button" class="btn btn04" onclick="xls_down();"> 엑셀 다운로드 </button>
						</td>
						<td align="right" height="40">
							<button type="button" class="btn btn01" onclick="goto_page(1);"> 검 색 </button>
						</td>
					</tr>
					</table>
				</form>


				<form id="delfm" name="delfm" method="post" action="msr_proc.php" target="_proc">
					<input type="hidden" name="cmd" id="cmd" value="" />
					<input type="hidden" name="msr_idx" id="msr_idx" value="" />					
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
					<tr>
						<th width="50" class="mu"><input type="checkbox" onClick="chk_all(this,'msr_idx[]');"></th>
						<th width="70" class="mu">번호</th>
						<th width="" class="mu">메일주소</th>
						<th width="100" class="mu">등록일</th>
					</tr>
<?
if($recordcount == 0){
?>
					<tr>
						<td colspan="4" height="100">
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
						<td><input name="msr_idx[]" type="checkbox" id="msr_idx_<?=$db_msr_idx?>" value="<?=$db_msr_idx?>"></td>
						<td><?= get_recordnum($NO) ?></td>
						<td><?= $db_msr_email ?></td>
						<td><?= $msr_ins_datetime ?></td>
					</tr>
<?
	}
}
?>
					</table>
				</form>

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr align="right">
					<td height="40">
						<button type="button" class="btn btn05" onclick="del();"> 삭제 </button>
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

<? include $server_root_path."/admin_mgr/inc/inc_footer.php" ?>
</body>
</html>
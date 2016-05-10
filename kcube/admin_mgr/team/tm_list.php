<?
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_team.php";

//-- 로그인 체크
admin_check( "menuD01" );


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

function chg_seq( v_cmd, v_tm_idx, v_tm_seq ){
	var fm = document.getElementById("delfm");
	fm.cmd.value = v_cmd;
	fm.tm_idx.value = v_tm_idx;
	fm.tm_seq.value = v_tm_seq;
	fm.submit();
}

function del(){
	var fm = document.getElementById("delfm");
	if(confirm("삭제한 데이타는 복구할수 없습니다.\n삭제하시겠습니까?")){
		fm.cmd.value = "list_del";
		fm.submit();
	}
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
					<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />Team > 목록</td>
				</tr>
				</table>


				<form id="pagefm" name="pagefm" method="get" action="<?= $GLB_SELFPAGE ?>">
					<input type="hidden" name="page" id="page" value='<?= $ipage ?>' />
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
					<tr>
						<th width="150" class="mu">공개여부</th>
						<td class="left02">
							<input type="radio" name="ser_tm_status" id="ser_tm_status" value="" <?= checked($ser_tm_status, "") ?> ><label for="ser_tm_statusY">전체</label>
							<input type="radio" name="ser_tm_status" id="ser_tm_statusY" value="Y" <?= checked($ser_tm_status, "Y") ?> ><label for="ser_tm_statusY">공개</label>
							<input type="radio" name="ser_tm_status" id="ser_tm_statusH" value="H" <?= checked($ser_tm_status, "H") ?>><label for="ser_tm_statusH">비공개</label>
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
					<input type="hidden" name="cmd" id="cmd" value="" />
					<input type="hidden" name="tm_idx" id="tm_idx" value="" />
					<input type="hidden" name="tm_seq" id="tm_seq" value="" />					
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
					<tr>
						<th width="50" class="mu"><input type="checkbox" onClick="chk_all(this,'tm_idx[]');"></th>
						<th width="70" class="mu">번호</th>
						<th width="100" class="mu">이름</th>
						<th width="" class="mu">직책</th>
						<th width="100" class="mu">직급</th>
						<th width="100" class="mu">등록일</th>
						<th width="80" class="mu">공개여부</th>
						<th width="100" class="mu">순서</th>
					</tr>
<?
if($recordcount == 0){
?>
					<tr>
						<td colspan="8" height="100">
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
						<td><input name="tm_idx[]" type="checkbox" id="tm_idx_<?=$db_tm_idx?>" value="<?=$db_tm_idx?>"></td>
						<td><?= get_recordnum($NO) ?></td>
						<td>
							<a href="tm_write.php?tm_idx=<?=$db_tm_idx?>&return_param=<?=$GLB_QUERY_PARAM_ENC?>"><?= $db_tm_name ?></a>
						</td>
						<td class="text_left left_padding10"><?= $db_tm_pos ?></td>
						<td><?= $db_tm_rnk ?></td>
						<td><?= $tm_ins_datetime ?></td>
						<td><?= $arr_status[$db_tm_status]?></td>
						<td>
						<?
						if($recordcount == get_recordnum($NO)){
						?>
							<a href="javascript:chg_seq('down', <?= $db_tm_idx ?>, <?= $db_tm_seq+1 ?>);"><img src="../images/btn/btn_down.gif"></a>
						<?
						}else if(get_recordnum($NO) == 1){
						?>
							<a href="javascript:chg_seq('up', <?= $db_tm_idx ?>, <?= $db_tm_seq-1 ?>);"><img src="../images/btn/btn_up.gif"></a>
						<?
						}else{
						?>
							<a href="javascript:chg_seq('up', <?= $db_tm_idx ?>, <?= $db_tm_seq-1 ?>);"><img src="../images/btn/btn_up.gif"></a>
							<a href="javascript:chg_seq('down', <?= $db_tm_idx ?>, <?= $db_tm_seq+1 ?>);"><img src="../images/btn/btn_down.gif"></a>
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
				</form>

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr align="right">
					<td height="40">
						<button type="button" class="btn btn05" onclick="del();"> 삭제 </button>
						<button type="button" class="btn btn02" onclick="goto_url('tm_write.php');"> 등록</button>
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
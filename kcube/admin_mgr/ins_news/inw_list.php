<?
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_ins_news.php";
include $server_root_path."/lib/class/class_mgr_cate.php";

//-- 로그인 체크
admin_check( "menuE01" );


//-- DB 연결
set_dbcon();

//-- 리스트 가져오기
$sql_where = " and inw_status != 'D'";

if($ser_inw_status != ""){
	$search_yn = true;
	$sql_where .= " and inw_status = '$ser_inw_status' ";
}

if($ser_fk_inw_mct_cate != ""){
	$search_yn = true;
	$sql_where .= " and fk_inw_mct_cate = '$ser_fk_inw_mct_cate' ";
}


if($search_title != ""){
	$search_yn = true;
	if(eqyn($fild, "inw_com")){
		$sql_where .= " and (inw_com like '%$search_title%' or inw_com_eng like '%$search_title%') ";
	}else if(eqyn($fild, "inw_service")){
		$sql_where .= " and (inw_service like '%$search_title%' or inw_service_eng like '%$search_title%') ";			
	}else{
		$sql_where .= " and ".$fild." like '%$search_title%' ";
	}
}

$arr_sql = array(
	"fild" => "*, (select mct_name from tb_mgr_cate where mct_idx=fk_inw_mct_idx and mct_status='Y') as mct_name",
	"table" => "tb_ins_news",
	"where" => $sql_where,
	"orderby" => "order by inw_ins_datetime desc, inw_idx desc"
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

function chg_seq( v_cmd, v_inw_idx, v_inw_seq ){
	var fm = document.getElementById("delfm");
	fm.cmd.value = v_cmd;
	fm.inw_idx.value = v_inw_idx;
	fm.inw_seq.value = v_inw_seq;
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
							<input type="radio" name="ser_inw_status" id="ser_inw_status" value="" <?= checked($ser_inw_status, "") ?> ><label for="ser_inw_statusY">전체</label>
							<input type="radio" name="ser_inw_status" id="ser_inw_statusY" value="Y" <?= checked($ser_inw_status, "Y") ?> ><label for="ser_inw_statusY">공개</label>
							<input type="radio" name="ser_inw_status" id="ser_inw_statusH" value="H" <?= checked($ser_inw_status, "H") ?>><label for="ser_inw_statusH">비공개</label>
						</td>
					</tr>
					<tr>
						<th width="150" class="mu">구분</th>
						<td class="left02">
							<input type="radio" name="ser_fk_inw_mct_cate" id="ser_fk_inw_mct_cate" value="" <?= checked($ser_fk_inw_mct_cate, "") ?> ><label for="ser_fk_inw_mct_cate">전체</label>
							<?
							$var = array_keys($arr_mct_cate);
							for($i=1; $i<=2; $i++){
								$key = $var[$i];
							?>
								<input type="radio" name="ser_fk_inw_mct_cate" id="ser_fk_inw_mct_cate<?= $key ?>" value="<?= $key ?>" <?= checked($ser_fk_inw_mct_cate, $key) ?>><label for="ser_fk_inw_mct_cate<?= $key ?>"><?= $arr_mct_cate[$key] ?></label>
							<?
							}
							?>
						</td>
					</tr>


					<tr>
						<th class="mu">검색</th>
						<td class="left02">
							<select name="fild" id="fild">
								<option value='inw_title' <?= selected($fild, "inw_title") ?>>제목</option>
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


				<form id="delfm" name="delfm" method="post" action="inw_write_proc.php" target="_proc">
					<input type="hidden" name="cmd" id="cmd" value="" />
					<input type="hidden" name="inw_idx" id="inw_idx" value="" />
					<input type="hidden" name="inw_seq" id="inw_seq" value="" />					
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
					<tr>
						<th width="50" class="mu"><input type="checkbox" onClick="chk_all(this,'inw_idx[]');"></th>
						<th width="60" class="mu">번호</th>
						<th width="60" class="mu">구분</th>
						<th width="100" class="mu">카테고리</th>
						<th width="" class="mu">제목</th>
						<th width="100" class="mu">작성자</th>
						<th width="100" class="mu">태그</th>
						<th width="70" class="mu">등록일</th>
						<th width="70" class="mu">공개여부</th>
					</tr>
<?
if($recordcount == 0){
?>
					<tr>
						<td colspan="9" height="100">
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
		$db_inw_idx			= $ors["inw_idx"];
		$db_inw_status		= $ors["inw_status"];
		$db_fk_inw_mct_cate	= $ors["fk_inw_mct_cate"];	
		$db_mct_name		= $ors["mct_name"];
		$db_inw_title		= $ors["inw_title"];
		$db_inw_wname		= $ors["inw_wname"];
		$db_inw_tag			= $ors["inw_tag"];
		$db_inw_ins_datetime= substr($ors["inw_ins_datetime"], 0, 10);
?>
					<tr>
						<td><input name="inw_idx[]" type="checkbox" id="inw_idx_<?=$db_inw_idx?>" value="<?=$db_inw_idx?>"></td>
						<td><?= get_recordnum($NO) ?></td>
						<td><?= $arr_mct_cate[$db_fk_inw_mct_cate] ?></td>
						<td><?= $db_mct_name ?></td>
						<td class="text_left left_padding10">
							<a href="inw_write.php?inw_idx=<?=$db_inw_idx?>&return_param=<?=$GLB_QUERY_PARAM_ENC?>"><?= $db_inw_title ?></a>
						</td>
						<td><?= $db_inw_wname ?></td>
						<td><?= $db_inw_tag ?></td>						
						<td><?= $db_inw_ins_datetime ?></td>
						<td><?= $arr_status[$db_inw_status]?></td>
						<td></td>
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
						<button type="button" class="btn btn02" onclick="goto_url('inw_write.php');"> 등록</button>
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
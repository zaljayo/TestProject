<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_family.php";

//-- 로그인 체크
admin_check( "menuE01" );


//-- DB 연결
set_dbcon();

//-- 리스트 가져오기
$sql_where = " and fm_status != 'D'";

if($ser_fm_status != ""){
	$search_yn = true;
	$sql_where .= " and fm_status = '$ser_fm_status' ";
}

if( $search_title != "" ){
	$search_yn = true;
	if(eqyn($fild, "")){
		$sql_where .= " and (
				fm_com like '%$search_title%' or fm_com_eng like '%$search_title%'
				or fm_service like '%$search_title%' or fm_service_eng like '%$search_title%'
				or fm_ceo like '%$search_title%'
			)
		";
	}else if(eqyn($fild, "fm_com")){
		$sql_where .= " and (fm_com like '%$search_title%' or fm_com_eng like '%$search_title%') ";
	}else if(eqyn($fild, "fm_service")){
		$sql_where .= " and (fm_service like '%$search_title%' or fm_service_eng like '%$search_title%') ";			
	}else{
		$sql_where .= " and ".$fild." like '%$search_title%' ";
	}
}

$arr_sql = array(
	"fild" => "*, (select mct_name from tb_mgr_cate where mct_status='Y' and mct_idx=fk_fm_mct_idx) as mct_name",
	"table" => "tb_family",
	"where" => $sql_where,
	"orderby" => "order by fm_seq asc, fm_idx desc"
);
$db_result = get_record( $arr_sql );
$rs = $db_result[result];


//-- 업로드 경로
get_updir( "family" );
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
	var name = $("#fm_name"+ idx).val();
	opener.set_family( idx, name);
}
//-->
</script>
</head>
<body style="padding: 10px">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />Family 관련 글 검색 > 목록</td>
</tr>
</table>

<form id="pagefm" name="pagefm" method="get" action="<?= $GLB_SELFPAGE ?>">
	<input type="hidden" name="page" id="page" value='<?= $ipage ?>' />
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
	<tr>
		<th width="150" class="mu">공개여부</th>
		<td class="left02">
			<select name="ser_fm_status">
				<option value="">전체</option>
				<option value="Y" <?= selected($ser_fm_status, "Y") ?>>공개</option>
				<option value="H" <?= selected($ser_fm_status, "H") ?>>비공개</option>
			</select>
		</td>
	</tr>
	
	<tr>
		<th class="mu">검색</th>
		<td class="left02">
			<select name="fild" id="fild">
				<option value=''>- 전체 -</option>
				<option value='fm_com' <?= selected($fild, "fm_com") ?>>업체명</option>
				<option value='fm_ceo' <?= selected($fild, "fm_ceo") ?>>업체대표</option>
				<option value='fm_service' <?= selected($fild, "fm_service") ?>>서비스내용</option>
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


				<form id="delfm" name="delfm" method="post" action="fm_write_proc.php" target="_proc">
					<input type="hidden" name="cmd" id="cmd" value="" />
					<input type="hidden" name="fm_idx" id="fm_idx" value="" />
					<input type="hidden" name="fm_seq" id="fm_seq" value="" />					
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
					<tr>
						<th width="50" class="mu"><input type="checkbox" onClick="chk_all(this,'fm_idx[]');"></th>
						<th width="70" class="mu">번호</th>
						<th width="100" class="mu">카테고리</th>
						<th width="" class="mu">업체명</th>
						<th width="100" class="mu">대표</th>
						<th width="100" class="mu">등록일</th>
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
		$db_fm_idx			= $ors["fm_idx"];
		$db_fm_status		= $ors["fm_status"];
		$db_fm_seq			= $ors["fm_seq"];	
		$db_mct_name		= $ors["mct_name"];
		$db_fm_com			= $ors["fm_com"];
		$db_fm_ceo 			= $ors["fm_ceo"];
		$fm_ins_datetime	= substr($ors["fm_ins_datetime"], 0, 10);
?>
					<tr>
						<td><input name="fm_idx[]" type="checkbox" id="fm_idx_<?=$db_fm_idx?>" value="<?=$db_fm_idx?>"></td>
						<td><?= get_recordnum($NO) ?></td>
						<td><?= $db_mct_name ?></td>
						<td class="text_left left_padding10">
							<a href="fm_write.php?fm_idx=<?=$db_fm_idx?>&return_param=<?=$GLB_QUERY_PARAM_ENC?>"><?= $db_fm_com ?></a>
						</td>
						<td><?= $db_fm_ceo ?></td>
						<td><?= $fm_ins_datetime ?></td>
						<td><?= $arr_status[$db_fm_status]?></td>
						<td>
							<input type="hidden" id="fm_name<?= $db_fm_idx ?>" value="<?= print_content( "input" , $db_fm_com) ?>">
							<button type="button" class="btn btn02" onclick="sel_ok(<?= $db_fm_idx ?>);"> 선택</button>
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
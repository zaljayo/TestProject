<?
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_mgr_cate.php";

//-- 로그인 체크
admin_check( "menuB01" );

//-- DB 연결
set_dbcon();

//-- 데이타 가져오기
get_tb_mgr_cate_rq("g");

//-- DB 데이타 가져오기
/*
if(!eqyn($rq_mmi[mct_idx], 0)){
	get_tb_mgr_cate_info_001( $rq_mmi[mct_idx] );
	if(!eqyn($db_mmi[result_cmd], "YESDATA") || eqyn($db_mmi['mct_status'], "D")){
		printmsgback("해당 정보를 찾을수 없습니다.");
	}
}

//-- 업로드 경로
get_updir( "mgr_main" );
*/
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
$(document).ready(function(){
});

function regi( v_cmd, v_cate ){
	var fm = document.getElementById("actfm");
	fm.cmd.value = v_cmd;
	fm.mct_cate.value = v_cate;

	if(v_cmd == "del"){
		var v_mct_idx = "";
		$("input[name=mct_idx_"+ v_cate +"]:checked").each(function() {
			v_mct_idx += $(this).val() +",";
		});
		if(v_mct_idx == ""){
			alert("삭제하실 카테고리를 선택해주세요.");
			$("input[name=mct_idx_"+ v_cate +"]:eq(0)").focus();
			return;
		}
	
		$("#mct_idx").val(v_mct_idx);
		if(confirm("삭제한 데이타는 복구할수 없습니다.\n삭제하시겠습니까?")){
			fm.submit();
		}
	}else{
		var e_mct_name = $("#mct_name_"+ v_cate);
		fm.mct_name.value = e_mct_name.val();

		if(e_mct_name.val() == ""){
			alert("카테고리명을 입력해주세요.");
			e_mct_name.focus();
			return;
		}

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
					<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />카테고리 관리</td>
				</tr>
				</table>



				<form name="actfm" id="actfm" action="mct_write_proc.php" method="post" target="_proc" style="display: none;">
					<input type="text" name="cmd" id="cmd" value=""><br>
					<input type="text" name="return_param" id="return_param" value=""><br>
					<input type="text" name="mct_idx" id="mct_idx" value=""><br>
					<input type="text" name="mct_cate" id="mct_cate" value=""><br>
					<input type="text" name="mct_name" id="mct_name" value=""><br>
					<input type="text" name="mct_name_eng" id="mct_name_eng" value="">
				</form>

<?
foreach($arr_mct_cate as $mct_cate => $title){
//	echo $key ."==". $val ."<br>";
?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
				<tr>
				  <th class="mu" width="150">* 메뉴</th>
				  <td class="text_left" style="padding-left:5px"><?= $title ?></td>
				</tr>

				<tr>
				  <th class="mu">* 카테고리</th>
				  <td class="text_left" style="padding-left:5px">
					<?
					$sql = "select * from tb_mgr_cate where mct_cate='$mct_cate' and mct_status='Y' order by mct_idx asc";
					$rs = sql_array($sql);
					foreach($rs as $ors) {
						$db_mct_idx = $ors[mct_idx];
						$db_mct_name = print_content("text", $ors[mct_name]);
					?>
						<input type="checkbox" name="mct_idx_<?= $mct_cate ?>" id="mct_idx_<?= $db_mct_idx ?>" value="<?= $db_mct_idx ?>">
						<label for="mct_idx_<?= $db_mct_idx ?>"><?= $db_mct_name ?></label>
					<?
					}
					?>
				  </td>
				</tr>
				<tr>
					<th class="mu">* 카테고리명</th>
					<td class="text_left" style="padding-left:5px">
						<input type="text" id="mct_name_<?= $mct_cate ?>" value="<?= $db_mmi[mct_name] ?>" style="width:200px">
					</td>
				</tr>
				</table>
	
				<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td align="right">
						<button type="button" class="btn btn02" onclick="regi('ins', '<?= $mct_cate ?>');"> 등 록</button>
						<!--button type="button" class="btn btn02" onclick="regi('upt', '<?= $mct_cate ?>');"> 수 정</button-->
						<button type="button" class="btn btn05" onclick="regi('del', '<?= $mct_cate ?>');"> 삭 제 </button>
					</td>
				</tr>
				</table>
				<br>
<?
}
?>

















			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<? include $server_root_path."/admin_mgr/inc/inc_footer.php" ?>
</body>
</html>
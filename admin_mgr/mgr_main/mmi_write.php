<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_mgr_main.php";

//-- 로그인 체크
admin_check( "menuA01" );

//-- DB 연결
set_dbcon();

//-- 데이타 가져오기
get_tb_mgr_main_rq("g");

//-- DB 데이타 가져오기
if(!eqyn($rq_mmi[mmi_idx], 0)){
	get_tb_mgr_main_info_001( $rq_mmi[mmi_idx] );
	if(!eqyn($db_mmi[result_cmd], "YESDATA") || eqyn($db_mmi['mmi_status'], "D")){
		printmsgback("해당 정보를 찾을수 없습니다.");
	}
}

if(eqyn($db_mmi[mmi_seq], 0))
	$db_mmi[mmi_seq] = "";

//-- 업로드 경로
get_updir( "mgr_main" );
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

function regi( v_cmd ){
	var fm = document.getElementById("actfm");
	fm.cmd.value = v_cmd;

	if(v_cmd == "del"){
		if(confirm("삭제한 데이타는 복구할수 없습니다.\n삭제하시겠습니까?")){
			fm.submit();
		}
	}else{
		if(fm.mmi_seq.value == ""){
			alert("순서를 숫자로 입력해주세요.");
			fm.mmi_seq.focus();
			return;
		}
		if(!digitstr(fm.mmi_seq.value)){
			alert("순서를 숫자로 입력해주세요.");
			fm.mmi_seq.focus();
			return;
		}
/*
		if(fm.mmi_title.value == ""){
			alert("제목을 입력해주세요.");
			fm.mmi_title.focus();
			return;
		}
*/
		if(fm.mmi_img_desc.value == ""){
			alert("이미지 설명을 입력해주세요.");
			fm.mmi_img_desc.focus();
			return;
		}

		if(fm.mmi_img_pc.value == "" && fm.db_mmi_img_pc.value == ""){
			alert("PC 이미지를 선택해주세요.");
			fm.mmi_img_pc.focus();
			return;
		}
		if(fm.mmi_img_pc.value != ""){
			var result = upload_file_check( "image", fm.mmi_img_pc.value);
			if(result != "Y"){
				alert( result );
				fm.mmi_img_pc.focus();
				return;
			}
		}

		if(fm.mmi_desc_pc.value == ""){
			alert("PC 설명을 입력해주세요.");
			fm.mmi_desc_pc.focus();
			return;
		}

		if(fm.mmi_img_tb.value == "" && fm.db_mmi_img_tb.value == ""){
			alert("Tablet 이미지를 선택해주세요.");
			fm.mmi_img_tb.focus();
			return;
		}
		if(fm.mmi_img_tb.value != ""){
			var result = upload_file_check( "image", fm.mmi_img_tb.value);
			if(result != "Y"){
				alert( result );
				fm.mmi_img_tb.focus();
				return;
			}
		}

		if(fm.mmi_img_mb.value == "" && fm.db_mmi_img_mb.value == ""){
			alert("Moblie 이미지를 선택해주세요.");
			fm.mmi_img_mb.focus();
			return;
		}
		if(fm.mmi_img_mb.value != ""){
			var result = upload_file_check( "image", fm.mmi_img_mb.value);
			if(result != "Y"){
				alert( result );
				fm.mmi_img_mb.focus();
				return;
			}
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
					<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />메인관리 > 관리</td>
				</tr>
				</table>

				<form name="actfm" id="actfm" action="mmi_write_proc.php" method="post" enctype="multipart/form-data" target="_proc" >
					<input type="hidden" name="cmd" id="cmd" value="">
					<input type="hidden" name="return_param" id="return_param" value="<?= $GLB_RETURN_PARAM ?>">
					<input type="hidden" name="mmi_idx" id="mmi_idx" value="<?= $rq_mmi[mmi_idx] ?>">

					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
					<? if( $rq_mmi[mmi_idx] != 0 ){ ?>
					<tr>
						<th class="mu" width="150">등록일</th>
						<td class="text_left" style="padding-left:5px">
							<?=$db_mmi[mmi_ins_datetime]?>
						</td>
						<th class="mu" width="150">수정시간</th>
						<td class="text_left" style="padding-left:5px">
							<?=$db_mmi[mmi_proc_datetime]?>
						</td>
					</tr>
					<?}?>

					<tr>
					  <th class="mu" width="150">* 공개여부</th>
					  <td class="text_left" style="padding-left:5px" colspan="3">
						<input type="radio" name="mmi_status" id="mmi_statusY" value="Y" <?= checked($db_mmi[mmi_status], "Y") ?> ><label for="mmi_statusY">공개</label>
						<input type="radio" name="mmi_status" id="mmi_statusH" value="H" <?= checked($db_mmi[mmi_status], "H") ?>><label for="mmi_statusH">비공개</label>
					  </td>
					</tr>
					<tr>
						<th class="mu">* 순서</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_mmi_seq" id="db_mmi_seq" value="<?= $db_mmi[mmi_seq] ?>">
							<input type="text" name="mmi_seq" id="mmi_seq" value="<?= $db_mmi[mmi_seq] ?>" style="width:100px" onkeyup="checkNum(this);">
						</td>
					</tr>
					<tr style="display: none;">
						<th class="mu">* 제목</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="text" name="mmi_title" id="mmi_title" value="<?= print_content( "input" , $db_mmi[mmi_title]) ?>" style="width:98%">
						</td>
					</tr>
					<tr>
						<th class="mu">링크</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="text" name="mmi_link" id="mmi_link" value="<?= print_content( "input" , $db_mmi[mmi_link]) ?>" style="width:98%">
							<input type="radio" name="mmi_link_target" id="mmi_link_target_self" value="_self" <?= checked($db_mmi[mmi_link_target], "_self") ?>>
							<label for="mmi_link_target_self">현재창</label>

							<input type="radio" name="mmi_link_target" id="mmi_link_target_blank" value="_blank" <?= checked($db_mmi[mmi_link_target], "_blank") ?>>
							<label for="mmi_link_target_blank">새창</label>
						</td>
					</tr>
					<tr>
						<th class="mu">* 이미지 설명</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="text" name="mmi_img_desc" id="mmi_img_desc" value="<?= print_content( "input" , $db_mmi[mmi_img_desc]) ?>" style="width:98%">
						</td>
					</tr>
					<tr>
						<th class="mu">* PC 이미지</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_mmi_img_pc" id="db_mmi_img_pc" value="<?= $db_mmi[mmi_img_pc] ?>">
							<input type="file" name="mmi_img_pc" id="mmi_img_pc" value="" style="width:98%">
							<?
							if($db_mmi[mmi_img_pc] != ""){
							?>
								<a href="<?= $GLB_UP_FILE_URL.$db_mmi[mmi_img_pc] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_mmi[mmi_img_pc] ?>" width="100"></a>
							<?
							}
							?>
						</td>
					</tr>
					<tr>
						<th class="mu">* PC 설명</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							영문폰트 사용시 샘플 : <b style="color:red">&lt;span class='txt-en'&gt;영문내용&lt;/span&gt;</b>
							<textarea name="mmi_desc_pc" id="mmi_desc_pc" style="width:98%; height:60px"><?= $db_mmi[mmi_desc_pc] ?></textarea>
						</td>
					</tr>
					
					<tr>
						<th class="mu">* Tablet 이미지</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_mmi_img_tb" id="db_mmi_img_tb" value="<?= $db_mmi[mmi_img_tb] ?>">
							<input type="file" name="mmi_img_tb" id="mmi_img_tb" value="" style="width:98%">
							<?
							if($db_mmi[mmi_img_tb] != ""){
							?>
								<a href="<?= $GLB_UP_FILE_URL.$db_mmi[mmi_img_tb] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_mmi[mmi_img_tb] ?>" width="100"></a>
							<?
							}
							?>
						</td>
					</tr>

					<tr>
						<th class="mu">* Moblie 이미지</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_mmi_img_mb" id="db_mmi_img_mb" value="<?= $db_mmi[mmi_img_mb] ?>">
							<input type="file" name="mmi_img_mb" id="mmi_img_mb" value="" style="width:98%">
							<?
							if($db_mmi[mmi_img_mb] != ""){
							?>
								<a href="<?= $GLB_UP_FILE_URL.$db_mmi[mmi_img_mb] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_mmi[mmi_img_mb] ?>" width="100"></a>
							<?
							}
							?>
						</td>
					</tr>
					</table>
				</form>

	
				<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td align="right">
					<?
					if($db_mmi[mmi_idx] != 0 ){
					?>
						<button type="button" class="btn btn02" onclick="regi('upt');"> 수 정</button>
						<button type="button" class="btn btn05" onclick="regi('del');"> 삭 제 </button>
					<?
					}else{
					?>
						<button type="button" class="btn btn02" onclick="regi('ins');"> 등 록</button>
					<?
					}	
					?>
					<button type="button" class="btn btn01" onclick="goto_url('mmi_list.php?<?= $GLB_RETURN_PARAM_DEC ?>');"> 리스트 </button>
					</td>
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
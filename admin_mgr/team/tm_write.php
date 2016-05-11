<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_team.php";

//-- 로그인 체크
admin_check( "menuD01" );

//-- DB 연결
set_dbcon();

//-- 데이타 가져오기
get_tb_team_rq("g");

//-- DB 데이타 가져오기
if(!eqyn($rq_tm[tm_idx], 0)){
	get_tb_team_info_001( $rq_tm[tm_idx] );
	if(!eqyn($db_tm[result_cmd], "YESDATA") || eqyn($db_tm['tm_status'], "D")){
		printmsgback("해당 정보를 찾을수 없습니다.");
	}else{
//		set_tb_team_read_cnt_proc_001( $rq_tm[tm_idx] );
	}
}else{
	$db_tm[tm_wname] = get_admin_name();
}

if(eqyn($db_tm[tm_seq], 0))
	$db_tm[tm_seq] = "";

//-- 업로드 경로
get_updir( "team" );
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
		if(fm.tm_seq.value == ""){
			alert("순서를 숫자로 입력해주세요.");
			fm.tm_seq.focus();
			return;
		}
		if(!digitstr(fm.tm_seq.value)){
			alert("순서를 숫자로 입력해주세요.");
			fm.tm_seq.focus();
			return;
		}

		if(fm.tm_name_eng.value == ""){
			alert("이름(영문)을 입력해주세요.");
			fm.tm_com_eng.focus();
			return;
		}
		if(fm.tm_name_eng.value == ""){
			alert("이름(국문)을 입력해주세요.");
			fm.tm_com.focus();
			return;
		}

		if(fm.tm_name.value != "NULL" && fm.tm_name_eng.value != "NULL"){
			if(fm.tm_list_img_pc.value == "" && fm.db_tm_list_img_pc.value == ""){
				alert("리스트 사진을 선택해주세요.");
				fm.tm_list_img_pc.focus();
				return;
			}
			if(fm.tm_list_img_pc.value != ""){
				var result = upload_file_check( "image", fm.tm_list_img_pc.value);
				if(result != "Y"){
					alert( result );
					fm.tm_list_img_pc.focus();
					return;
				}
			}

			if(fm.tm_det_img_pc.value == "" && fm.db_tm_det_img_pc.value == ""){
				alert("상세페이지 사진을 선택해주세요.");
				fm.tm_det_img_pc.focus();
				return;
			}
			if(fm.tm_det_img_pc.value != ""){
				var result = upload_file_check( "image", fm.tm_det_img_pc.value);
				if(result != "Y"){
					alert( result );
					fm.tm_det_img_pc.focus();
					return;
				}
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
					<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />Team > 관리</td>
				</tr>
				</table>

				<form name="actfm" id="actfm" action="tm_write_proc.php" method="post" enctype="multipart/form-data" target="_proc" >
					<input type="hidden" name="cmd" id="cmd" value="">
					<input type="hidden" name="return_param" id="return_param" value="<?= $GLB_RETURN_PARAM ?>">
					<input type="hidden" name="tm_idx" id="tm_idx" value="<?= $rq_tm[tm_idx] ?>">

					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
					<? if( $rq_tm[tm_idx] != 0 ){ ?>
					<tr>
						<th class="mu">등록일</th>
						<td class="text_left" style="padding-left:5px">
							<?=$db_tm[tm_ins_datetime]?>
						</td>
						<th class="mu">수정시간</th>
						<td class="text_left" style="padding-left:5px">
							<?=$db_tm[tm_proc_datetime]?>
						</td>
					</tr>
					<tr>
						<th class="mu" width="150">조회수</th>
						<td class="text_left" style="padding-left:5px"  colspan="3">
							<?=$db_tm[tm_read_cnt]?>
						</td>
					</tr>
					<?}?>

					<tr>
					  <th class="mu" width="150">* 공개여부</th>
					  <td class="text_left" style="padding-left:5px">
						<input type="radio" name="tm_status" id="tm_statusY" value="Y" <?= checked($db_tm[tm_status], "Y") ?> ><label for="tm_statusY">공개</label>
						<input type="radio" name="tm_status" id="tm_statusH" value="H" <?= checked($db_tm[tm_status], "H") ?>><label for="tm_statusH">비공개</label>
					  </td>

						<th class="mu" width="150">작성자</th>
						<td class="text_left" style="padding-left:5px">
							<input type="text" name="tm_wname" id="tm_wname" value="<?= print_content( "input" , $db_tm[tm_wname]) ?>" style="width:95%">
						</td>
					</tr>
					<tr>
						<th class="mu">* 순서</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_tm_seq" id="db_tm_seq" value="<?= $db_tm[tm_seq] ?>">
							<input type="text" name="tm_seq" id="tm_seq" value="<?= $db_tm[tm_seq] ?>" style="width:100px" onkeyup="checkNum(this);">
						</td>
					</tr>
					<tr>
						<th class="mu">* 이름</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							Team 공백을 원하시는경우 이름에 NULL 을 입력하시면됩니다.
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
							<tr>
								<th class="mu" width="100">영문</th>
								<td class="text_center">
									<input type="text" name="tm_name_eng" id="tm_name_eng" value="<?= print_content( "input" , $db_tm[tm_name_eng]) ?>" style="width:95%">
								</td>
								<th class="mu" width="100">국문</th>
								<td class="text_center">
									<input type="text" name="tm_name" id="tm_name" value="<?= print_content( "input" , $db_tm[tm_name]) ?>" style="width:95%">
								</td>
							</tr>
							</table>

						</td>
					</tr>
					<tr>
						<th class="mu">직책(조직, 그룹)</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
							<tr>
								<th class="mu" width="100">영문</th>
								<td class="text_center">
									<input type="text" name="tm_pos_eng" id="tm_pos_eng" value="<?= print_content( "input" , $db_tm[tm_pos_eng]) ?>" style="width:95%">
								</td>
								<th class="mu" width="100">국문</th>
								<td class="text_center">
									<input type="text" name="tm_pos" id="tm_pos" value="<?= print_content( "input" , $db_tm[tm_pos]) ?>" style="width:95%">
								</td>
							</tr>
							</table>

						</td>
					</tr>
					<tr>
						<th class="mu">직급</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
							<tr>
								<th class="mu" width="100">영문</th>
								<td class="text_center">
									<input type="text" name="tm_rnk_eng" id="tm_rnk_eng" value="<?= print_content( "input" , $db_tm[tm_rnk_eng]) ?>" style="width:95%">
								</td>
								<th class="mu" width="100">국문</th>
								<td class="text_center">
									<input type="text" name="tm_rnk" id="tm_rnk" value="<?= print_content( "input" , $db_tm[tm_rnk]) ?>" style="width:95%">
								</td>
							</tr>
							</table>

						</td>
					</tr>
					<tr>
						<th class="mu">외부 링크</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
<?
for($i=0; $i<count($arr_tm_web_tyle); $i++){
	if($i%2 == 0) echo "<tr>";

	$ele = $arr_tm_web_tyle[$i];
	$name = "tm_".$ele;
	$db_val = $db_tm[$name];
?>
								<th class="mu text_left" style="padding-left:10px" width="100">
									<img src="/images/icon/icon_<?= $ele ?>.png" align="absmiddle">
									<?= $ele ?>
								</th>
								<td class="text_center">
									<input type="text" name="tm_<?= $ele ?>" id="tm_<?= $ele ?>" value="<?= print_content( "input" , $db_val) ?>" style="width:95%">
								</td>
<?
	if($i%2 == 1) echo "</tr>";
}
?>
							</table>

						</td>
					</tr>
					<tr>
						<th class="mu">국문 소개</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<textarea name="tm_int" id="tm_int" style="width:98%; height:40px"><?= $db_tm[tm_int] ?></textarea>
						</td>
					</tr>
					<tr>
						<th class="mu">영문 소개</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<textarea name="tm_int_eng" id="tm_int_eng" style="width:98%; height:40px"><?= $db_tm[tm_int_eng] ?></textarea>
						</td>
					</tr>
					<tr>
						<th class="mu">프로필</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<p style="padding:0; margin:0;">아래 태그를 복사해서 추가 하세요.
								<xmp style="padding:0; margin:0;"> 
<li>
	<strong class="year">0000.00.00 ~ 0000.00.00</strong>
	<span class="action">내용입력</span>
</li>							
								</xmp>
							</p>
							<textarea name="tm_profile" id="tm_profile" style="width:98%; height:100px"><?= $db_tm[tm_profile] ?></textarea>
						</td>
					</tr>
					<tr>
						<th class="mu">* 리스트 사진</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_tm_list_img_pc" id="db_tm_list_img_pc" value="<?= $db_tm[tm_list_img_pc] ?>">
							<input type="file" name="tm_list_img_pc" id="tm_list_img_pc" value="" style="width:150px">
							<?
							if($db_tm[tm_list_img_pc] != ""){
							?>
								<a href="<?= $GLB_UP_FILE_URL.$db_tm[tm_list_img_pc] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_tm[tm_list_img_pc] ?>" height="50"></a>
							<?
							}
							?>
						</td>
					</tr>
					<tr>
						<th class="mu">* 상세페이지 사진</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_tm_det_img_pc" id="db_tm_det_img_pc" value="<?= $db_tm[tm_det_img_pc] ?>">
							<input type="file" name="tm_det_img_pc" id="tm_det_img_pc" value="" style="width:150px">
							<?
							if($db_tm[tm_det_img_pc] != ""){
							?>
								<a href="<?= $GLB_UP_FILE_URL.$db_tm[tm_det_img_pc] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_tm[tm_det_img_pc] ?>" height="50"></a>
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
					if($db_tm[tm_idx] != 0 ){
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
					<button type="button" class="btn btn01" onclick="goto_url('tm_list.php?<?= $GLB_RETURN_PARAM_DEC ?>');"> 리스트 </button>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<form name="imgdelfm" id="imgdelfm" method="post" action="tm_write_proc.php" target="_proc">
	<input type="hidden" name="cmd" id="cmd" value="img_del">
	<input type="hidden" name="fmi_idx" id="fmi_idx" value="">
</form>

<? include $server_root_path."/admin_mgr/inc/inc_footer.php" ?>
</body>
</html>
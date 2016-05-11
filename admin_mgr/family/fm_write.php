<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib/class/class_family.php";
include $server_root_path."/lib/class/class_family_img.php";

//-- 로그인 체크
admin_check( "menuC01" );

//-- DB 연결
set_dbcon();

//-- 데이타 가져오기
get_tb_family_rq("g");

//-- DB 데이타 가져오기
if(!eqyn($rq_fm[fm_idx], 0)){
	get_tb_family_info_001( $rq_fm[fm_idx] );
	if(!eqyn($db_fm[result_cmd], "YESDATA") || eqyn($db_fm['fm_status'], "D")){
		printmsgback("해당 정보를 찾을수 없습니다.");
	}else{
//		set_tb_family_read_cnt_proc_001( $rq_fm[fm_idx] );
	}
}else{
	$db_fm[fm_wname] = get_admin_name();
}

if(eqyn($db_fm[fm_seq], 0))
	$db_fm[fm_seq] = "";

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
<!--
$(document).ready(function(){
});

function set_gps_info(v_addr, lat, lng){
	$("#fm_gps_addr").val( v_addr );
	$("#fm_gpsx").val( lat );
	$("#fm_gpsy").val( lng );

	var v_fm_com_eng = $("#fm_com_eng").val();

	$("#ifm_map").attr("src", "/lib_map/ifm_map.php?cmd=|not_click|&info_title="+ v_fm_com_eng +"&gpsx="+ lat +"&gpsy="+ lng);
}

function regi( v_cmd ){
	var fm = document.getElementById("actfm");
	fm.cmd.value = v_cmd;

	if(v_cmd == "del"){
		if(confirm("삭제한 데이타는 복구할수 없습니다.\n삭제하시겠습니까?")){
			fm.submit();
		}
	}else{
		if(fm.fm_seq.value == ""){
			alert("순서를 숫자로 입력해주세요.");
			fm.fm_seq.focus();
			return;
		}
		if(!digitstr(fm.fm_seq.value)){
			alert("순서를 숫자로 입력해주세요.");
			fm.fm_seq.focus();
			return;
		}

		if($(":radio[name='fk_fm_mct_idx']:checked").val() == undefined){
			alert("카테고리를 선택해주세요.");
			$(":radio[name='fk_fm_mct_idx']:eq(0)").focus();
			return;
		}

		if(fm.fm_com_eng.value == ""){
			alert("업체명(영문)을 입력해주세요.");
			fm.fm_com_eng.focus();
			return;
		}
		if(fm.fm_com.value == ""){
			alert("업체명(국문)을 입력해주세요.");
			fm.fm_com.focus();
			return;
		}
		if(fm.fm_ceo.value == ""){
			alert("대표이사를 입력해주세요.");
			fm.fm_ceo.focus();
			return;
		}

		if(fm.fm_service_eng.value == ""){
			alert("서비스(영문)를 입력해주세요.");
			fm.fm_service_eng.focus();
			return;
		}
		if(fm.fm_service.value == ""){
			alert("서비스(국문)를 입력해주세요.");
			fm.fm_service.focus();
			return;
		}

		if(fm.fm_list_desc.value == ""){
			alert("리스트 약식 소개를 입력해주세요.");
			fm.fm_list_desc.focus();
			return;
		}
		if(fm.fm_svr_desc.value == ""){
			alert("서비스 약식 소개를 입력해주세요.");
			fm.fm_svr_desc.focus();
			return;
		}

		if(fm.fm_img_list_pc.value == "" && fm.db_fm_img_list_pc.value == ""){
			alert("리스트 이미지1를 선택해주세요.");
			fm.fm_img_list_pc.focus();
			return;
		}
		if(fm.fm_img_list_pc.value != ""){
			var result = upload_file_check( "image", fm.fm_img_list_pc.value);
			if(result != "Y"){
				alert( result );
				fm.fm_img_list_pc.focus();
				return;
			}
		}

		if(fm.fm_img_list_mb.value == "" && fm.db_fm_img_list_mb.value == ""){
			alert("리스트 이미지2를 선택해주세요.");
			fm.fm_img_list_mb.focus();
			return;
		}
		if(fm.fm_img_list_mb.value != ""){
			var result = upload_file_check( "image", fm.fm_img_list_mb.value);
			if(result != "Y"){
				alert( result );
				fm.fm_img_list_mb.focus();
				return;
			}
		}
		

		if(fm.fm_img_ceo_pc.value == "" && fm.db_fm_img_ceo_pc.value == ""){
			alert("대표이사 사진을 선택해주세요.");
			fm.fm_img_ceo_pc.focus();
			return;
		}
		if(fm.fm_img_ceo_pc.value != ""){
			var result = upload_file_check( "image", fm.fm_img_ceo_pc.value);
			if(result != "Y"){
				alert( result );
				fm.fm_img_ceo_pc.focus();
				return;
			}
		}

		if(fm.fm_ci_img_pc.value == "" && fm.db_fm_ci_img_pc.value == ""){
			alert("CI/BI 이미지를 선택해주세요.");
			fm.fm_ci_img_pc.focus();
			return;
		}
		if(fm.fm_ci_img_pc.value != ""){
			var result = upload_file_check( "image", fm.fm_ci_img_pc.value);
			if(result != "Y"){
				alert( result );
				fm.fm_ci_img_pc.focus();
				return;
			}
		}

		if(fm.fm_logo_img_pc.value == "" && fm.db_fm_logo_img_pc.value == ""){
			alert("로고 이미지를 선택해주세요.");
			fm.fm_logo_img_pc.focus();
			return;
		}
		if(fm.fm_logo_img_pc.value != ""){
			var result = upload_file_check( "image", fm.fm_logo_img_pc.value);
			if(result != "Y"){
				alert( result );
				fm.fm_logo_img_pc.focus();
				return;
			}
		}

/*
		for(var i=1; i<5; i++){
			var e_fmi_img_desc = document.getElementById("fmi_img_desc"+ i);

			var e_fmi_img_pc = document.getElementById("fmi_img_pc"+ i);
			var e_db_fmi_img_pc = document.getElementById("db_fmi_img_pc"+ i);

			var e_fmi_img_mb = document.getElementById("fmi_img_mb"+ i);
			var e_db_fmi_img_mb = document.getElementById("db_fmi_img_mb"+ i);

			if(e_fmi_img_pc.value != ""){
				var result = upload_file_check( "image", e_fmi_img_pc.value);
				if(result != "Y"){
					alert( result );
					e_fmi_img_pc.focus();
					return;
				}
			}
		}
*/

		fm.submit();

	}
}
function img_del( v_fmi_idx ){
	var fm = document.getElementById("imgdelfm");
	fm.fmi_idx.value = v_fmi_idx;
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
					<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />Family > 관리</td>
				</tr>
				</table>

				<form name="actfm" id="actfm" action="fm_write_proc.php" method="post" enctype="multipart/form-data" target="_proc" >
					<input type="hidden" name="cmd" id="cmd" value="">
					<input type="hidden" name="return_param" id="return_param" value="<?= $GLB_RETURN_PARAM ?>">
					<input type="hidden" name="fm_idx" id="fm_idx" value="<?= $rq_fm[fm_idx] ?>">

					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
					<? if( $rq_fm[fm_idx] != 0 ){ ?>
					<tr>
						<th class="mu">등록일</th>
						<td class="text_left" style="padding-left:5px">
							<?=$db_fm[fm_ins_datetime]?>
						</td>
						<th class="mu">수정시간</th>
						<td class="text_left" style="padding-left:5px">
							<?=$db_fm[fm_proc_datetime]?>
						</td>
					</tr>
					<tr>
						<th class="mu" width="150">조회수</th>
						<td class="text_left" style="padding-left:5px"  colspan="3">
							<?=$db_fm[fm_read_cnt]?>
						</td>
					</tr>
					<?}?>

					<tr>
					  <th class="mu" width="150">* 공개여부</th>
					  <td class="text_left" style="padding-left:5px">
						<input type="radio" name="fm_status" id="fm_statusY" value="Y" <?= checked($db_fm[fm_status], "Y") ?> ><label for="fm_statusY">공개</label>
						<input type="radio" name="fm_status" id="fm_statusH" value="H" <?= checked($db_fm[fm_status], "H") ?>><label for="fm_statusH">비공개</label>
					  </td>

						<th class="mu" width="150">작성자</th>
						<td class="text_left" style="padding-left:5px">
							<input type="text" name="fm_wname" id="fm_wname" value="<?= print_content( "input" , $db_fm[fm_wname]) ?>" style="width:95%">
						</td>
					</tr>
					<tr>
						<th class="mu">* 순서</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_fm_seq" id="db_fm_seq" value="<?= $db_fm[fm_seq] ?>">
							<input type="text" name="fm_seq" id="fm_seq" value="<?= $db_fm[fm_seq] ?>" style="width:100px" onkeyup="checkNum(this);">
						</td>
					</tr>
					<tr>
						<th class="mu">* 카테고리</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<?
							$mct_cate = "FM";
							$sql = "select * from tb_mgr_cate where mct_cate='$mct_cate' and mct_status='Y' order by mct_idx asc";
							$rs = sql_array($sql);
							foreach($rs as $ors) {
								$db_mct_idx = $ors[mct_idx];
								$db_mct_name = print_content("text", $ors[mct_name]);
							?>
								<input type="radio" name="fk_fm_mct_idx" id="fk_fm_mct_idx_<?= $db_mct_idx ?>" value="<?= $db_mct_idx ?>" <?= checked($db_fm[fk_fm_mct_idx], $db_mct_idx) ?>>
								<label for="fk_fm_mct_idx_<?= $db_mct_idx ?>"><?= $db_mct_name ?></label>
							<?
							}
							?>
						</td>
					</tr>
					<tr>
						<th class="mu">* 업체명<br>COMPANY</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
							<tr>
								<th class="mu" width="100">영문</th>
								<td class="text_center">
									<input type="text" name="fm_com_eng" id="fm_com_eng" value="<?= print_content( "input" , $db_fm[fm_com_eng]) ?>" style="width:95%">
								</td>
								<th class="mu" width="100">국문</th>
								<td class="text_center">
									<input type="text" name="fm_com" id="fm_com" value="<?= print_content( "input" , $db_fm[fm_com]) ?>" style="width:95%">
								</td>
							</tr>
							<tr>
								<th class="mu" width="100">대표이사</th>
								<td class="text_center" colspan="3">
									<input type="text" name="fm_ceo" id="fm_ceo" value="<?= print_content( "input" , $db_fm[fm_ceo]) ?>" style="width:98%">
								</td>
							</tr>
							</table>

						</td>
					</tr>
					<tr>
						<th class="mu">* 서비스<br>SERVICE</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
							<tr>
								<th class="mu" width="100">영문</th>
								<td class="text_center">
									<input type="text" name="fm_service_eng" id="fm_service_eng" value="<?= print_content( "input" , $db_fm[fm_service_eng]) ?>" style="width:95%">
								</td>
								<th class="mu" width="100">국문</th>
								<td class="text_center">
									<input type="text" name="fm_service" id="fm_service" value="<?= print_content( "input" , $db_fm[fm_service]) ?>" style="width:95%">
								</td>
							</tr>
							</table>

						</td>
					</tr>
					<tr>
						<th class="mu">외부링크</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
							<tr>
								<th class="mu" width="100">대표사이트</th>
								<td class="text_left">
									<input type="radio" name="fm_home_url_type" id="fm_home_url_typeL" value="L" <?= checked($db_fm[fm_home_url_type], "L") ?>>
									<label for="fm_home_url_typeL">View Website</label>
									<input type="radio" name="fm_home_url_type" id="fm_home_url_typeD" value="D" <?= checked($db_fm[fm_home_url_type], "D") ?>>
									<label for="fm_home_url_typeD">Download</label>
									<input type="text" name="fm_home_url" id="fm_home_url" value="<?= print_content( "input" , $db_fm[fm_home_url]) ?>" style="width:98%">
								</td>
							</tr>
							<tr class="hide">
								<th class="mu" width="100">대표메일</th>
								<td class="text_center">
									<input type="text" name="fm_email" id="fm_email" value="<?= print_content( "input" , $db_fm[fm_email]) ?>" style="width:98%">
								</td>
							</tr>
							<tr>
								<th class="mu" width="100">브랜드사이트</th>
								<td class="text_left">
									<input type="radio" name="fm_brand_url_type" id="fm_brand_url_typeL" value="L" <?= checked($db_fm[fm_brand_url_type], "L") ?>>
									<label for="fm_brand_url_typeL">View Website</label>
									<input type="radio" name="fm_brand_url_type" id="fm_brand_url_typeD" value="D" <?= checked($db_fm[fm_brand_url_type], "D") ?>>
									<label for="fm_brand_url_typeD">Download</label>
									<input type="text" name="fm_brand_url" id="fm_brand_url" value="<?= print_content( "input" , $db_fm[fm_brand_url]) ?>" style="width:98%">
								</td>
							</tr>
							</table>

						</td>
					</tr>
					<tr>
						<th class="mu">국문 회사소개</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<textarea name="fm_com_int" id="fm_com_int" style="width:98%; height:80px"><?= $db_fm[fm_com_int] ?></textarea>
						</td>
					</tr>
					<tr>
						<th class="mu">영문 회사소개</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<textarea name="fm_com_int_eng" id="fm_com_int_eng" style="width:98%; height:80px"><?= $db_fm[fm_com_int_eng] ?></textarea>
						</td>
					</tr>
					<tr>
						<th class="mu">국문 서비스소개</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<textarea name="fm_svr_int" id="fm_svr_int" style="width:98%; height:80px"><?= $db_fm[fm_svr_int] ?></textarea>
						</td>
					</tr>
					<tr class="hide">
						<th class="mu">영문 서비스소개</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<textarea name="fm_svr_int_eng" id="fm_svr_int_eng" style="width:98%; height:80px"><?= $db_fm[fm_svr_int_eng] ?></textarea>
						</td>
					</tr>
					<tr>
						<th class="mu">* 리스트 약식 소개<br>PC</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<textarea name="fm_list_desc" id="fm_list_desc" style="width:98%; height:40px"><?= $db_fm[fm_list_desc] ?></textarea>
						</td>
					</tr>
					<tr>
						<th class="mu">* 서비스 약식 소개<br>(상세페이지)<br>PC&Mobile</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<textarea name="fm_svr_desc" id="fm_svr_desc" style="width:98%; height:40px"><?= $db_fm[fm_svr_desc] ?></textarea>
						</td>
					</tr>
					<tr>
						<th class="mu">주소</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
							<tr>
								<th class="mu" width="150">주소</th>
								<td class="text_left" style="padding-left:5px">
									<input type="text" name="fm_addr" id="fm_addr" value="<?= print_content( "input" , $db_fm[fm_addr]) ?>" style="width:98%">
								</td>
							</tr>
							<tr>
								<th class="mu">지도 검색용 주소</th>
								<td class="text_left" style="padding-left:5px">
									<input type="text" name="fm_gps_addr" id="fm_gps_addr" value="<?= print_content( "input" , $db_fm[fm_gps_addr]) ?>" style="width:98%">

									<button type="button" class="btn btn02" onclick="window.open('/lib_map/ifm_map.php?cmd=|search|', 'mapsearch', 'width=800, height=600');"> 지도 검색</button>
								</td>
							</tr>
							<tr>
								<th class="mu">GPS좌표</th>
								<td class="text_left" style="padding-left:5px">
									<input type="text" name="fm_gpsx" id="fm_gpsx" value="<?= $db_fm[fm_gpsx] ?>" style="width:150px">
									<input type="text" name="fm_gpsy" id="fm_gpsy" value="<?= $db_fm[fm_gpsy] ?>" style="width:150px">
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th class="mu">지도</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<iframe src="/lib_map/ifm_map.php?cmd=|not_click|&info_title=<?= $db_fm[fm_com_eng] ?>&gpsx=<?= $db_fm[fm_gpsx] ?>&gpsy=<?= $db_fm[fm_gpsy] ?>" id="ifm_map" border="0" frameborder="0" width="100%" height="250"></iframe>
						</td>
					</tr>
					<tr>
						<th class="mu">* 리스트 이미지</th>
						<td class="text_left" style="padding-left:5px" colspan="3">

							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
							<tr>
								<th class="mu" width="150">이미지1</th>
								<td class="text_left" style="padding-left:5px">
									<input type="hidden" name="db_fm_img_list_pc" id="db_fm_img_list_pc" value="<?= $db_fm[fm_img_list_pc] ?>">
									<input type="file" name="fm_img_list_pc" id="fm_img_list_pc" value="" style="width:150px">
									<?
									if($db_fm[fm_img_list_pc] != ""){
									?>
										<a href="<?= $GLB_UP_FILE_URL.$db_fm[fm_img_list_pc] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_fm[fm_img_list_pc] ?>" height="50"></a>
									<?
									}
									?>
								</td>
							</tr>
							<tr>
								<th class="mu">이미지2</th>
								<td class="text_left" style="padding-left:5px" colspan="3">
									<input type="hidden" name="db_fm_img_list_mb" id="db_fm_img_list_mb" value="<?= $db_fm[fm_img_list_mb] ?>">
									<input type="file" name="fm_img_list_mb" id="fm_img_list_mb" value="" style="width:150px">
									<?
									if($db_fm[fm_img_list_mb] != ""){
									?>
										<a href="<?= $GLB_UP_FILE_URL.$db_fm[fm_img_list_mb] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_fm[fm_img_list_mb] ?>" height="50"></a>
									<?
									}
									?>
								</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th class="mu">* 대표이사 사진</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_fm_img_ceo_pc" id="db_fm_img_ceo_pc" value="<?= $db_fm[fm_img_ceo_pc] ?>">
							<input type="file" name="fm_img_ceo_pc" id="fm_img_ceo_pc" value="" style="width:150px">
							<?
							if($db_fm[fm_img_ceo_pc] != ""){
							?>
								<a href="<?= $GLB_UP_FILE_URL.$db_fm[fm_img_ceo_pc] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_fm[fm_img_ceo_pc] ?>" height="50"></a>
							<?
							}
							?>
						</td>
					</tr>
					<tr>
						<th class="mu">* CI/BI 이미지</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_fm_ci_img_pc" id="db_fm_ci_img_pc" value="<?= $db_fm[fm_ci_img_pc] ?>">
							<input type="file" name="fm_ci_img_pc" id="fm_ci_img_pc" value="" style="width:150px">
							<?
							if($db_fm[fm_ci_img_pc] != ""){
							?>
								<a href="<?= $GLB_UP_FILE_URL.$db_fm[fm_ci_img_pc] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_fm[fm_ci_img_pc] ?>" height="50"></a>
							<?
							}
							?>
						</td>
					</tr>
					<tr>
						<th class="mu">* 로고 이미지</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_fm_logo_img_pc" id="db_fm_logo_img_pc" value="<?= $db_fm[fm_logo_img_pc] ?>">
							<input type="file" name="fm_logo_img_pc" id="fm_logo_img_pc" value="" style="width:150px">
							<?
							if($db_fm[fm_logo_img_pc] != ""){
							?>
								<a href="<?= $GLB_UP_FILE_URL.$db_fm[fm_logo_img_pc] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_fm[fm_logo_img_pc] ?>" height="50"></a>
							<?
							}
							?>
						</td>
					</tr>


<?
//-- 업로드 경로
get_updir( "family_img" );


$rs = get_tb_family_img_list_001($rq_fm[fm_idx]);
$NUM = 1;
if($rs){
	foreach($rs as $ors){
		$db_fmi_idx = $ors[fmi_idx];
		$db_fmi_img_desc = print_content( "input", $ors[fmi_img_desc]);
		$db_fmi_img_pc = $ors[fmi_img_pc];
		$db_fmi_img_mb = $ors[fmi_img_mb];
?>
					<tr class="hide">
						<th class="mu">
							대표 이미지<?= $NUM ?>
							<br><button type="button" class="btn btn05" onclick="img_del(<?= $db_fmi_idx ?>);"> 삭 제 </button>
						</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
							<tr>
								<th class="mu" width="150">이미지 설명</th>
								<td class="text_left" style="padding-left:5px">
									<input type="hidden" name="fmi_idx<?= $NUM ?>" id="fmi_idx<?= $NUM ?>" value="<?= $db_fmi_idx ?>">
									<input type="text" name="fmi_img_desc<?= $NUM ?>" id="fmi_img_desc<?= $NUM ?>" value="<?= print_content( "input" , $db_fmi_img_desc ) ?>" style="width:98%">
								</td>
							</tr>
							<tr>
								<th class="mu">PC</th>
								<td class="text_left" style="padding-left:5px">
									<input type="hidden" name="db_fmi_img_pc<?= $NUM ?>" id="db_fmi_img_pc<?= $NUM ?>" value="<?= $db_fmi_img_pc ?>">
									<input type="file" name="fmi_img_pc<?= $NUM ?>" id="fmi_img_pc<?= $NUM ?>" value="" style="width:150px">
									<?
									if($db_fmi_img_pc != ""){
									?>
										<a href="<?= $GLB_UP_FILE_URL.$db_fmi_img_pc ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_fmi_img_pc ?>" height="50"></a>
									<?
									}
									?>
								</td>
							</tr>
							<tr>
								<th class="mu">Mobile</th>
								<td class="text_left" style="padding-left:5px">
									<input type="hidden" name="db_fmi_img_mb<?= $NUM ?>" id="db_fmi_img_mb<?= $NUM ?>" value="<?= $db_fmi_img_mb ?>">
									<input type="file" name="fmi_img_mb<?= $NUM ?>" id="fmi_img_mb<?= $NUM ?>" value="" style="width:150px">
									<?
									if($db_fmi_img_mb != ""){
									?>
										<a href="<?= $GLB_UP_FILE_URL.$db_fmi_img_mb ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_fmi_img_mb ?>" height="50"></a>
									<?
									}
									?>
								</td>
							</tr>
							</table>
						</td>
					</tr>
<?
		$NUM++;
	}
}

$i = $NUM;
for($NUM=$i; $NUM<=4; $NUM++){
	$db_fmi_idx = 0;
	$db_fmi_img_desc = "";
	$db_fmi_img_pc = "";
	$db_fmi_img_mb = "";
?>
					<tr class="hide">
						<th class="mu">대표 이미지<?= $NUM ?></th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_table">
							<tr>
								<th class="mu" width="150">이미지 설명</th>
								<td class="text_left" style="padding-left:5px">
									<input type="hidden" name="fmi_idx<?= $NUM ?>" id="fmi_idx<?= $NUM ?>" value="<?= $db_fmi_idx ?>">
									<input type="text" name="fmi_img_desc<?= $NUM ?>" id="fmi_img_desc<?= $NUM ?>" value="<?= print_content( "input" , $db_fmi_img_desc ) ?>" style="width:98%">
								</td>
							</tr>
							<tr>
								<th class="mu" width="150">PC</th>
								<td class="text_left" style="padding-left:5px">
									<input type="hidden" name="db_fmi_img_pc<?= $NUM ?>" id="db_fmi_img_pc<?= $NUM ?>" value="<?= $db_fmi_img_pc ?>">
									<input type="file" name="fmi_img_pc<?= $NUM ?>" id="fmi_img_pc<?= $NUM ?>" value="" style="width:150px">
									<?
									if($db_fmi_img_pc != ""){
									?>
										<a href="<?= $GLB_UP_FILE_URL.$db_fmi_img_pc ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_fmi_img_pc ?>" height="50"></a>
									<?
									}
									?>
								</td>
							</tr>
							<tr>
								<th class="mu">Mobile</th>
								<td class="text_left" style="padding-left:5px">
									<input type="hidden" name="db_fmi_img_mb<?= $NUM ?>" id="db_fmi_img_mb<?= $NUM ?>" value="<?= $db_fmi_img_mb ?>">
									<input type="file" name="fmi_img_mb<?= $NUM ?>" id="fmi_img_mb<?= $NUM ?>" value="" style="width:150px">
									<?
									if($db_fmi_img_mb != ""){
									?>
										<a href="<?= $GLB_UP_FILE_URL.$db_fmi_img_mb ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_fmi_img_mb ?>" height="50"></a>
									<?
									}
									?>
								</td>
							</tr>
							</table>
						</td>
					</tr>
<?
}
?>
					</table>
				</form>

	
				<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td align="right">
					<?
					if($db_fm[fm_idx] != 0 ){
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
					<button type="button" class="btn btn01" onclick="goto_url('fm_list.php?<?= $GLB_RETURN_PARAM_DEC ?>');"> 리스트 </button>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<form name="imgdelfm" id="imgdelfm" method="post" action="fm_write_proc.php" target="_proc">
	<input type="hidden" name="cmd" id="cmd" value="img_del">
	<input type="hidden" name="fmi_idx" id="fmi_idx" value="">
</form>

<? include $server_root_path."/admin_mgr/inc/inc_footer.php" ?>
</body>
</html>
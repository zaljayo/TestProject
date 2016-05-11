<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php";
include $server_root_path."/lib_editor/lib_editor.php";
include $server_root_path."/lib/class/class_ins_news.php";
include $server_root_path."/lib/class/class_mgr_cate.php";

include $server_root_path."/lib/class/class_team.php";
include $server_root_path."/lib/class/class_family.php";

//-- 로그인 체크
admin_check( "menuE01" );

//-- DB 연결
set_dbcon();

//-- 데이타 가져오기
get_tb_ins_news_rq("g");

//-- DB 데이타 가져오기
if(!eqyn($rq_inw[inw_idx], 0)){
	get_tb_ins_news_info_001( $rq_inw[inw_idx] );
	if(!eqyn($db_inw[result_cmd], "YESDATA") || eqyn($db_inw['inw_status'], "D")){
		printmsgback("해당 정보를 찾을수 없습니다.");
	}else{
//		set_tb_ins_news_read_cnt_proc_001( $rq_inw[inw_idx] );
	}
}else{
	$db_inw[inw_wname] = get_admin_name();
}

//-- 업로드 경로
get_updir( "ins_news" );
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
var fn_mct_cate_print = function( val, result ){
//	console.log(result);
	data = JSON.parse(result);
	var v_html = "";
	var v_mct_idx = 0;
	var v_mct_name = "";

	for(var i=0; i<data.length; i++){
		v_mct_idx = data[i].mct_idx;
		v_mct_name = data[i].mct_name;
		v_html += "<input type='radio' name='fk_inw_mct_idx' id='fk_inw_mct_idx"+ v_mct_idx +"' value='"+ v_mct_idx +"'";
		if(val == v_mct_idx){
			v_html += " checked";
		}
		v_html +="><label for='fk_inw_mct_idx"+ v_mct_idx +"'>"+ v_mct_name +"</label>";
	}

	$("#td_fk_inw_mct_idx").html( v_html );
}

$(document).ready(function(){
	chg_fk_inw_mct_cate('fk_inw_mct_cate', '<?= $db_inw["fk_inw_mct_idx"] ?>', fn_mct_cate_print);

	var inw_ins_datetime = $('#inw_ins_datetime').val();
    $('#inw_ins_datetime').datepicker({
        dateFormat: 'yy-mm-dd',
		monthNamesShort: v_monthNamesShort, 
		dayNamesMin: v_dayNamesMin,
		changeYear: true,
		changeMonth: true,
        onSelect: function (dateText, inst) {
        }
    });
    $('#img_inw_ins_datetime').click(function() {$('#inw_ins_datetime').focus();});
});

function init(){
	$(".cmd_upt").attr("onclick", "regi('upt');");
	$(".cmd_del").attr("onclick", "regi('del');");
	$(".cmd_ins").attr("onclick", "regi('ins');");
}


function regi( v_cmd ){
	var fm = document.getElementById("actfm");
	fm.cmd.value = v_cmd;

	if(v_cmd == "del"){
		if(confirm("삭제한 데이타는 복구할수 없습니다.\n삭제하시겠습니까?")){
			fm.submit();
		}
	}else{

		if(fm.inw_title.value == ""){
			alert("제목을 입력해주세요.");
			fm.inw_title.focus();
			return;
		}

		if(fm.fk_inw_mct_cate.value == ""){
			alert("구분을 선택해주세요.");
			fm.fk_inw_mct_cate.focus();
			return;
		}

		if($(":radio[name='fk_inw_mct_idx']:checked").val() == undefined){
			alert("카테고리를 선택해주세요.");
			$(":radio[name='fk_inw_mct_idx']:eq(0)").focus();
			return;
		}

		if(fm.inw_img_list.value == "" && fm.db_inw_img_list.value == ""){
			alert("리스트 이미지를 선택해주세요.");
			fm.inw_img_list.focus();
			return;
		}
		if(fm.inw_img_list.value != ""){
			var result = upload_file_check( "image", fm.inw_img_list.value);
			if(result != "Y"){
				alert( result );
				fm.inw_img_list.focus();
				return;
			}
		}

		if(fm.inw_img_list_desc.value == ""){
			alert("요약 설명을 입력해주세요.");
			fm.inw_img_list_desc.focus();
			return;
		}

		fm.inw_content.value = editor_ifrm_inw_content.get_editor_contents();
		if(!editor_ifrm_inw_content.get_editor_contents_status()){
			alert("내용을 입력해주세요.");
			editor_ifrm_inw_content.editor_focus();
			return;
		}


		fm.submit();

	}
}

function del_team( idx ){
	$("#span_team"+ idx).remove();
}
function set_team( idx, name ){
//	console.log( idx +" == "+ name );
	var ins_yn = true;
	for(var i=0; i<document.getElementsByName("tm_idx[]").length; i++){
//		console.log(document.getElementsByName("tm_idx[]")[i].value +" == "+ idx)
		if(document.getElementsByName("tm_idx[]")[i].value == idx){
			ins_yn = false;
			break;
		}
	}

	if(ins_yn){
		var v_html = "<span id='span_team"+ idx +"'>"
		v_html += " <a href='javascript:del_team("+ idx +");'><img src='../images/btn/delete_02.gif' align='absmiddle'></a>";
		v_html += "<input type='hidden' name='tm_idx[]' value='"+ idx +"'> "+ name +"<br></span>";
		$("#div_tm_name").append( v_html );
	}else{
		alert("이미 입력된 정보입니다.");
	}
}
function search_team(){
	window.open("search_team.php", "searchteam", "width=600, height=500;")
}


function del_family( idx ){
	$("#span_family"+ idx).remove();
}
function set_family( idx, name ){
//	alert( idx +" == "+ name );
	var ins_yn = true;
	for(var i=0; i<document.getElementsByName("fm_idx[]").length; i++){
		if(document.getElementsByName("fm_idx[]")[i].value == idx){
			ins_yn = false;
			break;
		}
	}

	if(ins_yn){
		var v_html = "<span id='span_family"+ idx +"'>"
		v_html += " <a href='javascript:del_family("+ idx +");'><img src='../images/btn/delete_02.gif' align='absmiddle'></a>";
		v_html += "<input type='hidden' name='fm_idx[]' value='"+ idx +"'> "+ name +"<br></span>";
		$("#div_fm_title").append( v_html );
	}else{
		alert("이미 입력된 정보입니다.");
	}
}
function search_family(){
	window.open("search_family.php", "searchfamily", "width=900, height=500;")
}
//-->
</script>
</head>

<body onload="init();">
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
					<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />Insight & News > 관리</td>
				</tr>
				</table>

				<form name="actfm" id="actfm" action="inw_write_proc.php" method="post" enctype="multipart/form-data" target="_proc" >
					<input type="hidden" name="cmd" id="cmd" value="">
					<input type="hidden" name="return_param" id="return_param" value="<?= $GLB_RETURN_PARAM ?>">
					<input type="hidden" name="inw_idx" id="inw_idx" value="<?= $rq_inw[inw_idx] ?>">

					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
					<? if( $rq_inw[inw_idx] != 0 ){ ?>
					<tr>
						<th class="mu">등록일</th>
						<td class="text_left" style="padding-left:5px">
							<input type="text" name="inw_ins_datetime" id="inw_ins_datetime" value='<?= substr($db_inw[inw_ins_datetime],0, 10) ?>' size="11" readonly="readonly"/>
							<img src="../images/icn_calendal.gif" id="inw_ins_datetime" align="absmiddle">
						</td>
						<th class="mu">수정시간</th>
						<td class="text_left" style="padding-left:5px">
							<?=$db_inw[inw_proc_datetime]?>
						</td>
					</tr>
					<tr>
						<th class="mu" width="150">조회수</th>
						<td class="text_left" style="padding-left:5px"  colspan="3">
							<?=$db_inw[inw_read_cnt]?>
						</td>
					</tr>
					<?} else{
					?>
					<tr>
						<th class="mu">등록일</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="text" name="inw_ins_datetime" id="inw_ins_datetime" value='<?= substr($db_inw[inw_ins_datetime],0, 10) ?>' size="11" readonly="readonly"/>
							<img src="../images/icn_calendal.gif" id="inw_ins_datetime" align="absmiddle">
						</td>
					</tr>
					<?
					}?>

					<tr>
					  <th class="mu" width="150">* 공개여부</th>
					  <td class="text_left" style="padding-left:5px">
						<input type="radio" name="inw_status" id="inw_statusY" value="Y" <?= checked($db_inw[inw_status], "Y") ?> ><label for="inw_statusY">공개</label>
						<input type="radio" name="inw_status" id="inw_statusH" value="H" <?= checked($db_inw[inw_status], "H") ?>><label for="inw_statusH">비공개</label>
					  </td>

						<th class="mu" width="150">작성자</th>
						<td class="text_left" style="padding-left:5px">
							<input type="text" name="inw_wname" id="inw_wname" value="<?= print_content( "input" , $db_inw[inw_wname]) ?>" style="width:95%">
						</td>
					</tr>
					<tr>
						<th class="mu">* 제목</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="text" name="inw_title" id="inw_title" value="<?= print_content( "input" , $db_inw[inw_title]) ?>" style="width:98%">
						</td>
					</tr>
					<tr>
						<th class="mu">* 구분</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<select name="fk_inw_mct_cate" id="fk_inw_mct_cate" onchange="chg_fk_inw_mct_cate('fk_inw_mct_cate', '<?= $db_inw["fk_inw_mct_idx"] ?>', fn_mct_cate_print);">
								<option value="">- 선택 -</option>
								<?
								$var = array_keys($arr_mct_cate);
								for($i=1; $i<=2; $i++){
									$key = $var[$i];
								?>
									<option value="<?= $key ?>" <?= selected($key, $db_inw["fk_inw_mct_cate"]) ?>>
										<?= $arr_mct_cate[$key] ?>
									</option>
								<?
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th class="mu" width="150">* 카테고리</th>
						<td class="text_left" style="padding-left:5px" colspan="3" id="td_fk_inw_mct_idx">
						</td>
					</tr>
					<tr>
						<th class="mu">Team 관련 글</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<span id="span_fk_inw_tm_idx"></span>
							<button type="button" class="btn btn04" onclick="search_team();"> 관련글 검색</button>
							<div id="div_tm_name">

<?
$arr_tm_idx = explode (",", $db_inw[fk_inw_tm_idx]);
for($i=0; $i<count($arr_tm_idx); $i++){
	get_tb_team_info_001( $arr_tm_idx[$i] );
	if(eqyn($db_tm[result_cmd], "YESDATA") && eqyn($db_tm['tm_status'], "Y")){
?>
		<span id='span_team<?= $db_tm['tm_idx'] ?>'>
			<a href='javascript:del_team(<?= $db_tm['tm_idx'] ?>);'><img src='../images/btn/delete_02.gif' align='absmiddle'></a>
			<input type='hidden' name='tm_idx[]' value='<?= $db_tm['tm_idx'] ?>'><?= $db_tm['tm_name'] ?><br>
		</span>
<?
	}
}
?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="mu">Family 관련 글</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<span id="span_fk_inw_fm_idx"></span>
							<button type="button" class="btn btn04" onclick="search_family();"> 관련글 검색</button>
							<div id="div_fm_title" style="padding:5px">
<?
$arr_fm_idx = explode (",", $db_inw[fk_inw_fm_idx]);
for($i=0; $i<count($arr_fm_idx); $i++){
	get_tb_family_info_001( $arr_fm_idx[$i] );
	if(eqyn($db_fm[result_cmd], "YESDATA") && eqyn($db_fm['fm_status'], "Y")){
?>
		<span id='span_family<?= $db_fm['fm_idx'] ?>'>
			<a href='javascript:del_family(<?= $db_fm['fm_idx'] ?>);'><img src='../images/btn/delete_02.gif' align='absmiddle'></a>
			<input type='hidden' name='fm_idx[]' value='<?= $db_fm['fm_idx'] ?>'><?= $db_fm['fm_com'] ?><br>
		</span>
<?
	}
}
?>
							</div>
						</td>
					</tr>
					<tr>
						<th class="mu">태그</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_inw_tag" id="db_inw_tag" value="<?= print_content( "input" , $db_inw[inw_tag]) ?>">
							<input type="text" name="inw_tag" id="inw_tag" value="<?= print_content( "input" , $db_inw[inw_tag]) ?>" style="width:98%"><br>
							여러 개의 태그를 등록 할 경우 ,(쉼표)로 구분해서 작성하세요. 예) 뉴스, 펀드, 게임
						</td>
					</tr>
					<tr>
						<th class="mu">* 리스트 이미지</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="hidden" name="db_inw_img_list" id="db_inw_img_list" value="<?= $db_inw[inw_img_list] ?>">
							<input type="file" name="inw_img_list" id="inw_img_list" value="" style="width:150px">
							<?
							if($db_inw[inw_img_list] != ""){
							?>
								<a href="<?= $GLB_UP_FILE_URL.$db_inw[inw_img_list] ?>" target="_blank"><img src="<?= $GLB_UP_FILE_URL.$db_inw[inw_img_list] ?>" height="50"></a>
							<?
							}
							?>
						</td>
					</tr>
					<tr>
						<th class="mu">* 내용 요약</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
							<input type="text" name="inw_img_list_desc" id="inw_img_list_desc" value="<?= print_content( "input" , $db_inw[inw_img_list_desc]) ?>" style="width:98%">
						</td>
					</tr>
					<tr>
						<th class="mu">* 내용</th>
						<td class="text_left" style="padding-left:5px" colspan="3">
<?
/*
#####################################################
## 에디터 셋팅 정보 START ###########################
#####################################################
*/
$editor_board_idx	= $rq_inw[inw_idx];			//-- 게시글 key
$editor_form_name	= "actfm";					//-- form 이름
$editor_ele_name	= "inw_content";			//-- editor element name

$editor_ele_val		= $db_inw['inw_content'];			//-- editor element value
$editor_ele_val		= print_content( "editor", $editor_ele_val);

$editor_height		= "300";					//-- editor height

$editor_ifm_name	= "editor_ifrm_". $editor_ele_name;	//-- iframe 이름
$editor_upload_key	= "ins_news_editor";					//-- 에디터 업로드 파일 경로 key
/*
#####################################################
## 에디터 셋팅 정보 END #############################
#####################################################
*/
?>
						<span id="span_<?= $editor_upload_key ?>_image"></span>
						<span id="span_<?= $editor_upload_key ?>_file"></span>
						<input type="hidden" name="editor_file_kind" id="editor_file_kind" value='<?= $editor_file_kind ?>'>
						<input type="hidden" name="editor_upload_key" id="editor_upload_key" value='<?= $editor_upload_key ?>'>
						<textarea name="<?= $editor_ele_name ?>" id="<?= $editor_ele_name ?>" style="display: none;"><?= $editor_ele_val ?></textarea>
						<iframe name="<?= $editor_ifm_name ?>" id="<?= $editor_ifm_name ?>" src="/lib_editor/editor_ifm.php?editor_board_idx=<?= $editor_board_idx ?>&editor_ifm_name=<?= $editor_ifm_name ?>&editor_form_name=<?= $editor_form_name ?>&editor_ele_name=<?= $editor_ele_name ?>&editor_height=<?= $editor_height ?>&editor_file_kind=<?= $editor_file_kind ?>&editor_upload_key=<?= $editor_upload_key ?>" style="width: 100%; height: 380px;" frameborder="0" scrolling="no"></iframe>
						</td>
					</tr>
					</table>
				</form>

	
				<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td align="right">
					<?
					if($db_inw[inw_idx] != 0 ){
					?>
						<button type="button" class="btn btn02 cmd_upt" onclick="alert('로딩중입니다. 잠시만 기다려 주세요.');"> 수 정</button>
						<button type="button" class="btn btn05 cmd_del" onclick="alert('로딩중입니다. 잠시만 기다려 주세요.');"> 삭 제 </button>
					<?
					}else{
					?>
						<button type="button" class="btn btn02 cmd_ins" onclick="alert('로딩중입니다. 잠시만 기다려 주세요.');"> 등 록</button>
					<?
					}	
					?>
					<button type="button" class="btn btn01" onclick="goto_url('inw_list.php?<?= $GLB_RETURN_PARAM_DEC ?>');"> 리스트 </button>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<form name="imgdelfm" id="imgdelfm" method="post" action="inw_write_proc.php" target="_proc">
	<input type="hidden" name="cmd" id="cmd" value="img_del">
	<input type="hidden" name="fmi_idx" id="fmi_idx" value="">
</form>

<? include $server_root_path."/admin_mgr/inc/inc_footer.php" ?>
</body>
</html>
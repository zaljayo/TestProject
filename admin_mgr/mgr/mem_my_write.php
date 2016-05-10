<? include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php" ?>
<?
//-- 로그인 체크
admin_check( "menuZ01" );

//-- DB 연결
set_dbcon();


//-- 데이타 가져오기
get_tb_admin_mem_rq("g");

$am_userid = get_admin();

if(!eqyn($am_userid, "")){
	get_tb_admin_mem_info_001( $am_userid );

	if(eqyn($db_am[result_cmd], "NODATA")){
		printmsgback("해당 정보를 찾을수 없습니다.");
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>- 관리자 -</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<? include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_header.php" ?>
<script type="text/javascript" link src="/js/string.js"></script>
<script type="text/javascript">
<!--
function regi( v_cmd ){
	var fm = document.getElementById("actfm");
	fm.cmd.value = v_cmd;
	if(v_cmd == "del"){
		if(confirm("삭제한 데이타는 복구할수 없습니다.\n삭제하시겠습니까?")){
			fm.submit();
		}
	}else{
		if(!fm.am_kindA.checked && !fm.am_kindM.checked){
			alert("관리자 구분을 선택해주세요.");
			fm.am_kindM.focus();
			return;		
		}

		if(!chk_am_userid()){
			return;
		}

		if(v_cmd == "ins" || fm.am_pwd.value != ""){
			if(!chk_am_pwd()){
				return;
			}
		}

		if(fm.am_name.value == ""){
			alert("이름을 입력해주세요.");
			fm.am_name.focus();
			return;		
		}

/*
		if(fm.am_email.value == "" || !isEmailstr(fm.am_email.value)){
			alert("메일주소를 정확히 입력해주세요.");
			fm.am_email.focus();
			return;		
		}

		if(fm.am_tel.value == "" && fm.am_hp.value == ""){
			alert("연락처는 1개이상 입력해주세요.");
			return;		
		}
*/
		if(!fm.am_statusY.checked && !fm.am_statusS.checked){
			alert("상태를 선택해주세요.");
			fm.am_statusY.focus();
			return;		
		}
	}

	fm.submit();
}

function chk_am_userid(){
	var fm = document.getElementById("actfm");

	if(fm.am_userid.value == ""){
		alert("아이디는 영문 또는 숫자로 4~12자로 입력해주세요.");
		fm.am_userid.focus();
		return false;
	}

	if(fm.am_userid.value.length <4 || fm.am_userid.value.length >12){
		alert("아이디는 영문 또는 숫자로 4~12자로 입력해주세요.");
		fm.am_userid.focus();
		return false;
	}

	if(!alphadigitstr(fm.am_userid.value)){
		alert("아이디는 영문 또는 숫자로 4~12자로 입력해주세요.");
		fm.am_userid.focus();
		return false;
	}
	return true;
}

function chk_am_pwd(){
	var fm = document.getElementById("actfm");
	if(!check_str_num(fm.am_pwd.value, 4, 20)){
		alert("비밀번호는 영문+숫자의 조합으로 4~12자로 입력해주세요.");
		fm.am_pwd.focus();
		return false;
	}
	return true;
}

function use_am_userid(){
	var fm = document.getElementById("actfm");
	if(!chk_am_userid()){
		return;
	}else{
		_proc.location.href = "mem_id_check.php?am_userid="+ fm.am_userid.value;
	}
}
function return_am_userid(val){
	var fm = document.getElementById("actfm");
	if(val == "NODATA"){
		alert("사용하실수 있는 아이디 입니다.");
	}else{
		alert("사용하실수 없는 아이디 입니다.\n다시 입력해주세요.");
		fm.am_userid.value = "";
		fm.am_userid.focus();
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
			<td width="175" colspan="2"  align="center"><? include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_logo.php" ?></td>
			<td style="padding-right:20px;"><? include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top.php" ?></td>
		</tr>
		<tr>
			<td height="1" colspan="3" bgcolor="#c4c4c4"></td>
		</tr>
		<tr>
			<td width="180" valign="top" style="padding-left:20px;padding-bottom:200px;"><? include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_menu.php" ?></td>
			<td width="1" bgcolor="#c4c4c4"></td>
			<td valign="top" style="padding:10px 15px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td colspan="2" align="left" class="title"><img src="../images/icon/bullet.gif" align="absmiddle" />개인정보 수정</td>
				  </tr>
				</table>
				<form name="actfm" id="actfm"method="post" action="mem_proc.php" target="_proc">
					<input type="hidden" name="cmd" id="cmd" value="<?= $cmd ?>">
					<input type="hidden" name="pre_cmd" id="pre_cmd" value="my">
					<input type="hidden" name="return_param" id="return_param" value="<?= $GLB_RETURN_PARAM_DEC ?>">
					<input type="hidden" name="am_idx" id="pre_cmd" value="<?= $db_am[am_idx] ?>">				
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
					<tr style="display: none;">
						<th width="100" class="mu">* 관리자 구분</th>
						<td class="text_left" style="padding-left:5px">
							<input type="radio" name="am_kind" id="am_kindA" value="A" <?= checked( $db_am[am_kind], "A") ?>>
							<label for="am_kindA">슈퍼마스터</label>

							<input type="radio" name="am_kind" id="am_kindM" value="M" <?= checked( $db_am[am_kind], "M") ?>>
							<label for="am_kindM">마스터</label>
						</td>
					</tr>
					<tr>
						<th width="100" class="mu">* 아이디</th>
						<td class="text_left" style="padding-left:5px">
							<?
							if(eqyn($am_userid, "")){
							?>
								<input type="text" name="am_userid" id="am_userid" class="input_01 input_h20" value="">
								<button type="button" class="btn btn04" onclick="use_am_userid();"> 중복 검사 </button>
								<br>* 영문 또는 숫자로 4~12자로 입력
							<?
							}else{
							?>
								<?= $db_am[am_userid] ?>
								<input type="hidden" name="am_userid" id="am_userid" class="input_01 input_h20" value="<?= $db_am[am_userid] ?>">
							<?
							}
							?>
						</td>
					</tr>
					<tr>
						<th width="100" class="mu">* 비밀번호</th>
						<td class="text_left" style="padding-left:5px">
							<input name="am_pwd" type="password" class="input_01 input_h20" id="am_pwd">
							<br>* 영문+숫자의 조합으로 4~12자로 입력해 주세요

							<?
							if(!eqyn($am_userid, "")){
								echo "<br><b style='color:red;'>* 수정이 필요한 경우 입력해주세요.</b>";
							}
							?>
						</td>
					</tr>
					<tr>
						<th class="mu">* 이름</th>
						<td class="text_left" style="padding-left:5px">
							<input name="am_name" type="text" class="input_01 input_h20" id="am_name" value="<?= $db_am[am_name] ?>">
						</td>
					</tr>
					<tr>
					<th class="mu">이메일</th>
						<td class="text_left" style="padding-left:5px">
							<input name="am_email" type="text" class="input_01 input_h20" id="am_email" value="<?= $db_am[am_email] ?>">
						</td>
					</tr>
					<tr>
						<th class="mu">연락처</th>
						<td class="text_left" style="padding-left:5px">
							<input name="am_tel" type="text" class="input_01 input_h20" id="am_tel" value="<?= $db_am[am_tel] ?>">
						</td>
					</tr>
					<tr>
					<th class="mu"> 메모</th>
						<td class="text_left" style="padding-left:5px">
							<input name="am_memo" type="text" class="input_01 input_h20" id="am_memo" style="width:90%" maxlength="100" value="<?= $db_am[am_memo] ?>">
						</td>
					</tr>
					<tr style="">
						<th class="mu">* 상태</th>
						<td class="text_left" style="padding-left:5px">
							<input type="radio" name="am_status" id="am_statusY" value="Y" <?= checked( $db_am[am_status], "Y") ?>>
							<label for="am_statusY">이용중</label>

							<input type="radio" name="am_status" id="am_statusS" value="S" <?= checked( $db_am[am_status], "S") ?>>
							<label for="am_statusS">이용정지</label>
						</td>
					</tr>
					</table>
				</form>

				<table width="100%" border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td align="right">
						<button type="button" class="btn btn02" onclick="regi('upt');"> 수정 </button>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<? include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_footer.php" ?>
</body>
</html>

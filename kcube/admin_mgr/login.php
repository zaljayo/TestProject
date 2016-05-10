<? include $_SERVER["DOCUMENT_ROOT"]."/lib/common.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>- 관리자 -</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<SCRIPT LANGUAGE="JavaScript">
<!--
function login(){
	var fm = document.getElementById("loginfm");
	if(fm.userid.value == ""){
		alert("아이디를 입력해주세요.");
		fm.userid.focus();
		return;	
	}

	if(fm.pwd.value == ""){
		alert("비밀번호를 입력해주세요.");
		fm.pwd.focus();
		return;
	}

	fm.submit();
}
//-->
</SCRIPT>
</head>

<body onload="document.getElementById('userid').focus();">
<form name="loginfm" id="loginfm" method="post" action="login_proc.php" target="_self">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="40" background="images/top_bg.gif">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" valign="top"><table width="1000" border="0" cellspacing="0" cellpadding="0">
          <tr height="70">
            <td width="175" align="center"><img src="images/logo.png" height="50" style="display: none"></td>
            <td width="825">&nbsp;</td>
          </tr>
          <tr>
            <td height="1" colspan="2" bgcolor="#ffffff"></td>
          </tr>
          <tr>
            <td colspan="2" valign="top" style="padding:100px 0;"><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center" style="padding-left:80px"><img src="images/logo.gif"></td>
                </tr>
                <tr>
                  <td><table width="540" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="250" valign="top" background="images/login.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="270">&nbsp;</td>
                              <td height="153" valign="bottom"><div style="width:250px;height:32px" align="left">
                                  <input name="userid" id="userid" type="text" class="input_02" size="20">
                                </div>
                                <div style="width:250px;height:32px" align="left">
                                  <input name="pwd" id="pwd" type="password" class="input_02"  size="20">
                                </div></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td height="40" style="padding-left:45px;"><a href="javascript:login();"><img src="images/btn/login.gif" width="85" height="26"></a></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td align="center" style="padding-left:80px">
                    <table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><img src="images/warning.gif" align="absmiddle"> <b>도움말</b></td>
                      </tr>
                      <tr>
                        <td style="padding-top:10px">
							관리자 업무가 끝나시면 꼭 로그아웃을 해 주시기 바랍니다.<br>
							로그인 오류 또는 이용 시 궁금하신 점은 담당자에게<br>
							연락을 주시기 바랍니다.<br>
							- 연락처 : 02-563-1736<br>
							- E-mail : <a href="mailto:jh.tak@oncecf.com">jh.tak@oncecf.com</a>
						</td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="1" bgcolor="#c4c4c4"></td>
    </tr>
    <tr>
      <td height="50" align="center"><img src="images/footer.gif"></td>
    </tr>
  </table>
</form>
</body>
</html>

<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php" ?>
<?
//-- DB 연결
set_dbcon();
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
function init(){
	var v_link = $("#span_left_menu").find("a").attr("href");
	if(v_link == undefined){
		alert("접속 가능한 메뉴가 없습니다.");
		location.href="logout_proc.php";
	}else{
		location.href=v_link;	
	}
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
					<td colspan="2" align="left" class="title"><img src="./images/icon/bullet.gif" align="absmiddle" />메인</td>
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
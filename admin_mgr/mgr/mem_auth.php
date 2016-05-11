<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_top_mgr.php" ?>
<?
//-- 로그인 체크
admin_check( "menuZ01", "opener" );


//-- DB 연결
set_dbcon();


//-- 데이타 가져오기
get_tb_admin_mem_rq("p");
$am_userid = $rq_am['am_userid'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>- 관리자 -</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<? include $_SERVER["DOCUMENT_ROOT"]."/admin_mgr/inc/inc_header.php" ?>
<script type="text/javascript">
<!--
function chg_amm_key(ele, v_amm_key){
	var fm = document.getElementById("actfm");
	var v_str = "";

	for(var i=0; i<document.getElementsByName("sub_amm_key_"+ v_amm_key +"[]").length; i++){
		document.getElementsByName("sub_amm_key_"+ v_amm_key +"[]")[i].checked = ele.checked;
	}
}

function regi(){
	var fm = document.getElementById("actfm");
	fm.submit();
}

function fm_load(){
	var fm = document.getElementById("ldfm");
	fm.submit();	
}

function load_check(){
	for(var i=0; i<document.getElementsByName("amm_key[]").length; i++){
		var v_amm_key = document.getElementsByName("amm_key[]")[i].value;

		var len = document.getElementsByName("sub_amm_key_"+ v_amm_key + "[]").length;
		var ck_cnt = 0;

		for(var z=0; z<len; z++){
			if(document.getElementsByName("sub_amm_key_"+ v_amm_key + "[]")[z].checked){
				ck_cnt++;
			}
		}

		if(len == ck_cnt){
			document.getElementById("amm_key_"+ v_amm_key).checked = true;
		}else{
			document.getElementById("amm_key_"+ v_amm_key).checked = false;
		}
	}
}
//-->
</script>
</head>
<body onload="load_check();">
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="title"><br>
				<img src="../images/icon/bullet.gif" align="absmiddle">이용권한 (이용권한을 부여하실 메뉴만 체크해 주십시오)
			</td>
		</tr>
		</table>


		<form name="ldfm" id="ldfm" method="post" action="mem_auth.php">
			<input type="hidden" name="am_userid" id="am_userid" value="<?= $am_userid ?>">
		</form>

		<form name="actfm" id="actfm" method="post" action="mem_auth_proc.php" target="_proc">
			<input type="hidden" name="fk_ama_am_userid" id="fk_ama_am_userid" value="<?= $am_userid ?>">

			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mem_list">
<?
/* 기등록 데이타 확인 */
$arr_auth = get_tb_admin_mem_auth_info_001( $am_userid );


$sql = "
	select * from tb_admin_memu
	where fk_amm_amm_key  = '-' and amm_status='Y'
	order by amm_seq asc
";
$row = sql_array($sql);
if($row){
	foreach($row as $value) {
?>
			<tr>
			   <th width="200" align="left" class="mu">
					<input type="hidden" name="amm_key[]" value="<?= $value[amm_idx] ?>">

					<input type="checkbox" name="ma_amm_key" id="amm_key_<?= $value[amm_idx] ?>" onclick="chg_amm_key(this, '<?= $value[amm_idx] ?>');">
					<label for="amm_key_<?= $value[amm_idx] ?>"><?= $value[amm_name]; ?></label>
				</th>
				<td class="text_left" style="padding-left:5px">
<?
		$sql = "
			select * from tb_admin_memu
			where fk_amm_amm_key = '". $value[amm_key] ."' and amm_status='Y'
			order by amm_seq asc
		";
		$row2 = sql_array($sql);
		if(!$row2){
			$sql = "
				select * from tb_admin_memu
				where amm_key = '". $value[amm_key] ."' and amm_status='Y'
				order by amm_seq asc
			";
			$row2 = sql_array($sql);
		}

		foreach($row2 as &$value2){
?>
					<input type="checkbox" name="sub_amm_key_<?= $value[amm_idx] ?>[]" id="amm_key_2d_<?= $value2[amm_key] ?>" value="<?= $value2[amm_key] ?>" onclick="load_check();" <? if (in_array($value2[amm_key], $arr_auth)) echo " checked"; ?>>
					<label for="amm_key_2d_<?= $value2[amm_key] ?>"><?= $value2[amm_name] ?></label><br>
<?
		}
?>

				</td>
			</tr>
<?
	}
}
?>
			</table>
		</form>

		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="80" class="text_center">
				<button type="button" class="btn btn02" onclick="regi();"> 등록 </button>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<? include $server_root_path."/admin_mgr/inc/inc_footer.php" ?>
</body>
</html>

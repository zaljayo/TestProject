<?php
header("Content-Type: text/html; charset=utf-8");
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");
header('P3P: CP="CAO PSA OUR"');
session_start();

//error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('register_globals', 1);



// PHP 파일 이름이 들어간 절대 서버 경로
$file_server_path = realpath(__FILE__);

// PHP 파일 이름
$php_filename = basename(__FILE__);

// PHP 파일 이름을 뺀 절대 서버 경로
$server_path = str_replace(basename(__FILE__), "", $file_server_path);

// 서버의 웹 뿌리(루트) 경로(절대 경로)
$server_root_path = $_SERVER['DOCUMENT_ROOT'];
$server_admin_path = $server_root_path.$admin_dir;

// 웹 문서의 뿌리 경로를 뺀 상대 경로
$GLB_DOAMIN = $_SERVER['HTTP_HOST'];
$GLB_SELF_PAGE = $_SERVER['PHP_SELF'];
$GLB_HTTP_REFERER = $_SERVER['HTTP_REFERER'];
$GLB_SELFPAGE = $_SERVER['PHP_SELF']; 
$GLB_QUERY_PARAM = $_SERVER['QUERY_STRING'];
$GLB_QUERY_PARAM_ENC = urlencode($GLB_QUERY_PARAM);
$GLB_RETURN_PARAM = rqstr("return_param", "", "g");
$GLB_RETURN_PARAM_DEC = urldecode($GLB_RETURN_PARAM);

$search_yn = false;





/* WWW로 리디렉션 */
/*
$tmp_domain = strtolower($GLB_DOAMIN);
if(substr($tmp_domain,0, 3) != "www"){
	$redir_url = "http://www.$tmp_domain$GLB_SELF_PAGE";
	if($GLB_QUERY_PARAM != ""){
		$redir_url = "$redir_url?$GLB_QUERY_PARAM";
	}

	header("Location: $redir_url");
	exit();
};
*/



/* API KEY */
//-- google map api key (탁종훈 개인 계정)
$GLB_GOOGLE_MAP_KEY = "AIzaSyB2yOI6SR3H-m2EpMSyPgeQARryIDlQoMQ";
$GLB_DEF_PGS_X = "37.49178323870583";
$GLB_DEF_PGS_Y = "127.00761795043945";

//-- facebook app key (원스계정 - once@oncecf.com)
$GLB_FACEBOOK_KEY = "1524172111220060";


//-- og meta default value
$GLB_OG_TITLE = "K CUBE VENTURES";
$GLB_OG_IMAGE = "http://$GLB_DOAMIN/share/share.jpg";
$GLB_OG_URL = "http://$GLB_DOAMIN";
$GLB_OG_DESCRIPTION = "케이큐브벤처스는 기업가 분들을 진심으로 존경하며 기업가 분들이 최고의 성과를 낼 수 있도록 지원하고 있습니다.";


//-- Location
$MENU1_NAME = "HOME";
$MENU1_LINK = "/";

$MENU2_NAME = "";
$MENU2_LINK = "";

$MENU3_NAME = "";
$MENU3_LINK = "";




$cmd = rqstr("cmd", "");

//노출
$arr_status = array(
	"Y" => "공개",
	"H" => "비공개"
);

// 이벤트 관리자 경로
$admin_dir = "/admin_mgr/";


function convert_iframe_bootstrap( $str ){
	if( strpos( $str, "<iframe" ) !== false ){
		$str = str_replace( "<iframe", "<p class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' ", $str );
		$str = str_replace( "</iframe>", "</iframe></p>", $str);
	}
	return $str;
}

function setnull( $val, $def_val ){
//	echo "val -> $val<br>";
//	if(empty($val) || is_null($val) || $val == ""){
	$val = trim($val);
	if((empty($val) && is_null($val)) || is_null($val) || $val == ""){
		return $def_val;
	}else{
		return $val;
	}
}

function rqint( $name, $def_val = "", $method = "p" ){
	$val = "";
	if($method == "post" || $method == "p"){
		global $_POST;
		$val = $_POST[ $name ];
	}else if($method == "get" || $method == "g"){
		global $_GET;
		$val = $_GET[ $name ];
	}

	if (!is_numeric($val)){
		$val = $def_val;
	}
	return $val;
}

function rqstr( $name, $def_val = "", $method = "p" ){
	if($method == "post" || $method == "p"){
		global $_POST;
		$val = $_POST[ $name ];
	}else if($method == "get" || $method == "g"){
		global $_GET;
		$val = $_GET[ $name ];
	}
	$val = setnull( $val, $def_val );
//	$val = filter(xss_filter($val));

//	if(!instryn($GLB_SELFPAGE, $admin_dir)){
		$val = xss_filter($val);	
//	}	

	return $val;
//	return addslashes($val);
//	return htmlspecialchars($val);	 
}


function set_cookie( $name, $val, $day = 0 ){
	$time = $day * 60 * 60 * 24; //-- 1일
	setcookie($name, $val, time() + $time);
}

function get_cookie( $name ){
	global $_COOKIE;
//	print_r($_COOKIE[$name]);
	return $_COOKIE[$name];
}

function del_cookie( $name ){
	$time = $day * 60 * 60 * 24;
	setcookie($name, "", time() - $time);
}


//xss
function xss_filter($content){
	$ra1= array('javascript', 'vbscript', 'expression', 'applet', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'eval', 'innerHTML', 'charset', 'document', 'string', 'create', 'append', 'binding', 'alert', 'msgbox', 'refresh', 'embed', 'cookie');
	
	$ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbefore', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 
	'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 
	'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondbclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload'); 
	
	$ra = array_merge($ra1, $ra2);
	$found = true;
	while($found == true){
		$content_before = $content;
		for($i = 0; $i < sizeof($ra); $i++){
			$pattern = '/';
			for($j = 0; $j< strlen($ra[$i]); $j++){
				if($j > 0){
					$pattern .= '(';
					$pattern .= '(&#[xX]0{0,8}([9ab]);)';
					$pattern .= '|';
					$pattern .= '|(&#0{0,8}([9|10|13]);)';
					$pattern .= ')*';
				}
				$pattern .= $ra[$i][$j];
			}
			$pattern .= '/i';
			$replacement = substr($ra[$i], 0, 2).'x-'.substr($ra[$i], 2);
			$content = preg_replace($pattern, $replacement, $content);
			if($content_before == $content){
				$found = false;
			}
		}
	}
	return $content;
}

//인젝션 방지
function filter($param){
	$param = htmlspecialchars($param); //html엔티티문자변환
	$param = strip_tags($param); //모든 html태그재거
	return $param;
//	return mysql_real_escape_string($param);
}

function printjs( $js ){
	echo "
		<script type=\"text/javascript\">
		<!--
			$js
		//-->
		</script>
	";
}

function printmsg( $msg ){
	echo "
		<script type=\"text/javascript\">
		<!--
			alert(\"$msg\");
		//-->
		</script>
	";
}
function printmsgback( $msg ){
	echo "
		<script type=\"text/javascript\">
		<!--
			alert(\"$msg\");
			history.back(-1);
		//-->
		</script>
	";
	exit;
}

function gotoOpenerAndClose( $url ){
	echo "
		<script type=\"text/javascript\">
		<!--
			opener.location.href='$url'
			self.close();
		//-->
		</script>
	";
	exit;
}

function gourl( $target = "self.", $url ){
	$str_url = $target."location.href='$url'";

	echo "
		<script type=\"text/javascript\">
		<!--
			$str_url;
		//-->
		</script>
	";
	exit;
}

function host_ip(){
	global $_SERVER;
	return $_SERVER["REMOTE_ADDR"];
}

function get_test_ip(){
	if(host_ip() == "112.218.176.34-"){
		return true;
	}else{
		return false;
	}
}

function get_iframe( $fmName ){
	if(get_test_ip()){
		$strW= "95%";
		$strH = "300";
		$disp = "";
	}else{
		$strW= "0";
		$strH = "0";
		$disp = "none";
	}

	echo "<iframe name='$fmName' src='about:blank' width='$strW' height='$strH' title='정보지원' style='display:$disp'></iframe>";
}


/* 파일 업로드 경로 셋팅  */
$GLB_UP_FILE_ROOTDIR = "";
$GLB_UP_FILE_URL = "";
function get_updir( $key ){
	global $server_root_path;
	global $GLB_UP_FILE_ROOTDIR;
	global $GLB_UP_FILE_URL;
	
	switch( $key ){
		//-- 메인관리
		case "mgr_main": 
			$GLB_UP_FILE_ROOTDIR = $server_root_path."/upload_file/mgr_main/";
			$GLB_UP_FILE_URL = "/upload_file/mgr_main/";	
		break;
		
		//-- Family
		case "family": 
			$GLB_UP_FILE_ROOTDIR = $server_root_path."/upload_file/family/";
			$GLB_UP_FILE_URL = "/upload_file/family/";	
		break;
		case "family_img": 
			$GLB_UP_FILE_ROOTDIR = $server_root_path."/upload_file/family/img/";
			$GLB_UP_FILE_URL = "/upload_file/family/img/";	
		break;
		case "family_editor":
			$GLB_UP_FILE_ROOTDIR = $server_root_path."/upload_file/family/editor/";
			$GLB_UP_FILE_URL = "/upload_file/family/editor/";	
		break;

		//-- Team
		case "team": 
			$GLB_UP_FILE_ROOTDIR = $server_root_path."/upload_file/team/";
			$GLB_UP_FILE_URL = "/upload_file/team/";	
		break;
		case "team_editor":
			$GLB_UP_FILE_ROOTDIR = $server_root_path."/upload_file/team/editor/";
			$GLB_UP_FILE_URL = "/upload_file/team/editor/";	
		break;

		//-- Insight & News
		case "ins_news": 
			$GLB_UP_FILE_ROOTDIR = $server_root_path."/upload_file/ins_news/";
			$GLB_UP_FILE_URL = "/upload_file/ins_news/";	
		break;
		case "ins_news_editor":
			$GLB_UP_FILE_ROOTDIR = $server_root_path."/upload_file/ins_news/editor/";
			$GLB_UP_FILE_URL = "/upload_file/ins_news/editor/";	
		break;



		default:
			$GLB_UP_FILE_ROOTDIR = $server_root_path."/upload_file/temp/";
			$GLB_UP_FILE_URL = "/upload_file/temp/";
	}
}
?>
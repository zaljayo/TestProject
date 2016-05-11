<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/lib/common.php";
include $server_root_path."/lib/class/class_ins_news.php";



//echo "PHP_SELF = ". $_SERVER['PHP_SELF'] ."<br>";


//-- 업로드 경로
get_updir( "ins_news" );


$arr_url = explode ("/share/index.php/", $GLB_SELF_PAGE);
$menu = "";
$idx = 0;
$link = "/";

if(count($arr_url) == 2){
	$arr_param = explode("/", $arr_url[1]);
	if(count($arr_param) == 2){
		$menu = $arr_param[0];
		$idx = $arr_param[1];
	}
}


if(eqyn($menu, "") || eqyn($idx, 0)){
	$link = $GLB_OG_URL;
}else{
	if(is_numeric($idx)){
		if(eqyn($menu, "insight")){
			$link = "/insight/insight_view.html?inw_idx=$idx";
			get_tb_ins_news_info_001( $idx );
			if(!eqyn($db_inw[result_cmd], "YESDATA") || !eqyn($db_inw['inw_status'], "Y")){
				$idx = 0;
			}else{
				$GLB_OG_TITLE		= $db_inw[inw_title];
				$GLB_OG_IMAGE		= "$GLB_OG_URL$GLB_UP_FILE_URL$db_inw[inw_img_list]";
				$GLB_OG_URL			= "$GLB_OG_URL/share/insight/$idx";
				$GLB_OG_DESCRIPTION	= $db_inw[inw_img_list_desc];
			}

		}else if(eqyn($menu, "news")){
			$link = "/news/news_view.html?inw_idx=$idx";
			get_tb_ins_news_info_001( $idx );
			if(!eqyn($db_inw[result_cmd], "YESDATA") || !eqyn($db_inw['inw_status'], "Y")){
				$idx = 0;
			}else{
				$GLB_OG_TITLE		= $db_inw[inw_title];
				$GLB_OG_IMAGE		= "$GLB_OG_URL$GLB_UP_FILE_URL$db_inw[inw_img_list]";
				$GLB_OG_URL			= "$GLB_OG_URL/share/news/$idx";
				$GLB_OG_DESCRIPTION	= $db_inw[inw_img_list_desc];
			}
		}
	}
}


if(eqyn($menu, "") || eqyn($idx, 0)){
	$link = $GLB_OG_URL;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!--meta http-equiv="refresh" content="0;url=<?= $GLB_OG_REFRESH ?>"-->

<meta property='og:title' content='<?= $GLB_OG_TITLE ?>'/>
<meta property='og:type' content='website'/>
<meta property='og:image' content='<?= $GLB_OG_IMAGE ?>'/>
<meta property='og:url' content='<?= $GLB_OG_URL ?>'/>
<meta property='og:description' content='<?= $GLB_OG_DESCRIPTION ?>'/>
<title>K Cube Ventures</title>
<script type="text/javascript">
<!--
function init(){
	location.href="<?= $link ?>";
}
//-->
</script>
</head>
<body onload="init();">
</body>
</html>
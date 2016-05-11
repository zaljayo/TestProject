<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/lib/common.php";
include $server_root_path."/lib/class/class_mgr_main.php";



//-- 메인 비쥬얼 가져오기1
//-- 업로드 경로
get_updir( "mgr_main" );
$main_url = $GLB_UP_FILE_URL;

$sql_where = " and mmi_status = 'Y' ";
$arr_sql = array(
	"fild" => "*",
	"table" => "tb_mgr_main",
	"where" => $sql_where,
	"orderby" => "order by mmi_seq asc, mmi_idx desc"
);
$db_result = get_record( $arr_sql );
$rs = $db_result[result];






//-- 메인 하단 뉴스 가져오기
//-- 업로드 경로
get_updir( "ins_news" );

//-- 리스트 가져오기
$ilist_size = 4;
$sql_where = " and inw_status = 'Y'";
$sql_where .= " and fk_inw_mct_cate = 'NW' ";


$arr_sql = array(
	"fild" => "*",
	"table" => "tb_ins_news",
	"where" => $sql_where,
	"orderby" => "order by inw_ins_datetime desc, inw_idx desc"
);
$db_result = get_record( $arr_sql );
$nw_rs = $db_result[result];



//-- DB 닫기
set_db_close();


//-- Location
$MENU2_NAME = "";
$MENU2_LINK = "";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title>CONTACT | K Cube Ventures</title>
<? include "inc/filelink.html"; ?>
<link rel="stylesheet" type="text/css" href="css/jquery.fullPage.css" />
<script type="text/javascript" src="js/jquery.fullPage.js"></script>
<script type="text/javascript">
//<![CDATA[
/* 변수 초기화 */
var slickDelay = 4000; //슬라이드 딜레이 시간
var isSpotAuto = true; //스팟 슬라이드 자동 설정
var spotSlide;
var pcMainSlide;
//페이지 상태에 따른 헤더 배경 변경
pageName = 'main';


var v_ani_enum = 144;
var v_ani_num = 0;
var v_ani_timmer;
var v_ani_load_yn = false;


//가운데 모션
function ani_play(){
	if(v_ani_load_yn){
		v_ani_num++;

		if(v_ani_num > v_ani_enum){
			v_ani_num = 1;
//			clearTimeout(v_ani_timmer);
		}
		$("#img_play").attr("src", "images/main/play/"+ v_ani_num +".png");
//		console.log(v_ani_num);
		v_ani_timmer = setTimeout(ani_play, 100);
	}else{
		ani_load( "play" );
	}
}

function ani_load( v_cmd ){
	$('#div_list').imagesLoaded( function(){
		v_ani_load_yn = true;
		if(v_cmd == "play"){
			ani_play();
		}
	});
}

/* 페이지 초기화 */
$(document).ready(function(){
	spotSlick(".js-slide");
	pcMainSlick(".js-btnSlide");
	$(".js-btnSlide").find(".item.slick-current").find(".js-fade").fadeIn("slow");
	loadedIsotope(".js-grid")

	//해상도 체크 & PC일때 풀페이지 실행
	var wow = window.innerWidth;
	if(wow<1024){
	}else{
		fullpageSetUp();
		$("body").addClass("pc");
	}

	//해상도 체크 & PC일때 풀페이지 실행
	$(window).resize(function(){
		var wow =window.innerWidth;
		if(wow<1024){
			if($("body").hasClass("pc")){
				$.fn.fullpage.destroy('all');
				//console.log("풀페이지를 off 합니다.");
			}else{
				//console.log("풀페이지가 현재 off 상태입니다.");
			}
			$("body").removeClass("pc");
		}else{
			if($("body").hasClass("pc")){
				//console.log("풀페이지가 현재 on 상태입니다.");
			}else{
				fullpageSetUp()
				//console.log("풀페이지를 on 합니다.");
			}
			$("body").addClass("pc");
		}
		
	});

	//풀페이지 다음페이지 이동
	$('.js-go-nextsection').click(function(e){
		e.preventDefault();
		moveSectionDown()
	});

	/*풀페이지 지정된 위치 이동*/
	$(".js-moveto").click(function(e){
		e.preventDefault();
		moveTo(1);
	});



	var v_html = "";
	for(var i=1; i<=v_ani_enum; i++){
		v_html += "<img src='images/main/play/"+ i +".png'>";
	}
	$("#div_list").html( v_html );
});

/* 함수 정의 */
//풀페이지
function fullpageSetUp(){
	$('#fullage').fullpage({
		verticalCentered: false,
		navigation:true,
		css3:false
		/*,
		afterLoad: function(anchorLink, index){
			_fullpageIdx = index
		}
		*/
	});
}

//풀페이지 moveSectionDown 기능
function moveSectionDown(){
	$.fn.fullpage.moveSectionDown();
}
//풀페이지 moveTo 기능
function moveTo(a){
	$.fn.fullpage.moveTo(a);
}

//스팟슬라이드
function spotSlick(e){
	spotSlide = $(e).slick({
		arrows: false,
		dots: true,
		infinite: true, //무한반복
		speed: 700,
		autoplaySpeed : slickDelay,
		autoplay : isSpotAuto
	});
}

//PC메인슬라이드
function pcMainSlick(e){
	pcMainSlide = $(e).slick({
		arrows: true,
		dots: true,
		infinite: true, //무한반복
		speed: 700,
		autoplaySpeed : slickDelay,
		autoplay : isSpotAuto
	});
	$(e).on('beforeChange', function(event, slick, currentSlide, nextSlide){
	  $(e).find(".item.slick-current").find(".js-fade").hide();
	});
	$(e).on('afterChange', function(event, slick, currentSlide, nextSlide){
	  $(e).find(".item.slick-current").find(".js-fade").fadeIn("slow");
	});
}

// 이미지 로드후 Isotope 실행
function loadedIsotope(e){
	//IE 9이하 리턴
	if(navigator.appName.indexOf("Internet Explorer")!=-1){
		var badBrowser=(
			navigator.appVersion.indexOf("MSIE 10")==-1 &&   //v10 is ok
			navigator.appVersion.indexOf("MSIE 1")==-1  //v11, 12, etc. is fine too
		);

		if(badBrowser){
			// navigate to error page
			return;
		}
	}

	$(e).imagesLoaded( function() {
		$( ".js-grid>.js-grid-item:first-child" ).addClass("grid-sizer");
		$(e).isotope({
			itemSelector: '.js-grid>.item',
			percentPosition: true, 
			layoutMode: 'packery', //빈칸채우기
			masonry: {
				columnWidth: '.grid-sizer'
			}
		});
	});
}
//]]>
</script>
</head>
<body onload="ani_load('play');">
<div id="div_list" style="display: none;"></div>
<? include "inc/skip-nav.html"; ?>

<hr />

<div id="wrap" class="main">
	<header id="header">
		<? include "inc/head-spot.html"; ?>
	</header><!-- //header -->

	<hr />

	<? include "inc/totalmenu.html"; ?>

	<hr />

	<div id="container">
		<!-- 모바일+태블릿 -->
		<div class="visible-upto-1023">
			<!-- 스팟 슬라이드 -->
			<div class="main-slide js-slide">
<?
foreach($rs as $ors) {

	$db_mmi_img_desc	= $ors["mmi_img_desc"];
	$db_mmi_img_tb 		= $ors["mmi_img_tb"];
	$db_mmi_img_mb 		= $ors["mmi_img_mb"];

	$db_mmi_link 		= $ors["mmi_link"];
	$db_mmi_link_target = $ors["mmi_link_target"];
	if(eqyn($db_mmi_link, "")){
		$db_mmi_link = "";
		$db_mmi_link_target = "";
	}else{
		$db_mmi_link = "<a href='$db_mmi_link' target='$db_mmi_link_target'>";
		$db_mmi_link_target = "</a>";
	}
?>
				<div class="item">
					<?= $db_mmi_link ?>
						<img src="<?= $main_url.$db_mmi_img_mb ?>" alt="<?= $db_mmi_img_desc ?>" class="visible-upto-767" />
						<img src="<?= $main_url.$db_mmi_img_tb ?>" alt="<?= $db_mmi_img_desc ?>" class="hidden-upto-767" />
					<?= $db_mmi_link_target ?>
				</div>
<?
}
?>
			</div>
			<!-- //스팟 슬라이드 -->

			<div class="latestnews">
				<strong class="h4-main">LATEST NEWS</strong>
				<div class="main-news-grid js-grid">
<?
foreach($nw_rs as $ors) {
?>
					<div class="item">
						<a href="/news/news_view.html?inw_idx=<?= $ors[inw_idx] ?>">
							<div class="c-img">
								<img src="<?= $GLB_UP_FILE_URL.$ors[inw_img_list] ?>" />
							</div>
							<div class="info">
								<span class="b-date">
									<?= get_eng_date($ors[inw_ins_datetime]) ?>
								</span>
								<strong class="b-title">
									<?= $ors[inw_img_list_desc] ?>
								</strong>
							</div>
						</a>
						<div class="tags tag_lim">
							<strong class="title">Tag</strong>
							<?= get_tag_search_make($ors[inw_tag]) ?>
						</div>
					</div>
<?
}
?>
				</div>
				<div class="btn-area">
					<a href="/news/news_list.html" class="btn-main-more">MORE</a>
				</div>
			</div>
		</div>

		<!-- pc화면 -->
		<div class="pc-main hidden-upto-1023" id="fullage">
			<div class="section sec-main1">
				<div class="img-cube"><img src="images/main/play/1.png" id="img_play"/></div>
				<div class="txt-cube-title">Start up’s best friend</div>
				<!-- 스팟 슬라이드 -->

			<div class="pc-main-slide js-btnSlide">
<?
$NO = 0;
foreach($rs as $ors) {
	$NO++;
	$NO_str = "00".$NO;
	$NO_str = substr($NO_str, -2);

	$db_mmi_img_desc	= $ors["mmi_img_desc"];
	$db_mmi_desc_pc		= $ors["mmi_desc_pc"];	
	$db_mmi_img_pc 		= $ors["mmi_img_pc"];

	$db_mmi_link 		= $ors["mmi_link"];
	$db_mmi_link_target = $ors["mmi_link_target"];
	if(eqyn($db_mmi_link, "")){
		$db_mmi_link = "";
		$db_mmi_link_target = "";
	}else{
		$db_mmi_link = "<a href='$db_mmi_link' target='$db_mmi_link_target'>";
		$db_mmi_link_target = "</a>";
	}
?>
				<div class="item box<?= $NO_str ?>">
					<?= $db_mmi_link ?>
						<span class="pc-txt-slide js-fade"><?= $db_mmi_desc_pc ?></span>
						<img src="<?= $main_url.$db_mmi_img_pc ?>" alt="<?= $db_mmi_img_desc ?>" />
						<i class="line01"></i>
						<i class="line02"></i>
					<?= $db_mmi_link_target ?>
				</div>
<?
}
?>
			</div>
			<div class="main-pagedown">
				<a href="#" class="js-go-nextsection"><img src="images/main/pc_btn_fulldown.png" alt="" /></a>
			</div>
			<!-- //스팟 슬라이드 -->
			</div>

			<div class="section sec-main2">
				<strong class="pc-h4-main">LATEST NEWS</strong>
				<div class="main-news-grid js-grid">
<?
foreach($nw_rs as $ors) {
?>
					<div class="item">
						<a href="/news/news_view.html?inw_idx=<?= $ors[inw_idx] ?>">
							<div class="c-img">
								<img src="<?= $GLB_UP_FILE_URL.$ors[inw_img_list] ?>" />
							</div>
							<div class="info">
								<span class="b-date">
									<?= get_eng_date($ors[inw_ins_datetime]) ?>
								</span>
								<strong class="b-title">
									<?= $ors[inw_img_list_desc] ?>
								</strong>
							</div>
						</a>
						<div class="tags">
							<strong class="title">Tag</strong>
							<div class="tag_lim">
								<?= get_tag_search_make($ors[inw_tag]) ?>
							</div>
						</div>
					</div>
<?
}
?>
				</div>
				<div class="btn-area">
					<a href="/news/news_list.html" class="btn-main-more">MORE</a>
				</div>
				<div class="main-pageup">
					<a href="#" class="js-moveto"><img src="images/main/pc_btn_fullup.png" alt="" /></a>
				</div>
			</div>
		</div>
		<!-- //pc화면 -->
	</div><!-- //container -->

	<hr />
	<? include "inc/footer.html"; ?>
	<script type="text/javascript">
	//<![CDATA[
	function mainFoo(){
		var $foo = $("footer"),
			fooOpenH = 250 + "px",
			fooCloseH = 53 + "px",
			speed = 500;
			$foo.css({height: fooCloseH}),
			$ico = $("#footer .foot-list .title+i");
	
		function openFoo(e) {
			var $e = $(e)
			$e.closest("footer").addClass("open");
			$foo.stop().animate({height: fooOpenH}, speed);
			$("#footer .foot-list .title+i")
			$ico.removeClass("fa-angle-up").addClass("fa-angle-down");
		}
		function closeFoo(e) {
			var $e = $(e)
			$e.closest("footer").removeClass("open");
			$foo.stop().animate({height: fooCloseH}, speed);
			$ico.removeClass("fa-angle-down").addClass("fa-angle-up");
		}
		
		$(window).resize(function(){
			var wow2 = window.innerWidth,
				$btnFoo = $("#footer");
			if(wow2<1024){
				$btnFoo.unbind();
				$foo.removeAttr("style");
				$ico.hide();
			}else{
				$ico.show();
				$btnFoo.unbind();
				$btnFoo.hover(function(){
					openFoo($(this));
				}, function(){
					closeFoo($(this));
				});
			}
		}).resize();
	}
	mainFoo();
	//]]>
	</script>
</div>
</body>
</html>
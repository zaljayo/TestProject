<?
error_reporting(E_ALL ^ E_NOTICE);
include $_SERVER["DOCUMENT_ROOT"]."/lib/common.php";
include $server_root_path."/lib/class/class_family.php";

//-- 업로드 경로
get_updir( "family" );

$pageName = "family";

$code_rs = get_tb_mgr_cate_list_001("FM", "*", "array" );

//-- DB 닫기
set_db_close();


//-- Location
$MENU2_NAME = "FAMILY";
$MENU2_LINK = "/family/family_list.html";

$MENU3_NAME = "VIEW ALL";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title>FAMILY 목록 | K Cube Ventures</title>
<? include "../inc/filelink.html"; ?>
<script type="text/javascript">
//<![CDATA[
/* 변수 초기화 */
//페이지 상태에 따른 헤더 배경 변경
pageName = '<?= $pageName ?>';


/* 페이징 초기 변수 */
v_page = 1;
v_list_size = 28;
//v_list_size = 1;
v_tmp_page = v_page;
v_def_list_size = v_list_size;

var v_ser_fk_fm_mct_idx = "";
var v_search_yn  = false;



function get_page_view( v_fm_idx ){
	setHash( "&ser_fk_fm_mct_idx="+ v_ser_fk_fm_mct_idx );
	location.href = "family_view.html?fm_idx=" + v_fm_idx +"&ser_fk_fm_mct_idx="+ v_ser_fk_fm_mct_idx +"&page="+ v_page;
}
function get_more(){
	v_page++;
	v_search_yn = false;
	get_page_list();
}
function get_family_cate_search( val ){
	v_ser_fk_fm_mct_idx = val;

	cate_fn();

	hashClear();
	v_page = 1;
	$('#div_list .item').remove();
	v_search_yn = true;


	var v_cate_name = $("#cate_"+ v_ser_fk_fm_mct_idx).text();
	var v_locaton = "<a href='/'>HOME</a>"
		+"<span class='bullet'>/</span>"
		+"<a href='/family/family_list.html'> FAMILY </a>"
		+"<span class='bullet'>/</span>"
		+"<span class='current'>"+ v_cate_name +"</span>";

	$("#div_location").html( v_locaton );


	get_page_list();
}
function get_page_list(){
	var v_param = "page="+ v_page +"&list_size="+ v_list_size +"&ser_fk_fm_mct_idx="+ v_ser_fk_fm_mct_idx;
//	console.log(v_param)
	var v_html = "";
	$.ajax({
		type:"get" ,
		url:"/lib_ajax/get_family.php",
		data:v_param ,
		success:function(data){
			var json = JSON.parse(data);
			var v_recordcount = json.recordcount;
//			console.log(json)
//			console.log(json.sql_list)
//			console.log(json.result)
			if(v_recordcount == 0 || json.result == null){
				v_page--;
				if(v_search_yn){
					v_html += "<div class='item'>검색된 데이타가 없습니다.</div>";
					$('#div_list').html( v_html );
					v_search_yn = false;
				}else{
					alert("검색된 데이타가 없습니다.");
				}
			}else{
				var v_grid_sizer = "";
				for(var i=0; i<json.result.length; i++){
					db_fm_idx				= json.result[i].fm_idx;
					db_fm_com				= json.result[i].fm_com;
					db_fm_com_eng			= json.result[i].fm_com_eng;
					db_fm_img_list_pc		= json.result[i].fm_img_list_pc;
					db_fm_img_list_mb		= json.result[i].fm_img_list_mb;
					db_fm_list_desc			= json.result[i].fm_list_desc;
					db_fm_list_desc_eng		= json.result[i].fm_list_desc_eng;

					v_link = "javascript:get_page_view("+ db_fm_idx +");";
					
					if(v_page == 1 && i == 0){
						v_grid_sizer = "grid-sizer";
					}else{
						v_grid_sizer = "";
					}
					v_html += "<div class='item "+ v_grid_sizer +"'>";
					v_html += "	<a href='"+ v_link +"'>";
					v_html += "		<div class='c-img'>";
					v_html += "			<img src='<?= $GLB_UP_FILE_URL ?>"+ db_fm_img_list_pc +"' imgon='<?= $GLB_UP_FILE_URL ?>"+ db_fm_img_list_pc +"' imgoff='<?= $GLB_UP_FILE_URL ?>"+ db_fm_img_list_mb +"' alt='"+ db_fm_com +"' />";
					v_html += "		</div>";
					v_html += "	</a>";
					v_html += "	<div class='hover-box'>";
					v_html += "		<strong class='name'>"+ db_fm_com +"</strong>";
					v_html += "		<span class='info'>"+ db_fm_list_desc +"</span>";
					v_html += "		<a href='"+ v_link +"' class='btn-txt'>Learn More</a>";
					v_html += "	</div>";
					v_html += "</div>";
				}

//				$("#div_list").append(v_html);
				var $items = $(v_html);
				$('#div_list').imagesLoaded( function() {
					$('#div_list').append( $items ).isotope( 'appended', $items ).isotope('layout');
					wiwResize1280();
				});
				hashClear();
				
				var view_cnt = v_page * v_list_size;
				if(view_cnt > v_recordcount){
					view_cnt = v_recordcount;
				}
				$("#a_list_more").text("Learn More ("+ view_cnt +"/"+ v_recordcount +")");
			}
		},
		error:function(){
			v_page--;
			alert( "처리도중 오류가 발생하였습니다." );
		}
	});
}


/* 페이지 초기화 */
var cate_fn = function(){
	$("#ser_fk_fm_mct_idx_mb").val(v_ser_fk_fm_mct_idx);
	$("#ser_fk_fm_mct_idx_pc li").each(function( idx ){
		if($(this).attr("idx") == v_ser_fk_fm_mct_idx){
			$(this).addClass("on");
		}else{
			$(this).removeClass("on");
		}
	});
}
var first_fn = function(){
	cate_fn();

	loadedIsotope(".js-grid")
	$(".js-fam-list .item>a").bind("mouseenter", famEnter);  //해상도 1280 일때, 마우스 엔터
	$(".js-fam-list .item").bind("mouseleave", famLeave);  //해상도 1280 일때, 마우스 리브
	wiwResize1280(); //사용자 해상도 넓이 따른 기능 부여,제거
	$(window).resize(function(){ wiwResize1280() }); //사용자 해상도 넓이 윈도우 리사이징
};

$(document).ready(function(){
	var json = checkForHash();

	if("<?= $ser_fk_fm_mct_idx ?>" != ""){
		v_ser_fk_fm_mct_idx = "<?= $ser_fk_fm_mct_idx ?>";
	}else{
		v_ser_fk_fm_mct_idx = json.ser_fk_fm_mct_idx;
		if(v_ser_fk_fm_mct_idx == undefined){
			v_ser_fk_fm_mct_idx = "";
		}
	}

	var tmp_page = <?= $ipage ?>;
	if(tmp_page != 1){
		v_page = 1;
		v_list_size = tmp_page * v_def_list_size;
		v_tmp_page = tmp_page;
		setHash("&ser_fk_fm_mct_idx="+ v_ser_fk_fm_mct_idx);
	}

//	get_page_list();
	get_family_cate_search(v_ser_fk_fm_mct_idx);
	first_fn();
});




/* 함수 정의 */
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
//		$( ".js-grid>.item:first-child" ).addClass("grid-sizer");
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

//해상도 1280 일때, 마우스 엔터
var famEnter = function (){
//	$(this).find(".c-img>img").attr("src",$(this).find(".c-img>img").attr("src").replace("_off.jpg","_on.jpg"));
	$(this).find(".c-img>img").attr("src", $(this).find(".c-img>img").attr("imgoff"));
	$(this).next(".hover-box").show();
}

//해상도 1280 일때, 마우스 리브
var famLeave = function (){
//	$(this).find(".c-img>img").attr("src",$(this).find(".c-img>img").attr("src").replace("_on.jpg","_off.jpg"));
	$(this).find(".c-img>img").attr("src", $(this).find(".c-img>img").attr("imgon"));
	$(this).find(".hover-box").hide();
}

//사용자 해상도 넓이 따른 기능 부여,제거
function wiwResize1280() {
	pageWidth = 1280
	var wiw = window.innerWidth;

	if(wiw<pageWidth){
		$(".js-fam-list .item>a").unbind("mouseenter", famEnter)
		$(".js-fam-list .item").unbind("mouseleave", famLeave)
		//$(".js-fam-list .item a").css({"cursor":"default"});
	}else{
		$(".js-fam-list .item>a").bind("mouseenter", famEnter)
		$(".js-fam-list .item").bind("mouseleave", famLeave)
		//$(".js-fam-list .item a").css({"cursor":"pointer"});
	}
}
//]]>
</script>
</head>
<body>
<? include "../inc/skip-nav.html"; ?>

<hr />

<div id="wrap">
	<header id="header">
		<? include "../inc/head-spot.html"; ?>

		<hr />

		<!-- 일반 페이지 -->
		<div class="page-title js-title">
			<h3></h3>
		</div>

		<div class="lowmenu">
			<!-- 메뉴 2개이상 -->
			<div class="sel-lowmenu">
				<label for="ser_fk_fm_mct_idx_mb" class="sr-only">하위 메뉴</label>
				<select class="selectpicker" id="ser_fk_fm_mct_idx_mb" onchange="get_family_cate_search(this.value);">
					<option value="">VIEW ALL</option>
<?
	foreach($code_rs as $ors){
?>
					<option value="<?= $ors[mct_idx] ?>"><?= $ors[mct_name] ?></option>
<?
	}
?>
				</select>
			</div>
			
			<div class="txt-lowmenu">
				<ul id="ser_fk_fm_mct_idx_pc">
					<li idx="" id="cate_"><a href="javascript:get_family_cate_search('');">VIEW ALL</a></li>
<?
	foreach($code_rs as $ors){
?>
					<li idx="<?= $ors[mct_idx] ?>" id="cate_<?= $ors[mct_idx] ?>"><a href="javascript:get_family_cate_search('<?= $ors[mct_idx] ?>');"><?= $ors[mct_name] ?></a></li>
<?
	}
?>
				</ul>
			</div>
			<!-- //메뉴 2개이상 -->
		</div>
	</header><!-- //header -->

	<? include "../inc/totalmenu.html"; ?>

	<hr />

	<div id="container">
		<? include "../inc/location.html"; ?>

		<div id="contents">
			<h4 class="cont-title">About K Cube Family</h4>
			<div class="feature-list">
				<ul style="display: ;">
					<li>
						<div class="c-img">
							<img src="../images/family/fam_feature_1.png" alt="Best Member" />
						</div>
						<strong class="b-title">Best Member</strong>
						<span class="txt">
							특정 분야 문제를 푸는 데 있어 해당 분야<br />
							 최고의 역량을 갖고 있는 팀<br />
							함께 성장하며 배움이 있는 동료들로 구성
						</span>
					</li>
					<li>
						<div class="c-img">
							<img src="../images/family/fam_feature_2.png" alt="Warm Heart" />
						</div>
						<strong class="b-title">Warm Heart</strong>
						<span class="txt">
							따뜻한 마음과 자율성을 갖고 일하며 결과적으로 좋은 성과를 내는 팀
						</span>
					</li>
					<li>
						<div class="c-img">
							<img src="../images/family/fam_feature_3.png" alt="Great Product" />
						</div>
						<strong class="b-title">Great Product</strong>
						<span class="txt">
							팀의 역량을 최대한으로 발휘해 이전에 볼 수 없었던 훌륭한 제품을 만드는 팀
						</span>
					</li>
					<li>
						<div class="c-img">
							<img src="../images/family/fam_feature_4.png" alt="Innovation" />
						</div>
						<strong class="b-title">Innovation</strong>
						<span class="txt">
							전체 패밀리의 일원으로서 다양한 혁신을<br />
							만들어 나가며 차원이 다른 성장을 실현
						</span>
					</li>
				</ul>
			</div>

			<h4 class="cont-title">K Cube Family Members</h4>
			<div class="fam-grid-wrap">
				<div class="fam-grid js-grid js-fam-list" id="div_list">
					<!-- Family 리스트 컨텐츠 //-->
				</div>
			</div>

			<div class="btn-area">
				<a href="javascript:get_more();" class="btn-blue-fixed" id="a_list_more">Learn More (0/0)</a>
			</div>

			<hr />

			<? include "../inc/btn-go-top.html"; ?>
		</div><!-- //contents -->
	</div><!-- //container -->

	<hr />
	<? include "../inc/footer.html"; ?>
</div>
</body>
</html>
/*변수 초기화*/
var pageName = null;
var pageWidth;

/* 페이지 초기화 */
$(document).ready(function(){
	var iev = parseInt(get_version_of_IE());
	if(iev != "NaN"){
		if(iev >= 11){
			$(".ie11_01").addClass("padding-right01");
			$(".ie11_02").addClass("padding-right02");
		}else{

		}
	}else{
	}

	$(".skip-navigation a").bind("click", skipNavi); //스킵네비
	$("#btn-srchbar-open").bind("click", headSearchOpen); //PC화면 일때, 상단 검색 바 열기
	$("#btn-srchbar-close").bind("click", headSearchClose); //PC화면 일때, 상단 검색 바 닫기
	$("#btn-total-open").bind("click", totalMenuOpen); //모바일화면 일때, 토탈 메뉴 열기
	$("#btn-total-close").bind("click", totalMenuClose); //모바일화면 일때, 토탈 메뉴 닫기
	wiwResize(); //사용자 해상도 넓이 따른 기능 부여,제거
	$(window).resize(function(){ wiwResize() }); //사용자 해상도 넓이 윈도우 리사이징
	$(window).scroll(function(){scrollTop()}); //스크롤탑 위치에 따른 스크롤탑 이벤트 생성,해제
	$("#btn-go-top").bind("click", scrollTopBtn); //스크롤탑 이벤트 실행
	headerBg();  //페이지별 헤더 배경 변경


	

	/* 이용약관 표시 */
	var v_url = location.href.toLowerCase();
	if (v_url.indexOf("#pop-privacy") != -1){
		$("#pop-privacy").modal();
	}
});

/* 함수 정의 */
//스킵네비
function skipNavi(){
	var thisHref = $(this).attr("href")
	$(thisHref).attr("tabindex","-1");
	$(thisHref).focus();
}

//PC화면 일때, 상단 검색 바 열기
var headSearchOpen = function(){
	$("#head-srch-box").show();
	$("#search_pc").focus();
}

//PC화면 일때, 상단 검색 바 닫기
var headSearchClose = function(){
	$("#head-srch-box").hide();
}

//모바일화면 일때, 토탈 메뉴 열기
var totalMenuOpen = function(){
	$("#totalmenu").show();
}

//모바일화면 일때, 토탈 메뉴 닫기
var totalMenuClose = function(){
	$("#totalmenu").hide();
}

//대메뉴 클릭시 이벤트
var gnbClick = function() {
	if($(this).parent("li").hasClass("on")){
		$(this).find("i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
		$(this).parent("li").removeClass("on");
		$(this).next("ul").hide();
	}else{
		$(this).find("i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
		$(this).parent("li").siblings().removeClass("on");
		$(this).parent("li").addClass("on");
		$(this).next("ul").show();
	}
	return false;
}

//사용자 해상도 넓이 따른 기능 부여,제거
function wiwResize() {
	pageWidth = 1024;
	var wiw = window.innerWidth;
//	console.log(wiw);
	if(wiw<pageWidth){
		$("#btn-srchbar-open").attr("href", "/search/search.html");
		$("#btn-srchbar-open").unbind("click", headSearchOpen)
		$("#head-srch-box").removeAttr("style");
	}else{
		$("#btn-srchbar-open").attr("href", "#");
		$("#btn-srchbar-open").bind("click", headSearchOpen)		
		$("#totalmenu").removeAttr("style");
	}
}

//스크롤탑 위치에 따른 스크롤탑 이벤트 생성,해제
function scrollTop(){
	if($(window).scrollTop() >150){
		$("#btn-go-top").show();
	}else{
		$("#btn-go-top").fadeOut("fast");
	}
}

//스크롤탑 이벤트 실행
function scrollTopBtn(){
	$("body,html").stop().animate({scrollTop:0},300);
	return false;
}

//페이지별 헤더 배경, 페이지 타이틀 변경
function headerBg(){
	if(pageName == null) return

	if(pageName == 'about'){
		$("#header").css({'background-image': 'url("../images/common/bg_header_about.jpg")'});
		$(".js-title>h3").html("ABOUT");
	}else if(pageName == 'news'){
		$("#header").css({'background-image': 'url("../images/common/bg_header_news.jpg")'});
		$(".js-title>h3").html("NEWS");
	}else if(pageName == 'insight'){
		$("#header").css({'background-image': 'url("../images/common/bg_header_insight.jpg")'});
		$(".js-title>h3").html("INSIGHT");
	}else if(pageName == 'team'){
		$("#header").css({'background-image': 'url("../images/common/bg_header_team.jpg")'});
		$(".js-title>h3").html("TEAM");
	}else if(pageName == 'family'){
		$("#header").css({'background-image': 'url("../images/common/bg_header_family.jpg")'});
		$(".js-title>h3").html("FAMILY");
	}else if(pageName == 'search'){
		$("#header").css({'background-image': 'url("../images/common/bg_header_search.jpg")'});
	}else if(pageName == 'contact'){
		$("#header").css({'background-image': 'url("../images/common/bg_header_contact.jpg")'});
		$(".js-title>h3").html("CONTACT");
	}else if(pageName == 'main'){
		$("#header").addClass("main");
	}


/*
	$(".gnb ul li").each(function(){
		$(this).removeClass("on");
	});
*/
	$("#gnb_"+ pageName).addClass("on");
}
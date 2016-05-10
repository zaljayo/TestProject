//-- hash 데이타 저장
var v_page = 1;
var v_list_size = 1;

var v_tmp_page = v_page;
var v_def_list_size = v_list_size;

var v_postionx = 0;

var isHashClear = false;

function setHash( str ){
	location.hash = "page="+ v_page +"&postionx=" + $(document).scrollTop() + str;
}

//param String 을 json 으로 
function parseParamToJson( str ){
	if( str == "" || !str ) return jQuery.parseJSON("{}");
	var arr = str.split( "&" );
	var str = "{\"";

	for(var i in arr){
		str += arr[i].replace("=","\":\"");
		if( i == arr.length - 1 ) str += "\"}";
		else str += "\",\"";
	}

	return jQuery.parseJSON( str);
}

//-- hash 데이타 json으로 리턴
function getHashToJson(){
	var param;
	
	if(location.hash){
		var HashLocationName = document.location.hash;
		HashLocationName = HashLocationName.replace("#","");
		param = parseParamToJson( HashLocationName );
	}else{
		param = jQuery.parseJSON("{}")
	}
//	console.log(param);
	return param;
}

//-- hash 데이타 reset
function hashClear(){
	if(!isHashClear && document.location.hash){
		$(document).scrollTop(v_postionx);
		v_page = v_tmp_page;
		v_list_size = v_def_list_size;
		isHashClear = true;
	}
}

//-- hash 데이타 check
function checkForHash() {
	var param = "";
	if(document.location.hash){
		param = getHashToJson();
//		console.log(param);
		var tmp_page = param.page;
		var tmp_postionx = param.postionx;

		if(tmp_page != undefined){
			v_tmp_page = tmp_page;
			if(tmp_page > 1){
				v_page = 1;
				v_list_size = tmp_page * v_def_list_size;
			}			
		}

		if(tmp_postionx != undefined){
			v_postionx = tmp_postionx;
		}
	}
	return param;
}


//-- 전체 검색
function search_keydown( kind ){
	if(event.keyCode == 13){
		search_all( kind );
	}
}

function search_all( kind ){
	var ele = $("#search_"+ kind);
	if(ele.val() == ""){
		alert("검색어를 입력해주세요.");
		ele.focus();
		return false;
	}else{
		location.href='/search/search.html?search_title='+ ele.val();
	}
}


//-- 페이지 이동
function go_blank( v_target ){
	eval(v_target +"location.href = \"about:blank\";");
}

function goto_page( v_page ){
	var fm = document.pagefm;
	if(fm.act_url) fm.action=fm.act_url.value;
	if(fm.act_target) fm.target=fm.act_target.value;
	if(fm.act_method) fm.method=fm.act_method.value;
	fm.page.value = v_page;
	fm.submit();
}

function goto_url( v_url, v_target ){
	if(v_target == undefined){
		v_target = "_self.";
		v_target = "";
	}
	eval(v_target +"location.href = \""+ v_url +"\";");
}

//-- 체크박스 전체 체크,비체크
function chk_all(ele, name){
	for(var i=0; i<document.getElementsByName(name).length; i++){
		document.getElementsByName(name)[i].checked = ele.checked;
	}
}

/* 모바일 접속 여부 확인 */
function get_mobile_yn(){
	var v_mobile_yn = false;
	var uAgent = navigator.userAgent.toLowerCase();
	// 아래는 모바일 장치들의 모바일 페이지 접속을위한 스크립트
	var mobilePhones = new Array('iphone', 'ipod', 'ipad', 'android', 'blackberry', 'windows ce','nokia', 'webos', 'opera mini', 'sonyericsson', 'opera mobi', 'iemobile', 'lg', 'mot', 'samsung', 'sonyericsson');
	for (var i = 0; i < mobilePhones.length; i++){
		if (uAgent.indexOf(mobilePhones[i]) != -1){
		   v_mobile_yn = true;
		   break;
		}
	}
	return v_mobile_yn;
}

//-- 업로드 파일 확장명 체크
function upload_file_check( type, fname){
	if(fname == ""){
		v_status = "Y";
	}else{
		var v_ext = "";
		var tmp_ext = "";
		v_status = false;
		var arr_fname = fname.split(".");
		var tmp_fname = arr_fname[ arr_fname.length-1 ];
		tmp_fname = tmp_fname.toLowerCase() +",";

		v_ext = "js,jsp,php,php3,php5,phtml,asp,aspx,asp,ascx,cfm,cfc,pl,bat,exe,dll,reg,cgi,inc";
		tmp_ext = v_ext +",";
		if(tmp_ext.indexOf(tmp_fname) >= 0){
			v_status = "업로드 하실수 없는 파일 입니다.";
		}else{
			v_status = "Y";
		}

		if(v_status == "Y"){
			if(type == "image"){
				v_ext = "jpg,gif,png";
				tmp_ext = v_ext +",";
				if(tmp_ext.indexOf(tmp_fname) >= 0){
					v_status = "Y";
				}else{
					v_status = "확장명이 "+ v_ext +"파일만 업로드 하실수 있습니다.";
				}
			}else if(type == "movie"){
				v_ext = "wmv,avi,mpeg,mov,mp4";
				tmp_ext = v_ext +",";
				if(tmp_ext.indexOf(tmp_fname) >= 0){
					v_status = "Y";
				}else{
					v_status = "확장명이 "+ v_ext +"파일만 업로드 하실수 있습니다.";
				}
			}else if(type == "movie_mobile"){
				v_ext = "mp4";
				tmp_ext = v_ext +",";
				if(tmp_ext.indexOf(tmp_fname) >= 0){
					v_status = "Y";
				}else{
					v_status = "확장명이 "+ v_ext +"파일만 업로드 하실수 있습니다.";
				}
			}else if(type == "xls"){
				v_ext = "xls";
				tmp_ext = v_ext +",";
				if(tmp_ext.indexOf(tmp_fname) >= 0){
					v_status = "Y";
				}else{
					v_status = "확장명이 "+ v_ext +"파일만 업로드 하실수 있습니다.";
				}
			}else if(type == "doc"){
				v_ext = "pdf,ppt,pptx,doc";
				tmp_ext = v_ext +",";
				if(tmp_ext.indexOf(tmp_fname) >= 0){
					v_status = "Y";
				}else{
					v_status = "확장명이 "+ v_ext +"파일만 업로드 하실수 있습니다.";
				}
			}else if(type == "xls2"){
				v_ext = "xls,xlsx";
				tmp_ext = v_ext +",";
				if(tmp_ext.indexOf(tmp_fname) >= 0){
					v_status = "Y";
				}else{
					v_status = "확장명이 "+ v_ext +"파일만 업로드 하실수 있습니다.";
				}
			}
		}
	}
	return v_status;
}

/* 쿠키 구하기  */
function getCookie( name ) {
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length ) {
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) 
				endOfCookie = document.cookie.length;

			return unescape( document.cookie.substring( y, endOfCookie ) );
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
			break;  
	}
	return "";
}

/* 쿠키 설정  */
function setCookie( name, value, expiredays ){ 
	var todayDate = new Date(); 
	todayDate.setDate( todayDate.getDate() + expiredays ); 
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
}



/* 영문 월 표시 */
var v_monthNamesShort = ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'];
var v_dayNamesMin = ['일','월','화','수','목','금','토'];

function get_eng_date( v_date ){
	var tmp_date = v_date.substr(0, 10);
	var v_year = tmp_date.substr(0,4);
	var v_mon = tmp_date.substr(5,2);
	var v_day = tmp_date.substr(8,2);

	var json_mon = {
		"m1": "January",
		"m2": "February",
		"m3": "March",
		"m4": "April",
		"m5": "May",
		"m6": "June",
		"m7": "July",
		"m8": "August",
		"m9": "September",
		"m10": "October",
		"m11": "November",
		"m12": "December"
	}


	v_mon = parseInt(v_mon);
	v_mon = "m"+ v_mon;
	eval("v_mon = json_mon."+ v_mon);

	if(v_mon == undefined){
		return tmp_date;
	}else{
		return v_mon +" "+ v_day +","+ v_year;	
	}
}


function print_content( ptype , str){
	if(ptype == "js"){
		str = replace(str, "<", "&lt;");
		str = replace(str, ">", "&gt;");
		str = replace(str, "'", "&#x27;");
		str = replace(str, "\"", "&quot;");
		str = replace(str, "&#x2F;", "/");
	}
	return str;
}

/* 테그 검색 링크 */
function get_tag_search_make( v_tag ){
	var arr_tag = v_tag.split(",");
	var v_result = "";
	for(var i=0; i<arr_tag.length; i++){
		v_result += "<a href='/search/search_tag.html?search_title="+ print_content('js', arr_tag[i]) +"'>"+ arr_tag[i] +"</a>";
		if(i < arr_tag.length-1){
			v_result += ",";
		}
	}

	return v_result;
}

/* 브라우져 ie11 체크 */
function get_version_of_IE () { 
	 var word; 
	 var v_version = "N/A"; 

	 var agent = navigator.userAgent.toLowerCase(); 
	 var name = navigator.appName; 

	 // IE old version ( IE 10 or Lower ) 
	 if ( name == "Microsoft Internet Explorer" ) word = "msie "; 

	 else { 
		 // IE 11 
		 if ( agent.search("trident") > -1 ) word = "trident/.*rv:"; 

		 // Microsoft Edge  
		 else if ( agent.search("edge/") > -1 ) word = "edge/"; 
	 } 

	 var reg = new RegExp( word + "([0-9]{1,})(\\.{0,}[0-9]{0,1})" ); 

	 if (  reg.exec( agent ) != null  ) v_version = RegExp.$1 + RegExp.$2; 

	 return v_version; 
} 


function set_facebook_share( v_url ){
//	v_url = escape(v_url);
//	v_url = encodeURI(v_url);
	v_url = encodeURIComponent(v_url);
	window.open("https://www.facebook.com/sharer/sharer.php?u="+ v_url, "fbsharepop", "width=600, height=600, scrollbars=yes");
}

function set_twitter_share( v_url, ele_name ){
//	v_url = escape(v_url);
//	v_url = encodeURI(v_url);
	v_url = encodeURIComponent(v_url);

	var v_text = $("#"+ ele_name).text();
//	v_text = escape(v_text);
//	v_text = encodeURI(v_text);
	v_text = encodeURIComponent(v_text);

	window.open("https://twitter.com/intent/tweet?url="+ v_url +"&text="+ v_text, "twsharepop", "width=600, height=600, scrollbars=yes");
}
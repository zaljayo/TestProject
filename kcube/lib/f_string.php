<?php
function urlenc( $val ){
	return urlencode($val);
}
function urldec( $val ){
	return urldecode($val);
}

function getUrl($str){
	$pos = strpos( $str, "http" );
	if( $pos === false ){
		return "http://".$str;
	}else{
		return $str;
	}
}
function selected( $val1, $val2 ){
	if($val1 == $val2){
		return " selected";
	}else{
		return "";
	}
}

function selectedArray( $arr, $val ){
	$returnStr = "";

	foreach($arr as $key => $value){
		if( $value == $val ){
			$returnStr = " selected";
			break;
		}
	}

	return $returnStr;
}

function checked( $val1, $val2 ){
	if($val1 == $val2){
		return " checked";
	}else{
		return "";
	}
}

function checkedArray( $arr, $val ){
	$returnStr = "";
	
	foreach($arr as $key => $value){
		if( $value == $val ){
			$returnStr = " checked";
			break;
		}
	}

	return $returnStr;
}

function arrayToString( $arr, $type = "int"){

	if( gettype( $arr ) == "array" ){
		$rstr = "";

		foreach( $arr as $key => $val ){
			if( $type == "int" ){
				$rstr .= $val;
			}else{
				$rstr .= " '".$val."' ";
			}
			
			
			$rstr .= ",";
		}

		return substr( $rstr, 0, strlen($rstr) -1 );
	}else{
		return $default;
	}
}

function stringToArray( $str, $default = ""){

	if( gettype( $str ) == "string" ){
		return explode(",", $str);
	}else{
		return $default;
	}
}

function eqyn( $val1, $val2 ){

	$val1 = strtolower($val1);
	$val2 = strtolower($val2);

	if($val1 == $val2){
		return true;
	}else{
		return false;
	}
}

function instryn( $string, $find ){
	$string = strtolower($string);
	$find = strtolower($find);
		
	$pos = strpos($string, $find);
	if ($pos === false) {
		return false;
	} else {
		return true;
	}
}

//글자수 제한
function cut_str($str, $len, $suffix="…"){ 
	global $g4; 

	$s = substr($str, 0, $len); 
	$cnt = 0; 
	for ($i=0; $i<strlen($s); $i++) 
		if (ord($s[$i]) > 127) 
			$cnt++; 
	if (strtoupper($g4['charset']) == 'UTF-8') 
		$s = substr($s, 0, $len - ($cnt % 3)); 
	else 
		$s = substr($s, 0, $len - ($cnt % 2)); 
	if (strlen($s) >= strlen($str)) 
		$suffix = ""; 
	return $s . $suffix; 
} 

function utf8_length($str) {
	$len = strlen($str);
	for ($i = $length = 0; $i < $len; $length++) {
		$high = ord($str{$i});
		if ($high < 0x80)//0<= code <128 범위의 문자(ASCII 문자)는 인덱스 1칸이동
			$i += 1;
		else if ($high < 0xE0)//128 <= code < 224 범위의 문자(확장 ASCII 문자)는 인덱스 2칸이동
			$i += 2;
		else if ($high < 0xF0)//224 <= code < 240 범위의 문자(유니코드 확장문자)는 인덱스 3칸이동 
			$i += 3;
		else//그외 4칸이동 (미래에 나올문자)
			$i += 4;
	}
	return $length;
}

function utf8_strcut($str, $chars, $tail = '..') {  
	if (utf8_length($str) <= $chars)//전체 길이를 불러올 수 있으면 tail을 제거한다.
		$tail = '';
	else
		$chars -= utf8_length($tail);//글자가 잘리게 생겼다면 tail 문자열의 길이만큼 본문을 빼준다.
		$len = strlen($str);
		for ($i = $adapted = 0; $i < $len; $adapted = $i) {
			$high = ord($str{$i});
			if ($high < 0x80)
				$i += 1;
			else if ($high < 0xE0)
				$i += 2;
			else if ($high < 0xF0)
				$i += 3;
			else
				$i += 4;
		if (--$chars < 0)
			break;
	}
	return trim(substr($str, 0, $adapted)) . $tail;
}

function print_content( $ptype , $str){
	$cut_str = $str;
	if(empty($str) || is_null($str)){
		$cut_str = "";
	}else{
		if($ptype == "html"){
			$cut_str = str_replace("&amp;", "&", $cut_str);
			$cut_str = str_replace("&lt;", "<", $cut_str);
			$cut_str = str_replace("&gt;", ">", $cut_str);
			$cut_str = str_replace("&#x27;", "'", $cut_str);
			$cut_str = str_replace("&quot;", "\"", $cut_str);

		}else if($ptype == "htmlbr"){
			$cut_str = str_replace("&amp;", "&", $cut_str);
			$cut_str = str_replace("&lt;", "<", $cut_str);
			$cut_str = str_replace("&gt;", ">", $cut_str);
			$cut_str = str_replace("&#x27;", "'", $cut_str);
			$cut_str = str_replace("&quot;", "\"", $cut_str);
			$cut_str = nl2br($cut_str);

		}else if($ptype == "input"){
			$cut_str = str_replace("\"", "&quot;", $cut_str);
			$cut_str = str_replace("\'", "&#x27;", $cut_str);

		}else if($ptype == "quot"){
			$cut_str = str_replace("'", "&#x27;", $cut_str);

		}else if($ptype == "jsinput"){
			$cut_str = str_replace("\"", "\"", $cut_str);
			$cut_str = str_replace("&#x2F;", "/", $cut_str);
			$cut_str = str_replace(chr(13), "\n", $cut_str);
			$cut_str = str_replace(chr(10), "\r", $cut_str);

		}else if($ptype == "js"){
			$cut_str = str_replace("<", "&lt;", $cut_str);
			$cut_str = str_replace(">", "&gt;", $cut_str);
			$cut_str = str_replace("'", "&#x27;", $cut_str);
			$cut_str = str_replace("\"", "&quot;", $cut_str);
			$cut_str = str_replace("&#x2F;", "/", $cut_str);

		}else if($ptype == "text"){
			$cut_str = str_replace("&", "&amp;", $cut_str);
			$cut_str = str_replace("<", "&lt;", $cut_str);
			$cut_str = str_replace(">", "&gt;", $cut_str);
			$cut_str = str_replace("\'", "&#x27;", $cut_str);
			$cut_str = str_replace("'", "&#x27;", $cut_str);
			$cut_str = str_replace("\"", "&quot;", $cut_str);
			$cut_str = str_replace("&#x2F;", "/", $cut_str);

		}else if($ptype == "textbr"){
			$cut_str = str_replace("<", "&lt;", $cut_str);
			$cut_str = str_replace(">", "&gt;", $cut_str);
			$cut_str = str_replace("\'", "&#x27;", $cut_str);
			$cut_str = str_replace("'", "&#x27;", $cut_str);
			$cut_str = str_replace("\"", "&quot;", $cut_str);
			$cut_str = str_replace("&#x2F;", "/", $cut_str);
			$cut_str = nl2br($cut_str);

		}else if($ptype == "editor"){
			$cut_str = str_replace("\\\"", "\"", $cut_str);
		}
	}
	return $cut_str;
}



/* 테그 검색 링크 */
function get_tag_search_make( $v_tag ){
	$arr_tag = explode (",", $v_tag);
	$v_result = "";
	for($i=0; $i<count($arr_tag); $i++){
		$v_result .= "<a href='/search/search_tag.html?search_title=". print_content('js', $arr_tag[$i]) ."'>". $arr_tag[$i] ."</a>";
		if($i < count($arr_tag)-1){
			$v_result .= ",";
		}
	}

	return $v_result;
}

/* 날짜 영문으로 변경*/
function get_eng_date( $v_date ){
	$tmp_date = substr($v_date, 0, 10);
	$v_year = substr($tmp_date, 0,4);
	$v_mon = substr($tmp_date, 5,2);
	$v_day = substr($tmp_date, 8,2);

	$json_mon = array(
		"m01" =>"January",
		"m02" =>"February",
		"m03" =>"March",
		"m04" =>"April",
		"m05" =>"May",
		"m06" =>"June",
		"m07" =>"July",
		"m08" =>"August",
		"m09" =>"September",
		"m10" =>"October",
		"m11" =>"November",
		"m12" =>"December"
	);


//	$v_mon = parseInt(v_mon);
	$v_mon = "m". $v_mon;

	$v_mon = $json_mon[$v_mon];

	if($v_mon == undefined){
		return $tmp_date;
	}else{
		return $v_mon ." ". $v_day .",". $v_year;	
	}
}
//echo get_eng_date( "2015-12-31 11:11:12" );
?>
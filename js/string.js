	/*
	1-1. 문자열의 양쪽(왼쪽, 오른쪽) 공백 제거 > Return : 공백제거후 문자 
	1-2. 문자열의 모든 공백을 제거 > Return : 공백제거후 문자
	1-3. 문자열의  왼쪽 공백을 제거 > Return : 공백제거후 문자
	1-4. 문자열의  오른쪽 공백을 제거 > Return : 공백제거후 문자
	2. 문자열의 BYTE 길이 구하기 > Return :  문자열의 바이트 수
	3. 한글 스트링 체크 > 한글만 존재하는 경우  Return : true
	3-1. 한글 byte 체크 > Return : 한글 byte
	3-2. 문자열 바이트로 자르기
	3-3. 문자열 바이트정보 가져오기
	4. 숫자 스트링 체크 > 지정된 문자열만 있는 경우 Return : True
	4.1 숫자 입력 체크
	5. 영문자,숫자 스트링 체크 > 지정된 문자열만 있는 경우 Return : True
	6. 영문자,숫자,특수문자 스트링 체크  > 지정된 문자열만 있는 경우 Return : True
	6-2. 영문자,숫자 포함여부 체크  > 영문자,숫자 포함된 경우 Return : True
	7. Select Form 값 가져오기
	8. Radio Form 값 가져오기
	9. Checkbox Form 값 가져오기
	10. 이메일 유효성 검사 > 유효한 경우 Return : True
	11. 문자열 Replace 처리  >  Return : 처리한 문자열 
	12. 문자열 시작 위치 가져오기 > Return : 시작위치에 대한 문자순번
	13. checkbox  선택 여부 > 선택시 Return : True
	14. radio 선택 여부 > 선택시 Return : True
	15. 숫자만 입력받도록 > event.returnValue = false 처리
	16. 일정크기의 값을 받았을때 다른 object로 이동
	17. 주민등록번호 체크 > 정상시 Return : True
	18. 원 단위 콤파 처리후 스트링 반환 
	19. 체크박스 전체선택/해제 (objMe : 선택 , objTarget : 대상)
	20. 라디오/체크박스 선택여부 반환
	21. 키보드 엔터 누를 경우
	22. 공백 입력 불가능
	23. 단순 공백 체크
	24. inputbox focus
	25. 사업자등록번호 체크
	26. 핸드폰 유효성 체크
	27. 날짜 유효성 체크
	28. 날짜 유효성 체크
	29. html 제거
	*/

	
	/* 1-1. 문자열의 양쪽(왼쪽, 오른쪽) 공백 제거 > Return : 공백제거후 문자 */ 
	function trim_side(pstr) {
		var search = 0
		while (pstr.charAt(search) == " ") {
			search = search + 1
		}
		pstr = pstr.substring(search, (pstr.length))
		search = pstr.length - 1
		while (pstr.charAt(search) ==" ")
		{
			search = search - 1
		}
		return pstr.substring(0, search + 1)         
	}

	/* 1-2. 문자열의 모든 공백을 제거 > Return : 공백제거후 문자 */ 
	function trim_all(a) {
		for (; a.indexOf(" ") != -1 ;) { 
			a = a.replace(" ","")
		 }
		return a;
	}

	/* 1-3. 문자열의  왼쪽 공백을 제거 > Return : 공백제거후 문자 */ 
	function trim_left(a) {
		//방법 1
		// for (; a.charAt(0) ==" " ;)
		//     {
		//             a = a.replace(" ","")
		//      }   

		//방법 2 
		 var search = 0
	 
		while ( a.charAt(search) == " ") {
		  search = search + 1
		}		
		a = a.substring(search, (a.length))
		return a;
	}

  
	/* 1-4. 문자열의  오른쪽 공백을 제거 > Return : 공백제거후 문자 */ 
  function trim_right(char_text)  {  
		var search = char_text.length - 1

		//방법1   
		while (char_text.charAt(search) ==" ") {
		   search = search - 1
		 }
		//방법2
		//for (search = (char_text.length - 1) ; char_text.charAt(search) ==" " ; search--)
		//  {
		//   }      
		return char_text.substring(0, search + 1)   
    }    


	/* 2. 문자열의 BYTE 길이 구하기 > Return :  바이트 수*/ 
	function bytelength(pstr) {
		var i, ch;
		len = pstr.length;
		for (i = 0; i < pstr.length; i++) {
			ch = pstr.substr(i,1).charCodeAt(0);
			if (ch > 127) { len++; }
		}
		return len;
	}

	/* 3. 한글 스트링 체크 > 한글만 존재하는 경우  Return : true */
	function hanstr(pstr) {
		var i, ch;
		for (i = 0; i < pstr.length; i++) {
			ch = escape(pstr.charAt(i));        //ISO-Latin-1 문자셋으로 변경
			//가 ==> %uAC00
			//힝 ==> %uD79D
			//힣 ==> %uD7A3
			if (strCharByte(ch) != 2) {
				return false;
			}
		}
		return true;
	}

	/* 3-1. 한글 byte 체크 > Return : 한글 byte */
	function strCharByte(chStr) {
		if (chStr.substring(0, 2) == '%u') {			
			if (chStr.substring(2,6) >= "AC00" && chStr.substring(2,6) <= "D7A3") {
				return 2;			/* 한글 */
			} else {
				return 1;
			}

		} else if (chStr.substring(0,1) == '%') {
			if (parseInt(chStr.substring(1,3), 16) > 127)
				return 2;			/* 한글 */
			else
				return 1;
		} else {
			return 1;
		}
	}

	/* 3-2. 문자열 바이트로 자르기 */
	function lim_str(str, len, end_str ){
		var s = 0;
		var break_yn = false;
		for (var i=0; i<str.length; i++) {
			s += (str.charCodeAt(i) > 128) ? 2 : 1;
			if (s > len){
				break_yn = true;
				break;
			}
		}

		if(break_yn){
			return str.substring(0,i) +""+ end_str;
		}else{
			return str;
		}
	}

	/* 3-3. 문자열 바이트정보 가져오기 */
	function check_byte(ele){
		var str = ele.value;
		var s = 0;
		for(var i=0; i<str.length; i++){
			s += (str.charCodeAt(i) > 128) ? 2 : 1;
		}
		return s;
	}

	/* 4. 숫자 스트링 체크 > 지정된 문자열만 있는 경우 Return : True  */
	function digitstr(pstr) {
		var valid = "0123456789";
		return checkstr(pstr, valid, 0);
	}
	/* 4.1 숫자 입력 체크 */
	function checkNum(e){
		var numVal = e.value;

		if(digitstr(numVal) || numVal == ""){
		}else{
			alert ( "숫자만 입력할 수 있습니다." );
			e.value = "";
			e.focus();
		}
	}

	/* 5. 영문자,숫자 스트링 체크 > 지정된 문자열만 있는 경우 Return : True */
	function alphadigitstr(pstr) {
		var valid = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		return checkstr(pstr, valid, 0);
	}

	/* 6. 영문자,숫자,특수문자 스트링 체크  > 지정된 문자열만 있는 경우 Return : True */
	function charstr(pstr) {
		var valid = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789~!@#$%^*()_+`-={}|[]\\:\";'<>?,./&";
		return checkstr(pstr, valid, 0);
	}

	/* 6-2. 영문자,숫자 포함여부 체크  > 영문자,숫자 포함된 경우 Return : True */
	function check_str_num(v_str, v_min, v_max)
	{

		if(v_str.length <v_min || v_str.length >v_max){
//			alert(v_min +"이상 "+ v_max +"미만으로 입력해주세요.");
			return false;
		}

		var result = (/[^a-zA-Z0-9]/).test(v_str);
		if( result ) 
		{
//			alert("숫자, 영문를 제외한 특수문자는 입력할 수 없습니다!!");
			return false;
		}

		if(!v_str.match(/\d+/g) || !v_str.match(/[a-z]+/gi))
		{
//			alert("영문과 숫자의 조합만 가능합니다.");
			return false;
		}

		return true;
	}

	function checkstr(pstr, pvalid, han) {
		var valid = pvalid;
		var tmp;
		var flag = true;

		for (var i = 0; i < pstr.length; i++) {
			flag = true;
			tmp = "" + pstr.substring(i, i+1);
			
			if (han != 1) {
				if (valid.indexOf(tmp) == -1) {
					return false;
				}
			} else {
				ch = escape(pstr.charAt(i));  // ISO-Latin-1 문자셋으로 변경
				if (valid.indexOf(tmp) == -1 && strCharByte(ch) != 2)
				{
					return false;
				}
			}
		}
		return true;;
	}

	/* 7. Select Form 값 가져오기 */
	function get_select_value(sset) { 
		for (var i = 0; i < sset.length; i++ ) {
			if ( sset.options[i].selected ) {
				return (sset[i].value);
			}
		}
		return "";
	}

	/* 8. Radio Form 값 가져오기 */
	function get_radio_value(rset) {
		if (rset.length) {
			for (var i = 0; i < rset.length; i++ ) {
				if ( rset[i].checked ) {
					return (rset[i].value);
				}
			}
			return ""; 
		} else {
			if (rset.checked) {
				return rset.value;
			} else {
				return "";
			} 
		}
	}

	/* 9. Checkbox Form 값 가져오기 */
	function get_checkbox_value(cset) {
		if (cset.length) {
			for (var i = 0; i < cset.length; i++ ) {
				if ( cset[i].checked ) {
					return (cset[i].value);
				}
			}
			return "";
		} else {
			if (cset.checked) {
				return cset.value;
			} else {
				return "";
			}
		}
	}


	/* 10. 이메일 유효성 검사 : 유효한 경우 Return : True */
	function isEmailstr(emailStr) {
		var checkTLD = 1;
		var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
		var emailPat = /^(.+)@(.+)$/;
		var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
		var validChars="\[^\\s" + specialChars + "\]";
		var quotedUser="(\"[^\"]*\")";
		var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
		var atom = validChars + '+';
		var word="(" + atom + "|" + quotedUser + ")";
		var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
		var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
		var matchArray=emailStr.match(emailPat);

		if (matchArray == null) {
			return false;
		}

		var user=matchArray[1];
		var domain=matchArray[2];

		for (i=0; i<user.length; i++) {
			if (user.charCodeAt(i)>127) {
				return false;
			}
		}

		for (i=0; i<domain.length; i++) {
			if (domain.charCodeAt(i)>127) {
				return false;
			}
		}

		if (user.match(userPat) == null) {
			return false;
		}
		var IPArray = domain.match(ipDomainPat);
		if (IPArray != null) {
			for (var i = 1; i <= 4; i++) {
				if (IPArray[i] > 255) {
					return false;
				}
			}
			return true;
		}

		var atomPat = new RegExp("^" + atom + "$");
		var domArr = domain.split(".");
		var len = domArr.length;
		for (i = 0; i < len; i++) {
			if (domArr[i].search(atomPat)==-1) {
				return false;
			}
		}

		if (checkTLD && domArr[domArr.length-1].length!=2 && 
			domArr[domArr.length-1].search(knownDomsPat)==-1) {
			return false;
		}

		if (len<2) {
			return false;
		}
		return true;
	}

	/* 11. 문자열 Replace 처리  >   Return : 처리한 문자열  */
	/*  msrc : 대상 문자열 , sstr : 대상문자 ,  rstr : 변경할 문자 */
	/* 샘플 : str_ds.replace(/\-/gi, "") 이것은 "-" 을 변환함 / 이와 같이 하지 않을경우 첫문자만 replace 처리됨 */
	function replace(msrc,sstr,rstr) {
		   var idx,sleft,sright;
		   msrc+="";
		   sstr+="";
		   rstr+="";
		   idx=msrc.indexOf(sstr);
		   if (idx > -1) {
				  sleft = msrc.substring(0,idx) + rstr;
				  sright = msrc.substring(idx+sstr.length);
				  return sleft + replace(sright,sstr,rstr);
		   } else {
				  return msrc;
		   }
	}

	/* 12. 문자열 시작 위치 가져오기 > Return : 시작위치에 대한 문자순번 */
	function InStr(strSearch , charSearchFor){
		var return_val=-1;

		if(strSearch && charSearchFor ){
			for(i=0; i< strSearch.length; i++){
				  if (charSearchFor == strSearch.substr(i,charSearchFor.length)){
						return_val = i+1;
						break;
				  }
			}
		}
		return return_val;
	}

	/* 13. checkbox  선택 여부 > 선택시 Return : True */
	function isCheck(obj) {
		if(obj == 'undefined' || !obj) {
				return false;
		}
 		if (obj.length) {
			for(i=0;i<obj.length;i++) if (obj[i].checked) return true;
		} else {
			return obj.checked;
		}
		return false;
	}

	/* 14. radio 선택 여부 > 선택시 Return : True */
	function isRadio(obj) {
		if(obj == 'undefined' || !obj) {
				return false;
		}
		if (obj.length) {
			for(i=0;i<obj.length;i++) if (obj[i].checked) return true;
		} else {
			return obj.checked;
		}
		return false;
	}

	/* 15. 숫자만 입력받도록 > event.returnValue = false 처리 */
	function onlyNum(obj) {
		//return !(event.keyCode < 48 || event.keyCode > 57);
		event.returnValue = !(event.getAttribute("keyCode") < 48 || event.getAttribute("keyCode") > 57 );
	}

	/* 16. 일정크기의 값을 받았을때 다른 object로 이동 */
	/* obj : 현재 필트 , len : 문자길이 , nobj : 이동될 필드 */	
	function MoveObject(obj , len , nobj){
		if(obj.value.length == len){
			nobj.focus();
			return true;
		}
		return false;
	}

	/* 17. 주민등록번호 체크 > 정상시 Return : True */
	/* fpersono1 : 주민번호 앞자리 오브젝트, fpersono2  : 주민번호 뒷자리 오브젝트 , fname : 체크네임 스트링 */
	function validPersono(fpersono1, fpersono2, fname) {
		var str1 = trim_side(fpersono1.value);
		var str2 = trim_side(fpersono2.value);
		var len1 = bytelength(str1);
		var len2 = bytelength(str2);
		if (!fname)		fname = "주민등록번호";
		
		var str = String(str1) + String(str2);
		var len = bytelength(str);

        var sex = str2.substring(0,1);

        if (str1 == "" || len1 == 0 || str2 == "" || len2 == 0) {
			alert(fname+"는 반드시 입력해야 합니다. "+fname+"를 입력하시기 바랍니다.");
			fpersono1.select();
			return false;
		}

        if (len1 != 6 || len2 != 7 || len != 13) {
            alert(fname+" 자릿수가 틀립니다. "+fname+"를 확인하시고 다시 입력하시기 바랍니다");
            return false ;
        }   
        
        if (!digitstr(str1) || !digitstr(str2) || !digitstr(str)) {
            alert(fname+"는 숫자만으로 구성되어야 합니다. "+fname+"를 확인하신후 다시 입력하시기 바랍니다");
            return false;
        }
        
        if (sex == "9" || sex == "0") {
            alert(fname+" 성별부분을 잘못 입력하였습니다. "+fname+"를 확인하신후 다시 입력하시기 바랍니다");
			fpersono2.select();
            return false;
        }
        /*
        if ((str1 == "570908" && str2 == "1009010") ||
        	(str1 == "010410" && str2 == "3495917"))
        {
        	return true;
        }
        */
        if (sex == "1" || sex == "2" || sex == "3" || sex == "4") {
			var chk = 0 ;
			total = 0;
			temp = new Array(13);

			for(i = 1; i <= 6; i++) {
				temp[i] = str1.charAt(i-1);
			}

			for(i = 7; i < 13; i++) {
				temp[i] = str2.charAt(i-7);
			}

			for(i = 1; i <= 12; i++ ) {
				k = i + 1;
				if( k >= 10 ) {
					k = k % 10 + 2;
				}
				total = total + temp[i] * k;
			}

			mm = temp[3] + temp[4];
			dd = temp[5] + temp[6];
			temp[13] = str2.charAt(6);

			totalmod = total % 11;
			chd = (11 - totalmod) % 10;

			if (chd == temp[13] && mm < 13 && dd < 32 &&
				(temp[7]==1 || temp[7] == 2 || temp[7] == 3 || temp[7] == 4)) {
				return true;
			}
			alert("유효하지 않은 "+fname+"입니다. "+fname+"를 확인하시고 다시 입력하시기 바랍니다");
			return false;
		}
		else
		{
			var sum = 0;
			var odd = 0;
			var reg_no = str1 + str2;

			buf = new Array(13);
			for (i = 0; i < 13; i++) buf[i] = parseInt(reg_no.charAt(i));

		    odd = buf[7]*10 + buf[8];
    
		    if (odd%2 != 0) {
				alert("유효하지 않은 "+fname+"입니다. "+fname+"를 확인하시고 다시 입력하시기 바랍니다");
				return false;
			}

			if ((buf[11] != 6)&&(buf[11] != 7)&&(buf[11] != 8)&&(buf[11] != 9)) {
				return false;
			}

			multipliers = [2,3,4,5,6,7,8,9,2,3,4,5];
			for (i = 0, sum = 0; i < 12; i++) sum += (buf[i] *= multipliers[i]);

			sum=11-(sum%11);

			if (sum>=10) sum-=10;

	    	sum += 2;

		    if (sum>=10) sum-=10;

		    if ( sum != buf[12]) {
				alert("유효하지 않은 "+fname+"입니다. "+fname+"를 확인하시고 다시 입력하시기 바랍니다");
				return false;
			} else {
				return true;
			}
		}
	}

	/* 18. 원 단위 콤파 처리후 스트링 반환 */
	function addCommas( strValue ){ 
		var strValue = strValue + "";
		var objRegExp = new RegExp('(-?[0-9]+)([0-9]{3})'); 
		while (objRegExp.test(strValue)) { 
			strValue = strValue.replace(objRegExp, '$1,$2'); 
		} 
		return strValue; 
	} 

	/* 19. 체크박스 전체선택/해제 (objMe : 선택 , objTarget : 대상) */
	function checkboxchg(objMe, objTarget) {
		if(objTarget == 'undefined' || !objTarget) {
				return false;
		} else { 
			var TargetLen = objTarget.length;
			if(TargetLen) {  // 여러 개일 경우
				for(var i = 0; i<TargetLen;i++) {
					objTarget[i].checked = objMe.checked;
				}
			} else { 
				objTarget.checked = objMe.checked;
			}
		}
	}

	/* 20. 라디오/체크박스 선택여부 반환 */
	function validChoice(obj) {
		if(obj == 'undefined' || !obj) {
				return false;
		} else {
			if(obj.length == null) {
				if (obj.checked) {
					return true;
				} else {
					return false;
				}
			} else {
				var len = obj.length;
				for (var z = 0; z < len; z++) {
					if(obj[z].checked) {
						return true;
						break;
					}
				}
				return false;
			}
		}
	}

	/* 21*******************************************************************
	*  1. 함수명		:  Check_Enter
	*  2. 입력값		:
	*  3. 리턴값		:  true false
	*  4. 내용			:  키보드 엔터 누를 경우
	*  5. 특이사항		:
	********************************************************************/
	function Check_Enter() 	{
		if(event.keyCode==13)
		   return true;
		else
		   return false;
	}


	/* 22******************************************************************
	*  1. 함수명		:  NoSpace
	*  2. 입력값		:
	*  3. 리턴값		:  event -> true false
	*  4. 내용			:  공백 입력 불가능
	*  5. 특이사항		:  style="ime-mode:disabled"
	********************************************************************/
	function NoSpace(){
		if(event.keyCode==32)
			event.returnValue =false;
	}


 //23. 단순 공백체크
 function validNull(field, fname) {
	var str =  trim_side(field.value);
	var len = bytelength(str);
	if (str == "" || len == 0 ) {
		alert(fname+"는 반드시 입력해야 합니다.\n"+ fname +"를 입력하시기 바랍니다.");
		return false;
	} else {
		return true;
	}
 }


// 24. inputbox focus
function inputfous(obj) {
	obj.value = '';
	obj.focus();
}


//25. 사업자등록번호 체크
function chk_companynum(saup1,saup2,saup3) {
	 var checkID = new Array(1, 3, 7, 1, 3, 7, 1, 3, 5, 1);
	 var bizID = ""+ saup1 + saup2 + saup3;
	 var i, Sum=0, c2, remander;
	 
	 for (i=0; i<=7; i++) Sum += checkID[i] * bizID.charAt(i);

	 c2 = "0" + (checkID[8] * bizID.charAt(8));
	 c2 = c2.substring(c2.length - 2, c2.length);

	 Sum += Math.floor(c2.charAt(0)) + Math.floor(c2.charAt(1));

	 remander = (10 - (Sum % 10)) % 10 ;
	 
	 if (Math.floor(bizID.charAt(9)) != remander)
	 {
	  // alert ("정확한 사업자 등록번호를 입력하세요");
	  return false;
	 } else {
		return true;
	}
}



//26. 핸드폰 유효성 체크 (obj)
function validHp(obj) {
	var str = obj.value;
	var len = bytelength(str);
	if (str != "" || len != 0 ) {
		var str = str.replace(/\-/gi, "")
		if(!digitstr(str)) {
			//alert("핸드폰번호는 숫자로만 입력하십시오.");
			return false;
		}

		if(str.length < 10 || str.length > 11){
			//alert("올바른 핸드폰번호가 아닙니다.");
			return false;
		}
		
		var hpno = str.substring(0, 3)
		if(hpno != '010' && hpno != '017' && hpno != '016'  && hpno != '011' && hpno != '018' && hpno != '019') {
			//alert("올바른 핸드폰번호가 아닙니다.");
			return false;
		}
	}
	return true;
}


//27. 유선전화 유효성 체크 (str)
function validTel(str) {
	var flag = false;
	var len = bytelength(str);

	if (str != "" || len != 0 ) {
		var str = str.replace(/\-/gi, "");

		if(str.length < 10 || str.length > 12) {
			//alert("올바른 연락처가 아닙니다.");
			return false;
		}

		if(!digitstr(str)) {
			//alert("연락처는 숫자로만 입력하십시오.");
			return false;
		}

		if(str.length < 10 || str.length > 11){
			//alert("올바른 연락처가 아닙니다.");
			return false;
		}

		var firststr = str.substring(0, 3);
		var arrstr = new Array()
		arrstr[0] = "02"
		arrstr[1] = "051"
		arrstr[2] = "053"
		arrstr[3] = "032"
		arrstr[4] = "062"
		arrstr[5] = "042"
		arrstr[6] = "052"
		arrstr[7] = "044"
		arrstr[8] = "031"
		arrstr[9] = "033"
		arrstr[10] = "043"
		arrstr[11] = "041"
		arrstr[12] = "063"
		arrstr[13] = "061"
		arrstr[14] = "054"
		arrstr[15] = "055"
		arrstr[16] = "064"
		arrstr[17] = "070"
		
		for(var i=0; i<=arrstr.length; i++) {
			if(arrstr[i] == firststr) {
				flag = true;
				break;
			}
		}

		if(!flag) {
			return false;
		}
	}
	return true;
}

// 28. 날짜 유효성 체크
function vaildDate(strdt) {
	var str = strdt.replace(/\-/gi, "");
	if(str.length != 8) return false;
	var y = str.substr(0,4);
	var m = str.substr(4,2) -1;
	var d = str.substr(6,2);

	var dt = new Date(y,m,d);
	if(dt.getFullYear() == y && dt.getMonth() == m && dt.getDate() == d ) {return true;}
	else {return false;}
}

// 29. html 제거
/*
ex) var str = strip_tags('<p>Kevin</p> <b>van</b> <i>Zonneveld</i>', '<i><b>'); ==> <i><b> 테그빼고 모든 html 제거
*/
function strip_tags (input, allowed) {
	allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
	var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
	commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
	return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1){return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
	});
}
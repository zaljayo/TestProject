<?php
/* 유니크한 파일명 가져오기 */
function GetUniqFileName($dir, $file_name){
  $FileExt = substr(strrchr($file_name, "."), 1); // 확장자 추출
  $FileName = substr($file_name, 0, strlen($file_name) - strlen($FileExt) - 1); // 화일명 추출
 
  $ret = "$FileName.$FileExt";
  $FileCnt = 0;
  while(file_exists($dir.$ret)) // 화일명이 중복되지 않을때 까지 반복
  {
    $FileCnt++;
    $ret = $FileName."(".$FileCnt.").".$FileExt; // 화일명뒤에 (_1 ~ n)의 값을 붙여서....
  }
  return($ret); // 중복되지 않는 화일명 리턴
}


/* 파일사이즈 가져오기 */
function get_filesize($file){
	if(file_exists($file)){
		return (int)(filesize($file)/1024);
	}else{
		return 0;
	}
}


/* 파일 업로드 */
function file_upload($dir, $url, $file,  $db_file = "", $del_file_yn = "N"){

	$ext = substr(strrchr($db_file,"."),1);
	$ext = strtolower($ext);
	$file_info = array(
					"name" => $db_file,
					"size" => get_filesize($dir . $db_file), 
					"ext" => $ext,
					"url" => $url
				);

	$error = file_error($file['error']);
	if($error == "4"){ //-- 업로드된 파일이 없으면 기존 파일명으로 교체
		return $file_info;
		exit;
	}else if($error != "0"){
		PrintMsg( $error );
		exit;
	}

	$name = $file['name'];
	$name = iconv("UTF-8", "EUC-KR", $file['name']); 

	$tmp_name = $file['tmp_name'];

	$name = preg_replace("/\s+/", "", $name);
	$name = GetUniqFileName($dir, $name);
	$dir.= $name;

	$name = iconv("EUC-KR", "UTF-8", $name);
	$ext = substr(strrchr($name,"."),1);
	$ext = strtolower($ext);

	$file_info = array(
					"name" => $name,
					"size" => $file['size'], 
					"ext" => $ext,
					"url" => $url
				);


/*
	echo $dir."<br>";
	echo $tmp_name."<br>";
*/
	if(move_uploaded_file($tmp_name, $dir)){
		return $file_info;
	}else{
		return $file_info;
	}
}


/* 파일 업로드 오류 체크 */
function file_error( $file ){
	$msg = "0";
	if ($file > 0) {
		switch ($file) {
			case 1:
				$msg = 'php.ini 파일의 upload_max_filesize 설정값을 초과함(업로드 최대용량 초과)';
				break;
			case 2:
				$msg = 'Form에서 설정된 MAX_FILE_SIZE 설정값을 초과함(업로드 최대용량 초과)';
				break;
			case 3:
				$msg = '파일 일부만 업로드 됨';
				break;
			case 4:
//				$msg = '업로드된 파일이 없음';
				$msg = '4';
				break;
			case 6:
				$msg = '사용가능한 임시폴더가 없음';
				break;
			case 7:
				$msg = '디스크에 저장할수 없음';
				break;
			case 8:
				$msg = '파일 업로드가 중지됨';
				break;
			default:
				$msg = '시스템 오류가 발생';
				break;
		}
	}
	return $msg;
}


/* 파일 삭제 */
function filedel($dir, $file){
	@unlink( $dir.$file );
}

/* 업로드 가능 파일 체크 */
function get_upload_file_check( $dir, $file ){
	$file = setnull($file, "");

	$result = true;
	$not_ext = "";
	$arr_len = 0;
	$ext = "";
	$not_ext = ",js,jsp,php,php3,php5,htm,html,phtml,asp,aspx,asp,ascx,cfm,cfc,pl,bat,exe,dll,reg,cgi,inc,";

	if($file != ""){
		$arr_file = explode(".", $file);
		$arr_len = count($arr_file);
		$ext = $arr_file[$arr_len-1];

/*
echo $not_ext ."<br>";
echo $ext ."<br>";
*/

//		if(instryn("txt", not_ext, ","& ext &",") Then
		if(instryn($not_ext, ",". $ext .",")){
			filedel($dir, $file);
			$result = false;
		}else{
			$result = true;
		}

	}else{
		$result = true;
	}

	if(!$result){
		printmsg("업로드 하실수 없는 파일입니다.");
		exit;
	}
}
?>
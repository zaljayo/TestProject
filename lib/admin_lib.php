<?
/* 보안키 */
$sec_key = "!@#rhksflwkqhdks!@#";

/* 로그인 정보 셋팅 */
function set_admin( $id = "", $auth = "", $name = "" ){
	global $sec_key;
//	$_SESSION["admin"] = $id;
//	$_SESSION["admin_key"] = md5($id.$sec_key);
	if(eqyn($id, "")){
		set_cookie( "admin", "", -365 );
		set_cookie( "admin_key", "", -365 );
		set_cookie( "admin_auth", "", -365 );
		set_cookie( "admin_name", "", -365 );

	}else{
		set_cookie( "admin", $id, 365 );
		set_cookie( "admin_key", md5($id.$sec_key.$auth), 365 );
		set_cookie( "admin_auth", $auth, 365 );
		set_cookie( "admin_name", $name, 365 );
	}
/*
	echo md5($id.$sec_key.$auth)."<br>";
	echo get_cookie("admin_key")."<br>";
	echo get_cookie("admin_auth")."<br>";
	exit;
*/
}

/* 로그인 아이디 정보 가져오기 */
function get_admin(){
	global $sec_key;

//	$s_id = $_SESSION["admin"];
//	$s_sec_key = $_SESSION["admin_key"];
	$s_id = get_cookie("admin");
	$s_sec_key = get_cookie("admin_key");
	$s_auth = get_cookie("admin_auth");
	$s_auth = setnull($s_auth, "-");

	$v_sec_key = md5($s_id.$sec_key.$s_auth);
/*
	echo "$sec_key<br>"; 
	echo "$s_id<br>"; 
	echo "$s_sec_key<br>"; 
	echo "$v_sec_key<br>"; 
	exit;
*/
	if($s_id == "" || $s_sec_key != $v_sec_key){
		$s_id = "";
	}
	return $s_id;
}


/* 로그인 권한 정보 가져오기 */
function get_admin_auth(){
	$s_auth = get_cookie("admin_auth");
	$s_auth = setnull($s_auth, "-");

	return $s_auth;
}

/* 로그인 이름 정보 가져오기 */
function get_admin_name(){
	$s_name = get_cookie("admin_name");
	$s_name = setnull($s_name, "");

	return $s_name;
}

/* 로그인 체크 */
function admin_check( $page_code = "", $target = "" ){
	global $dbcon;
	global $admin_dir;

	if(get_admin() == ""){
		session_destroy();
		set_admin("");
		printmsg("로그인 후 이용해주세요.");

		if(eqyn($target, "")){
			gourl( $target, $admin_dir."login.php" );
		}else{
			gourl( $target, $admin_dir."login.php" );
			printjs("top.window.close();");
		}

	}else{
		if(!eqyn(get_admin_auth(), "A") && $page_code != ""){
			if(!$dbcon){
				set_dbcon();
			}

			$sql = "
					and fk_ama_am_userid = '". get_admin() ."'
					and fk_ama_amm_key = '$page_code'
			";
//			echo $sql;
			$cnt = sql_count("tb_admin_mem_auth", $sql);
//			exit;
			if($cnt == 0){
				session_destroy();
				set_admin("");
				printmsg("권한이 없습니다. 로그인 후 이용해주세요.");
				if(eqyn($target, "")){
					gourl( $target, $admin_dir."login.php" );
				}else{
					gourl( $target, $admin_dir."login.php" );
					printjs("top.window.close();");
				}
			}
		}
	}
}
?>
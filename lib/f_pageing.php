<?php
$ipage = rqint( "page", 1, "g");
if($ipage == ""){
	$ipage = 1;
}

$ilist_size = 10;
$ilist_size = rqint( "list_size", 10, "g");
if($ilist_size == ""){
	$ilist_size = 10;
}

$page_size = 10;
$recordcount = 0;



//$fild = $_GET["fild"];
//$search_title = $_GET["search_title"];
$fild = rqstr("fild", "", "g");
$search_title = rqstr("search_title", "", "g");
//$search_title = iconv('euc-kr', 'utf-8', $search_title);
//echo $search_title;
$search_title_str = Print_Content( "input" , $search_title);


function get_recordnum( $num ){
	global $recordcount;
	global $ipage;
	global $ilist_size;
	return $recordcount - ($ipage-1) * $ilist_size - $num + 1;
}

/* 페이징 수량 */
function get_pagecnt(){
	global $ilist_size;
	global $page_size;
	global $recordcount;

	$pagecount = floor($recordcount/$ilist_size);
	if(($recordcount%$ilist_size) >0){
		$pagecount++;
	}
//	echo "<br>pagecount : $pagecount<br>";
	return $pagecount;
}


/* 페이지 정보 */
function pageing_admin(){
	global $ilist_size;
	global $page_size;
	global $recordcount;
	global $ipage;
	global $admin_dir;

	$return_val = "";
	
	$pagecount = get_pagecnt();


	if($recordcount > 0){
		$n_page = floor(($ipage-1)/$page_size);
		if($n_page == 0){
			$n_page = 0;
		}
		$n_page++;

		$s_page = floor(($n_page-1) * $page_size); // 시작 페이지
		if($s_page < 1){
			$s_page = 1;
		}
		if($s_page >= $page_size){
			$s_page = $s_page + 1;
		}

		$e_page = $n_page * $page_size; // 종료 페이지
		if($e_page > $pagecount){
			$e_page = $pagecount;
		}

		$go_page = floor(($s_page-2)/$page_size)*$page_size+1;
		if($go_page < 1){
			$go_page = 1;
		}

/*
echo "
<br><br>
recordcount : $recordcount<br>
page_size : $page_size<br>
n_page : $n_page<br>
s_page : $s_page<br>
e_page : $e_page<br>
go_page : $go_page<br>
<br><br>
";
*/


		$return_val .= "<table border='0' align='center' cellpadding='0' cellspacing='0'>";
		$return_val .= "<tr>";
		$return_val .= "<td >";
		$return_val .= "<a href='javascript:goto_page(1);'><img src='". $admin_dir ."images/btn/prev_02.gif' border='0' align='absmiddle' style='margin-right:10px;' alt='처음' /></a>";
		$return_val .= "<a href='javascript:goto_page(". $go_page .");'><img src='". $admin_dir ."images/btn/prev_01.gif' border='0' align='absmiddle' style='margin-right:10px;' alt='이전' /></a>";


		//페이지 번호 리스트 출력
		for($i = $s_page; $i<=$e_page; $i++){
			if($i == $ipage){
				$return_val .= " <a href=\"javascript:goto_page(". $i .");\" style='color:#b86e01'><strong>". $i ."</strong></a> ";
			}else{
				$return_val .= " <a href=\"javascript:goto_page(". $i .");\">". $i ."</a> ";
			}
		}

		$go_page = $e_page+1;
		if($go_page > $pagecount){
			$go_page = $pagecount;
		}

		$return_val .= "<a href='javascript:goto_page(". $go_page .");'><img src='". $admin_dir ."images/btn/next_01.gif' border='0' align='absmiddle' style='margin-left:10px;'alt='다음' /></a>";
		$return_val .= "<a href='javascript:goto_page(". $pagecount .");'><img src='". $admin_dir ."images/btn/next_02.gif' border='0' align='absmiddle' style='margin-left:10px;'alt='마지막' /></a>";

		$return_val .= "</tr>";
		$return_val .= "</table>";

	}
	return $return_val;
}
?>
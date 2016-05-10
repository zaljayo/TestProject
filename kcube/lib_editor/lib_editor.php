<?
//Dim editor_form_name		'-- form 이름
//Dim editor_contents			'-- 작성된 본문
//Dim editor_ele_name		'-- editor element name

//Dim editor_upload_key		'-- 업로드 폴더 key
//Dim editor_img_rs			'-- 업로드 이미지 레코드셋
//Dim editor_file_rs				'-- 업로드 파일 레코드셋



//Dim arr_tx_attach_image , arr_tx_attach_file


$CONTENTS_ICON = "/lib_editor/images/icon/editor/";
$CONTENTS_IMG = "/lib_editor/images/deco/contents/";



$editor_board_idx = "";		// 게시글 key
$editor_ifm_name = "";		// iframe 이름
$editor_form_name = "";		// form 이름
$editor_contents = "";		// 작성된 본문
$editor_ele_name = "";		// editor element name
$editor_ele_val = "";		// editor element value
$editor_height = "";		// editor height

$editor_file_kind = "";			// 업로드 파일 구분 (에디터가 여러개일경우 구분자로 사용)
$editor_upload_key = "";		// 업로드 폴더 key
$editor_img_rs = "";			// 업로드 이미지 레코드셋
$editor_file_rs = "";			// 업로드 파일 레코드셋


$arr_tx_attach_image = array();
$arr_tx_attach_file = array();


$editor_board_idx = rqint("editor_board_idx", 0, "g");
$editor_ifm_name = rqstr("editor_ifm_name", "", "g");
$editor_form_name = rqstr("editor_form_name", "", "g");
$editor_contents = rqstr("editor_contents", "", "g");
$editor_ele_name = rqstr("editor_ele_name", "", "g");
$editor_ele_val = rqstr("editor_ele_val", "", "g");
$editor_height = rqint("editor_height", 0, "g");

$editor_file_kind = rqstr("editor_file_kind", "0", "g");
$editor_upload_key = rqstr("editor_upload_key", "", "g");
?>
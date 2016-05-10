<?
include $_SERVER["DOCUMENT_ROOT"]."/lib/web_lib.php";
include $server_root_path."/lib/f_dbcon.php";
include $server_root_path."/lib/f_string.php";
include $server_root_path."/lib/f_file.php";
include $server_root_path."/lib_editor/lib_editor.php";

$file_kind = rqstr("file_kind", "file");
$editor_upload_key = rqstr("editor_upload_key", "");

get_updir( $editor_upload_key );


$tmp_file = file_upload($GLB_UP_FILE_ROOTDIR, $GLB_UP_FILE_URL, $_FILES['file'], $rq_mb[db_mb_img1], $rq_mb[del_mb_img1]);
//print_r($tmp_file);
//exit;

$file_name = $tmp_file["name"];
$file_size = $tmp_file["size"];
$file_ext =  $tmp_file["ext"];
//$file_url =  Left(GLB_UP_FILE_URL , InStrRev(GLB_UP_FILE_URL,"/")-1)
$file_url =  $tmp_file["url"];
$file_desc = rqstr("file_desc", "");

if(eqyn($file_kind, "file")){
	if(eqyn($file_desc, "")){
		$file_desc = "첨부파일";
	}

}else if(eqyn($file_kind, "image")){
	if(eqyn($file_desc, "")){
		$file_desc = "첨부이미지";
	}

}else{
	if(eqyn($file_desc, "")){
		$file_desc = "첨부파일";
	}
}


if(eqyn($file_kind, "file")){
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		var _mockdata = {
			'attachurl': '<?= $file_url ?><?= $file_name ?>',
			'filemime': 'image/<?= $file_ext ?>',
			'filename': '<?= $file_name ?>',
			'filesize': <?= $file_size ?>,
			'alt': '<?= $file_desc ?>'
		};
		parent.done(_mockdata);
	//-->
	</SCRIPT>
<?
}else if(eqyn($file_kind,"image")){
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		var _mockdata = {
			'imageurl': '<?= $file_url ?><?= $file_name ?>',
			'filename': '<?= $file_name ?>',
			'filesize': <?= $file_size ?>,
			'imagealign': 'C',
			'originalurl': '<?= $file_url ?><?= $file_name ?>',
			'thumburl': '<?= $file_url ?><?= $file_name ?>',
			'alt': '<?= $file_desc ?>'
		};
		parent.done(_mockdata);
	//-->
	</SCRIPT>
<?
}
?>
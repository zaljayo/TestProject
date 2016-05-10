<?
include $_SERVER["DOCUMENT_ROOT"]."/lib/web_lib.php";
include $server_root_path."/lib/f_dbcon.php";
include $server_root_path."/lib/f_string.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>이미지 첨부</title> 
<script src="../../js/popup.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="../../css/popup.css" type="text/css"  charset="utf-8"/>
<script type="text/javascript">
	function done(_mockdata) {
		if (typeof(execAttach) == 'undefined') { //Virtual Function
	        return;
	    }

		execAttach(_mockdata);
		closeWindow();
	}

	function initUploader(){
	    var _opener = PopupUtil.getOpener();
	    if (!_opener) {
	        alert('잘못된 경로로 접근하셨습니다.');
	        return;
	    }
	    
	    var _attacher = getAttacher('image', _opener);
		document.getElementById("editor_upload_key").value = opener.document.getElementById("editor_upload_key").value;
	    registerAction(_attacher);
	}

	function file_up(){
		var fm = document.getElementById("filefm");
		if(fm.file.value == ""){
			alert("업로드 하실 파일을 선택해주세요.");
			fm.file.focus();
			return;
		}

		if(fm.file_desc.value == ""){
			alert("이미지 설명을 입력해주세요.");
			fm.file_desc.focus();
			return;
		}

		fm.submit();
	}
</script>
</head>
<body onload="initUploader();">
<form name="filefm" id="filefm" method="post" enctype="multipart/form-data" action="file_upload_proc.php" target="_proc">
	<input type="hidden" name="editor_upload_key" id="editor_upload_key" value="">
	<input type="hidden" name="file_kind" id="file_kind" value="image">

	<div class="wrapper ">
		<div class="header">
			<h1>사진 첨부</h1>
		</div>	
		<div class="body">
			<dl class="alert">
				<dt>사진 첨부 확인</dt>
				<dd>
					<input type="file" name="file" id="file"><br>
					이미지 설명 : <input type="text" name="file_desc" id="file_desc" value="">	<br>

					확인을 누르시면 임시 데이터가 사진첨부 됩니다.<br /> 
					인터페이스는 소스를 확인해주세요.
				</dd>
			</dl>
		</div>

		<div class="footer" style="height:39px">
			<p><a href="#" onclick="closeWindow();" title="닫기" class="close">닫기</a></p>
			<ul>
				<li class="submit"><a href="javascript:file_up();" title="등록" class="btnlink">등록</a> </li>
				<li class="cancel"><a href="#" onclick="closeWindow();" title="취소" class="btnlink">취소</a></li>
			</ul>
		</div>
	</div>
</form>
<?= get_iframe("_proc") ?>
</body>
</html>
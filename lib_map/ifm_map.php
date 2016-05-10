<?
include $_SERVER["DOCUMENT_ROOT"]."/lib/web_lib.php";
include $server_root_path."/lib/f_dbcon.php";
include $server_root_path."/lib/f_string.php";
include $server_root_path."/lib/f_pageing.php";

//lib_map/ifm_map.asp?cmd=|not_info|not_click|search|
$cmd = rqstr("cmd", "", "g");
$rq_gpsx = rqstr("gpsx", "", "g");
$rq_gpsy = rqstr("gpsy", "", "g");
$rq_info_title = rqstr("info_title", "", "g");
$rq_gpsx = setnull($rq_gpsx, $GLB_DEF_PGS_X);
$rq_gpsy = setnull($rq_gpsy, $GLB_DEF_PGS_Y);
$rq_info_title = setnull($rq_info_title, "<b>회사 위치</b>");


$rq_gm_zoom = rqint("gm_zoom", 15, "g");

$lng = rqstr("lng","" , "g");
?>
<!DOCTYPE html>
<html>
<head>
<title>Map</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<? include $server_root_path."/admin_mgr/inc/inc_header.php"; ?>
<style type="text/css">
	html { height : 100% }
	body { height : 100%; margin: 0; padding: 0 }
	#map_canvas { width:100%; height:100% }
</style>
<!--script src="https://maps.googleapis.com/maps/api/js?key=<?= $GLB_GOOGLE_MAP_KEY ?>" async defer></script-->
<!--script src="https://maps.googleapis.com/maps/api/js?key=<?= $GLB_GOOGLE_MAP_KEY ?>&language=en&sensor=false"></script-->
<script src="https://maps.googleapis.com/maps/api/js?key=<?= $GLB_GOOGLE_MAP_KEY ?>&language=<?= $lng ?>" async defer></script>

<script type = "text/javascript">
var map;
var infowindow; // infoWindow Object를 담을 변수
var markers = []; // Marker Object를 담을 변수

var v_info = "<?= $rq_info_title ?>";
var image = "images/googlemap_icon.png"; // 새롭게 적용할 아이콘 이미지 *
var shadow = "images/googlemap_icon_shadow.png"; // 새롭게 적용할 아이콘 이미지의 그림자 *

function initialize(){

<?
if(instryn($cmd, "|search|")){
?>
	var win_height = $("body").height();
	var v_mem_list_height = 120;
	$(".mem_list").height(v_mem_list_height +"px");
	$("#map_canvas").height(win_height - v_mem_list_height - 30 +"px");
<?
}
?>

	var latlng = new google.maps.LatLng(<?= $rq_gpsx ?>, <?= $rq_gpsy ?>); // 중앙지점 좌표값 입력 – 남한산성 로터리
	var myOptions = {
		zoom: <?= $rq_gm_zoom ?>,
		center:latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	google.maps.event.addListener(map, 'click', function(event) {
<?
if(!instryn($cmd,"|not_click|")){
?>
		addMarker(event.latLng);
<?
}
?>
	});

	var contentString = "<div>"+ v_info +"</div>";
	infowindow = new google.maps.InfoWindow({
		content: contentString
	});

	addMarker(latlng);

	try{
		parent.map_focus();
	}catch(e){
	}

	$(window).resize(function() {
		// (the 'map' here is the result of the created 'var map = ...' above)
//		google.maps.event.trigger(map, "resize");
		map.setCenter(latlng);
	});
}


// Add a marker to the map and push to the array.
function addMarker(location) {
	deleteMarkers();

	var myIcon = new google.maps.MarkerImage(image, null, null, null, new google.maps.Size(44,52));

	var contentString = "<div>"+ v_info +"</div>";
	infowindow = new google.maps.InfoWindow({
		content: contentString
	});

	var marker = new google.maps.Marker({
		position: location,
		icon: myIcon,
		title: v_info,
		map: map
	});
	markers.push(marker);


	lat = location.lat();
	lng = location.lng();
	var latlng = new google.maps.LatLng(lat , lng);

	$("#gpsx").val(lat);
	$("#gpsy").val(lng);


<?
if(!instryn($cmd, "|not_info|")){
?>
	infowindow.open(map,marker);
<?
}
?>
}

// Sets the map on all markers in the array.
function setAllMap(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setAllMap(null);
}

// Shows any markers currently in the array.
function showMarkers() {
  setAllMap(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  markers = [];
}




function set_gps(){
	var v_addr = $("#addr").val();
	var ele = $("#search_list option:selected");

	var v_lat = $("#gpsx").val();
	var v_lng = $("#gpsy").val();

	lat = v_lat;
	lng = v_lng;

	try{
		set_gps_info(v_addr, lat, lng);
	}catch(e){
		try{
			opener.set_gps_info(v_addr, lat, lng);
		}catch(e){
			try{
				parent.set_gps_info(v_addr, lat, lng);
			}catch(e){
			
			}
		}
	}
	window.close();
}

function set_map_search_list(){
	var ele = $("#search_list option:selected");

	lat = ele.attr("lat");
	lng = ele.attr("lng");
	var latlng = new google.maps.LatLng(lat , lng);
//	v_info = ele.text();

	addMarker(latlng);
	map.setCenter(latlng);

}
function searchAddrPostion( val ) {
	var geocoder = new google.maps.Geocoder();
	var v_addr = document.getElementById(val).value;
	var lat = "";
	var lng = "";
	geocoder.geocode({'address': v_addr},
		function(results, status){
			console.log(results)
			if(results != ""){
/*
				var location = results[0].geometry.location;
				lat=location.lat();
				lng=location.lng();
				var latlng = new google.maps.LatLng(lat , lng);

				addMarker(latlng);
				map.setCenter(latlng);
				$("#gpsx").val(lat);
				$("#gpsy").val(lng);
*/
				if(results.length > 0){
					$("#search_list option").remove();
					var v_selected;
					for(var i=0; i<results.length; i++){
						var v_address_components = results[i].address_components[0].long_name;

						var location = results[i].geometry.location;
						var lat = location.lat();
						var lng = location.lng();

						if(i == 0){
							v_selected = "selected";
						}else{
							v_selected = "";
						}
//						console.log( i +" == "+ v_selected +" == "+ v_address_components)
						$("<option></option>")
//						.attr("selected", v_selected)
						.text(v_address_components)
						.attr("lat", lat)
						.attr("lng", lng)
						.appendTo("select[name='search_list']");
					}
				}
				set_map_search_list();

			}else{
				alert("위도와 경도를 찾을 수 없습니다.");
				$("#gpsx").val("");
				$("#gpsy").val("");
			}
		}
	)
}
</script>
</head>
<body onload="initialize();">
<span style="display: <? if(!instryn($cmd, "|search|")) echo "none" ?>">
	<table width="99%" border="0" cellspacing="0" cellpadding="0" class="mem_list" align="center">
	<tr>
		<th width="150" class="mu">주소 검색</th>
		<td colspan="3" class="text_left left_padding5">
			<input type="text" id="addr" value="" style="width:50%"/>
			<input type="button" class="btn btn01" value=" 검 색 " onclick="searchAddrPostion('addr');"><br>
		</td>
	</tr>
	<tr>
		<th width="150" class="mu">매장이름</th>
		<td colspan="3" class="text_left left_padding5">
			<select name="search_list" id="search_list" onchange="set_map_search_list();">
				<option value="">주소를 검색해주세요.</option>
			</select>
		</td>
	</tr>
	<tr>
		<th width="150" class="mu">gps X</th>
		<td class="text_left left_padding5"><input type="text" id="gpsx" value="" style="width:90%"></td>

		<th width="150" class="mu">gps Y</th>
		<td class="text_left left_padding5"><input type="text" id="gpsy" value="" style="width:90%"/></td>
	</tr>
	<tr>
		<td colspan="4">
			<button type="button" class="btn btn02" onclick="set_gps();"> GPS 정보 등록</button>
		</td>
	</tr>
	</table>
</span>

<div id="map_canvas" style="width:100%; height:100%"></div>

</body>
</html>
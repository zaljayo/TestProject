function chg_fk_inw_mct_cate( name, val, callback ){
	var v_mct_cate = document.getElementById(name).value;
	var v_url = "/proc/ajax_mgr_cate.php";
	var param = "mct_cate="+ v_mct_cate;
	$.ajax({
		type:"post",
		url : v_url,
		data:param,
//		async: false,
		success:function( result ){
/*
			data = JSON.parse(result);
			console.log( data[0].mct_idx );
			console.log( result );
*/
			if(typeof callback == "function"){
				callback(val, result);
			}
			
		},
		error:function(request, status, error) {
			alert( "ajax call error" );
		}
	});
}

function ajax( url, param, onSuccess, fail ){
	$.ajax({
		type:"POST",
		url : url,
		data:param,
		async: false,
		dataType:"text",
		success:function( resultData ){
			var data;

			try{
				data = JSON.parse(resultData);
				//console.log( resultData );
				
			}catch(e){
				if( fail ) {
					fail();
				}else{
					console.log( resultData );
					alert( "return json data is error \n" + resultData );
				}
			}
			
			try{
				onSuccess( data );
			}catch(e){
				alert( "success callback function errer");
			}
			
		},
		error:function(request, status, error) {
			if( fail ) {
				fail();
			}else{
				alert( "ajax call error" );
			}
		}
	});
}
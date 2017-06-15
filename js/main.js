var xmlhttp;
var start_pos = end_pos = 0;
var start_line_num = end_line_num = 1;
var xhr = new Array();

/**
 * Remote Procedure Call
 * @param  {obj} 	r      ActiveX object
 * @param  {string} url    Endpoint URL
 * @param  {string} params Endpoint Parameters
 * @param  {string} method Request Method
 * @return 
 */
function postRPC(r,url,params,method){
	if(method == "GET"){ 
		url = url+'?'+params;
	}
	r.open(method, url, true);	
	r.setRequestHeader("Content-type", "application/x-www-form-urlencoded;application/json; charset=utf-8");
	r.send(params);
}

/**
 * Genric AJAX fuction to make async http calls
 * @return
 */
function myAjax(){
	if(window.XMLHttpRequest){
		req = new XMLHttpRequest();
	}else{	
		if(window.ActiveXObject){
			try{
				req = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){ }
		}
	}
	if(req){return req;}
	alert("your browser does not support HttpRequest"); return;
}

/**
 * Loads the ajax content into the targetted DOM identifier
 * @param  {string} id DOM Identifier 
 * @param  {obj} 	x  Server Reponse
 * @return 
 */
function loadp(id,x){
	$('#'+id).html(x.responseText);
}

/**
 * Performs AJAX request for the specified params and loads the results into target DOM Identifier
 * @param  {string} mgr Identifier to process relevant function on server side
 * @param  {string} q   Query Parameters
 * @param  {string} id  Target DOM Identifier to load the ajax response
 * @return 
 */
function loadAjax(mgr,q,id){
	var	params="mgr="+mgr+"&q="+q;
	xhr[id]=myAjax();
	var url="/ct.php";
	postRPC(xhr[id], url, params, 'POST');

	xhr[id].onreadystatechange=function(){
		if(xhr[id].readyState == 4){
			var z = $('#'+id);
			if(z.length!=0){
				if(xhr[id].responseText=='' ||  xhr[id].responseText.match(/^[\s]+$/)){
				    alertEndOfFile();z=xhr[id]=null;return '';
				}else{
					loadp(id,xhr[id]);
				}
			}
			z=xhr[id]=null;
		}
		
	}
}

/**
 * Alerts if End of File is reached
 * @return
 */
function alertEndOfFile(){
	alert('You are at the end of the file!');
	return;
}

/**
 * Checks if the file pointer is at the beginning of the file
 * @return
 */
function checkBeginningOfFile(){
	if(start_pos == 0){
		alert('You are at the beginning of the file!');
		return true;
	}
}

/**
 * Toggles the CSS classes for the button clicks
 * @param  {obj} t Object reference of the clicked element
 * @return 
 */
function changeCSS(t){
	$('.cta_btn').removeClass('select');
	$('.cta_btn').addClass('deselect');		
	t.removeClass('deselect');
	t.addClass('select');
	t = null;
}

$(document).ready(function() {
	$('.cta_btn').on('click',function(e) {
		var file_path = $('#filelocation').val();
		if(file_path == ''){
			$('#err2').css({"display":"none"});
			$('#err1').css({"display":"block"});
			$('#results').html('');
			return;
		}else{
			$('#err1').css({"display":"none"});
		}
		var action = $(this).attr('data-id');
		if(action == 'prev'){
			if(checkBeginningOfFile()){return;}
		}
		var q = action+'###'+start_pos+'###'+end_pos+'###'+file_path+'###'+start_line_num+'###'+end_line_num;
		var t = $(this);changeCSS(t);
		var id = "results";
		loadAjax(1,q,id);
	});
})
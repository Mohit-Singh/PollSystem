self.port.on("initFunction", function() {
  caller();
});

function caller(){
	$('img')
	.each(
			function(index) {
				$(this)
						.wrap(
								'<div class="imgWrapper" id="img_index_'
										+ index
										+ '"></div>')
						.after(
								'<div class="toolBar" id="tool_bar_'
										+ index
										+ ' onclick="performTask(this,'+index+') "><input type="button" value="check" onclick="performTask(this,'+index+')"></div>');

				var position = $(this).position();

				$('.toolBar', $(this).parent())
						.css(
								{
									'position' : 'absolute',
									'top' : position.top,
									'left' : (position.left
											+ $(this)
													.width() - 50)
											+ 'px',
									'width' : $(this).width() + 'px',
									'height' : $(this)
											.height()
											+ 'px',
									'text-align' : 'center',
									'background-color' : '#FFF',
									'z-index' : '111111',
									'cursor' : 'pointer'
								});

				manageToolbar($(this));

			});
	addImageConvertHtml();
}

function manageToolbar(obj) {
	obj.hover(function() {
		$('.toolBar', obj.parent()).show();
	}, function() {
		$('.toolBar', obj.parent()).hide();
	});
	
}


function performTask(obj,index){
	imgSrc = $("img_index_"+index).find('img').attr('src');
	initImageConvert(imgSrc);
}

var ImageText = null

function initImageConvert(url){
	var objImg = new Image();
	objImg.src = url;
	curHeight = objImg.height;
	curWidth = objImg.width;				
	$("#finalSourceImage").attr('width',curWidth);
	$("#finalSourceImage").attr('src',url);
	$("#ALP_ajax-overlay").show();
	
}
function imageConvert(type){
	$("#ImageContainer").css('padding-left','0%');
	if(ImageText == null){
		ImageText = $("#ImageContainer").html();
	}
	document.getElementById("ImageContainer").innerHTML = ImageText
		jsImageFX.doImage(document.getElementById("finalSourceImage"), type);
}

function reflectImage()
{
	if(ImageText == null){
		ImageText = $("#ImageContainer").html();
	}else{
		$("#ImageContainer").html('');
		$("#ImageContainer").html(ImageText);
	}
	$("#finalSourceImage").reflect({
		height: 0.322,
		opacity: 0.6,
	});
	$("#ImageContainer").next('div').css('text-align','center');
}

function frameChange(){
	var r = Math.floor((Math.random() * 255) + 1);
	var g = Math.floor((Math.random() * 255) + 1);
	var b = Math.floor((Math.random() * 255) + 1);
	
	$("#paraImage").css('background-color','rgb('+r+','+g+','+b+')');
}

function capture() {
	$('#ImageContainer #paraImage').html2canvas({
		 onrendered: function (canvas) {
				Canvas2Image.saveAsPNG(canvas); 
		 }
	});
}

function addImageConvertHtml(){
	
	/*$.getScript( "resource://support.js", function( data, textStatus, jqxhr ) {
		console.log( data ); // Data returned
		console.log( textStatus ); // Success
		console.log( jqxhr.status ); // 200
		console.log( "Load was performed." );
		});*/
	
	html ='<div id="ALP_ajax-overlay" class="alert_popup_overlay">'+
					'<input type="button" onclick="frameChange()" value="Change Frame"/>'+ 
					'<input type="button" onclick="capture()" value="Save Image"/>'+ 
								'<div class="image-header">'+
									'<h2>Effects</h2>'+
										'<ul>'+
											'<li><a href="#" onclick="imageConvert(\'fliphorizontal\')">fliphorizontal</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'flipvertical\')">flipvertical</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'invert\')">invert</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'desaturate\')">desaturate</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'blur\')">blur</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'blurfast\')">blurfast</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'blurmore\')">blurmore</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'sharpen\')">sharpen</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'sharpenmore\')">sharpenmore</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'edges\')">edges</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'emboss\')">emboss</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'emboss2\')">emboss2</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'laplace\')">laplace</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'noise\')">noise</a></li>'+
											'<li><a href="#" onclick="imageConvert(\'lighten\')">lighten</a></li>'+
											'li><a href="#" onclick="reflectImage()">Reflection</a></li>'+
										'</ul>'+
								'</div>'+
				'<div id="ImageContainer" class="ALP_content" style=" text-align: center;  z-index: 11111111;">'+
					'<p id="paraImage">'+
					'<img id="finalSourceImage"  src="" >'+
					'</p>'+ 
				'</div>'+
		'</div>';
											
	$('body').append(html);
	addImageConvertCss();
}

function addImageConvertCss(){
	
	$('.addme').css({
	    'left':'0px',
		'margin':'10px',
	    'position': 'absolute',
	});
	$("div.image-header").css({
	  'width': '200px',
	  'color': 'white',
	  'float':'left',
	  'border': '1px solid',
	  'margin-right': '20px',
	  'position': 'fixed',
	});
	 
	$("div.image-header h2").css({
	  'font': '400 40px/1.5 Helvetica, Verdana, sans-serif',
	  'margin': '0',
	  'padding': '0',
	  'border-bottom': '1px solid',
	});
	 
	$("div.image-header ul").css({
	  'list-style-type': 'none',
	  'margin': '0',
	  'padding': '0',
	});
	 
	$("div.image-header ul li").css({
	  'font': '200 20px/1.5 Helvetica, Verdana, sans-serif',
	  'border-bottom': '1px solid #ccc',
	});
	 
	$("div.image-header ul li:last-child").css({
	  'border': 'none',
	});
	 
	$("div.image-header ul li a").css({
	  'text-decoration': 'none',
	  'color': 'white',
	  'display': 'block',
	  'width': '200px',
	  '-webkit-transition': 'font-size 0.3s ease, background-color 0.3s ease',
	  '-moz-transition': 'font-size 0.3s ease, background-color 0.3s ease',
	  '-o-transition': 'font-size 0.3s ease, background-color 0.3s ease',
	  '-ms-transition': 'font-size 0.3s ease, background-color 0.3s ease',
	  'transition': 'font-size 0.3s ease, background-color 0.3s ease',
	});
	 
	$("div.image-header ul li a:hover").css({
	  'font-size': '30px',
	  'background': '#24C1D9',
	});
	
	$("#ImageContainer").css({
		'margin-left': '220px',
	});
	
	$("#ImageContainer div").css({
		'margin': 'auto',
	});
	
	$("#paraImage").css({
		'background-color': '#FFFFFF',			    
	    'padding': '18px',
	    'float' : 'left',
	});
	$("#ALP_ajax-overlay").css({
		 'background': 'none repeat scroll 0px 0px #000000',
		 'opacity': '0.9',
		 'position': 'fixed',
		 'bottom': '0px', 
		 'left': '0px', 
		 'right': '0px',
		 'top': '0px', 
		 'z-index': '1111111',
		 'overflow': 'scroll',
		 'display' : 'none',
	});
	
}


/*
 * Javascript Image Effects - Core Functions
 * Copyright (c) 2008 Jacob Seidelin, cupboy@gmail.com
 * This software is free to use for non-commercial purposes. For anything else, please contact the author.
 */

var jsImageFX = {

	effects : {}, 

	doEffects : function(oImg, oCanvasImg, strFilter) 
	{
		var bHasCanvas = false;
		var bHasCanvasImageData = false;
		var bIsIE = !!(window.attachEvent && !window.opera);  // ew..

		var oCanvas = document.createElement("canvas");
		if (oCanvas.getContext) {
			bHasCanvas = true;
			var oCtx = oCanvas.getContext("2d");
			if (oCtx.getImageData) {
				bHasCanvasImageData = true;
			}
		}

		var iWidth = parseInt(oImg.offsetWidth);
		var iHeight = parseInt(oImg.offsetHeight);

		var strFilterName = strFilter;
		var oOptions = {};

		var oArgs = {};
		if (strFilter.indexOf("(") > -1) {
			strFilterName = strFilter.substr(0, strFilter.indexOf("("));
			var aArg = strFilter.match(/\((.*?)\)/);
			if (aArg[1]) {
				aArg = aArg[1].split(";");
				for (var a=0;a<aArg.length;a++) {
					aThisArg = aArg[a].split("=");
					if (aThisArg.length == 2)
						oArgs[aThisArg[0]] = aThisArg[1];
				}
			}
		}

		if (typeof jsImageFX.effects[strFilterName] != "function") {
			return false;
		}

		if (bHasCanvas) {
			oCanvas.width = iWidth;
			oCanvas.height = iHeight;
			oCanvas.style.width = iWidth;
			oCanvas.style.height = iHeight;
	
			oCtx.drawImage(oCanvasImg, 0, 0, iWidth, iHeight);
		}

		var oImage = {
			image : oImg,
			canvas : oCanvas,
			width : iWidth,
			height : iHeight,
			client : {
				hasCanvas : bHasCanvas,
				hasCanvasImageData : bHasCanvasImageData,
				isIE : bIsIE
			},
			useData : true
		}

		var bRes = jsImageFX.effects[strFilterName](oImage, oArgs);

		if (bHasCanvas) {
			if (oImage.useData) {
				if (bHasCanvasImageData) {
					oCanvas.getContext("2d").putImageData(oImage.canvasData, 0, 0);
					// Opera doesn't seem to update the canvas until we draw something on it, lets draw a 0x0 rectangle.
					oCanvas.getContext("2d").fillRect(0,0,0,0);
				}
			}
			
			// copy properties and stuff from the source image
			oCanvas.title = oImg.title;
			oCanvas.alt  = oImg.alt;
			oCanvas.imgsrc = oImg.src;
			oCanvas.className = oImg.className;
			oCanvas.cssText = oImg.cssText;
			oCanvas.id = oImg.id;

			oImg.parentNode.replaceChild(oCanvas, oImg);
		}
	},

	// load the image file
	doImage : function(oImg, strFilter)
	{
		var oCanvasImg = new Image();
		oCanvasImg.src = oImg.src;
		if (oCanvasImg.complete) {
			jsImageFX.doEffects(oImg, oCanvasImg, strFilter);
		} else {
			oCanvasImg.onload = function() {
				jsImageFX.doEffects(oImg, oCanvasImg, strFilter)
			}
		}
	},

	processImages : function() 
	{
		var aImg = document.getElementsByTagName("img");
		var aImages = [];
		for (var i=0;i<aImg.length;i++) {
			aImages[i] = aImg[i];
		}

		for (var i=0;i<aImages.length;i++) {
			if (aImages[i].getAttribute("imagefx")) {
				jsImageFX.doImage(aImages[i], aImages[i].getAttribute("imagefx"));
			}
		}
	}

}


if (window.addEventListener) { 
	window.addEventListener("load", jsImageFX.processImages, false); 
} else if (window.attachEvent) { 
	window.attachEvent("onload", jsImageFX.processImages); 
}


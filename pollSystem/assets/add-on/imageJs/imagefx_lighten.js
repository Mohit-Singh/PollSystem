/*
 * Javascript Image Effects - Lighten/Darken filter
 * Copyright (c) 2008 Jacob Seidelin, cupboy@gmail.com
 * This software is free to use for non-commercial purposes. For anything else, please contact the author.
 */

jsImageFX.effects.lighten = function(oImage, oArgs)
{
	var fAmount = 0;

	if (oArgs) {
		if (typeof oArgs.amount != "undefined")
			fAmount = parseFloat(oArgs.amount);
	}

	if (oImage.client.hasCanvas && oImage.client.hasCanvasImageData) {
		var oCtx = oImage.canvas.getContext("2d");
		var oDataSrc = oCtx.getImageData(0, 0, oImage.width, oImage.height);
		var oDataDst = oCtx.getImageData(0, 0, oImage.width, oImage.height);
		var aDataSrc = oDataSrc.data;
		var aDataDst = oDataDst.data;
		oImage.canvasData = oDataDst;

		var h = oImage.height;
		var w = oImage.width;
		var y = h;
		do {
			var iOffsetY = (y-1)*w*4;
			var x = w;
			do {
				var iOffset = iOffsetY + (x-1)*4;
	
				var iR = aDataSrc[iOffset];
				var iG = aDataSrc[iOffset+1];
				var iB = aDataSrc[iOffset+2];

				if (fAmount < 0 ||true) {
					iR = iR + iR*fAmount;
					iG = iG + iG*fAmount;
					iB = iB + iB*fAmount;
				} else if (fAmount > 0) {
					iR = iR + (255-iR)*fAmount;
					iG = iG + (255-iG)*fAmount;
					iB = iB + (255-iB)*fAmount;
				}

				if (iR < 0 ) iR = 0;
				if (iG < 0 ) iG = 0;
				if (iB < 0 ) iB = 0;
				if (iR > 255 ) iR = 255;
				if (iG > 255 ) iG = 255;
				if (iB > 255 ) iB = 255;

				aDataDst[iOffset] = iR;
				aDataDst[iOffset+1] = iG;
				aDataDst[iOffset+2] = iB;
				aDataDst[iOffset+3] = aDataSrc[iOffset+3];
	
			} while (--x);
		} while (--y);
		return true;

	} else if (oImage.client.isIE) {
		if (fAmount < 0) {
			oImage.image.style.filter += " light()";
			oImage.image.filters[oImage.image.filters.length-1].addAmbient(
				255,255,255,
				100 * -fAmount
			);
		} else if (fAmount > 0) {
			oImage.image.style.filter += " light()";
			oImage.image.filters[oImage.image.filters.length-1].addAmbient(
				255,255,255,
				100
			);
			oImage.image.filters[oImage.image.filters.length-1].addAmbient(
				255,255,255,
				100 * fAmount
			);
		}
		return true;
	}
}

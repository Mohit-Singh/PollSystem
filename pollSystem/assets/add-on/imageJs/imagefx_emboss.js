/*
 * Javascript Image Effects - Emboss filter
 * Copyright (c) 2008 Jacob Seidelin, cupboy@gmail.com
 * This software is free to use for non-commercial purposes. For anything else, please contact the author.
 */

(function(){

jsImageFX.effects.emboss = function(oImage, oOptions)
{
	if (oImage.client.hasCanvas && oImage.client.hasCanvasImageData) {

		var oCtx = oImage.canvas.getContext("2d");
		var oDataSrc = oCtx.getImageData(0, 0, oImage.width, oImage.height);
		var oDataDst = oCtx.getImageData(0, 0, oImage.width, oImage.height);
		var aDataSrc = oDataSrc.data;
		var aDataDst = oDataDst.data;
		oImage.canvasData = oDataDst;


		if (!oOptions) oOptions = {};
		oOptions.strength = parseFloat(oOptions.strength) > 0 ? parseFloat(oOptions.strength) : 1;
		oOptions.grayLevel = 180;

		var h = oImage.height;
		var w = oImage.width;

		var y = h;
		do {
			var iOffsetY = (y-1)*w*4;

			var iOffsetYPrev = (y-2)*w*4;

			if (y == 1) {
				iOffsetYPrev = iOffsetY;
			}	

			var x = w;
			do {
				if (x < w && y < h) {

					var iOffset = iOffsetY + (x-1)*4;
					var iOffsetPrev = iOffsetYPrev + (x-1)*4;

					if (x == 1) {
						iOffsetPrev = iOffset;
					}

					var iR = 0;
					var iG = 0;
					var iB = 0;

					iDeltaR = aDataSrc[iOffset] - aDataSrc[iOffsetPrev-4];
					iDeltaG = aDataSrc[iOffset+1] - aDataSrc[iOffsetPrev-3];
					iDeltaB = aDataSrc[iOffset+2] - aDataSrc[iOffsetPrev-2];

					var iDif = iDeltaR;
					if (Math.abs(iDeltaG) > Math.abs(iDif)) {
						iDif = iDeltaG;
					}
					if (Math.abs(iDeltaB) > Math.abs(iDif)) {
						iDif = iDeltaB;
					}

					var iGray = oOptions.grayLevel - iDif;
					if (iGray < 0) iGray = 0;
					if (iGray > 255) iGray = 255;

					aDataDst[iOffset] = iGray;
					aDataDst[iOffset+1] = iGray;
					aDataDst[iOffset+2] = iGray;
					aDataDst[iOffset+3] = aDataSrc[iOffset+3];
				}

			} while (--x);
		} while (--y);
		return true;
	} else if (oImage.client.isIE) {
		oImage.image.style.filter += " progid:DXImageTransform.Microsoft.emboss()";
		return true;
	}
}

})();
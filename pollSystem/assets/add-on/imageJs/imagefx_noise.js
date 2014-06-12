/*
 * Javascript Image Effects - Noise filter
 * Copyright (c) 2008 Jacob Seidelin, cupboy@gmail.com
 * This software is free to use for non-commercial purposes. For anything else, please contact the author.
 */

(function(){

var random = Math.random;

jsImageFX.effects.noise = function(oImage, oArgs)
{
	if (oImage.client.hasCanvas && oImage.client.hasCanvasImageData) {

		var oCtx = oImage.canvas.getContext("2d");
		var oDataSrc = oCtx.getImageData(0, 0, oImage.width, oImage.height);
		var oDataDst = oCtx.getImageData(0, 0, oImage.width, oImage.height);
		var aDataSrc = oDataSrc.data;
		var aDataDst = oDataDst.data;
		oImage.canvasData = oDataDst;

		var h = oImage.height;
		var w = oImage.width;

		var fAmount = 1;
		var fStrength = 1;
		var bMono = false;

		if (oArgs) {
			if (typeof oArgs.amount != "undefined")
				fAmount = parseFloat(oArgs.amount);
			if (typeof oArgs.strength != "undefined")
				fStrength = parseFloat(oArgs.strength);
			if (typeof oArgs.mono != "undefined")
				bMono = (oArgs.mono == "true");
		}

		var fNoise = 128 * fStrength;
		var fNoise2 = fNoise / 2;

		var y = h;
		do {
			var iOffsetY = (y-1)*w*4;
			var x = w;
			do {
				if (x < w && y < h) {
					var iOffset = iOffsetY + (x-1)*4;

					if (Math.random() < fAmount) {
						if (bMono) {
							var fPixelNoise = - fNoise2 + random() * fNoise;
							var iR = aDataDst[iOffset] + fPixelNoise;
							var iG = aDataDst[iOffset+1] + fPixelNoise;
							var iB = aDataDst[iOffset+2] + fPixelNoise;
						} else {
							var iR = aDataDst[iOffset] - fNoise2 + (random() * fNoise);
							var iG = aDataDst[iOffset+1] - fNoise2 + (random() * fNoise);
							var iB = aDataDst[iOffset+2] - fNoise2 + (random() * fNoise);
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
					}
				}

			} while (--x);
		} while (--y);
		return true;

	} else if (oImage.client.isIE) {
		// no noise filter for IE
	}
}

})();
/*
 * Javascript Image Effects - Desaturation filter
 * Copyright (c) 2008 Jacob Seidelin, cupboy@gmail.com
 * This software is free to use for non-commercial purposes. For anything else, please contact the author.
 */

(function(){

jsImageFX.effects.edges = function(oImage, oArgs)
{
	var bMono = false;
	var fStrength = 1.0;

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

		var fC = -fStrength/8;


		var bMono = false;
		var bInvert = false;
		if (oArgs) {
			if (typeof oArgs.invert != "undefined")
				bInvert = (oArgs.invert == "true");
			if (typeof oArgs.mono != "undefined")
				bMono = (oArgs.mono == "true");
		}


		var aKernel = [
			[fC, 	fC, 	fC],
			[fC, 	1, 	fC],
			[fC, 	fC, 	fC]
		];

		var fWeight = 0;
		for (var i=0;i<3;i++) {
			for (var j=0;j<3;j++) {
				fWeight += aKernel[i][j];
			}
		}
		fWeight = fC;

		do {
			var iOffsetY = (y-1)*w*4;

			var iOffsetYPrev = (y-2)*w*4;
			var iOffsetYNext = (y)*w*4;

			var x = w;
			do {
				if (x < w && y < h) {

					var iOffset = iOffsetY + (x-1)*4;
					var iOffsetPrev = iOffsetYPrev + (x-1)*4;
					var iOffsetNext = iOffsetYNext + (x-1)*4;
	
					var iR = 0;
					var iG = 0;
					var iB = 0;
	
					var iR = (aDataSrc[iOffsetPrev-4]	* fC
						+ aDataSrc[iOffsetPrev]		* fC
						+ aDataSrc[iOffsetPrev+4]	* fC
						+ aDataSrc[iOffset-4]		* fC
						+ aDataSrc[iOffset]
						+ aDataSrc[iOffset+4]		* fC
						+ aDataSrc[iOffsetNext-4]	* fC
						+ aDataSrc[iOffsetNext]		* fC
						+ aDataSrc[iOffsetNext+4]	* fC) 
						/ fWeight;
	
					var iG = (aDataSrc[iOffsetPrev-3] 	* fC
						+ aDataSrc[iOffsetPrev+1]	* fC
						+ aDataSrc[iOffsetPrev+5] 	* fC
						+ aDataSrc[iOffset-3]		* fC
						+ aDataSrc[iOffset+1] 
						+ aDataSrc[iOffset+5]		* fC
						+ aDataSrc[iOffsetNext-3]	* fC
						+ aDataSrc[iOffsetNext+1]	* fC
						+ aDataSrc[iOffsetNext+5]	* fC)
						/ fWeight;
	
					var iB = (aDataSrc[iOffsetPrev-2]	* fC
						+ aDataSrc[iOffsetPrev+2]	* fC
						+ aDataSrc[iOffsetPrev+6] 	* fC
						+ aDataSrc[iOffset-2]		* fC
						+ aDataSrc[iOffset+2] 
						+ aDataSrc[iOffset+6]		* fC
						+ aDataSrc[iOffsetNext-2]	* fC
						+ aDataSrc[iOffsetNext+2]	* fC
						+ aDataSrc[iOffsetNext+6]	* fC)
						/ fWeight;

					if (bMono) {
						var iBrightness = Math.round(iR*0.3 + iG*0.59 + iB*0.11);
						if (bInvert) iBrightness = 255 - iBrightness;
						if (iBrightness < 0 ) iBrightness = 0;
						if (iBrightness > 255 ) iBrightness = 255;
						iR = iG = iB = iBrightness;
					} else {
						if (bInvert) {
							iR = 255 - iR;
							iG = 255 - iG;
							iB = 255 - iB;
						}
						if (iR < 0 ) iR = 0;
						if (iG < 0 ) iG = 0;
						if (iB < 0 ) iB = 0;
						if (iR > 255 ) iR = 255;
						if (iG > 255 ) iG = 255;
						if (iB > 255 ) iB = 255;
					}

					aDataDst[iOffset] = iR;
					aDataDst[iOffset+1] = iG;
					aDataDst[iOffset+2] = iB;
					aDataDst[iOffset+3] = aDataSrc[iOffset+3];
				}

			} while (--x);
		} while (--y);
		return true;

	} else if (oImage.client.isIE) {
		// none for IE!
	}
}

})();
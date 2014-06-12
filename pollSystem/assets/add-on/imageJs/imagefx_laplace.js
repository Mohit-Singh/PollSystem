/*
 * Javascript Image Effects - Laplace filter
 * Copyright (c) 2008 Jacob Seidelin, cupboy@gmail.com
 * This software is free to use for non-commercial purposes. For anything else, please contact the author.
 */

(function(){

jsImageFX.effects.laplace = function(oImage, oArgs)
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

		var aKernel = [
			[-1, 	-1, 	-1],
			[-1, 	8, 	-1],
			[-1, 	-1, 	-1]
		];

		var fContrast = 0;
		var bInvert = false;
		if (oArgs) {
			if (typeof oArgs.contrast != "undefined")
				fContrast = parseFloat(oArgs.contrast);
			if (typeof oArgs.invert != "undefined")
				bInvert = (oArgs.invert == "true");
		}


		var y = h;
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
	
					var iR = (-aDataSrc[iOffsetPrev-4]
						- aDataSrc[iOffsetPrev]
						- aDataSrc[iOffsetPrev+4]
						- aDataSrc[iOffset-4]
						+ aDataSrc[iOffset]		* 8
						- aDataSrc[iOffset+4]
						- aDataSrc[iOffsetNext-4]
						- aDataSrc[iOffsetNext]
						- aDataSrc[iOffsetNext+4]) 
						/ 8;
	
					var iG = (-aDataSrc[iOffsetPrev-3]
						- aDataSrc[iOffsetPrev+1]
						- aDataSrc[iOffsetPrev+5]
						- aDataSrc[iOffset-3]
						+ aDataSrc[iOffset+1] 		* 8
						- aDataSrc[iOffset+5]
						- aDataSrc[iOffsetNext-3]
						- aDataSrc[iOffsetNext+1]
						- aDataSrc[iOffsetNext+5])
						/ 8;
	
					var iB = (-aDataSrc[iOffsetPrev-2]
						- aDataSrc[iOffsetPrev+2]
						- aDataSrc[iOffsetPrev+6]
						- aDataSrc[iOffset-2]
						+ aDataSrc[iOffset+2]		* 8
						- aDataSrc[iOffset+6]
						- aDataSrc[iOffsetNext-2]
						- aDataSrc[iOffsetNext+2]
						- aDataSrc[iOffsetNext+6])
						/ 8;

					var iBrightness = Math.round((iR + iG + iB)/3) + 128;

					if (fContrast > 0) {
						if (iBrightness > 127) {
							iBrightness += ((iBrightness + 1) - 128) * fContrast;
						} else if (iBrightness < 127) {
							iBrightness -= (iBrightness + 1) * fContrast;
						}
					}

					if (bInvert) {
						iBrightness = 255 - iBrightness;
					}

					if (iBrightness < 0 ) iBrightness = 0;
					if (iBrightness > 255 ) iBrightness = 255;

					iR = iG = iB = iBrightness;

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
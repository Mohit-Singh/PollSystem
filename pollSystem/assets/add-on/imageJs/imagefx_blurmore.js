/*
 * Javascript Image Effects - Stronger Blur filter
 * Copyright (c) 2008 Jacob Seidelin, cupboy@gmail.com
 * This software is free to use for non-commercial purposes. For anything else, please contact the author.
 */

(function(){

jsImageFX.effects.blurmore = function(oImage)
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
		var y = h;

		var aKernel = [
			[0.5, 	1, 	0.5],
			[1, 	2, 	1],
			[0.5, 	1, 	0.5]
		];

		var fWeight = 0;
		for (var i=0;i<3;i++) {
			for (var j=0;j<3;j++) {
				fWeight += aKernel[i][j];
			}
		}

		fWeight = 25;

		do {
			var iOffsetY = (y-1)*w*4;

			var iOffsetYPrev = (y-2)*w*4;
			var iOffsetYNext = (y)*w*4;
			var iOffsetYPrev2 = (y-3)*w*4;
			var iOffsetYNext2 = (y+1)*w*4;

			var x = w;
			do {
				if (x < w-1) {
					if (y == h-1) {
						iOffsetYNext2 = iOffsetYNext;
						iOffsetYNext = iOffsetY;
					}
					if (y == h) {
						iOffsetYNext2 = iOffsetY;
						iOffsetYNext = iOffsetY;
					}
					if (y == 1) {
						iOffsetYPrev2 = iOffsetYPrev;
						iOffsetYPrev = iOffsetY;
					}
					if (y == 2) {
						iOffsetYPrev2 = iOffsetY;
						iOffsetYPrev = iOffsetY;
					}

					var iOffset = iOffsetY + (x-1)*4;
					var iOffsetPrev = iOffsetYPrev + (x-1)*4;
					var iOffsetNext = iOffsetYNext + (x-1)*4;
					var iOffsetPrev2 = iOffsetYPrev2 + (x-1)*4;
					var iOffsetNext2 = iOffsetYNext2 + (x-1)*4;

					if (x == 1) {
						iOffsetPrev2 = iOffsetPrev;
						iOffsetPrev = iOffset;
					}
					if (x == 2) {
						iOffsetPrev2 = iOffset;
						iOffsetPrev = iOffset;
					}
					if (x == w-1) {
						iOffsetNext2 = iOffsetNext;
						iOffsetNext = iOffset;
					}
					if (x == w) {
						iOffsetNext2 = iOffset;
						iOffsetNext = iOffset;
					}


					var iR = (
						+ aDataSrc[iOffsetPrev2-8]
						+ aDataSrc[iOffsetPrev2-4]
						+ aDataSrc[iOffsetPrev2]
						+ aDataSrc[iOffsetPrev2+4]
						+ aDataSrc[iOffsetPrev2+8]
						+ aDataSrc[iOffsetPrev - 8]
						+ aDataSrc[iOffsetPrev - 4]
						+ aDataSrc[iOffsetPrev]
						+ aDataSrc[iOffsetPrev+4]
						+ aDataSrc[iOffsetPrev+8]
						+ aDataSrc[iOffset-8]
						+ aDataSrc[iOffset-4]
						+ aDataSrc[iOffset]
						+ aDataSrc[iOffset+4]
						+ aDataSrc[iOffset+8]
						+ aDataSrc[iOffsetNext - 8]
						+ aDataSrc[iOffsetNext - 4]
						+ aDataSrc[iOffsetNext]
						+ aDataSrc[iOffsetNext+4]
						+ aDataSrc[iOffsetNext+8]
						+ aDataSrc[iOffsetNext2-8]
						+ aDataSrc[iOffsetNext2-4]
						+ aDataSrc[iOffsetNext2]
						+ aDataSrc[iOffsetNext2+4]
						+ aDataSrc[iOffsetNext2+8])
						/ fWeight;
	
					var iG = (aDataSrc[iOffsetPrev2 - 7]
						+ aDataSrc[iOffsetPrev2 - 3]
						+ aDataSrc[iOffsetPrev2+1]
						+ aDataSrc[iOffsetPrev2+5]
						+ aDataSrc[iOffsetPrev2+9]
						+ aDataSrc[iOffsetPrev - 7]
						+ aDataSrc[iOffsetPrev - 3]
						+ aDataSrc[iOffsetPrev+1]
						+ aDataSrc[iOffsetPrev+5]
						+ aDataSrc[iOffsetPrev+9]
						+ aDataSrc[iOffset-7]
						+ aDataSrc[iOffset-3]
						+ aDataSrc[iOffset+1]
						+ aDataSrc[iOffset+5]
						+ aDataSrc[iOffset+9]
						+ aDataSrc[iOffsetNext - 7]
						+ aDataSrc[iOffsetNext - 3]
						+ aDataSrc[iOffsetNext+1]
						+ aDataSrc[iOffsetNext+5]
						+ aDataSrc[iOffsetNext+9]
						+ aDataSrc[iOffsetNext2-7]
						+ aDataSrc[iOffsetNext2-3]
						+ aDataSrc[iOffsetNext2+1]
						+ aDataSrc[iOffsetNext2+5]
						+ aDataSrc[iOffsetNext2+9])
						/ fWeight;
	
					var iB = (aDataSrc[iOffsetPrev2-6]
						+ aDataSrc[iOffsetPrev2-2]
						+ aDataSrc[iOffsetPrev2+2]
						+ aDataSrc[iOffsetPrev2+6]
						+ aDataSrc[iOffsetPrev2+10]
						+ aDataSrc[iOffsetPrev-6]
						+ aDataSrc[iOffsetPrev-2]
						+ aDataSrc[iOffsetPrev+2]
						+ aDataSrc[iOffsetPrev+6]
						+ aDataSrc[iOffsetPrev+10]
						+ aDataSrc[iOffset-6]
						+ aDataSrc[iOffset-2]
						+ aDataSrc[iOffset+2]
						+ aDataSrc[iOffset+6]
						+ aDataSrc[iOffset+10]
						+ aDataSrc[iOffsetNext-6]
						+ aDataSrc[iOffsetNext-2]
						+ aDataSrc[iOffsetNext+2]
						+ aDataSrc[iOffsetNext+6]
						+ aDataSrc[iOffsetNext+10]
						+ aDataSrc[iOffsetNext2-6]
						+ aDataSrc[iOffsetNext2-2]
						+ aDataSrc[iOffsetNext2+2]
						+ aDataSrc[iOffsetNext2+6]
						+ aDataSrc[iOffsetNext2+10])
						/ fWeight;

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

			} while (--x);
		} while (--y);
		return true;
	} else if (oImage.client.isIE) {
		oImage.image.style.filter += " progid:DXImageTransform.Microsoft.Blur(pixelradius=2)";
		return true;
	}
}

})();
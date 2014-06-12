/*
 * Javascript Image Effects - Alternative Blur filter
 * Copyright (c) 2008 Jacob Seidelin, cupboy@gmail.com
 * This software is free to use for non-commercial purposes. For anything else, please contact the author.
 */

(function(){

jsImageFX.effects.blurfast = function(oImage)
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
			[0, 	2, 	0],
			[2, 	1, 	2],
			[0, 	2, 	0]
		];

		var fWeight = 0;
		for (var i=0;i<3;i++) {
			for (var j=0;j<3;j++) {
				fWeight += aKernel[i][j];
			}
		}

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
	
					var iR = (aDataSrc[iOffsetPrev] * 2
						+ aDataSrc[iOffset-4] * 2
						+ aDataSrc[iOffset] 		* 1
						+ aDataSrc[iOffset+4] * 2
						+ aDataSrc[iOffsetNext] * 2) 
						/ fWeight;
	
					var iG = (aDataSrc[iOffsetPrev+1] * 2
						+ aDataSrc[iOffset-3] * 2
						+ aDataSrc[iOffset+1] 	* 1
						+ aDataSrc[iOffset+5] * 2
						+ aDataSrc[iOffsetNext+1] * 2)
						/ fWeight;
	
					var iB = (aDataSrc[iOffsetPrev+2] * 2
						+ aDataSrc[iOffset-2] * 2
						+ aDataSrc[iOffset+2] 		* 1
						+ aDataSrc[iOffset+6] * 2
						+ aDataSrc[iOffsetNext+2] * 2)
						/ fWeight;

					aDataDst[iOffset] = iR;
					aDataDst[iOffset+1] = iG;
					aDataDst[iOffset+2] = iB;
					aDataDst[iOffset+3] = aDataSrc[iOffset+3];
				}
			} while (--x);
		} while (--y);
		return true;

	} else if (oImage.client.isIE) {
		oImage.image.style.filter += " progid:DXImageTransform.Microsoft.Blur(pixelradius=1.5)";
		return true;

	}
}

})();
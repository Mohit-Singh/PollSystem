/*
 * jsImageFX v0.1
 * Copyright (c) 2008 Jacob Seidelin, cupboy@gmail.com
 * This software is free to use for non-commercial purposes. For anything else, please contact the author.
 */

jsImageFX.effects.none = function(oImage)
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
		do {
			var iOffsetY = (y-1)*w*4;
			var x = w;
			do {
				var iOffset = iOffsetY + (x-1)*4;
	
				aDataDst[iOffset] = aDataSrc[iOffset];
				aDataDst[iOffset+1] = aDataSrc[iOffset+1];
				aDataDst[iOffset+2] = aDataSrc[iOffset+2];
				aDataDst[iOffset+3] = aDataSrc[iOffset+3];
	
			} while (--x);
		} while (--y);
		return true;
	}
}

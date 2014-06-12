/*
 * Javascript Image Effects - Vertical Flip filter
 * Copyright (c) 2008 Jacob Seidelin, cupboy@gmail.com
 * This software is free to use for non-commercial purposes. For anything else, please contact the author.
 */

jsImageFX.effects.flipvertical = function(oImage)
{
	if (oImage.client.hasCanvas) {
		oImage.canvas.getContext("2d").scale(1,-1);
		oImage.canvas.getContext("2d").drawImage(oImage.image, 0, -oImage.height, oImage.width, oImage.height)
		oImage.useData = false;
		return true;

	} else if (oImage.client.isIE) {
		oImage.image.style.filter += " flipv";
		return true;
	}
}

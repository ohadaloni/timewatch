/*------------------------------------------------------------*/
$(function() {
	timeWatchPaintRows(document);
	/*	$(".imgToolTip").imgToolTip();	*/
	$(".showImage").showImage();
});
/*------------------------------------------------------------*/
function timeWatchPaintRows(context)
{
	$(".mRow", context).hoverClass("hilite");
	$(".timeWatchRow", context).hoverClass("hilite");
	$(".mFormRow", context).hoverClass("hilite");
	$(".mHeaderRow", context).addClass("timeWatchZebra0");
	$(".timeWatchHeaderRow", context).addClass("timeWatchZebra0");
	$(".mFormRow:nth-child(odd)", context).addClass("timeWatchZebra1");
	$(".mFormRow:nth-child(even)", context).addClass("timeWatchZebra2");
	$(".mRow:nth-child(odd)", context).addClass("timeWatchZebra1");
	$(".mRow:nth-child(even)", context).addClass("timeWatchZebra2");
	$(".timeWatchRow:nth-child(odd)", context).addClass("timeWatchZebra2");
	$(".timeWatchRow:nth-child(even)", context).addClass("timeWatchZebra1"); // first row is 1
	$(".timeWatchFormRow:nth-child(odd)", context).addClass("timeWatchZebra2");
	$(".timeWatchFormRow:nth-child(even)", context).addClass("timeWatchZebra1"); // first row is 1

	$(".today:nth-child(odd)", context).addClass("timeWatchZebra3");
	$(".today:nth-child(even)", context).addClass("timeWatchZebra4");
	$(".yesterday:nth-child(odd)", context).addClass("timeWatchZebra5");
	$(".yesterday:nth-child(even)", context).addClass("timeWatchZebra6");

}
/*------------------------------------------------------------*/

function fixBackground() {
	var elements = new Array();
	elements[1] = document.getElementById("main");
	elements[3] = document.getElementById("content");
	elements[2] = document.getElementById("fringe-left");
	elements[4] = document.getElementById("fringe-right");
	if (elements[1].scrollHeight > document.body.parentNode.scrollHeight) {
		mainSC = elements[1].scrollHeight+40;
	} else {
		mainSC = document.body.parentNode.scrollHeight;
	}
	
	var i;
	for (i in elements) {
		elements[i].style.height = mainSC + "px";
	}
	document.body.style.height = mainSC + "px";
	document.body.scrollHeight = mainSC;
}
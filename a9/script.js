window.onload = initAll;

function initAll()
{
	for(i=0; i<document.links.length; i++)
	{
		if(document.links[i].className == "newWin")
		{
		document.links[i].onclick = myNewWindow;
		}
	}
}

function myNewWindow()
{
var littleWindow = window.open(this.href, "ltWin", "toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,width=600,height=600");
littleWindow.focus();
return false;
}

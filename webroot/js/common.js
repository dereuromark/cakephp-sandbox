/*** JQuery Stuff DEPRECATED ***/

/** Ajax Visualisation / Indicator **/

// pre-submit callback 
function showRequest() { 
    document.getElementById('ajax-loading').style.display = 'block';
    document.getElementById('ajax-loading-alt').style.display = 'block';
    return true; 
} 
 
// post-submit callback 
function showResponse()  {
	document.getElementById('ajax-loading').style.display = 'none';
	document.getElementById('ajax-loading-alt').style.display = 'none';
}


/*** End - JS Stuff ***/


//Per Dropdown navigieren	# Dropdownnummer / Link wo es hingeht
function filter(selectNode,linkNode) 
{
	//alert(selectNode[selectNode.selectedIndex].value);
	self.location.href=''+linkNode+''+selectNode[selectNode.selectedIndex].value+'';
}

//Per Dropdown navigieren	# Dropdownnummer / Link wo es hingeht
function changeSel(selectNode,linkNode) 
{
self.location.href=''+linkNode+''+selectNode[selectNode.selectedIndex].value+'';
}



/* language */

// prevents adding it several times - if clicked too often
function insert_before(field,newvalue) {
	currentvalue = document.getElementById(field).value;

	if (currentvalue.substr(0,newvalue.length) != newvalue) {
		document.getElementById(field).value = newvalue + currentvalue;
	}
	document.getElementById(field).focus();
	return false;
}

// prevents adding it several times - if clicked too often
function insert_replace(field,newvalue) {
	document.getElementById(field).value = newvalue;
	document.getElementById(field).focus();
	return false;
}



function loadMarkup(form,url) {
	
	document.getElementById(form).action = url;
	document.getElementById(form).submit();
	return false;
}



/**
* Call print preview
*/
function printPage()
{
	if (is_ie)
	{
		printPreview();
	}
	else
	{
		window.print();
	}
}


/**
* on PRE codes -> select code via mouseclick
*/
function selectCode(a)
{
	// Get ID of code block
	var e = a.parentNode.parentNode.getElementsByTagName('code')[0];

	// Not IE
	if (window.getSelection)
	{
		var s = window.getSelection();
		// Safari
		if (s.setBaseAndExtent)
		{
			s.setBaseAndExtent(e, 0, e, e.innerText.length - 1);
		}
		// Firefox and Opera
		else
		{
			var r = document.createRange();
			r.selectNodeContents(e);
			s.removeAllRanges();
			s.addRange(r);
		}
	}
	// Some older browsers
	else if (document.getSelection)
	{
		var s = document.getSelection();
		var r = document.createRange();
		r.selectNodeContents(e);
		s.removeAllRanges();
		s.addRange(r);
	}
	// IE
	else if (document.selection)
	{
		var r = document.body.createTextRange();
		r.moveToElementText(e);
		r.select();
	}
}




//Per Dropdown navigieren	# Dropdownnummer / Link wo es hingeht
function changeSel(selectNode,linkNode) 
{
self.location.href=""+linkNode+""+selectNode[selectNode.selectedIndex].value+"";
}


function changeLocation(linkNode)
{
	self.location.href=""+linkNode+"";
}


/* Ein- Ausblenden */
function toggleMe(id){
  var e=document.getElementById(id);
  if(!e)return true;
  if(e.style.display=="none"){
    e.style.display="block"
  } else {
    e.style.display="none"
  }
  return true;
}
function untoggleMe(a){
  var e=document.getElementById(a);
  if(!e)return true;
  if(e.style.display=="block"){
    e.style.display="none"
  } else {
    e.style.display="block"
  }
  return true;
}
function changeMe(a,b){
  var e=document.getElementById(a);
  if(!e)return true;
  if(e.style.display=="block"){
    e.style.display="none"
  } else {
    e.style.display="block"
  }
  var f=document.getElementById(b);
  if(!f)return true;
  if(f.style.display=="block"){
    f.style.display="none"
  } else {
    f.style.display="block"
  }
  return true;
}
function changeTotalMe(a,b,c,d){
  var e=document.getElementById(a);
  if(!e)return true;
  if(e.style.display=="block"){
    e.style.display="none"
  } else {
    e.style.display="block"
  }
  var f=document.getElementById(b);
  if(!f)return true;
  if(f.style.display=="block"){
    f.style.display="none"
  } else {
    f.style.display="block"
  }

  var g=document.getElementById(c);
  if(!g)return true;
  if(g.style.display=="block"){
    g.style.display="none"
  } else {
    g.style.display="block"
  }
  var h=document.getElementById(d);
  if(!h)return true;
  if(h.style.display=="block"){
    h.style.display="none"
  } else {
    h.style.display="block"
  }

  return true;
}




/*** geshi ***/

function selectHighslideCode(a)
{
	var e = document.getElementById(a).getElementsByTagName('PRE')[0]; // CODE
	/*alert (e.innerHTML);*/
	
	// Not IE
	if (window.getSelection)
	{
		var s = window.getSelection();
		// Safari
		if (s.setBaseAndExtent)
		{
			s.setBaseAndExtent(e, 0, e, e.innerText.length - 1);
		}
		// Firefox and Opera
		else
		{
			var r = document.createRange();
			r.selectNodeContents(e);
			s.removeAllRanges();
			s.addRange(r);
		}
	}
	// Some older browsers
	else if (document.getSelection)
	{
		var s = document.getSelection();
		var r = document.createRange();
		r.selectNodeContents(e);
		s.removeAllRanges();
		s.addRange(r);
	}
	// IE
	else if (document.selection)
	{
		var r = document.body.createTextRange();
		r.moveToElementText(e);
		r.select();
	}
}

function selectCode(a)
{
	// Get ID of code block
	var e = a.parentNode.parentNode.getElementsByTagName('PRE')[0]; // CODE

	// Not IE
	if (window.getSelection)
	{
		var s = window.getSelection();
		// Safari
		if (s.setBaseAndExtent)
		{
			s.setBaseAndExtent(e, 0, e, e.innerText.length - 1);
		}
		// Firefox and Opera
		else
		{
			var r = document.createRange();
			r.selectNodeContents(e);
			s.removeAllRanges();
			s.addRange(r);
		}
	}
	// Some older browsers
	else if (document.getSelection)
	{
		var s = document.getSelection();
		var r = document.createRange();
		r.selectNodeContents(e);
		s.removeAllRanges();
		s.addRange(r);
	}
	// IE
	else if (document.selection)
	{
		var r = document.body.createTextRange();
		r.moveToElementText(e);
		r.select();
	}
}



/*** some default popups (not needed when using highslide) ***/

function goToWindow(link) {

var openWindow = window.open (link,"Window",
"width=700,height=440,toolbar=no,location=no,top=110,left=110,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes");
openWindow.focus();
}


function goToHelp(link) {

var openWindow = window.open (link,"Help",
"width=400,height=400,toolbar=no,location=no,top=210,left=20,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes");
openWindow.focus();
}


function goToFULL(link) {

var openWindow = window.open (link,"FULL",
"location=yes,directories=yes,status=yes,menubar=yes,fullscreen=yes");
openWindow.focus();
}
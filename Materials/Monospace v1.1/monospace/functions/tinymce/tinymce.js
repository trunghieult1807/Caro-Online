function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

function mnmshortcodesubmit() {
	
	var tagtext;
	
	var mnm_shortcode = document.getElementById('mnmshortcode_panel');
	
	// check active ?
	if (mnm_shortcode.className.indexOf('current') != -1) {
		var mnm_shortcodeid = document.getElementById('mnmshortcode_tag').value;
		switch(mnm_shortcodeid)
{
case 0:
 	tinyMCEPopup.close();
  break;

case "button-brown":
	tagtext = "["+ mnm_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + mnm_shortcodeid + "]";
break;

case "button-blue":
	tagtext = "["+ mnm_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + mnm_shortcodeid + "]";
break;

case "button-green":
	tagtext = "["+ mnm_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + mnm_shortcodeid + "]";
break;

case "button-yellow":
	tagtext = "["+ mnm_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + mnm_shortcodeid + "]";
break;

case "button-red":
	tagtext = "["+ mnm_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + mnm_shortcodeid + "]";
break;

case "button-white":
	tagtext = "["+ mnm_shortcodeid + "  url=\"#\" target=\"_self\" position=\"left\"] Button text [/" + mnm_shortcodeid + "]";
break;

case "alert-note":
	tagtext = "["+ mnm_shortcodeid + "] Note text [/" + mnm_shortcodeid + "]";
break;

case "alert-announce":
	tagtext = "["+ mnm_shortcodeid + "] Announce text [/" + mnm_shortcodeid + "]";
break;

case "alert-success":
	tagtext = "["+ mnm_shortcodeid + "] Success text [/" + mnm_shortcodeid + "]";
break;

case "alert-warning":
	tagtext = "["+ mnm_shortcodeid + "] Warning text [/" + mnm_shortcodeid + "]";
break;

case "youtube":
	tagtext = "["+ mnm_shortcodeid + " id=\"#\" width=\"600\" height=\"340\" position=\"none\"]";
break;

case "vimeo":
	tagtext = "["+ mnm_shortcodeid + " id=\"#\" width=\"600\" height=\"340\" position=\"none\"]";
break;

case "googlemap":
	tagtext = "["+ mnm_shortcodeid + " width=\"600\" height=\"340\" src=\"#\" position=\"left\"]";
break;

case "toggle":
	tagtext="["+mnm_shortcodeid + " title=\"Toggle Title\"]Insert content here[/" + mnm_shortcodeid + "]";
break;

case "tabs":
	tagtext="["+mnm_shortcodeid + "] [tab title=\"Tab 1 Title\"]Insert tab 1 content here[/tab] [tab title=\"Tab 2 Title\"]Insert tab 2 content here[/tab] [tab title=\"Tab 2 Title\"]Insert tab 3 content here[/tab] [/" + mnm_shortcodeid + "]";
break;

case "divider":
	tagtext = "["+ mnm_shortcodeid + "]";
break;

case "divider_top":
	tagtext = "["+ mnm_shortcodeid + "]";
break;

case "clear":
	tagtext = "["+ mnm_shortcodeid + "]";
break;

default:
tagtext="["+mnm_shortcodeid + "] Insert you content here [/" + mnm_shortcodeid + "]";
}
}

if(window.tinyMCE) {
		//TODO: For QTranslate we should use here 'qtrans_textarea_content' instead 'content'
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML. 
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}
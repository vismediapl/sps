var started = false;

var xhrEvents = {
	onCreate: function () {
		Element.show("loading");
	},
	onComplete: function () {
		if(Ajax.activeRequestCount == 0){
			Element.hide("loading");
		}
	}
};

var events = {
	'#files li' : function (el) {
		el.onmouseover = function () { this.className = "hov"; },
		el.onmouseout = function () { this.className = ""; }
	},
	'body' : function (el) {
		if (!started)
			new function () {
				Element.hide("loading");
				resizeWindow(840, 500);
				getFilesAndFolders('');
				started = true;
			}
	}
}

Ajax.Responders.register(xhrEvents);
Behaviour.register(events);

/* ------------------- */

var resizeWindow = function (W, H) {
	window.resizeTo(W + 200, H + 200);
	if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight))
	{
		var xDiff = (W - document.documentElement.clientWidth + 200);
		var yDiff = (H - document.documentElement.clientHeight + 200);
	} else {
		var xDiff = (W - document.body.clientWidth + 200);
		var yDiff = (H - document.body.clientHeight + 200);
	}
	window.resizeTo(W + xDiff, H + yDiff);
	if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight))
		window.moveTo((screen.width / 2) - ((xDiff + document.documentElement.clientWidth) / 2), (screen.height / 2) - ((yDiff + document.documentElement.clientHeight) / 2));
	else
		window.moveTo((screen.width / 2) - ((xDiff + document.body.clientWidth) / 2), (screen.height / 2) - ((yDiff + document.body.clientHeight) / 2));
	return true;
}

var outputOnlyName = function (fullname) {
	return fullname.substring(fullname.lastIndexOf('/') + 1);
}

/* ------------------- */

var getFiles = function (folderName) {
	var xhr = new Ajax.Updater({success: "right"}, "connector.php", {method: 'get', parameters: 'action=getFiles&folder=' + folderName, onComplete: getFilesCallback});
}

var getFolders = function (folderName) {
	var xhr = new Ajax.Updater({success: "left"}, "connector.php", {method: 'get', parameters: 'action=getFolders&folder=' + folderName});
	$("top").innerHTML = '<strong>Katalog: </strong> <a href="#" onclick="getFilesAndFolders(\'\'); return false">@</a>' + folderName;
	$("cfolder").value = folderName;
}

var getFilesAndFolders = function (folderName) {
	getFolders(folderName);
	getFiles(folderName);
}

var getFilesCallback = function (xhr) {
	Behaviour.apply();
	Element.hide("loading");
	$("right").scrollTop = 0;
}

/* ------------------- */

var renameFolder = function (fname) {
	var fn = prompt('Podaj nową nazwę katalogu "' + outputOnlyName(fname) + '":', '');
	if (fn != '' && fn !== null) {
		var xhr = new Ajax.Request('connector.php', {method: 'get', parameters: 'action=renameFolder&ajax=1&folder=' + fname + '&newName=' + fn, onComplete: actionFolderCallback}); 
	}
}

var createFolder = function () {
	var fn = prompt('Podaj nazwę nowego katalogu:', '');
	if (fn != '' && fn !== null) {
		var xhr = new Ajax.Request('connector.php', {method: 'get', parameters: 'action=createFolder&ajax=1&folder=' + $("cfolder").value + '&newName=' + fn, onComplete: actionFolderCallback}); 
	}
}

var actionFolderCallback = function (xhr) {
	var text = xhr.responseText.substring(1);
	var stat = xhr.responseText.charAt(0);
	if (stat == '0' || stat == '+')
	{
		getFolders(text);
		if (stat == '+')
			getFiles(text);
	}
	else
		alert(stat + '; ' + text);
}

var actionFileCallback = function (xhr) {
	var text = xhr.responseText.substring(1);
	var stat = xhr.responseText.charAt(0);
	if (stat == '0' || stat == '+')
	{
		getFiles(text);		
		if (stat == '+')
			getFolders(text);
	}
	else
		alert(stat + '; ' + text);
}

var deleteFolder = function (fname) {
	var df = confirm('Czy napewno usunąć katalog "' + outputOnlyName(fname) + '"\nwraz ze wszystkimi plikami?');
	if (df === true) {
		var xhr = new Ajax.Request('connector.php', {method: 'get', parameters: 'action=deleteFolder&ajax=1&folder=' + $("cfolder").value + '&delete=' + fname, onComplete: actionFolderCallback});
	}
}

var renameFile = function (fname) {
	var fn = prompt('Podaj nową nazwę pliku "' + outputOnlyName(fname) + '":', '');
	if (fn != '' && fn !== null) {
		var xhr = new Ajax.Request('connector.php', {method: 'get', parameters: 'action=renameFile&ajax=1&folder=' + $("cfolder").value + '&file=' + fname + '&newName=' + fn, onComplete: actionFileCallback}); 
	}
}

var deleteFile = function (fname) {
	var df = confirm('Czy napewno usunąć plik "' + outputOnlyName(fname) + '"?');
	if (df === true) {
		var xhr = new Ajax.Request('connector.php', {method: 'get', parameters: 'action=deleteFile&ajax=1&folder=' + $("cfolder").value + '&delete=' + fname, onComplete: actionFileCallback});
	}
}

var clearFileCache = function () {
	var xhr = new Ajax.Request('connector.php', {method: 'get', parameters: 'action=clearFileCache&ajax=1&folder=' + $("cfolder").value, onComplete: actionFileCallback});
}

var uploadFile = function () {
	$("upForm").action = "upload.php?folder=" + $("cfolder").value;
	$("upForm").submit();
	$("fileBox").disabled = false;
	$("btnSubmit").disabled = false;
	clearFileCache();
}

var useFile = function (fname) {
	window.opener.SetUrl(fname);
	window.close();
}

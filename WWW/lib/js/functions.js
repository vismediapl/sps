function confirmSubmit() {
var agree=confirm("<?=$lang['confirm_submit'];?>");
if (agree)
	return true ;
else
	return false ;
}

function show_tab(p,q,h) {

for(i=1;i<=h;i++) {
	if(i==q) {
		document.getElementById('tab_' + p + '_' + i).style.display = 'block';
		document.getElementById('td_' + p + '_' + i).className = 'TabClass1';
		if(p==1) {
			document.getElementById('tabCenter_' + p + '_' + i).style.display = 'block';
		}
	}
	else {
		document.getElementById('tab_' + p + '_' + i).style.display = 'none';
		document.getElementById('td_' + p + '_' + i).className = 'TabClass2';
		if(p==1) {
			document.getElementById('tabCenter_' + p + '_' + i).style.display = 'none';
		}
	}
}

}

function addbookmark(){
if (document.all) {
	var bookmarkurl=document.location
	var bookmarktitle=document.title
	window.external.AddFavorite(bookmarkurl,bookmarktitle)
}
}
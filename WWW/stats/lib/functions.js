function footer () {
         document.getElementById('body').style.height = 'auto';
         if (window.innerHeight >= document.getElementById('body').clientHeight) {
            document.getElementById('footer').style.position = 'absolute';
            document.getElementById('footer').style.bottom = 0;
            document.getElementById('body').style.height = window.innerHeight + 'px';
            document.getElementById('html').style.overflow = 'hidden';
            }
         else {
              document.getElementById('footer').style.position = 'static';
              document.getElementById('html').style.overflow = 'auto';
              }
         }
function IEover () {
         this.className = 'hover';
         }
function IEout () {
         this.className = '';
         }
function IEsupport () {
         document.getElementById('moption_admin').onmouseover = IEover;
         document.getElementById('moption_admin').onmouseout = IEout;
         document.getElementById('html').style.height = '100%';
         innerHeight = document.getElementById('html').clientHeight;
         }
function levelsSH (id) {
         value = document.getElementById(id + '_switch').value;
         a = document.getElementById(id).getElementsByTagName('hr');
         for (i = 0; i < a.length; i++) a[i].style.display = ((value == '  >  ')?'none':'block');
         document.getElementById(id + '_switch').value = ((value == '  >  ')?'  <  ':'  >  ');
         }
function highlightColumns (ids, num, type, id, mode) {
         document.getElementById('switch_' + num + '_' + type + '_' + id).className = (mode?'pointer':'');
         for (i = ((id == 3)?0:id), c = ((id == 3)?2:id); i <= c; i++) document.getElementById('level_' + num + '_' + type + '_' + i).style.borderColor = (mode?highlightColor:(type?chartLevelAll:chartLevelUni));
         for (i = 0, c = ids.length; i < c; i++) {
             a = document.getElementById((ids[i] == '_')?'chart_' + num:'bar_' + num + '_' + ids[i]).getElementsByTagName('div');
             for (j = 0, c = a.length; j < c; j++) if (a[j].className == (type?'all':'uni') || a[j].className == (type?'all':'uni') + ' max') a[j].style.borderColor = (mode?highlightColor:((a[j].className.split('ma').length > 1)?chartMaxBorder:chartColumnBorder));
             }
         }
function expandRow (id, container) {
         container.style.display = 'block';
         document.getElementById(id).className = 'expanded';
         document.getElementById(id).style.display = 'block';
         }
function findRows (gid, sid, find, mode) {
         paragraphs = document.getElementById(mode?gid:sid).getElementsByTagName('p');
         for (k = 0; k < paragraphs.length; k++) {
             pid = paragraphs[k].id;
             fields = document.getElementById(pid).getElementsByTagName(document.getElementById(pid).getElementsByTagName('textarea').length?'textarea':'input');
             string = ' ' + fields[0].value.toLowerCase () + fields[0].name.toLowerCase () + ' ';
             if (string.split(find).length > 1) {
                if (paragraphs[k].style.display != 'block') document.getElementById('ResultsAmount').innerHTML++;
                if (!mode) expandRow (sid, paragraphs[k]);
                expandRow (gid, paragraphs[k]);
                }
             }
         }
function search (find) {
         find = find.toLowerCase ();
         fieldsets = document.getElementById('advanced').getElementsByTagName('fieldset');
         rows = document.getElementById('advanced').getElementsByTagName('p');
         document.getElementById('ResultsAmount').innerHTML = 0;
         if (find != '') {
            for (i = 0; i < fieldsets.length; i++) fieldsets[i].style.display = 'none';
            for (i = 0; i < rows.length; i++) rows[i].style.display = 'none';
            }
         else {
              for (i = 0; i < fieldsets.length; i++) {
                  fieldsets[i].className = 'nexpanded';
                  fieldsets[i].style.display = 'block';
                  }
              for (i = 0; i < rows.length; i++) rows[i].style.display = 'block';
              document.getElementById('ResultsAmount').innerHTML = ResultsAmount;
              footer ();
              return (0);
              }
         for (i = 0; i < fieldsets.length; i++) {
             if (fieldsets[i].id.split('.').length == 1) {
                gid = fieldsets[i].id;
                groups = document.getElementById(gid).getElementsByTagName('fieldset');
                for (j = 0; j < groups.length; j++) {
                    sid = groups[j].id;
                    findRows (gid, sid, find, 0);
                    findRows (gid, sid, find, 1);
                    footer ();
                    }
                }
             }
         }
function checkDefault (field, value, type) {
         if (type) change = !(document.getElementById('F_' + field).checked == value);
         else change = !(document.getElementById('F_' + field).value == value);
         document.getElementById('P_' + field).className = (change?'changed':'');
         document.getElementById('P_' + field).title = (change?ChangedValueString:'');
         }
function setDefault (field, value, type) {
         if (type) document.getElementById('F_' + field).checked = ((value == '1')?true:false);
         else document.getElementById('F_' + field).value = value;
         checkDefault (field, value, type);
         }
function changeClassName (id) {
         document.getElementById(id).className = ((document.getElementById(id).className == 'expanded')?'nexpanded':'expanded');
         document.getElementById('ShowAll').checked = 0;
         footer ();
         }
function hideAll () {
         a = document.getElementById('advanced').getElementsByTagName('fieldset');
         for (i = 0; i < a.length; i++) a[i].className = 'nexpanded';
         footer ();
         }
function showAll () {
         a = document.getElementById('advanced').getElementsByTagName('fieldset');
         for (i = 0; i < a.length; i++) {
             a[i].className = (Expanded?'nexpanded':'expanded');
             a[i].style.display = 'block';
             }
         a = document.getElementById('advanced').getElementsByTagName('p');
         for (i = 0; i < a.length; i++) a[i].style.display = 'block';
         Expanded = !Expanded;
         document.getElementById('AdvancedSearch').value = SearchString;
         document.getElementById('AdvancedSearch').style.color = 'gray';
         document.getElementById('ResultsAmount').innerHTML = ResultsAmount;
         footer ();
         }
[start:menu]<ul id="menu">
{menu}</ul>
[/end]

[start:menu-row]<li id="moption_{id}">
<a href="{link}" title="{title}" tabindex="{tindex}" class="{class}">
{ssign}{text}
</a>
{submenu}</li>
[/end]

[start:submenu]<ul id="submenu_{id}">
{menu}</ul>
[/end]

[start:submenu-row]<li id="soption_{id}">
<a href="{link}" title="{title}" tabindex="{tindex}" class="{class}">
<span>{text}</span>
</a>
</li>
[/end]

[start:debug]<h3 style="margin-top:5px;">%debug%</h3>
<div id="debug">
{debug}</div>
[/end]

[start:announcement]<div class="{class}" title="{type}">
{content}
</div>
[/end]

[start:dateform]<form action="{spath}" method="post" id="dateform">
<p>
<span>
{monthselect}{yearselect}<input type="submit" value="%show%" tabindex="{dateformindex}" class="button" />
</span>
<label for="month">%showdatafor%</label>:
</p>
</form>
[/end]

[start:config-row]<p>
<span>
{form}
</span>
<label for="{fid}">{desc}</label>:
</p>
[/end]

[start:option-row]<p id="P_{id}"{changed}>
<span>
{form}
<input type="button" value="%default%" class="button" onclick="setDefault ('{id}', '{default}', {mode})" title="%defaultvalue%: {defaultvalue}" tabindex="{tindex}" />
</span>
<label for="F_{id}">
{option}:{desc}
</label>
</p>
[/end]
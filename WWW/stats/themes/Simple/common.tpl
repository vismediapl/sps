[start:menu]<ul>
{menu}</ul>
[/end]

[start:menu-row]<li>
<a href="{link}" title="{title}" tabindex="{tindex}">{text}</a>
{submenu}</li>
[/end]

[start:submenu]<ul>
{menu}</ul>
[/end]

[start:submenu-row]<li>
<a href="{link}" title="{title}" tabindex="{tindex}">{text}</a>
</li>
[/end]

[start:debug]<hr>
<h3>%debug%</h3>
{debug}[/end]

[start:announcement]<div border="1">
<h4>{type}</h4>
{content}
</div>
[/end]

[start:dateform]<form action="{spath}" method="post">
<p>
<label for="month">%showdatafor%</label>:<br>
{monthselect}{yearselect}<input type="submit" value="%show%" tabindex="{dateformindex}">
</p>
</form>
[/end]

[start:config-row]<p>
<label for="{fid}">{desc}</label>:<br>
{form}
</p>
[/end]

[start:option-row]<p id="P_{id}">
<label for="F_{id}">
{option}:{desc}
</label><br>
{form}
<input type="button" value="%default%" class="button" onclick="setDefault ('{id}', '{default}', {mode})" title="%defaultvalue%: {defaultvalue}" tabindex="{tindex}" />
</p>
[/end]
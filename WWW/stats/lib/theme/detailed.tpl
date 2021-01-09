[start:detailed]<table cellpadding="2" cellspacing="0" id="detailed">
<thead>
<tr>
<th>
#
</th>
<th>
%firstvisit%
</th>
<th>
%lastvisit%
</th>
<th>
%visitamount%
</th>
<th>
%referrer%
</th>
<th>
%host%
</th>
<th>
%userinfo%
</th>
</tr>
</thead>
<tbody>
{rows}</tbody>
</table>
{links}{legend}[/end]

[start:detailed-row]<tr class="{class}">
<td>
<strong><em>{id}</em></strong>
</td>
<td>
{first}
</td>
<td>
{last}
</td>
<td>
{visits}</td>
<td>
{referrer}
</td>
<td>
{host}
</td>
<td title="{useragent}">
{configuration}</td>
</tr>
[/end]

[start:detailed-links]{links}[/end]

[start:detailed-legend]<h4>%legend%:</h4>
<p>
<small class="user">%yourvisit%</small>
</p>
<p>
<small class="online">%onlinevisitors%</small>
</p>
<p>
<small class="robot">%robots%</small> {switch}
</p>
[/end]

[start:detailed-none]<tr>
<td colspan="7">
<strong>%none%</strong>
</td>
</tr>
[/end]
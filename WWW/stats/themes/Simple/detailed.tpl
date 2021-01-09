[start:detailed]<table cellpadding="2" cellspacing="0" border="1" width="100%">
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
{links}[/end]

[start:detailed-row]<tr>
<td align="center">
<strong><em>{id}</em></strong>
</td>
<td align="center">
{first}
</td>
<td align="center">
{last}
</td>
<td align="center">
{visits}</td>
<td align="center">
{referrer}
</td>
<td align="center">
{host}
</td>
<td title="{useragent}" align="center">
{configuration}</td>
</tr>
[/end]

[start:detailed-links]{links}[/end]

[start:detailed-none]<tr>
<td colspan="7" align="center">
<strong>%none%</strong>
</td>
</tr>
[/end]
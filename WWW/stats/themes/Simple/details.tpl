[start:details]<table cellpadding="0" cellspacing="0" border="1" width="100%"">
<thead>
<tr>
<th colspan="3">
%visitedpages% ({visits})
</th>
<th>
%referrer%
</th>
<th>
%keywords%
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
<tr>
<th>
#
</th>
<th>
%date%
</th>
<th>
%site%
</th>
<td rowspan="{rowspan}" align="center">
{referrer}
</td>
<td rowspan="{rowspan}" align="center">
{keywords}
</td>
<td rowspan="{rowspan}" align="center">
{host}
</td>
<td rowspan="{rowspan}" title="{useragent}" align="center">
{configuration}</td>
</tr>
{rows}{links}</tbody>
</table>
{legend}[/end]

[start:details-row]<tr>
<td align="center">
<em>{num}.</em>
</td>
<td align="center">
{date}
</td>
<td title="{title}" align="center">
{link}
</td>
</tr>
[/end]

[start:details-links]<tr>
<td colspan="3" align="center">
{links}
</td>
</tr>
[/end]

[start:details-none]<h4>%warning%</h4>
%dataunavailable%.<br>
[/end]
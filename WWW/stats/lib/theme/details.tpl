[start:details]<table cellpadding="0" cellspacing="0" id="details" class="{class}">
<thead>
<tr class="detailsheader">
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
<tr class="detailsheader">
<th>
#
</th>
<th>
%date%
</th>
<th>
%site%
</th>
<td rowspan="{rowspan}">
{referrer}
</td>
<td rowspan="{rowspan}">
{keywords}
</td>
<td rowspan="{rowspan}">
{host}
</td>
<td rowspan="{rowspan}" title="{useragent}">
{configuration}</td>
</tr>
{rows}{links}</tbody>
</table>
{legend}[/end]

[start:details-row]<tr>
<td>
<em>{num}.</em>
</td>
<td>
{date}
</td>
<td title="{title}">
{link}
</td>
</tr>
[/end]

[start:details-links]<tr>
<td colspan="3">
{links}
</td>
</tr>
[/end]

[start:details-none]<div class="warning" title="%warning%">
%dataunavailable%.
</div>
[/end]
[start:chart]<table cellspacing="0" cellpadding="0" class="chart" id="chart_{id}">
<thead>
<tr>
<th colspan="{colspan}">{title}</th>
</tr>
</thead>
{chart}</table>
{summary}{vprofile}[/end]

[start:chart-bars-container]<td{class} id="{id}">
<div>
{bars}</div>
{desc}</td>
[/end]

[start:chart-bar]<div style="height:{height}px;margin-top:{margin}px;" class="{class}" title="{title}"></div>
[/end]

[start:chart-summary]<table cellpadding="0" cellspacing="0" class="summary">
<thead>
<tr>
<th colspan="5">%summary%</th>
</tr>
</thead>
<tbody>
<tr>
<th>&nbsp;</th>
<th>%sum%</th>
<th>%most%</th>
<th>%average%</th>
<th>%least%</th>
</tr>
{rows}</tbody>
</table>
[/end]

[start:chart-summary-row]<tr>
<th>{text}</th>
<td{sumjs}>{sum}</td>
<td{maxjs}>{max}</td>
<td{avgjs}>{avg}</td>
<td{minjs}>{min}</td>
</tr>
[/end]
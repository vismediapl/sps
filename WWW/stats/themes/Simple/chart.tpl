[start:chart]<table cellspacing="0" cellpadding="0" width="100%" border="1">
<tr>
<th colspan="{colspan}">{title}</th>
</tr>
{chart}</table><br>
{summary}{vprofile}[/end]

[start:chart-bars-container]<td valign="bottom" height="150" align="center">
<table cellspacing="0" cellpadding="0" align="center" width="100%">
<tr>
{bars}</tr>
</table>
</td>
[/end]

[start:chart-bar]<td valign="bottom" width="30%">
<table cellspacing="0" cellpadding="0" height="{height}" width="80%" bgcolor="gray" title="{title}" border="1">
<tr>
<td height="{height}" width="100%">
{simplebar}<img src="" alt="" height="{height}">
</td>
</tr>
</table>
</td>
[/end]

[start:chart-summary]<table cellpadding="3" cellspacing="0" width="100%" border="1">
<tr>
<th colspan="5">%summary%</th>
</tr>
<tr>
<th>&nbsp;</th>
<th>%sum%</th>
<th>%most%</th>
<th>%average%</th>
<th>%least%</th>
</tr>
{rows}</table>
[/end]

[start:chart-summary-row]<tr>
<th>{text}</th>
<td align="center">{sum}</td>
<td align="center">{max}</td>
<td align="center">{avg}</td>
<td align="center">{min}</td>
</tr>
[/end]
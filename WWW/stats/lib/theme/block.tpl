[start:block]<table cellspacing="0" cellpadding="0" id="group_{id}">
<thead>
<tr>
<th colspan="4">{title}<!--start:block_{id}_info--> ({displayed} %of% {amount})<!--end:block_{id}_info--></th>
</tr>
</thead>
<tbody>
{rows}{sum}{admin}</tbody>
</table>
[/end]

[start:block-row]<tr>
<td class="auto">
<em>{num}</em>.
</td>
<td class="wide">
{icon}{value}
</td>
<td>
{amount}
</td>
<td>
<em>{percent}%</em>
</td>
</tr>
[/end]

[start:block-amount]<tr>
<td colspan="2">
<strong>%sum%:</strong>
</td>
<td>
<strong>{amount}</strong>
</td>
<td>&nbsp;</td>
</tr>
[/end]

[start:block-none]<tr>
<td colspan="4">
<strong>%none%</strong>
</td>
</tr>
[/end]

[start:block-admin]<tr>
<td colspan="4" class="settings">
{admin}</td>
</tr>
[/end]
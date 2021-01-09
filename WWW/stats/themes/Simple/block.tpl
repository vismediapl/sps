[start:block]<tr>
<th colspan="4">{title}<!--start:block_{id}_info--> ({displayed} %of% {amount})<!--end:block_{id}_info--></th>
</tr>
{rows}{sum}{admin}[/end]

[start:block-row]<tr>
<td>
<em>{num}</em>.
</td>
<td>
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
<td colspan="2" align="center">
<strong>%sum%:</strong>
</td>
<td colspan="2">
<strong>{amount}</strong>
</td>
</tr>
[/end]

[start:block-none]<tr>
<td colspan="4" align="center">
<strong>%none%</strong>
</td>
</tr>
[/end]

[start:block-admin]<tr>
<td colspan="4">
{admin}</td>
</tr>
[/end]
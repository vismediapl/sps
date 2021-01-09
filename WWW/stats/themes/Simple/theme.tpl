<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN">
<html dir="{dir}">
<head>
{meta}<link href="{dpath}themes/favicon.png" rel="shortcut icon" type="image/png">
<title>eStats :: {title}</title>
<!--
Simple theme for eStats 4.5
Author: Emdek
http://estats.emdek.cba.pl
Licence: GPL
-->
<script type="text/javascript" src="{dpath}themes/{theme}/theme.js"></script>
<script type="text/javascript" src="{dpath}lib/functions.js"></script>
</head>
<body bgcolor="white" align="center">
<div>
<a name="top"></a>
<div align="right">
<h1 align="center">
{header}
</h1>
<!--start:selectform--><form action="{spath}" method="post">
<div>
{langselect}{themeselect}<input type="submit" value="%change%" tabindex="{selectformindex}">
</div>
</form>
<!--end:selectform-->{date}<!--start:loggedin--><a {logoutlink}>%logout%</a><br>
<!--end:loggedin--></div>
<div align="left">
<hr>
{menu}<hr>
<!--start:announcements-->{info}<hr>
<!--end:announcements--><!--start:!critical--><!--start:!antyflood--><h2 align="center">{title}</h2>
<!--end:!antyflood--><!--end:!critical-->{page}{debug}<hr>
</div>
<div align="center">
Powered by<br>
<a href="http://estats.emdek.cba.pl/" tabindex="{tindex}">
<img src="{dpath}antipixels/default/simple.png" alt="eStats" title="eStats" border="0">
</a><br><br>
&copy; 2005 - 2007 <a href="http://emdek.cba.pl/" tabindex="{tindex}"><strong>Emdek</strong></a>
<div align="right">
<a href="#top" title="%gototop%" tabindex="{tindex}" id="gototop"><b>^</b></a><br>
</div>
<small>{pagegeneration}</small>
</div>
</div>
</body>
</html>
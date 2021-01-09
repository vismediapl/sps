<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{lang}" dir="{dir}" id="html">
<head>
{meta}<link href="{dpath}themes/{theme}/theme.css" rel="stylesheet" type="text/css" title="{theme}" />
<link href="{dpath}themes/favicon.png" rel="shortcut icon" type="image/png" />
<title>eStats :: {title}</title>
{css}<!--
Silver theme for eStats 4.5
Author: Emdek
http://estats.emdek.cba.pl
Licence: GPL
-->
<script type="text/javascript" src="{dpath}themes/{theme}/theme.js"></script>
<script type="text/javascript" src="{dpath}lib/functions.js"></script>
</head>
<body>
<div id="body">
<div id="header">
<div id="headerright">
<!--start:selectform--><form action="{spath}" method="post">
<div>
{langselect}{themeselect}<input type="submit" value="%change%" tabindex="{selectformindex}" class="button" />
</div>
</form>
<!--end:selectform-->{date}<!--start:loggedin--><a {logoutlink} id="logout">%logout%</a><br />
<!--end:loggedin--></div>
<h1>
{header}
</h1>
{menu}</div>
<div id="content">
{info}<!--start:!critical--><!--start:!antyflood--><h2>{title}</h2>
<!--end:!antyflood--><!--end:!critical-->{page}{debug}</div>
<div id="preloader">
<img src="{dpath}themes/{theme}/images/menu.png" alt="" />
<img src="{dpath}themes/{theme}/images/menu_active.png" alt="" />
<img src="{dpath}themes/{theme}/images/gototop_hover.png" alt="" />
</div>
<div id="footer">
Powered by<br />
<a href="http://estats.emdek.cba.pl/" tabindex="{tindex}">
<img src="{dpath}antipixels/default/silver.png" alt="eStats" title="eStats" />
</a>
<br />
<div>
&copy; 2005 - 2007 <a href="http://emdek.cba.pl/" tabindex="{tindex}"><strong>Emdek</strong></a>
</div>
<a href="#header" title="%gototop%" tabindex="{tindex}" id="gototop">&nbsp;</a>
<small>{pagegeneration}</small>
</div>
</div>
<!--[if IE]>
<script type="text/javascript">
window.onload = IEsupport ();
</script>
<![endif]-->
<script type="text/javascript">
window.onload = footer ();
</script>
</body>
</html>
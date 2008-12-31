<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MaNGOS Database Manager PHP</title>
<link rel="stylesheet" type="text/css" href="gfx/style.css" />
{php}
  global $xajax;
  $xajax->printJavascript('libs/xajax/');
{/php}
<script type="text/javascript" charset="UTF-8">
{literal}
function mdmphp_onLoad()
{
{/literal}
{$extrajs}
{literal}
}
{/literal}
</script>
</head>
<body onload="mdmphp_onLoad();">
<div id="pMenu">
{include file='layout_menu.tpl'}
</div>
<div id="pSearch">
</div>
<div id="pContent">
loading page...
<noscript><br />
<font color="#FF0000"><b>Diese Webseite ben&ouml;tigt einen scriptf&auml;higen Browser.<br />
Du hast entweder die Scripts deaktiviert oder benutzt einen veralteten Browser.<br />
Um diese Seite zu verwenden aktiviere JavaScript und/oder aktualisiere deinen Browser.</b></font>
</noscript>
</div>
<div id="pFooter">
{include file='layout_footer.tpl'}
</div>
</body>
</html>

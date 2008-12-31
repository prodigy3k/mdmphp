<center>
<h1>MDM Login</h1>
<div id="loginError" style="color: #FF0000;">
{$loginError}
</div>
<p>Benutze deinen normalen pdy.emu Login!</p>
<form id="loginForm" onsubmit="return false;">
<table border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td align="right">
      Benutzername
    </td>
    <td>
      <input type="text" id="username" name="username" size="15" />
    </td>
  </tr>
  <tr>
    <td align="right">
      Passwort
    </td>
    <td>
      <input type="password" id="password" name="password" size="15" />
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input type="submit" value="login" onclick="xajax_mdmpage.LogIn(xajax.getFormValues('loginForm'));" />
    </td>
  </tr>
</table>
</form>
</center>

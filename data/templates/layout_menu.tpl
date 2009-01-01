<h1 style="text-align:left;">Navigation</h1>
{php}
if($_SESSION['loggedin'] == true)
{
{/php}
<ul>
<li><a href="javascript:loadPage('serveroverview');">Server Overview</a></li>
<li><a href="javascript:loadPage('itemeditor');">Item Editor</a></li>
</ul>
<ul>
<li><a href="javascript:logOut();">Logout</a></li>
</ul>
{php}
} else {
{/php}
<ul>
<li><a href="javascript:loadPage('login');">Login</a></li>
</ul>
{php}
}
{/php}

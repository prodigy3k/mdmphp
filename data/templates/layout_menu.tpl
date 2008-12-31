<h1 style="text-align:left;">Navigation</h1>
{php}
if($_SESSION['loggedin'] == true)
{
{/php}
<ul>
<li><a href="javascript:void(1);" onClick="xajax_mdmpage.getContent('itemeditor');">Item Editor</a></li>
</ul>
<ul>
<li><a href="javascript:void(1);" onClick="xajax_mdmpage.LogOut();">Logout</a></li>
</ul>
{php}
} else {
{/php}
<ul>
<li><a href="javascript:void(1);" onClick="xajax_mdmpage.getContent('login');">Login</a></li>
</ul>
{php}
}
{/php}

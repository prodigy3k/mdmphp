<?php
if(isset($_mod_preload) && $_mod_preload == true)
{
}
else
{
  $rdbs = new realmdbs($objR);
  unset($rdbs);
}
?>

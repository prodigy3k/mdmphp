<?php

/* SMARTY_DIR Konstante setzen */
define('SMARTY_DIR', dirname(__FILE__)."/smarty/");
/* Script Pfad Konstanten setzen */
define('MDMPHP_DIR', dirname(__FILE__).'/../');
define('MDMPHP_PATH', dirname($_SERVER['SCRIPT_NAME']));

/* database config variable */
$__conf_db = array(
                   'server'  => 'localhost',    // server
                   'user'    => 'root',         // username
                   'pass'    => '',             // password
                  );

?>

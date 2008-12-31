<?php

error_reporting(E_ALL);

/**
 * MDMphp - class.mdmpage.php
 *
 * $Id$
 *
 * This file is part of MDMphp.
 *
 * @author prodigy
 * @since 31.12.2008
 * @version 0.1a
 */

if (0 > version_compare(PHP_VERSION, '5')) {
    die('This file was generated for PHP 5');
}

session_start();

/* require config and classes */
require_once('libs/config.conf.php');
require_once('libs/smarty/Smarty.class.php');
require_once('libs/xajax/xajax_core/xajax.inc.php');
require_once('libs/modules/mdmpage.class.php');

/* initialize needed page objects */
$xajax  = new xajax();
$p      = new mdmpage(&$__conf_db);

/* register page to xajax and process incoming requests */
$xajax->register(XAJAX_CALLABLE_OBJECT, $p);
$xajax->processRequest();

/* if no requests were send we get here
   and presume its an initial page load */
$p->FirstLoad();

?>

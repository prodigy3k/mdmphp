<?php

error_reporting(E_ALL);

/**
 * MDMphp - realmdbs.class.php
 *
 * $Id$
 *
 * This file is part of MDMphp.
 *
 * @author prodigy
 * @since 01.01.2009
 * @version 0.1a
 */

require_once('libs/modules/dbcontainer.class.php');

/**
 * realm BD management class
 *
 * @access public
 * @author prodigy
 * @since 01.01.2009
 * @version 0.1a
 */
class realmdbs
{
  // --- ATTRIBUTES ---

  /**
   * Container fuer Realm Datenbanken
   *
   * @access private
   * @var Array
   */
  private $__cont_dbs = null;

  /**
   * Reservierte Variable für die Smarty-Klasse (s. Konstruktor)
   *
   * @access private
   * @var Integer
   */
  private $smarty = null;

  /**
   * Reservierte Variable für die Smarty-Klasse (s. Konstruktor)
   *
   * @access private
   * @var DBContainer
   */
  private $DBc = null;
  
  /**
   * xajax Response Object
   *
   * @access private
   * @var xajaxResponse
   */
  private $objR = null;

  // --- OPERATIONS ---

  /**
   * Konstruktor
   *
   * @access public
   * @author prodigy
   * @since 01.01.2009
   * @version 0.1a
   */
  public function __construct(&$objR)
  {
    $this->smarty        = &$GLOBALS['smty'];
    $this->DBc           = &$GLOBALS['DBc'];
	$this->objR          = &$objR;
	$this->DBLoadAll();
  }
  
  /**
   * Alle eingetragenen realms laden
   *
   * @access private
   * @author prodigy
   * @since 01.01.2009
   * @version 0.1a
   */
  private function DBLoadAll()
  {
    if(!$this->DBc->DB_Connect('mdm'))
    {
      $this->objR->assign('SOVerror', 'innerHTML', 'Datenbank zur Zeit nicht verf&uuml;gbar.<br />'.mysqli_connect_error());
      return;
    }
	$res = $this->DBc->DB_Connection['mdm']->query("
                                             SELECT *
                                             FROM `realmdbs`;");
    $this->DBc->DB_Close('mdm');
	$this->objR->assign('SOVerror', 'innerHTML', "<pre>\n");
	$this->objR->append('SOVerror', 'innerHTML', $res->num_rows."\n");
    foreach($res as $db)
	{
	  $this->objR->append('SOVerror', 'innerHTML', print_r($db,true)."\n");
	}
	$this->objR->append('SOVerror', 'innerHTML', '</pre>');
  }
}
?>
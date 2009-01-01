<?php

error_reporting(E_ALL);

/**
 * MDMphp - mdmpage.class.php
 *
 * $Id$
 *
 * This file is part of MDMphp.
 *
 * @author prodigy
 * @since 31.12.2008
 * @version 0.1a
 */

/**
 * main page management class of MDMphp
 *
 * @access public
 * @author prodigy
 * @since 31.12.2008
 * @version 0.1a
 */
class mdmpage
{
  // --- ATTRIBUTES ---

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

  // --- OPERATIONS ---

  /**
   * Konstruktor
   *
   * @access public
   * @author prodigy
   * @since 31.12.2008
   * @version 0.1a
   */
  public function __construct()
  {
    $this->smarty        = &$GLOBALS['smty'];
    $this->DBc           = &$GLOBALS['DBc'];
    
    $this->smarty->template_dir = MDMPHP_DIR.'/data/templates/';
    $this->smarty->compile_dir  = MDMPHP_DIR.'/data/templates_c/';
    $this->smarty->cache_dir    = MDMPHP_DIR.'/data/cache/';
    $this->smarty->config_dir   = MDMPHP_DIR.'/data/config/';
    
    if(!isset($_SESSION['loggedin']))
    {
      $_SESSION['loggedin'] = false;
    }
  }

  /**
   * Destruktor
   *
   * @access public
   * @author prodigy
   * @since 31.12.2008
   * @version 0.1a
   */
  public function __destruct()
  {
    $this->DBc->DB_Close();
  }

  /**
   * Funktion für den ersten Seitenaufruf.
   *
   * @access public
   * @author prodigy
   * @since 31.12.2008
   * @version 0.1a
   */
  public function FirstLoad()
  {
    if($_SESSION['loggedin'] != true)
    {
      $this->smarty->assign('extrajs', "loadPage('main');");
      $this->smarty->assign('loginError', '');
    }
    elseif($_SESSION['loggedin'] == true)
    {
      $this->smarty->assign('extrajs', "loadPage('serveroverview');");
    }
    $this->smarty->display('layout.tpl');
  }
  
  /**
   * Template Nachladen und senden
   *
   * @access public
   * @returns xajaxResponse
   * @author prodigy
   * @since 31.12.2008
   * @version 0.1a
   */
  public function getContent($mod, &$objR=null)
  {
    if(!($objR instanceof xajaxResponse))
	{
       $objR = new xajaxResponse();
	   $doreturn = true;
	}
    if($_SESSION['loggedin'] != true && $mod != 'login')
    {
      $mod = 'main';
      $objR->assign('pMenu', 'innerHTML', $this->smarty->fetch('layout_menu.tpl'));
    }
    $_SESSION['page'] = $mod;
    if(
       is_file('libs/modules/content_'.$_SESSION['page'].'.mod.php') != true ||
       $this->smarty->template_exists('content_'.$_SESSION['page'].'.tpl') != true
      )
    {
	  $_SESSION['page'] = '404';
	}
	$_mod_preload = true;
    include('libs/modules/content_'.stripslashes(strip_tags($_SESSION['page'])).'.mod.php');
	unset($_mod_preload);
	$objR->assign('pContent', 'innerHTML', $this->smarty->fetch('content_'.$_SESSION['page'].'.tpl'));
    include('libs/modules/content_'.stripslashes(strip_tags($_SESSION['page'])).'.mod.php');
	return $objR;
  }
  
  /**
   * Login Funktionalität
   *
   * @access public
   * @author prodigy
   * @since 31.12.2008
   * @version 0.1a
   */
  public function LogIn($FormData)
  {
    $objR = new xajaxResponse();
    if(!$this->DBc->DB_Connect('realmdb'))
    {
      $this->smarty->assign('loginError', 'innerHTML', 'Datenbank zur Zeit nicht verf&uuml;gbar.<br />'.mysqli_connect_error());
      return $objR;
    }
    $res = $this->DBc->DB_Connection['realmdb']->query(
                                            "SELECT `gmlevel`
                                             FROM `account`
                                             WHERE
                                             UPPER(`username`) = UPPER('".$FormData['username']."')
                                             AND `sha_pass_hash` = SHA1(UPPER('".$FormData['username'].":".$FormData['password']."'));"
                                                 );
    $res = $res->fetch_array();
    $this->DBc->DB_Close('realmdb');
    if($res['gmlevel'] >= 3)
    {
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $FormData['username'];
      $_SESSION['page']     = 'main';
      $objR->assign('pMenu', 'innerHTML', $this->smarty->fetch('layout_menu.tpl'));
      $this->getContent('serveroverview',$objR);
      return $objR;
    }
    else
    {
      $objR->assign('loginError', 'innerHTML', 'Falsche Benutzername / Passwort Kombination.');
      return $objR;
    }
  }
  
  /**
   * Logout Funktionalität
   *
   * @access public
   * @author prodigy
   * @since 31.12.2008
   * @version 0.1a
   */
  public function LogOut()
  {
    $objR = new xajaxResponse();
    session_destroy();
    $objR->redirect('./');
    return $objR;
  }

} /* end of class mdmpage */

?>

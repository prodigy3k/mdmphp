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

/**
 * Short description of class mdmpage
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
	 * Datenbank Konfigurations Variable (by ref)
	 *
	 * @access private
	 * @var Array
	 */
	private $__conf_db = null;
	
	/**
	 * Datenbank Verbindungsvariable
	 *
	 * @access private
	 * @var array[mysqli]
	 */
	private $DB_Connection = null;

    // --- OPERATIONS ---

    /**
     * Konstruktor
     *
     * @access public
     * @author prodigy
     * @since 31.12.2008
     * @version 0.1a
     */
    public function __construct(&$dbConfig)
    {
	  $this->smarty        = new Smarty();
	  $this->__conf_db     = &$dbConfig;
	  $this->DB_Connection = array();
	  
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
	  if(is_array($this->DB_Connection))
	  {
	    foreach($this->DB_Connection as $con)
	    {
	      $con->close();
	    }
	  }
	}

    /**
     * Öffnet eine MySQL Verbindung falls nicht vorhanden
     *
     * @access private
     * @author prodigy
     * @return Boolean
     * @since 31.12.2008
     * @version 0.1a
     */
    private function DB_Connect($db='mdm')
    {
	  if($this->DB_Connection instanceof mysqli)
	  {
	    if(!$this->DB_Connection->ping)
		{
		  @$this->DB_Connection[$db] = new mysqli($this->__conf_db['server'], $this->__conf_db['user'], $this->__conf_db['pass'], 'pdyemu_'.$db);
		  if(mysqli_connect_errno())
		  {
		    return false;
		  }
		}
	  } else {
	    @$this->DB_Connection[$db] = new mysqli($this->__conf_db['server'], $this->__conf_db['user'], $this->__conf_db['pass'], 'pdyemu_'.$db);
		if(mysqli_connect_errno())
		{
		  return false;
		}
	  }
	  return true;
    }
	
	/**
	 * Schließt eine bestimmt oder Datenbank Verbindung(en)
	 *
	 * @access private
	 * @author prodigy
	 * @since 31.12.2008
	 * @version 0.1a
	 */
	 
	private function DB_Close($db=null)
	{
	  if(is_array($this->DB_Connection))
	  {
	    if($db != null)
	    {
	      if(isset($this->DB_Connection[$db]))
		  {
	        $this->DB_Connection[$db]->close();
		    unset($this->DB_Connection[$db]);
		  }
	    }
	    else
	    {
	      foreach($this->DB_Connection as $con)
	      {
	        $con->close();
	      }
	    }
	  }
	}
	
	/**
	 * Inhaltsvorbereitung
	 *
	 * @access private
	 * @author prodigy
	 * @since 31.12.2008
	 * @version 0.1a
	 */
	private function prepareContent(&$objR)
	{
	  // Nothing here yet..
	}
	
	/**
	 * eventuelle Javascripts einladen
	 *
	 * @access private
	 * @author prodigy
	 * @since 31.12.2008
	 * @version 0.1a
	 */
	private function assignScripts(&$objR)
	{
	  // Nothing here yet...
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
	  $this->prepareContent($objR);
      if($_SESSION['loggedin'] != true)
	  {
        $this->smarty->assign('extrajs', "xajax_mdmpage.getContent('main');");
        $this->smarty->assign('loginError', '');
	  }
	  elseif($_SESSION['loggedin'] == true)
	  {
	    $this->smarty->assign('extrajs', "xajax_mdmpage.getContent('itemeditor');");
	  }
	  $this->smarty->display('layout.tpl');
    }
	
	/**
	 * Template Nachladen und senden
	 *
	 * @access public
	 * @author prodigy
	 * @since 31.12.2008
	 * @version 0.1a
	 */
	public function getContent($mod)
	{
	  $objR = new xajaxResponse();
	  if($_SESSION['loggedin'] != true && $mod != 'login')
	  {
	    $mod = 'main';
		$objR->assign('pMenu', 'innerHTML', $this->smarty->fetch('layout_menu.tpl'));
	  }
	  $_SESSION['page'] = $mod;
	  $this->prepareContent($objR);
	  $objR->assign('pContent', 'innerHTML', $this->smarty->fetch('content_'.$_SESSION['page'].'.tpl'));
	  $this->assignScripts($objR);
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
	  $this->prepareContent($objR);
	  if(!$this->DB_Connect('realmdb'))
	  {
	    $this->smarty->assign('loginError', 'innerHTML', 'Datenbank zur Zeit nicht verf&uuml;gbar.<br />'.mysqli_connect_error());
		return $objR;
	  }
	  
	  $res = $this->DB_Connection['realmdb']->query("SELECT `gmlevel` FROM `account` WHERE UPPER(`username`) = UPPER('".$FormData['username']."') AND `sha_pass_hash` = SHA1(UPPER('".$FormData['username'].":".$FormData['password']."'));");
	  $res = $res->fetch_array();
	  $this->DB_Close('realmdb');
	  if($res['gmlevel'] >= 3)
	  {
	    $_SESSION['loggedin'] = true;
		$_SESSION['username'] = $FormData['username'];
		$_SESSION['page']     = 'main';
		$objR->assign('pMenu', 'innerHTML', $this->smarty->fetch('layout_menu.tpl'));
	    $objR->assign('content', 'innerHTML', $this->smarty->fetch('content_main.tpl'));
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
      $this->prepareContent($objR);
	  session_destroy();
	  $objR->redirect('./');
	  return $objR;
    }

} /* end of class mdmpage */

?>
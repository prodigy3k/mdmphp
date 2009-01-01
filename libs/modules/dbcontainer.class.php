<?php

error_reporting(E_ALL);

/**
 * MDMphp - dbcontainer.class.php
 *
 * $Id$
 *
 * This file is part of MDMphp.
 *
 * @author prodigy
 * @since 01.01.2009
 * @version 0.1a
 */

/**
 * DB Connection conatainer class
 *
 * @access public
 * @author prodigy
 * @since 01.01.2009
 * @version 0.1a
 */
class DBContainer
{
  // --- ATTRIBUTES ---
  
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
   * @access public
   * @var array[mysqli]
   */
  public $DB_Connection = null;

  // --- OPERATIONS ---
  
  /**
   * Konstruktor
   * @access public
   * @author prodigy
   * @since 01.01.2009
   * @version 0.1a
   */
  public function __construct(&$dbConfig)
  {
    $this->__conf_db     = $dbConfig;
    $this->DB_Connection = array();
  }

  /**
   * Destruktor
   *
   * @access public
   * @author prodigy
   * @since 01.01.2009
   * @version 0.1a
   */
  public function __destruct()
  {
    if(is_array($this->DB_Connection))
    {
      foreach($this->DB_Connection as $con)
      {
	    if($con->ping())
        {
          $con->close();
        }
      }
    }
  }

  /**
   * Öffnet eine MySQL Verbindung falls nicht vorhanden
   *
   * @access public
   * @author prodigy
   * @return Boolean
   * @since 31.12.2008
   * @version 0.1a
   */
  public function DB_Connect($db='mdm')
  {
    if($this->DB_Connection instanceof mysqli)
    {
      if(!$this->DB_Connection->ping())
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
   * @access public
   * @author prodigy
   * @since 31.12.2008
   * @version 0.1a
   */
  public function DB_Close($db=null)
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
		  if($con->ping())
          {
            $con->close();
          }
        }
      }
    }
  }
}

?>

<?php 
/** 
 * @desc  CodeIgniter CI_Log
 * @author CI
 * @date  2012-2-29
*/
class Logging {

	protected $_log_path;
	protected $_threshold	= 1;
	protected $_date_fmt	= 'Y-m-d H:i:s';
	protected $_enabled	= TRUE;
	protected $_levels	= array('ERROR' => '1', 'DEBUG' => '2',  'INFO' => '3', 'ALL' => '4');

	/**
	 * Constructor
	 */
	public function __construct()
	{

		//print_r($config);
		$this->_log_path = APPPATH.'logs/';


		$this->_enabled = true;
		$this->_date_fmt = 'Y-m-d H:i:s';
	}

	// --------------------------------------------------------------------

	/**
	 * Write Log File
	 *
	 * Generally this function will be called using the global log_message() function
	 *
	 * @param	string	the error level
	 * @param	string	the error message
	 * @param	bool	whether the error is a native PHP error
	 * @return	bool
	 */
	public function write_log($filename = 'error', $msg, $php_error = FALSE)
	{

		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}

	
		/*
		if ( ! isset(self::$_levels[$level]) OR (self::$_levels[$level] > self::$_threshold))
		{
			return FALSE;
		}
		*/
		
		//$filepath = self::$_log_path.'log-'.date('Y-m-d').'.php';
		$filepath = $this->_log_path.$filename.'-'.date('Y-m-d').'.php';
		$message  = '';

		if ( ! file_exists($filepath))
		{
			$message .= "<"."?php  if ( ! defined('APP_PATH')) exit('No direct script access allowed'); ?".">\n\n";
		}

		if ( ! $fp = @fopen($filepath, 'ab'))
		{
			return FALSE;
		}
		
		if(is_array($msg)){
			$msg = var_export($msg,true);
		}

		$message .= $filename.' - '.date($this->_date_fmt). ' --> '.$msg."\n";
		
		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);

		@chmod($filepath, 0666);
		return TRUE;
	}

}
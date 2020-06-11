<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Limpiar_Log extends CI_Log{

	private $logs_files_for = 30;

	function __construct(){
		log_message('debug','Log_Maintenance : class loaded');
		parent::__construct();
		$this->CI =& get_instance();
		$logs_files = $this->CI->config->item('logs_files_for');
		if(isset($logs_files))
			$this->logs_files_for = (int) (is_numeric($this->CI->config->item('logs_files_for')) ? $this->CI->config->item('logs_files_for') : 30);
		$this->delete_logs();
	}

	function delete_logs(){
		$dir = ($this->CI->config->item('log_path') != '') ? $this->CI->config->item('log_path') : APPPATH.'logs/';
		log_message('debug','Log_Maintenance : log dir: '.$dir);
		if( ! is_dir($dir) OR ! is_really_writable($dir)){ 
			return false; 
		}

		$deleted = 0;
		$kept = 0;

		$files = glob($dir . 'log*.log');
		foreach($files as $file){
			if( filemtime($file) < strtotime('-'.($this->logs_files_for - 1).' days') ) {
				unlink($file);
				$deleted++;
			} else {
				$kept++;
			}
		}

		$total = $deleted + $kept;
		if( $deleted > 0 ){
			log_message('info', $total.' log files: '.$deleted.' deleted, '.$kept.' kept.');
		}
		$a = array('total' => $total, 'deleted' => $deleted, 'kept' => $kept);
		return $a;
	}
}
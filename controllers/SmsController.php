<?php

Class SmsController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->css=array('style_long.css');
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();
	

}

public function index(){	
$dbo=PDBO;
	// DEFINE("SMS_SITE","http://192.168.1.10");
	// $sms_class=(SMS_SITE."/smssend/php_serial.class.php");
	// require_once($sms_class);	
	// exit;
	

	require_once(SITE."functions/smsFxn.php");


	$cpnum = $_GET['cpnum'];
	$msgs = $_GET['msgs'];
	// require "php_serial.class.php";
	
	
	$serial = new phpSerial;
	$serial->deviceSet("COM8");
	$serial->confBaudRate(9600);

	// Then we need to open it
	$serial->deviceOpen();

	// To write into
	$serial->sendMessage("AT+CMGF=1\n\r"); 
	// sleep(1);
	$serial->sendMessage("AT+CSCS=\"GSM\"\n\r");
	// sleep(1);
	$serial->sendMessage("AT+CMGS=\"".$cpnum."\"\n\r");
	// sleep(1);
	$serial->sendMessage($msgs."\n\r");
	// sleep(1);
	$serial->sendMessage(chr(26));

	//wait for modem to send message
	 sleep(3);
	$read=$serial->readPort();
	$serial->deviceClose();
	echo "Message sent.";

	
	// $this->view->render($data,'abc/defaultAbc');
	
	
	
	
}	/* fxn */

public function one(){}




}	/* BlankController */

<?php

Class ExcelController extends Controller{	

public function __construct(){
	parent::__construct();		
	$this->beforeFilter();

	
}

public function beforeFilter(){
	$this->view->js = array('js/jquery.js','js/vegas.js');
	parent::beforeFilter();			
}


public function index(){ 
	$data=NULL;
	$this->view->render($data,'excel/index');

}	/* fxn */


public function import(){
	require_once 'phpexcel/IOFactory.php';
    if(isset($_POST['upload_excel'])){
        $file_info = $_FILES["result_file"]["name"];
        $file_directory = "uploads/excel_mail/";
        $new_file_name = date("dmY").".". $file_info["extension"];
        move_uploaded_file($_FILES["result_file"]["tmp_name"], $file_directory . $new_file_name);
        $file_type	= PHPExcel_IOFactory::identify($file_directory . $new_file_name);
        $objReader	= PHPExcel_IOFactory::createReader($file_type);
        $objPHPExcel = $objReader->load($file_directory . $new_file_name);
        $sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		
		pr($sheet_data);
		exit;

        // foreach ($sheet_data as $row){
            // if(!empty($row['C']))
            // {
                // $checkemail = mysqli_query($conn,'SELECT * FROM `wo_emaillist` WHERE email = "'.$row['C'].'" ');
                // if(mysqli_num_rows($checkemail) == '0')
                // {
                    // mysqli_query($conn,'INSERT INTO `wo_emaillist` (firstname,gender,email) VALUES ("'.$row['A'].'","'.$row['B'].'","'.$row['C'].'") ');
                // }
            // }

        // }	// foreach
        // $updatemsg = "File Successfully Imported!";
        // $updatemsgtype = 1;
    }	/* post */


	
$data=NULL;
$this->view->render($data,"excel/importExcel");
	
}



}	/* BlankController */

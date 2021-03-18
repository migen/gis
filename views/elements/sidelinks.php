
<?php 

// isset();
$parts = isset($_GET['url'])? rtrim($_GET['url'],'/') : '/'; 
$parts = explode('/',$parts);		
$home = ($c = array_shift($parts))? $c : 'index'; 			


?>


<div class='brown third' style='min-height:600px;'>

<?php 
	

if(!isset($_SESSION['loggedin'])){
	echo "<p><a href='".URL."students/login'>Student</a></p>";  	
} else {
	if(isset($_SESSION['user']['role_id']) && $_SESSION['user']['role_id'] == 1){
		echo "<p><a href='".URL."students/login'>Student</a></p>";  	
	}
}


	

$role = isset($_SESSION['user']['role_id'])? $_SESSION['user']['role_id'] : 0;	
switch($role){
	case 1:	// Student
		if(!isset($_SESSION['user']['child'])):
			echo "<p><a href='".URL."students'>Home</a></p>";  						
		else:	// child student loggedin
			echo "<p><a href='".URL."students/dashboard'>Student</a></p>";  						
		endif;		
		break;
		
	case 7:	// Teacher
	
		echo "<p><a href='".URL."teachers'>Home</a></p>";  	
		// echo "<p><a href='".URL."teachers/sessionizeTeacher'>Reset</a></p>";  
		break;
	
	case 9:	// Registrar
		if(($_SESSION['user']['role_id'] == 9) && (($_SESSION['user']['privilege_id'] == 0))){
			echo "<p><a href='".URL."registrars'>Home</a></p>";  		
		}		
		echo "<p><a href='".URL."teachers/levels'>Levels</a></p>";  		
		echo "<p><a href='".URL."registrars/reports'>Reports</a></p>";  		
	
		break;
	
	
	case 4:	// Admin
	
		echo "<p><a href='".URL."admins'>Admin</a></p>";  			
		// echo "<p><a href='".URL."admins/scheduler'>Scheduler</a></p>";  			
		// echo "<p><a href='".URL."admins/classrooms'>Classrooms</a></p>";  		
		// echo "<p><a href='".URL."admins/teachers'>Teachers</a></p>";  		
		echo "<p><a href='".URL."registrars/reports'>Reports</a></p>";  		
		
		break;
		
	case 5:	// MIS
		echo "<p><a href='".URL."mis'> Home </a></p>";  
		// echo "<p><a href='".URL."mis/classroomsAdvisers'>Class Advisers</a></p>";  		
		
		break;
	default:
		break;
		
	case 2:	// Finance
		echo "<p><a href='".URL."accounts'> Home </a></p>";  
		break;
	default:
		break;

	case 6:	// Hrd
		echo "<p><a href='".URL."hrds'> Home </a></p>";  
		break;
	default:
		break;
		
		
}	// switch


if(!isset($_SESSION['is_child'])):
	// 2 - For All Users
	
	if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){
		echo "<p><a href='".URL."users/logout'>Logout</a></p>";  
	} else {
		echo "<p><a href='".URL."users/login'>Login</a></p>";  
	}
		
	// 3 - for switcher	
	if(isset($_SESSION['switcher']) && (count($_SESSION['loggedin']) > 0)){
		echo "<p><a href='".URL."users/switcher'>Switcher</a></p>";  
	} 
	
	
	if(isset($_SESSION['user'])){
		echo "<p><a href='".URL."users/securePassword/".$_SESSION['user']['username']."'>Password</a></p>";  		
	}

endif; 	// not is_child


	// FOR ALL TEMP
	if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin'])){
		echo "<p><a href='".URL.$home."/reset/".$home."'>Reset</a></p>";  		
		// echo "<p><a href='".URL."index/session'>Session</a></p>";  	
	}
	
	
	
	
/*


// For Admin
		echo "<p><a href='".URL."admins'>Admin</a></p>";  
		echo "<p><a href='".URL."admins/home'>Home</a></p>";  
		echo "<p><a href='".URL."admins/courses'>Courses</a></p>";  
		echo "<p><a href='".URL."admins/schedules'>Schedules</a></p>";  
		echo "<p><a href='".URL."admins/profiles'>Profiles</a></p>";  
		echo "<p><a href='".URL."admins/classrooms'>Classrooms</a></p>";  
		echo "<p><a href='".URL."admins/classRecords'>Class Records</a></p>";  
		echo "<p><a href='".URL."admins/crIndex'>Candy Reports</a></p>";  
		echo "<p><a href='".URL."admins/criteria'>Criteria</a></p>";  
		echo "<p><a href='".URL."admins/listTeachers'>List Teachers</a></p>";  
		echo "<p><a href='".URL."admins/listStudents'>List Students</a></p>";  
		echo "<p><a href='".URL."admins/qtrLevels'>qtrs</a></p>";  
		echo "<p><a href='".URL."admins/monthsqtrs'>Months qtrs</a></p>";  
		echo "<p><a href='".URL."admins/subjects'>Subjects</a></p>";  
		echo "<p><a href='".URL."admins/months'>Months</a></p>";  
		echo "<p><a href='".URL."admins/roles'>Roles</a></p>";  
		echo "<p><a href='".URL."admins/acl".MODULE_ID."'>ACL</a></p>";  
		echo "<p><a href='".URL."admins/indexTraits'>Traits</a></p>";  
		echo "<p><a href='".URL."admins/settings'>Settings</a></p>";  




// For All
	echo "<p><a href='".URL."users/portal'>Portal</a></p>";  
	echo "<p><a href='".URL."users/switcher'>Switcher</a></p>";  
	echo "<p><a href='password.php'>Manage Password</a></p>";  
	echo "<p><a href='".URL."index/session'>Session</a></p>";  



*/	
	
	
	

?>
	
	
 	
</div>
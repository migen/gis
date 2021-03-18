<?php
session_start();							
include_once('../config/Paths.php');		
include_once('library/database.php');		


$dbo=PDBO;

switch($_POST['task']){	

	case "menToHundred":
		$q="UPDATE {$dbo}.prodtypes SET position=100 WHERE id=1; ";
		$_SESSION['q'] = $q;
		$db->query($q);	
		break;	

	case "xgetSubproducts":
		$id = $_POST['id'];
		$cond=(empty($id))? NULL:"WHERE pr.`prodtype_id` = $id";

		$q="SELECT pr.*, pr.name AS pangalan, pr.id AS prid, pt.* FROM {$dbo}.products AS pr 
			LEFT JOIN {$dbo}.prodtypes AS pt ON pt.id=pr.prodtype_id
			$cond ORDER BY pr.prodtype_id,pr.name; ";		

		$_SESSION['q'] = $q;
		$sth = $db->query($q);
		$rows = $sth->fetchAll();
		echo "<h4>Products</h4>";		
		echo $_SESSION['postype']=='traditional' ? "<div class='prod-card'>" : "<div class='row'>" ;
		foreach($rows as $row){
			include(SITE."ajax/stores/".$_SESSION['postype'].".php");
		}
		echo "</div>";
		break;	

	case "xgetAllProducts":

		$q = "SELECT id AS prid, name AS pangalan, price FROM {$dbo}.products";

		$_SESSION['q'] = $q;
		$sth = $db->query($q);
		$rows = $sth->fetchAll();		
		echo "<h4>Products</h4>";
		// echo "<p>".$_SESSION['postype']."</p>";
		echo $_SESSION['postype']=='traditional' ? "<div class='prod-card'>" : "<div class='row'>" ;
		foreach($rows as $row){
			include(SITE."ajax/stores/".$_SESSION['postype'].".php");
		}
		echo "<div>";
		break;

	case "xsearchProduct":
		$value = $_POST['value'];
		$q = "SELECT id AS prid, name AS pangalan, price FROM {$dbo}.products WHERE name LIKE '%".$value."%' ";
		$_SESSION['q'] = $q;
		$sth = $db->query($q);
		$rows = $sth->fetchAll();
		echo "<h4>Products</h4>";
		echo $_SESSION['postype']=='traditional' ? "<div class='prod-card'>" : "<div class='row'>" ;
			foreach($rows as $row){
				include(SITE."ajax/stores/".$_SESSION['postype'].".php");
			}
		echo "</div>";
		break;

	case "xaddToCart":
		$id = $_POST['id'];
		// $cond=(empty($id))? NULL:"WHERE `prodtype_id` = $id";
		$q = "SELECT * FROM {$dbo}.products WHERE id = $id";
		$_SESSION['q'] = $q;
		$sth = $db->querysoc($q);
		$row = $sth->fetch();
		echo json_encode($row);
		break;

	case "xproductIdByBarcode":
		$value = $_POST['value'];
		$q = "SELECT id FROM ${dbo}.products WHERE item_code = '".$value."' ";
		$_SESSION['q'] = $q;
		$sth = $db->querysoc($q);
		$row = $sth->fetch();
		echo json_encode($row);
		break;

	case "xgetPTdraggable":
		$q="SELECT * FROM {$dbo}.prodtypes WHERE is_display = 1 ORDER BY position";
		$_SESSION['q'] = $q;
		$sth = $db->querysoc($q);
		$rows = $sth->fetchAll();
		echo '
			<style>
				.sort-btn{display: grid;grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));}
				
			</style>
			<div class="sort-btn" id="list" ondragover="allowDrop(event)" ondrop="displayProdtype(event)">
				<div style="margin-right: 20px; padding:0px;" class="row">
					<button class="btn btn-pos btn-block btn-primary mb-2" disabled>
					 	<span>&nbsp;All Products</span>
					</button>
				</div>
			';
		foreach($rows as $row){
				include(SITE."ajax/stores/ptDraggable.php");
		}
		echo '</div><hr>';
		echo '<div id="deletedPt" ondrop="hideProdtype(event)" ondragover="allowDrop(event)"></div><hr />';
		break;

	case "xupdatePosition":
		$id = $_POST['id'];
		$pos = $_POST['pos'];
		$q = "UPDATE ${dbo}.prodtypes SET position = ".$pos;
		$q .= " WHERE id = ".$id;
		$_SESSION['q'] = $q;
		$sth = $db->querysoc($q);
		// echo $q;
		// echo ": Success!";
		break;

	case "xhidePt":
		$id = $_POST['id'];
		$q = "UPDATE ${dbo}.prodtypes SET is_display = 0 WHERE id = ".$id;
		$_SESSION['q'] = $q;
		$sth = $db->querysoc($q);
		echo "success";
		break;

	case "xshowPt";
		$id = $_POST['id'];
		$q = "UPDATE ${dbo}.prodtypes SET is_display = 1 WHERE id = ".$id;
		$_SESSION['q'] = $q;
		$sth = $db->querysoc($q);
		echo "success";
		break;


	case "getDeletedProdtypes":
		$q = "SELECT * FROM ${dbo}.prodtypes WHERE is_display = 0";
		$_SESSION['q'] = $q;
		$sth = $db->querysoc($q);
		$rows = $sth->fetchAll();
		echo '<style>.sort-btn{display: grid;grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));}</style>
			  <div class="sort-btn" id="list">';
		foreach($rows as $row){
			echo '
				<div style="margin-right: 20px; padding:0px;" class="row" id="div'.$row["id"].'">
				<button class="btn btn-pos btn-block btn-danger mb-2" draggable="true" ondragstart="drag(event)" id="'.$row["id"].'"><span>&nbsp;'.$row["position"].'</span> &nbsp;'.$row["name"].'</button></div>';
		}
		echo '</div>';
	
	
default:
	break;

	
		
	

}	/* switch */




	

	

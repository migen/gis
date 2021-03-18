<link type="text/css" rel="stylesheet" href="<?php echo URL.'public/css/transcript.css'; ?>"   />

<?php 

	$dbo=PDBO;
	$dbcontacts="{$dbo}.00_contacts";
	$pagebreak="<p class='pagebreak' >pagebreak</p>";
	
?>

<h3 class="screen" >
	Transcript | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'students/datasheet/'.$scid; ?>" >Datasheet</a>


</h3>


<p class="screen" ><table id="tbl-1" class="gis-table-bordered screen" >
	<tr>
		<th>ID</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,30);return false;' />		
	</td></tr>
	
</table></p>

<div class="screen" id="names" >names</div>



<?php if($scid): ?>
<div class="wrapper_transcript" >
<?php 
	extract($data);
	// pr($profile);

	// include_once('incs/transcript');


	if($num_int>0){ 
		include('incs/transcript_studinfo_int.php');
		$doPagebreak=false;
		$num=0;
		for($i=0;$i<$ensumm_count;$i++){
			if($ensumm[$i]['group']=='int'){
				$arrgrades=$grades[$i];
				include('incs/transcript_grades_int.php');
				echo "<br />";
				$doPagebreak=($num%2)? true:false;
				echo ($doPagebreak)? $pagebreak:null;				
				$num++;							
			}	
		} 							
	} /* int */


	if($num_jhs>0){ 
		include('incs/transcript_studinfo_jhs.php');
		$doPagebreak=false;
		$num=0;		
		for($i=0;$i<$ensumm_count;$i++){
			if($ensumm[$i]['group']=='jhs'){
				$arrgrades=$grades[$i];
				include('incs/transcript_grades_jhs.php');
				echo "<br />";
				$doPagebreak=($num%2)? true:false;
				echo ($doPagebreak)? $pagebreak:null;				
				$num++;											
			}			
		} 			
	} /* jhs */


	if($num_shs>0){ 
		include('incs/transcript_studinfo_shs.php');
		for($i=0;$i<$ensumm_count;$i++){
			if($ensumm[$i]['group']=='shs'){
				$arrgradesSem1=$grades[$i]['sem1'];
				$arrgradesSem2=$grades[$i]['sem2'];
				include('incs/transcript_grades_shs.php');
				echo "<br />";
			}			
		} 			
	} /* jhs */

	
	
?>



</div>	<!-- wrapper_transcript -->
<?php endif; ?>	<!-- scid -->



<script>
var gurl = "http://<?php echo GURL; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/transcripts/scid/"+id;
	window.location=url;
}









</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>



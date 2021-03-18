<style>

.box{ float:left;border:1px solid black;height:100px;width:100px;border-radius:6px;text-align:center;margin-left:10px;} 

</style>

<h5>
	Test Stores | <?php $this->shovel('homelinks'); ?>
	
	
</h5>


<?php 

// $_SESSION['q']=111;
// pr($_SESSION['q']);

// pr($data);

?>

<?php for($i=0;$i<$count;$i++): ?>
	<?php $id=$rows[$i]['id']; ?>
	<div class="box" onclick="getSubproducts(<?php echo $id; ?>);" >
		<?php echo '#'.$rows[$i]['id'].'<br />'.$rows[$i]['name']; ?></div>
<?php endfor; ?>	


<div class="clear" id="subproducts" >subproducts</div>

<script>

var gurl="http://<?php echo GURL; ?>";

$(function(){

	
})


function getSubproducts(id){
	var vurl = gurl+'/ajax/xmerchandise.php';	
	var task = "xgetSubproducts";
	$.ajax({
		url: vurl,type:"POST",
		data: 'task='+task+'&id='+id,
		success: function(s) {  
			// var cs=s.length;
			// console.log(s);
			$('#subproducts').html(s);
			
			
			// var content="<h5>Subproducts</h5>";
			// for(var i=0;i<cs;i++){
				// content+="<div class='box' >"+s[i].name+"</div>";
				
			// }
			// $('#subproducts').html(content).show();content="";


		}		 
    });				

	
}	/* fxn */



function getSubproductsxxx(id){
	var vurl = gurl+'/ajax/xmerchandise.php';	
	var task = "xgetMerchandise";
	$.ajax({
		url: vurl,dataType:"json",type:"POST",async:true,
		data: 'task='+task+'&id='+id,
		success: function(s) {  
			var cs=s.length;
			content="";			
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content+='<p><span id="'+s[i].id+'" class="box" onclick="addToCart(this.id);return false;" >'+'#'+s[i].id+' '+s[i].name+'<br />'+s[i].price+'</span></p>';
}
			$("#subproducts").html(content).show();content="";

		}		 
    });				

	
}	/* fxn */




</script>

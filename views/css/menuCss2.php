
<style>

.page {
  width: 550px; /* 450px; */
  height: 400px;
  border: 1px solid;
}
.column {
  width: 100%;
  height: 500px; /* 100%; */
  background-color: #E0FFF4;
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
}
.content {
  /* width: calc(50% - 30px); */
  width: calc(50% - 30px); 
  min-height: 60px;
  margin: 15px;
  background-color: #CEBFFF;
}

</style>

<?php 

function genChars($num=200,$char="x"){
	$content="";
	for($i=0;$i<$num;$i++){
		$content.=$char;	
		$content.=($i%7)? " ":NULL;
	}
	return $content;
	
}

?>


<div class="page">
  <div class="column">
    <div class="content">1. some text</div>
    <div class="content">2. some longer text, some longer text, some longer text, some longer text, some longer text, some longer text, some longer text, some longer text, some longer text,</div>
    <div class="content">3. some text</div>
    <div class="content">4. some text</div>
    <div class="content">5. some longer text, some longer text, some longer text, some longer text,some longer text,some longer text,some longer textsome longer text,some longer text,some longer text,some longer text,some longer text,some longer text</div>
	<div class="content" >6. dfdsf dflksdlfk dflksdfl lkflsdkf lfksdlkflsdkf fdslkfsdlkfksdf </div>
	<div class="content" ><?php $content=genChars(20); echo "7".$content; ?></div>
	<div class="content" ><?php $content=genChars(40); echo "8".$content; ?></div>
	
  </div>
</div>

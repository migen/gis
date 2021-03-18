<!-- onblur='$(this).removeSuggestedTxns();return false;'-->

<script>
// function suggestTxns(value){
$.fn.suggestTxnsOk = function(value){
    if(value != ""){
		var url = gurl+'txns/jasmin';
        $.post(url,{part:value},function(data){
            $("#jasmin").html(data);
			$('td.ezfound').click(function(){
				$('#eztext').val($(this).html());
				$(this).removeSuggestedTxns();
			});
        });
    } else {
        removeSuggestedTxns2();
    }
};


$.fn.removeSuggestedTxnsOk = function(value){
    $("#jasmin").html("");
};

function addTextTemp(value,place){
    $(""+place+"").val(value);
    removeSuggest();
};

</script>

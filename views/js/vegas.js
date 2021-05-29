function randomize(aim){ for(var i=0;i<count;i++){ var x=getRandomInt(min,max);document.getElementById(aim+i).value=x; }	}	/* fxn */
function getRandomInt(min,max) { return Math.floor(Math.random()*(max-min+1))+min; }
function rc(cls){ var x;$('.'+cls).each(function(){ x = this.rowIndex;$(this).find("td:first").text(x); }); }
function selectFocused(){ $("input:text").focus(function() { $(this).select(); } );	}
function clearAll(cls){ $('.'+cls).val(""); }
function nolimits(){ $('#page').val(1);$('#limits').val(0); }	
function zeroOut(id){ $('#'+id).val(0); }	
function numberWithCommas(x) { return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }
function accorToggle(sxn){ $("#"+sxn).toggle(); }	
function populateColumn(cls){ var inVal = $("#i"+cls).val(); $("."+cls).val(inVal); };
function focusIdNext(jid){ $('#'+jid).focus(); }
function jcal(x){ $(x).datepicker({ dateFormat:"yy-mm-dd" }); }	
function hd(){ $('.hd').hide(); }
function hides(){ $('.hide').hide(); }
function summary(){ $('#hdbtn').hide();$('.hd').toggle(); }
function tracehd(){ $('.hd').toggle(); }
function traceshd(){ $('.shd').toggle(); }
function juice(){ $(".juice").datepicker({ dateFormat:"yy-mm-dd" }); }
function itago(cls){ $('.'+cls).hide(); }
function ilabas(cls){ $('.'+cls).toggle(); }
function deltrow(i){ $('#trow'+i).remove(); }	
function tracepass(){ $('#hdpdiv').toggle();$("#uhdp").focus();	}
function shd(){	$('.shd').hide(); }
function peek(){ $('.peek').toggle(); }
function clearBoxes(){ $('input:checkbox').removeAttr('checked'); }
function checkBoxes(){ $('input:checkbox').attr('checked',true); }
function peekaboo(div){	$('#'+div).toggle(); }
function pclass(pclass){ $('.'+pclass).toggle(); }
function removeSuggestions(){ $("#jasmin").html(""); };
function resize(elem,size){ $(elem).attr('size',size); };
function PrintElem(elem){ Popup($(elem).html()); }
function accordionTable(cls){ $("."+cls+" td").toggle(); }
function itoggle(id){ $('#'+id).toggle(); }

function chkAllvar(x){
	$('#chkAll'+x).click(function(event) {
		if(this.checked) {
			$('.chk'+x).each(function() { this.checked = true; });			
		} else {
			$('.chk'+x).each(function() { this.checked = false; });
		}
	});
	

}	/* fxn */

function excel(){
	$("#btnExport").click(function () {	
		$("#tblExport").btechco_excelexport({ containerid: "tblExport",datatype: $datatype.Table});
	});
}	/* fxn */

function tabEnter(cls) {
    $('.'+cls+':first').focus();	
    $('.'+cls).bind("keydown",function(e) {
        var n = $("."+cls).length;
        if (e.which == 13) {
            e.preventDefault();
            var nextIndex = $('.'+cls).index(this) + 1;
            if (nextIndex < n)
                $('.'+cls)[nextIndex].focus();
            else {
                $('.'+cls)[nextIndex - 1].blur();
                $('input:submit').click();
            }
        }
    });
    return false;
}

function xdelrow(dbtbl,id,i){
	var vurl=gurl+'/ajax/ajax.php';	
	var task="xdelrow";	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',data: 'task='+task+'&dbtbl='+dbtbl+'&id='+id,				
		async: true,
		success: function(s) { $('#trow-'+i).remove(); }		  
    });				
}

function smartPaste(srcbox){
	var aim = $('#classbox').val();
	var str = $("#"+srcbox).val();
    var res = str.split("\n");
	for(var i in res){
		var tmp = res[i];
		document.getElementById(aim+i).value = tmp;
	}		
}	/* fxn */

function pasteFromExcel(srcbox,aim){
	var str = $("#"+srcbox).val();
    var res = str.split("\n");
	for(var i in res){
		var tmp = res[i];
		document.getElementById(aim+i).value = tmp;
	}		
}

function jsredirect(str){
	var url = gurl+'/'+str;
	window.location = url;			
}

function looper(str){	
	var sr = str.split(',');
	var url = gurl+'/';
	for(var i = 0; i < sr.length; i++) {
	   sr[i] = sr[i].replace(/^\s*/, "").replace(/\s*$/, "");
	   url += sr[i] +'/';
	}
	window.location = url;		
}

function traceAuth(){
	var ctp = $('#uhdp').val();
	$('#uhdp').val('');
	$('#hdpdiv').hide();			
	var hp = CryptoJS.MD5(ctp);
	if(hdpass==hp){ $('.hd').show(); } 	
}	

function getKey(keyStroke) {
	isNetscape=(document.layers);
	eventChooser = (isNetscape) ? keyStroke.which : event.keyCode;
	which = String.fromCharCode(eventChooser).toLowerCase();
	for (var i in key) if (which == i) 
		$(key[i]).focus();
}

function accordion(){
	$(".accordion tbody:not(:first)").hide();	
	$('.accordion th').click(
		function() {
			$('table.accordion').children('tbody').slideUp();						
			$(this).parents('table.accordion').children('tbody').toggle();			
		}
	)		
}

function nextViaEnter() {
    $('input:text:first').focus();	
    $('input:text').bind("keydown",function(e) {
        var n = $("input:text").length;
        if (e.which == 13) {
            e.preventDefault();
            var nextIndex = $('input:text').index(this) + 1;
            if (nextIndex < n)
                $('input:text')[nextIndex].focus();
            else {
                $('input:text')[nextIndex - 1].blur(); $('input:submit').click();
            }
        }
    });
    return false;
}

function doubleConfirm(){
	if (confirm('DANGEROUS!!! Are you sure?'))
		if (confirm('Final Warning! Are you 100% sure?'))
			document.forms[0].submit();
	return false;
}


 	
function xgetidByCode(dbx,tbl,code){
	var vurl = gurl+'/ajax/xgetidByCode.php';		
	$.ajax({
	  type: 'POST',url: vurl,dataType: "json",data: "dbx="+dbx+"&tbl="+tbl+"&code="+code,
	  success:function(s){ $("#display").html(s.id); } 
	});					
}	

function redirectClassroom(axn,crid){ sy=$('#sy').val();var rurl=gurl+'/'+home+'/'+axn+'/'+crid+'/'+sy;window.location = rurl;	}

function columnHighlighting(){    
	var t;
    $('.colshading').hover(
		function() { t = parseInt($(this).index())+1;	$('td:nth-child(' + t + ')').addClass('colshadingbg'); },
		function() { $('td:nth-child(' + t + ')').removeClass('colshadingbg'); }
	);	
}	/* fxn */


function aderty(){ alert('haha- yyy'); }

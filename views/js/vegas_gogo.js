function rc(cls){ var x;$('.'+cls).each(function(){ x = this.rowIndex;$(this).find("td:first").text(x); }); }
function selectFocused(){ $("input:text").focus(function() { $(this).select(); } );	}
function populateColumn(cls){ var inVal = $("#i"+cls).val(); $("."+cls).val(inVal); };
function shd(){	$('.shd').hide(); }function hd(){ $('.hd').hide(); }
function tracehd(){ $('.hd').toggle(); }function traceshd(){ $('.shd').toggle(); }
function tracepass(){ $('#hdpdiv').toggle();$("#uhdp").focus();	}
function pclass(pclass){ $('.'+pclass).toggle(); }
function resize(elem,size){ $(elem).attr('size',size); };
function accordionTable(cls){ $("."+cls+" td").toggle(); }








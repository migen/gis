<h5>Summary</h5>

<table class="gis-table-bordered " >

<tr><th class="vc100" >OR First</th><td class="vc100 right" ><?php echo $or_first; ?></td></tr>
<tr><th>OR Last</th><td class="right" ><?php echo $or_last; ?></td></tr>
<tr><th>(A) Cash</th><td class="right" ><?php echo number_format($cash_total,2); ?></td></tr>
<tr><th>(B) Checks</th><td class="right" ><?php echo number_format($check,2); ?></td></tr>
<tr><th>(C) Deposits</th><td class="right" ><?php echo number_format($deposit,2); ?></td></tr>
<tr><th>Total</th><td class="right" ><?php echo number_format($total_sales,2); ?></td></tr>


</table>

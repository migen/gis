<h3><span style="font-size: 1.17em;">SNIPPETS</span></h3>
<p>1. xdelrow(dbtable,id,i)</p>
<p>2. update join</p>
<p>3.&nbsp;onclick="confirmXdelrow('<!--?php echo $dbtable; ?-->',<!--?php echo $id.','.$i; ?-->);" - prerequisites/edit</p>
<p>4.&nbsp;$('html').live('click',function(){ $('#names').hide(); });</p>
<p>5. $q2="SELECT id,book_id AS book, GROUP_CONCAT(DISTINCT author_id ORDER BY author_id) AS authors<br /> FROM {$dbo}.00_books_authors GROUP BY book_id ORDER BY book_id; ";</p>
<p>&nbsp;6. $q="UPDATE {$dbg}.05_classrooms AS cr</p>
<p>INNER JOIN {$dbg}.05_levels AS l ON cr.level_id=l.id<br /> INNER JOIN {$dbo}.`05_sections` AS s ON cr.section_id=s.id<br /> SET cr.name=CONCAT(l.`code`,'-',s.`name`),cr.label=s.`name`;";</p>
<p>&nbsp;7.&nbsp;</p>
<p>$q="UPDATE {$dbg}.05_course_moderators SET `mcid`=:mcid WHERE course_id=:club_id LIMIT 1; ";<br /> $sth = $db-&gt;prepare($q); <br /> $sth-&gt;bindValue(":mcid",$mcid);<br /> $sth-&gt;bindValue(":club_id",$club_id);<br /> $sth-&gt;execute();</p>
<p>8. jsname</p>
<p>var sy = $('input[name="students['+i+'][sy]"]').val();</p>
<p>var crid = $('select[name="students['+i+'][crid]"]').val();</p>
<p>&nbsp;</p>
<p>9. duplicates</p>
<p>1) duplicates query<br /> select id, scid<br /> from dbgis_mcs.05_summaries<br /> group by scid<br /> having count(scid) &gt; 1</p>
<p>10. update join</p>
<p>update 2016_dbmaster_abc.03_tuitions AS a<br />INNER JOIN (<br /> select * FROM 2016_dbmaster_abc.levels<br />) AS b ON b.id = a.level_id<br />SET a.label = b.name</p>
<p>-------</p>
<p>update {$dbo}.`00_contacts` AS a<br /> INNER JOIN (<br /> select s.contact_id,c.name<br /> from {$dbo}.`00_contacts` AS c<br /> inner join {$dbg}.05_students AS s ON s.contact_id = c.id<br /> inner join {$dbg}.05_classrooms AS cr ON s.crid = cr.id<br /> WHERE cr.section_id = '$tmpsxn_id'<br /> ) AS b ON b.contact_id = a.id<br /> SET a.year = '2014',a.is_active='0';</p>
<p>11. insert select - for action logs - college, i.e. lock course (lc), open course (oc)</p>
<p>$ucid=333;$key=555;$ip="some IP";<br /> $q="INSERT INTO {$dbg}.10_logs(`action_id`,`ucid`,`key_id`,`ip`)<br /> SELECT id AS action_id,$ucid,$key,'$ip' FROM {$dbg}.01_actions WHERE code='uc';";</p>
<p>&nbsp;12.&nbsp;$vc=210;require_once(SITE.'library/Css.php'); // em, color</p>
<p>&nbsp;13. mysql if condition</p>
<p><span class="sqlkeywordcolor">SELECT</span><span>&nbsp;</span><span class="sqlkeywordcolor">IF</span><span>(</span><span class="sqlnumbercolor">500</span><span>&lt;</span><span class="sqlnumbercolor">1000</span><span>,&nbsp;</span><span class="sqlstringcolor">"YES"</span><span>,&nbsp;</span><span class="sqlstringcolor">"NO"</span><span>);</span></p>
<p>&nbsp;14. css/center</p>
<p>.outer{ width:100%; background:#fff; } .inner{ background:yellow; margin:0 auto; }</p>
<p>&nbsp;15. html structure</p>
<p>16. table td - $('.table-text-gitna td').addClass('text-center');<br /><br /></p>
<p>&nbsp;17. links scripts</p>
<p>&lt;link type='text/css' rel='stylesheet' href="&lt;?php echo URL; ?&gt;public/css/style.css" /&gt;<br /> &lt;script type="text/javascript" src='&lt;?php echo URL."views/js/lookups.js"; ?&gt;' &gt;&lt;/script&gt;</p>
<p>
<script type="text/javascript" src="'&lt;?php">// <![CDATA[
' >
// ]]></script>
</p>
<p><br />
<script type="text/javascript"></script>
<br /> 18.&nbsp;<br />
<script type="text/javascript" src="http://127.0.0.1\gis\views/js/jquery.js"></script>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
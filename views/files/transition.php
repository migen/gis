<p>&nbsp;</p>
<h2>&nbsp;</h2>
<h2>TRANSITION with AXIS (New SY)</h2>
<ol>
<li>Copy `next_payments` to .`30_payments` then truncate `next_payments`</li>
<li>syncs/oldbalance/oldsy/newsy - create aux oldbalance if students have outstanding balance</li>
<li></li>
</ol>
<p>&nbsp;</p>
<h2>TRANSITION to NEW SY</h2>
<ol>
<li>Create NSY-dbg - trunc dbg-tables&nbsp;</li>
<li>a) Paths.DBYR &nbsp;b) settings - sq,qtr</li>
<li>Scripts/proma (promote all to nxtLvlTmp)</li>
<li>Syncs -</li>
<li>a) promotions b) openCrs, c) openCls</li>
<li>b) enrollments, 1) syncs/currlvl, 2) syncs/syncEnrollments, 3)&nbsp;syncs/promlvl&amp;exe2 4) syncs/arToEnrollments</li>
<li>Backup - VCFOLDER/SY_SQL</li>
<li>Cronjob - gisbox</li>
<li>Grading</li>
<li>- trunc: grades, activities, scores, attendance,&nbsp;&nbsp;</li>
<li>- *syncs/syncEnrollments*</li>
<li>- sync / open crs and classrooms Q1</li>
<li>- loop syncer, matrix@sync</li>
<li>-&nbsp;</li>
<li></li>
<li></li>
<li></li>
</ol>
<p>&nbsp;</p>
<hr />
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Hi Sir/Maam:</p>
<p><span style="text-decoration: underline;"><strong>TRANSITION</strong></span> means closing one school year and setting up master data for next school year. The following steps are transition processes in order:</p>
<p>1) Finalize class records (grades, attendance, summarize genave) for printing and <span style="text-decoration: underline;">distribution of report cards</span>.</p>
<p>2) <span style="text-decoration: underline;">Promotion </span><span style="text-decoration: underline;">by class adviser</span>. (Link at adviser's home page - Manage advisory class)</p>
<p>3) * Inform PCMed to <span style="text-decoration: underline;"><strong>setup&nbsp;</strong><strong>transition databases</strong></span> and <span style="text-decoration: underline;"><strong>configure settings</strong></span> for next school year (allow at least 2 weeks notice).&nbsp;</p>
<p>4) a)&nbsp;<span style="text-decoration: underline;">Registration new students</span> and b)&nbsp;<span style="text-decoration: underline;">Sectioning students</span> to their respective sections (by classroom or level).</p>
<p>5) All master data and settings are carried over from previous SY, provide PCMed hardcopy of adjustments in advance for modification in the following master data and settings (2 weeks at least)</p>
<p>&nbsp; &nbsp;a) Teachers' advisory class assignemtns (i.e. Mary Santos from G01-Matthew to G02-Luke)&nbsp;</p>
<p>&nbsp; &nbsp;b) Class subjects (G01 now introduced computer subject while none in the previous year)&nbsp;</p>
<p>&nbsp; &nbsp;c) Level components - i.e. Grade 1-English (Works 35%, Performance 40%, Assessment 25%)</p>
<p>&nbsp; &nbsp;d) Teacher-Course assignment - i.e. Pedro Cruz handling Math of G01 to G03 last year, this year assigned to handle Science of G04 - G06</p>
<p>&nbsp; &nbsp;e) Newly hired teachers and employees list&nbsp;</p>
<p>&nbsp;</p>
<p><strong>*</strong> <strong>IMPT</strong> - In order to know the system has been transitioned to next SY - 1) the SY after Make IT Smarter at the page banner should reflect <span style="text-decoration: underline;"><strong>2016</strong></span> and 2) the SY-Qtr underneath at the menu bar should reflect <strong>2016-Q1</strong>.&nbsp;</p>
<p>&nbsp;The <span style="text-decoration: underline;">TRANSITION</span> readme file can be found at this URL -&nbsp;<span style="text-decoration: underline;">gis/files/read/transition</span></p>
<p>&nbsp;</p>
<p>Best regards,</p>
<p>Information Systems Officer - PCMed&nbsp;</p>
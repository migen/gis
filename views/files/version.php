<p><strong style="font-size: 1.17em;">GIS VERSION Controller</strong>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>GISv5 - 20210301</strong></p>
<ol>
<li></li>
<li>genave (default by process), genaveByAverage (i.e. q7 = (q5 + q6) / 2); mathFxn - getAverage func_get_args (dynamic argument list/ parameters)</li>
<li>v539 - 20200219 - audit trails dbo.logs - textlog() as logfxn3</li>
<li>v538 - previous accounts / old accounts / prevaccts</li>
<li>ledger &amp; assesment - payables add columns - paid, and balance</li>
<li>OR - payer_is_student, if not, then no classroom and studno</li>
<li>settings.sy_payments - for student account - assessment and paymodes</li>
<li>payments report - default is all SY</li>
<li>accounting enrollment ledger steps / guideline / documentation / help &gt; transition next sy</li>
<li>&gt; 1) settings.sy_enrollment, 2) nextsy_dbgis, 3) proma/sy/dbyr, 4) gset &gt; setup nextSY - seeders a) tuitions, b) paydates, 5) ledger switch SY</li>
<li>v537 - schema/dropRecordsBySy</li>
<li>v537 - seeders/tuitions</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv5 - 20201023</strong></p>
<ol>
<li>v535 - batch/update, batch/setfield</li>
<li>subjtypes, subjects.subjtype_id - v533</li>
<li>rcard_viewing access control - students - enrollment 1) is_employee_child, 2) no_previous_balance, 3) no_minimum_balance - v532</li>
<li>matrix/view - scoresLink</li>
<li>classrooms/add - v532</li>
<li>rankings - sir/level and sir/classroom - v531</li>
<li>SirController to SirsController - sales, product, productEnum, byProduct, reports - v530</li>
<li>rankings - filter @gis/ranks v530</li>
<li>cleaned up config - bootstrap, acl, constants</li>
<li>config/Path. - define IS_LOCAL</li>
<li>conducts/records - links to student edit grades, conduct, genave summarizer, attendance</li>
<li>hdpdiv - requires crypto.js, passdiv</li>
<li>rosters/drafter</li>
<li>payables/filter</li>
<li>rosters/rollback</li>
</ol>
<p><strong>GISv5 - 20200930</strong></p>
<ol>
<li>20200929 - schema: 1) summext.skip_q1 to q4 (conducts/process), 2) advQtrs.conduct_q1 to q4 (conducts/process editing)</li>
<li>20200923 - payments.payer for bills and ledger, and edit payment</li>
</ol>
<p>&nbsp;</p>
<p>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</p>
<p><strong>GISV5 - 20200601</strong></p>
<ol>
<li>20200919 - conducts process access previous school year</li>
<li>20200918 - add notes to payments in ledger</li>
<li>20200918 - add credentials to classlist</li>
<li>20200916 - constant outsiders - constant ucid#11</li>
<li>20200827 - c.is_active removed from student list, summaries-based classlist</li>
</ol>
<p><strong>GISV5 - 20200601</strong></p>
<ol>
<li></li>
<li>20200808 - ucFirstLetter, ucfstr students/register, i.e. Michael Angelo</li>
<li>20200801 - LER (level enrollment report) - settings.balance_cutoff</li>
<li>20200801 - EPR (enrollment payment report) - consolidated all crnum, all tracks, update sync loop through all crnums</li>
<li>20200802 - PBL (previous balance by level) , prevbal/level</li>
<li></li>
</ol>
<p><strong>GISV5 - 20200601</strong></p>
<ol>
<li>20200626 - newlog / dbo.logbooks, enrollment report, purge/logbooks/$year</li>
<li>20200624 - data/nocrid-shs- G12 promote to C01, is_active=0, move to college, tuitions set coll tmp.</li>
<li>20200623 - interest, enrollmentFxn_sjam, getAssessment, ledger, fixed computations</li>
<li>20200619 - balances, payables/add, siblings, assessment with payables, orno/duplicate,&nbsp;</li>
<li>20200617 - payments/setup, payables/setup, payables/batch, payments/report, payables,report, students/tuitions/lvl</li>
<li>20200615 - shared ajax by php/ajax form and js. ledger orno. proma/sy,&nbsp;</li>
<li>20200615 - OR series</li>
<li>20200614 - enrollees/official, enrolled students paid over P3,500</li>
<li>20200614 - students/leveler, students/register, payments/weekly, payments/daily, students/payables, students/payments</li>
<li>20200613 - students/assessment, tuitions, previous_balance (old_accounts) @assessment</li>
<li>20200611 - new ajax axjs.js, ajax/axdata.php @students/encrid&nbsp;&nbsp;</li>
<li>20200611 - enterKeyup, keydown, keyup - enrollment/ledger</li>
<li>20200610 - custom variable variable function - enrollment/ledger doubleAmount</li>
<li>20200610 - pdf - booklists/index,&nbsp;</li>
<li>20200610 - v517 finance search, all axis tables / enrollment tables / finance tables migrated from dbg to dbo&nbsp;&nbsp;</li>
<li>20200609 - filter references / ajax references / xsave xedit xput - *enrollment/ledger, students/encrid, products, rfid/one,&nbsp;</li>
<li>20200609 - payments/add, payables/add, payables/edit</li>
<li>20200609 - replace shovel include_once to include - can include view elements multiple times&nbsp;</li>
<li>20200609 - ajax tuitions/level/lvl/sy - edit &amp; add.&nbsp;</li>
<li>20200609 - tuitions/edit/lvl/sy, tuitions/level/lvl/sy.&nbsp;</li>
<li>20200608 - num vs ptr - level-num is for tracks/ majors, while ptr / feetype stack is for same feetype_id with different pointers - for composites&nbsp;</li>
<li>20200608 - tally ptr - payables</li>
<li>20200608 - syncs/axis, syncs/payables,&nbsp;</li>
<li>20200608 - students/encrids, tests/levelCrid,&nbsp;</li>
<li>20200608 - new enrollment schema -&nbsp;feetypes, classfees, payplans, paymodes, tfeedetails, payables,&nbsp;&nbsp;</li>
<li>20200608 - enrollment - axis, finance, students, enrollment, sectioner, tuitions, payables, payments, studlinks,&nbsp;</li>
<li>20200605 - string functions and array functions compact, extract, utils/compext</li>
<li>20200603 - duplicates/students, syncgrades/scid, syncgrades/scids</li>
<li>20200603 - accounts receivables - arToEnrollments, arCrid</li>
<li>20200602 -&nbsp;</li>
<li>iframe wrapper</li>
<li>20200601 - functions logs.php-&gt;ezlog, edit ensumm remarks and logs</li>
<li>data/duplicates - php link, php href&nbsp;</li>
<li>20200531 - data/duplicates</li>
<li>20200530 - student reps / representatives per class or level.</li>
<li>20200529 - library/Functions.php - ps($sth), print sth result from dbquery, functions/logsFxn.php</li>
<li>20200529 - model cview - students/index - homeStudent.php</li>
<li>20200529 - blank grades for rcard / sjam matrix steps: 1) studlinks 2) grades 3) edit 4) put -1 / negative value for q4 and q5 if to be blank</li>
<li>v516 - portal, enrollment</li>
<li>20200528 - QueryController - bdayPass</li>
<li>20200228 - dbg.sch_ar_yyyy - students/ensumm, finance/rar/yyyy, synces/arToEnrollments</li>
<li>20200528 - students/add - studinfo - idno, fullname, bday&nbsp;</li>
<li>20200528 - dual / 2 years, prevsy - cirr, cir, lir - settings - is_dual</li>
<li>20200528 - data/students - complete students list</li>
<li>syncs/promlvl - promoted to next level on rcards, summ.currlvl, syncs/currlvl/$sy, goldenkey &amp;gk</li>
<li>20200527 - ranksWithHonors - sumx.honor_dg1-6, cview-students/datasheet</li>
<li>20200526 - contacts.cctp, rcards/crid, rcards/scid</li>
<li>20200524 - students/editEnrollment/scid - (balance By Admin) modified_by, modified_date</li>
<li>20200523 - syncs/levelConductsToSummaries, syncs/syncEnrollments - syncSummcridToEnrollments&nbsp;&nbsp;</li>
<li>20200522 - passwords, students, portals, filter, enrollment, assessment, ledger,&nbsp;</li>
<li>mcr/view, mcr/sem - 20200521 - grid</li>
<li>eys / encryption - 20200520 -&nbsp;</li>
<li>portals - parents/students - def pass: bday</li>
<li>sectioning/grp - group sectioning - alpha&nbsp;&nbsp;</li>
</ol>
<p><strong>Tasks / College</strong></p>
<ol>
<li>college / uni / transcript</li>
<li>dbyrIterator - findScidThruSummaries - collyears, transcript / is_synced - syncer</li>
<li>SCM - student course manager - adjustment &amp;&amp; CCM - college course manager - flowchart</li>
<li>steps - enrollment / college setup - uniscores / unigrades / unimatrix / unisummarizer / uniteachers/index (home)</li>
<li>contactRedirect - UniprofilesController / xeditData (update), xsaveData (insert) / filters - row - uniadvisers/all</li>
</ol>
<p><strong>GISv3.200405v521</strong>&nbsp;</p>
<ol>
<li>20200423 - a) feedback - enrollment/filter, b) data.js -&gt; xgetDataByPartRow</li>
<li>contacts - sy, x-is_parent,&nbsp;</li>
<li>sy_scid &gt; dbo.enrollments (with tsum)</li>
<li>moved to dbo - subjects, criteria, products, levels, sections,&nbsp;&nbsp;</li>
<li>setup/loading</li>
<li>synclist</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.190405v510</strong>&nbsp;</p>
<ol>
<li>login redirect url / rurl</li>
<li>subscription expired&nbsp;</li>
<li>streamlined oop class library methods - controllers, methods, login, general functions</li>
<li>cut string function for long course names on matrix subject label</li>
<li>aname for managed dns to point domain name to public ip</li>
<li>dbfxns - deport (dbo to dbp), stack (dbyr to dbo),&nbsp;</li>
<li>css tabs</li>
<li>filter_redirect / filter general - studyears/crid</li>
<li>accordion/index</li>
<li>group_concat -&nbsp;</li>
<li>db - getDbtableColumns - cr/edit, unicourses/edit, crs/edit</li>
<li>filter_general, id/finder - getDataByTable (table agnostic)</li>
<li>id finder - cr/edit, crs/edit</li>
<li></li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.181215 (12-15-v507)</strong>&nbsp;&nbsp;</p>
<ol>
<li>mis home float - css grid like</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.181115 (11-15-v507)</strong>&nbsp;&nbsp;</p>
<ol>
<li>customs - matrix, scores, rcards, conductsProcess, offenses, honors, remarksPS, CavMatrix</li>
<li>sir / split iterative ranking - genave, sir/level/lvl/sy/qtr</li>
<li>MIR / master inventory report</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.180830 (08-30-v392)</strong>&nbsp;&nbsp;</p>
<ol>
<li>passwords/one - by registrar privilege 2.</li>
<li>ranks-level, ties, update / ranksLevel (with and without genave)</li>
<li>honors-level</li>
<li>matrix of honors</li>
<li>honors with conduct awardees</li>
<li>honors-certificate - level award certificate (separate papers for ordinal honors)</li>
<li>date editable - certificate</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.180715 (07-31-v385)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Summary Extension (summext) for all rankings, honors</li>
<li>Foundation Report like 3R's - English, Math, Science</li>
<li>Honors Process - to qualify, must have 1) genave over 87, 2) conduct over 90, 3) major subjects over 85, 4) component subjects (i.e. music, arts) over 85&nbsp;</li>
<li>settify to zerofy or initialize grades or populate values for a specific classroom (all course grades and genave)</li>
<li>averager - settings.decicard</li>
<li>SHS - 1) Genave Summary 2) Genave Final</li>
<li>Randomizer - numbers and letters</li>
<li>Snippets</li>
<li>canteen student OR search</li>
<li>consolidate $dbm and $dbg, remove $dbyr, remove 3-tier kpup (scores, etcscores, sumscores)</li>
<li>iBook, itypes</li>
<li>minsoft - goodsoft (players,ranks,teams,games)</li>
<li>Foundation / fdn - is_foundation, fdntype_id</li>
<li>sync scores / syncScoresFxn - mismatched activities and scores</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.180630 (06-30-v376)</strong>&nbsp;&nbsp;</p>
<ol>
<li>no more DG or descriptive or letter grades, gis369 last version with_dg</li>
<li>sipiral grid view, crid params - for validation of component and aggregate courses</li>
<li>tally aggregates - update only those with changes</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.180530 (05-30-v369)</strong>&nbsp;&nbsp;</p>
<ol>
<li>gradesNum or gradeDG - if course[is_num]==0 (course isNot numeric)</li>
<li>courseAveragesNum or courseAveragesDG - if course isNot numeric</li>
<li>registration/index for enrollment and sectioning only - no grades links</li>
<li>cash tally includes prevsy,currsy, and nextsy</li>
<li>collection report includes prevsy, currsy, and nextsy</li>
<li>teacher_registrar, teacreg - role 7, privilege 2</li>
<li>faster and cleaner POS, printPOS - v368-20180220</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.180430 (04-30-v365)</strong>&nbsp;&nbsp;</p>
<ol>
<li>transcript - promotions/student/scid</li>
<li>gisa - dbtable numeric prefixes - 02 (axis), 03 (pos/invty), 05 (gis), 06 (hris), 07 (library)</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.180215 (02-15-v362)</strong>&nbsp;&nbsp;</p>
<ol>
<li>duplicates -</li>
<li>user account - login name</li>
<li>user code - school assigned ID Number / ID No.</li>
<li>clubs scores or club scores - settings.with_clubs @teachers index - ACL Roles (mis#5,acad#4,admin#6)</li>
<li>regyr / registration year - meaning the default value for single / batch student registration&nbsp;</li>
<li>letters/traitsByLevel - individual indicator letter grade updater</li>
<li>cav/traitsByLevel - traits genave</li>
</ol>
<p>&nbsp;</p>
<p><strong>*** GISv361 - contacts split from users</strong></p>
<p>&nbsp;</p>
<p><strong>HR Payroll Notes v362 (20180214</strong>)</p>
<ol>
<li>atimein / atimeout - actual timein, actual timeout</li>
<li>dtimein / dtimeout - designed or designated timein / designated timeout - from attendance_schemas and contacts attschema_id</li>
<li>overtime must be pre-approved</li>
<li>working on non-designated workdays not paid</li>
<li>swap or offsetting</li>
<li>payroll - a) with DTR (default), b) no DTR</li>
<li></li>
</ol>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>GISv3.180115 (01-15-v348)</strong>&nbsp;&nbsp;</p>
<ol>
<li>dbstruct / dbchanges a) components (ucid,modified), b) summaries (modifiedby,modified), c) products (pocost,level_currcost), d) poscredits, e) posdetails (datecr=null), f)&nbsp;</li>
<li>criteria components manager for academic coordinator - lsm</li>
<li>bookmarking - users</li>
<li>soas - payment period ppr - customizable, not only today to avoid confusion of parents</li>
<li>notes on products</li>
</ol>
<p><span>1) RO Qty is reorder quantity, default quantity when making PO.&nbsp;</span><br /><span>2) RO Level is critical inventory or reorder level, alerts manager to make PO.&nbsp;</span><br /><span>3) Combo - comma separated product id's, no spaces.&nbsp;</span><br /><span>4) For suppliers not main - go to assignments.&nbsp;</span></p>
<p>&nbsp;</p>
<ol>
<li>define smv - internal stocks movement in dbinvis&nbsp;</li>
<li>20180116 - fixed accounting ledger addons bug</li>
<li>20180116 - products po cost working for POS</li>
<li>tests cxn union - tests/cxn or tests/union</li>
<li>20180118 - cpos or credit POS with datecr&nbsp;</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.171115 (11-15-v345)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Turnover attd</li>
<li>Pending Remarks - sjalp srgrades, if Q2 or Q4 grade is zero</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.171015 (10-15-v338)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Setup library</li>
<li>- gis/libstats/sync</li>
<li>- gis/libstats/index - hd</li>
<li>Library stats - libstats month, tallyMonth, sync</li>
<li>Misc calendar - truncate dbm.calendar for new SY then sync, setup/grading &gt; calendar month setup</li>
<li>Attd barcode DTR, adviser attendance tally</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.170915 (09-15-v333)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Purge cleanCridcavs - clean cavs clean traits</li>
<li>mis cir</li>
<li>purgeLvlcavs&nbsp;</li>
<li>dupes studcavs</li>
<li>conso traits - same params as cav traits - 17.09.30 v335</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.170815 (08-15-v332)</strong>&nbsp;&nbsp;</p>
<ol>
<li>PO Transfer summary</li>
<li>library subdepts - gs, hs, shs - IP</li>
<li>patron reports by dept</li>
<li>depts legends: a) dp - dept patron, df - dept facility, b) dcp - deptcode patron, dcf - dept code facility, c) dip - dept id patron, dif - dept id facility</li>
<li>subdepts 1(PS), 2 (GS), 3 (SHS) - with subdept IP</li>
<li>enrolmment report - with parents option</li>
<li>per library facilities can have multiple readers, subdepts</li>
<li>misc cleanScores - delete from scores all zero activities</li>
<li>loads/crlist - loads/cls - edits course name and teacher - with logs</li>
<li>sessionizeArray - added to library functions</li>
<li>debug at functions level</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.170715 (06-16-v330)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Fixed report cards continuous online viewing - css auto height</li>
<li>Put headers to reports - shrinkages, po payments</li>
<li>customs.is_enrolled_amount = 5000</li>
<li>balances - is_enrolled, and sxn &lt;&gt; 2 (out), auto refresh tsum.paid, auto update is_enrolled</li>
<li>stats.popn() updated based on c.is_enrolled status</li>
<li>po summary - with invoices field</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.170630 (06-16-v320)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Main OR - can have multiple rx</li>
<li>&gt; rx can exchange only available qty</li>
<li>&gt; rx new item cannot have negative</li>
<li>&gt; main OR - qty controlled by number of unrx_qty</li>
<li>Cost - products.pocost - set cost to pocost when level falls zero or under after opos transaction</li>
<li>batch shrinkages, edit, delete</li>
<li>GET debug query for enrollment, pos sales, stocks dtr, pos dsr, &nbsp;</li>
<li>shrinkages lote - batch edit | lot edit</li>
<li>customs.php - pos_order append or prepend</li>
<li>matrix 1) goto button, 2) sy and qtr label at page title</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.170530 (05-30-v315)</strong>&nbsp;&nbsp;</p>
<ol>
<li>OPOS - Open POS (revised version of NPOS)</li>
<li>SY selector dropdown list - matrix, student links, attendance</li>
<li>&nbsp;Enrollment report - date range, nationality, level, (paid first tuition fee)</li>
<li>editable addons by registrar &nbsp;</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.170430 (04-31-v309)</strong>&nbsp;&nbsp;</p>
<ol>
<li>DBINVIS DBI - apr25v309 - po, smv</li>
<li>posrx, returns exchanges</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.170315 (03-31-v306)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Migration 290</li>
<li>- po_rx (scripts.porx)</li>
<li>- nxtdbg.05_summaries</li>
<li>- posdetails - rx_posid, rx_pdid</li>
<li>Stocks by Terminal - update inventory terminal qty and total level</li>
<li>Enrollment Sectioner - a) MIS, b) Reg, c) TeacherPriv#2</li>
<li>Inventory shrinkages - 20170816, free, mixture, spoilage or damage</li>
<li>averager</li>
<li>matrix for final qtr5</li>
<li>gisv302 - oave summ.q7</li>
<li>promotions - xeditPreport</li>
<li>CAV summary</li>
<li>genave truval, true values</li>
</ol>
<p>&nbsp;</p>
<p>MIGRATION say from SY16 to SY17<br />1. truncate SY17_dbgis all except- summaries<br />2. misc/promoteAll/2017<br />3. exec scripts/porx</p>
<p>&nbsp;</p>
<p><strong>GISv3.170215 (02-15-v289)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Students links - rpt card, traits / cav, grades, summarizer, attendance, and classroom modules links like classlist and matrix, etc.</li>
<li>Library patrons monthly statistical report per grade level and update processor</li>
<li>Patrons daily visitors breakdown - gs, hs, empl and total</li>
<li>Passed / Failed and Promoted to / Retained in - vertical column in report cards</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.170115 (01-15-v283)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Fees balances - addons balance</li>
<li>Save apostrophe in SOA remarks</li>
<li>Student links / student filter - grades, summary, matrix</li>
<li>Traits CAV genave</li>
<li>20170118 gis285 -</li>
<li>-- optimized MisController</li>
<li>-- Controllers - MISC, Chinese, QCR, Conducts, EtcScores, Aggregates, Finalizers, Honors, Semesters, Itypes, Summarizers, Units</li>
<li>gis287 - dg only for cav traits, save once to lookup dg</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.161215 (12-15-v280)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Simplified finalizing class records - Average &gt; Finalize (no longer ARSU)</li>
<li>Course ranks can be accessed thru "Averages" &gt; Ranks (Sort &gt; Update)</li>
<li>Subjects.decimal (default to zero) - for tally aggregates use only</li>
<li>v281 - utility change grade bonus affected</li>
<li>update student aggregate upon change grade for component subjects, and after finalize of averages module</li>
<li>then summarize genave after update student aggregate for change grade</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.160915 (09-15-v255)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Attendance by quarter, settings.Attd_qtr, attmonths qtr_days_total, dbgis.attd.qtr_days_present (tardy)</li>
<li>Print Orno - delete orno (cancel orno)</li>
<li>PO purchase order - remarks by PO not details</li>
<li>PO - 1) status delivery, 2) status payment - statuses - 0,1,2 (over)</li>
<li>PO - customer is school, contact person is one who placed the order</li>
<li>MIT - TQ or terminal quantity not terminal sold</li>
<li>Products code included in POS scanning, code is school assigned barcode, while barcode is supplier barcode like printed on coke bottle</li>
<li>Filtering separated lines - MIT, Cash Denominations, Sales Reports</li>
<li>Traits - criteria.critype_id, critypes (id,name)</li>
<li>Ledger and SOA - overpayment</li>
<li>acad/suco - for user 7-4-1 or subject coordinator role</li>
<li>teachers/grades - in_rank - to exclude those students not supposedly in course ranks</li>
<li>Custom matrix</li>
<li>Custom Size &amp; Interval class records header row</li>
<li>PDF Downloads - GIS Quick Guide&nbsp;</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.160815 (08-30-v250)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Advisers Courses Setup - settings.advcrs_setup</li>
<li>MIS ID Tracer - with smartboard, excel, and numrows&nbsp;</li>
<li>ROIC - Role 13 - axis, invis, cir</li>
<li>Library - patron attendance</li>
<li>Principal or Coor Courses settings</li>
<li>MIS Courses Setup with propagator</li>
<li>Logistics PO - filter, add, edit, delete</li>
<li>Logistics Movements - filter, add, edit, move</li>
<li>Editable products - sync total inventory level</li>
<li>Cashier - manage inventory level / MIT</li>
<li>Querys controller @ tools reflection class</li>
<li>Files conference - a) classlist roster, b) submissions &gt; courses setup, c) profiling</li>
<li>New Controllers - MCA, components, admin new</li>
<li>Reorganized sessionize and user reset functions</li>
<li>Admin user role - axis or accounting enrollment, pos store sales, grading</li>
<li>Components - removed label and semester fields</li>
<li>pos/orlist - filter by date range, terminal, employee&nbsp;</li>
<li>academic matrix adjustable font size</li>
<li>Registrars code name for editing idno and name and gender</li>
<li>Settings - passing_pct - for scores passed failed statistics, default is 50</li>
<li>Settings - raw_transmute - for scores transmute raw TNV before roundoff&nbsp;</li>
<li>Ledgers - pay, edit, with surcharge,&nbsp;</li>
<li>Soa - surcharge</li>
<li>Bills pay - for misc fees non enrollment related fees</li>
<li>Cash Tally - for accounting</li>
<li>Cash Denominations - for invis or inventory staff&nbsp;</li>
<li>mis ajax duplicate contacts purger</li>
<li>mis purge index</li>
<li>advisers edit traits - input max value imax error checking default of 100</li>
<li>rcards and srcards and tpl, rptincs - v250</li>
<li>add new products auto generated product barcode</li>
<li>invis reports header with datetime printed - sales, items, inventory</li>
<li>PO autogenerted reference number</li>
<li>MIT - js deduction of terminal qty</li>
<li>Supplier info module - suppliers and PO with supplier info</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.160730 (07-30-v210)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Products page size controller and color controller, allows user to customize or adjust font size and font color of the page</li>
<li>Ledger - Due balance deduct amount from ovrepayment or add short from previous balance</li>
<li>SOA - allows printing of level and classrooms with different tuition fees, ie grade 11 different strands</li>
<li>POS - has bank payment and multiple payments like cash with cheque</li>
<li>Ledger - has bank list for bank payments</li>
<li>POS Report - filter by sales or by inventory sold, with filterable date range and product categories, types, and subtypes</li>
<li>POS Report - filter sales by summary only</li>
<li>Classlist - settings remarks_levels - remarks (in_rl), rlr (remarks_levels array)</li>
<li>v195 - removed pos fxns - grid,ireturn,ireturns,report</li>
<li>Reconcile POS</li>
<li>actions - delete_pos</li>
<li>v195 - settings.sem_numrows = 11 for srcard</li>
<li>v198 - overhaul dbnames - scid,crid,tcid,ccid,acid,hcid,ecid,tsummaries,tpaytypes,tpaymodes,tfeetypes,pcrid</li>
<li>- tables - tuition_details, advisers_quarters,classrooms,dbgis_tables,contacts,students,sub_coors,pos,</li>
<li>error proof create po if no items selected</li>
<li>error proof registration new students if id number or code already taken - setup/students</li>
<li>dpr - daily payments report</li>
<li>revised soa - removed discounts, add tsumremarks, ldm as flexible duedate in lieu of last day of the month&nbsp;</li>
<li>gis202 - cleanup settings - passing_grade_gs_k12, passing_score_gs_k12</li>
<li>gis203 - a) contacts/staff, b) stocks/byTerminal, c) invoices filter by contacts</li>
<li>gis203 - invoices manager</li>
<li>gis206 - balances/level with paymode cutoff and balances</li>
<li>gis207 - removed pos delete row, ledger multiple or multipay, dsr and dtr daily sales and terminal report with filter&nbsp;</li>
<li>gis208 - batch fees registration, filter range pos daily collection, cash tally javascript autotally subtotal</li>
<li>gis210 - courses setup, orbooklets, courses settings, xedit tcid at setup/loading</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.160630 (06-30-v188)</strong>&nbsp;&nbsp;</p>
<ol>
<li>advisers/averager?qtr=sqtr - to average all grades for sem0,1, and 2</li>
<li>mis/promoteAll?sy=ssy, will only affect unpromoted students</li>
<li>update aggregate paid student ledgers setup - tpaid - aggregateLedgersByClassroom (ledgers/setup/$crid), mis/aggregateLedgers (all)</li>
<li>filter teachers for course setup - mis/clscrs</li>
<li>info/crs - for crs teachers assignment</li>
<li>id finder id filter - mis/idf - filter names by table</li>
<li>products filter product or supplier</li>
<li>info loading - lists all teachers and their loads</li>
<li>info trsTeachers - lists all classrooms and teachers in them</li>
<li>removed groups and products columns from pos</li>
<li>ledgers - soa, balances with payments and auxes</li>
<li>student ledger - improved</li>
<li>improved soa by level not classroom</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.160531 (05-31-v175)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Logs - login, lock open course, lock open classroom, summarize</li>
<li>Service Request Tickets - unlock course for change of scores and grades, unlock classroom for summarizer</li>
<li>classrooms.num - for same level different tuition fees like STEM</li>
<li>DBO.actions, DBO.modules</li>
<li>migrator - omg abc for training</li>
<li>conso - by courses position too</li>
<li>by students position in profile, classlist, class records, matrix, banig (mcr)</li>
<li>acad locking average grades</li>
<li>reintroduced bonus - credits to class records in score2T</li>
<li>attendance validates input not to exceed total days</li>
<li>ticket - qtr,axn,crsid,crid,ucid,ecid,memo,done</li>
<li>&nbsp;logs - qtr,axn,ucid,ecid,memo,crsid,crid</li>
<li>change grade - from averages and logs with memo</li>
<li>honors - factor_genave (0.70), factor_cocurrs (0.30), from adivsers/cir</li>
<li>mis/subjects - position all courses</li>
<li>academic coordinators / principal - locking lockall average grades upto current session-quarter</li>
<li>propagator - subjects to courses</li>
<li>propagator - criteria to components</li>
<li>bring back elective ctype = 7</li>
<li>equivalents vs descriptions, equiv for scores TNV transmutation while descriptions for DG of quarter grades in scores or average</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.160430 (04-30-v168)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Promotions Vs Sectioning</li>
<li><ol>
<li>Sectioning only after transitioning as it changes summary classroom</li>
<li>Promotions only change&nbsp;</li>
</ol></li>
<li>Dropped - 0 status, Transferred - 2 status, default is Active - 1 status</li>
<li>Promotions - Update On, Finalize On for supervisory privileges</li>
<li>Promptions Report - summary report using summary classroom not contacts classroom</li>
<li>c.grp (for gls - sectioning grouping)</li>
<li>old balance obal, resfee rfee</li>
<li>promotions report - lrn - 2016-04-06</li>
<li>ledger checkbox calculator - tally of checked paybles and tender change helper</li>
<li>ledger radio selector for payment</li>
<li>Same orno copier&nbsp;</li>
<li>ledger tuition discounts auto factoring of amount by percentage</li>
<li>orno printer</li>
<li>tendertype switcher</li>
<li>cash tally</li>
<li>POS auto enter upon scanning</li>
<li>dropped student from SOA when not active</li>
<li>SOA - has datedue range</li>
<li>SOA and ledger - advance payments, overpayments cover future annuities&nbsp;</li>
<li>POINTERS - classrooms.num, c.grp, aux.num, payments.pointer</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.160331 (03-09-v168)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Enrollment Assessment - teachers, registrar, accounting</li>
<li>Sessionize Axis Tables - tuitions, paymodes, paytypes, disctypes</li>
<li>Settings - intrate,hdpass_axis,orno (or invoice), teacher_enrolled</li>
<li>surcharge calculator</li>
<li>ledger/student - fees,addons</li>
<li>settings - year_start replaces initial_school_year</li>
<li>lrn - deped permanent unique student code - learner reference number</li>
<li>photos - from DBO to DBP</li>
<li>payments report</li>
<li>deciave - for courses final ave in report cards</li>
<li>Failed subjects in report card retain students, lacks units in</li>
<li>Sessetter, cooksessions</li>
<li>Reg-unsetter</li>
<li>REG-fetcher (default dbm), specify dbo.table</li>
<li>autosync &gt; ucis-summaries,upname,sectioner,assessment NOT ledger</li>
<li>find and print or number, orbooklets in DBO</li>
<li>settings - rcard_issued -&nbsp;</li>
<li>ECR - tlogin,rptCard,editStudentGrades</li>
<li>CIR &gt; Submissions &gt; Average column (traits and non-traits conducts) and academic courses</li>
<li>registrars - edit student attendance</li>
<li>accounting roles - 0:head,1:staff,2:pos,</li>
<li>registrars filter students list - sy, crid, lvlid</li>
<li>secrets for modules authorization</li>
<li>invoices - for nontuition accounts</li>
<li>exchange returns for POS</li>
<li>pos - type, product, qtr, amount</li>
<li>assignments - products_suppliers, cost</li>
<li>purchase orders</li>
<li>inventory with terminals upto maximum of 10 - settings numterminals</li>
<li>POS with tandem combo - egg sandwich will reduce egg ingredient inventory level too</li>
<li>POS with credit sales, not only cash sales</li>
<li>POS with returns and exchanges provisions</li>
<li>dropped student report cards - from classlist - students is_active status should be 0</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.160229 (02-29-v155)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Config paths Has POS - POS Controller for POS&nbsp;</li>
<li>AX Controller for POS sales and inventory reports</li>
<li>Chart Controller - chart of accounts</li>
<li>Txn Controller for bookkeeping records and manager</li>
<li>Settings - posconfirm=1 (0 if no need for POS register sale confirmation)</li>
<li>GIS settings file - terminal configuration at local computer</li>
<li>Sessionize Accounting</li>
<li>ACL Accounting - POS</li>
<li>POS Barcoding barcode standard - EAN-13 - options: include text guardwhitespace, &nbsp;http://www.terryburton.co.uk/barcodewriter/generator/&nbsp;</li>
<li>CSV | Vlookup XLS Setup - order non-default columns / fields; products - id,pcat_id,name,price</li>
<li>&gt; GIS - contacts, students, sections, classrooms,&nbsp;</li>
<li>&gt; POS - products, categories,&nbsp;</li>
<li>Accounting - Enrollments, POS, Accounts, Products (Inventory), SIR (Reports), Txns</li>
<li>DBG - Schedules - id,date,time,event,room_id,color_id,is_active,is_impt,is_recursive</li>
<li>POS search filter / pos report generator</li>
<li>products_suppliers - many to many</li>
<li>schedules - bulk (smartboard/paste), crud</li>
<li>20160214 - v156</li>
<li>&gt; mis/ts - c.is_male,c.school_year,c.crid</li>
<li>&gt; removed c.year,p.is_male</li>
<li>&gt; removed crid from dbm.students</li>
<li>&gt; removed school_year from a) dbg.attendance &amp; _employees b) dbg.50_grades, c) dbg.05_summaries,, d) dbm.students</li>
<li>v155 removed guidance - iscores,igrades,iteachers,eval,asor,asee&nbsp;</li>
<li>v157</li>
<li>&gt; yyyy even for current year dbg and dbm, dbyr = $sy.US</li>
<li>&gt; renames settings_gis to settings only, removed settings_mis,settings_client,settings_students</li>
<li>mis/employer - patterned after sectioner</li>
<li>products - index(items), assign (prod_supp), filter assignments (list-prod-supp), suppliers</li>
<li>tuitions - fees, ledger (discounts,surcharge,payments)</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.160131 (01-15-151)</strong>&nbsp;&nbsp;</p>
<ol>
<li>Promotions Report K12 / BANIG</li>
<li>Clipboard - Paste Values from Excel to Class Records</li>
<li>Sortable Order class records</li>
<li>Filter by Semester Teacher's Load</li>
<li>Improved Security by changing the default value of database port</li>
<li>Editable Traits by Criteria Row and allow with clipboard functionality&nbsp;</li>
<li>Improved Traits Conducts Workflow - finalize &gt; rank &gt; sort / update</li>
<li>Toggle genave row on the report card&nbsp;</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.151231 (12-01-137)</strong>&nbsp;&nbsp;</p>
<ol>
<li>137 - traits semester 2, components.semester = 0</li>
<li>repeated header row for visual convenience - lvlcrs, clscrs, courses</li>
<li>repeated header row future - scores, mcr, rcr, qcr</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.151130 (11-11-136)</strong>&nbsp;&nbsp;</p>
<ol>
<li>133 - employees photos</li>
<li>133 - download photo</li>
<li>133 - notes</li>
<li>135 - improved mis locking interface</li>
<li>135 - last activity absent / excused - fixed percentage computing algorithm</li>
<li>136 - reports/rcr or running class record</li>
<li>136 - settings general - rank_grade, rank_conduct, rank_genave</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.151031 (10-10-130)</strong>&nbsp;&nbsp;</p>
<ol>
<li>130 - calendar of events</li>
<li>130 - Subject Levels</li>
<li>130 - Course Schedule</li>
<li>131 - levels.is_sem (0)</li>
<li>131 - q5, q6 - grades, summaries, summaries_other</li>
<li>131 - summarizer for semestral / college or senior HS system &nbsp;</li>
<li>131 - semestral - summarizer, sortCourseRanks, course ave, qcr</li>
<li>131 - q5 for default FG or ave, and q6 for semestral ave</li>
<li>132 - semestral - sortCourseRanks, QCR domino (q5 and q6)</li>
<li>132 - summarizer - vertical for FG, idiv = 2 not 4 for semestral averages</li>
<li>132 - ajax/xgetContacts IPU / PCID - UCID, js/filters, elements/filterbox</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.150930 (0828-109)</strong>&nbsp;</p>
<ol>
<li>126 - affects_ranking even though not in genave summarizer</li>
<li>126 - sjsp courses.is_transmuted - SJSP CLED not transmuted while all other courses are transmuted</li>
<li>125 - tools/deleteDuplicates - attendance_employees_logs</li>
<li>122 - img/jpg - for converting blob photos to tmp/images; img/ejpg for employees</li>
<li>119A - etAggregates, EtcIndex, chinese aggregates, alien controller</li>
<li>sep04 - included conducts not only acad - matrix, ccr, mcr, reportcards</li>
<li>sep03 - PTL purge transfer teacher loads at Employees Manager</li>
<li>ajax alert names - Employees Manager for PTL</li>
<li>Filters at a) employees registration, b) students registration</li>
<li>sep02 - chinse_names for scores and grades</li>
<li>sectioning, classroom manager sync grades page, level sectioning</li>
<li>sep01 - grades.final, summaries.final &gt; Q5</li>
<li>summaries_other - final to Q5</li>
<li>advisers controller separated from teachers controller</li>
<li>advisers - classlist, profiling, traits, conducts, attendance</li>
<li>subjects course config - position, indent</li>
<li>advisers matrix / student grades monitor</li>
<li>teachers homepage cleaner, removed header table</li>
<li>fyi controller - subjects</li>
</ol>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>GISv3.150830 (0808-108)</strong></p>
<ol>
<li>aug-29 - 108 - a) chinese or foreign language ranking (summaries_other / sumo)</li>
<li>aug-28 - 108 - a) mis/lvlcrs; b) fyi-sxn,tcid,scid,crid,lvlid,subject,cri,role,title, c) college type semestral report card / rcard_coll</li>
<li>aug-27 - 108 - a) settings.custom_equiv (scores quarter grade custom transmutation); b) mis/query</li>
<li>aug-25 - 107 - a) registrars/classlistManager; b) mis/emplistManager; c) levels.is_coll (0) tinyint</li>
<li>aug-14 - scores header customizable, profiling quick fix</li>
<li>aug-10 - 103 - accounts switcher</li>
<li>aug-05 - settings.first_month (6)</li>
<li>aug-03 - speed/informant - only contacts</li>
<li>aug-05 - overhauled hybrid mvc-procedural</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.150731</strong></p>
<ol>
<li>jul-31 - tools/diagnose</li>
<li>jul-31 - settings.editable_code=0, vacation_months = apr,may;&nbsp;</li>
<li>jul-30 - sectioning batch save, cls courses all buttons</li>
<li>jul-29 - mis/dashboard - lock/open All attendance per quarter at tools controller</li>
<li>jul-29 - attendance close/open per classroom</li>
<li>jul-29 - setting_gis.algo_pct (algorithm for scores class records - 1-Pct, 0-Detailed)</li>
<li>jul-28 - tools/upname - for syncing child user contact's name with parent contact's name</li>
<li>jul-28 - courses.is_apo, mis-clscrs (edit classroom courses)</li>
<li>jul-22 - attd / attendance daily with search</li>
<li>jul-17 - truncker (whole table), eraser (per record) - with super hdpass</li>
<li>jul-10 - vcprefix adaptor for dbname</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.150630</strong></p>
<ol>
<li>Jun-29 - redirect_classroom element for classlist, mcr, ccr&nbsp;</li>
<li>Jun-26 - code_delimeter</li>
<li>Jun-22 - floor_grade_ftnv, floor_grade_equiv, ceiling_grade_ftnv, ceiling_grade_equiv, passing_grade&nbsp;</li>
<li>Jun-17 - circles manager -&gt; DBO.rooms, DBO.rooms_contacts, DBO.ctagcategories&nbsp;</li>
<li>Jun-16 - files manager</li>
<li>Jun-15 - webpage -&gt; DBO.webpages,</li>
<li>Jun-10 - users duplicates manager</li>
<li>Jun-04 - settings: floor_score: default value: 50 (removed all other 6 floor scores)</li>
<li>Jun-03 - live update</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.150331</strong></p>
<ol>
<li>Integrated web-based RFID via javascript</li>
<li>Add Score input validation - cannot exceed max score</li>
<li>Updated database for RCARD and gradebook - courses.is_displayed</li>
<li>Paths.RCARD_SHOW_TEACHERS</li>
<li>Level Best in Subjects for Registrars</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.150228</strong></p>
<ol>
<li>SessionizeAdmins - courses_quarters,advisories_quarters @ ARMModel</li>
<li>Documented GIS versions and information</li>
<li>DB setup and DB panel to analyze database statistics,backup and sync DB</li>
<li>MIS/version controller</li>
<li>QCR - uses summaries.conduct grade if levels.conduct_affects_ranking is true&nbsp;</li>
<li>QCR - crs.in_genave &amp;&amp; crs.affects_ranking</li>
<li>Conduct Affects Ranking Qualifier - summaries.is_qualifed_q# (default = 1,if any one of Traits less than settings.floor_conduct_{dept} &amp;&amp; Paths.TRAITSDOMINO==1,then NOT qualified)</li>
<li>Removed cocurrs AS default,Paths.COCURRS &amp; Paths.GOTOHONORS</li>
<li>SetNewSY - syncAttMonths / employees</li>
<li>Advisers Tally Promotion (School Form / SF) - follow DEPED descriptions or DG&nbsp;</li>
<li>CrsType = '3' is CLUB,mis/classrooms initGrades - club,classrooms.is_init_club</li>
<li>Registrars links - dynamic link for submissions</li>
<li>Gradebook conduct grades - levels.conduct_ctype &lt;&gt; 2 (traits)</li>
<li>CCR editConducts / editTraits module</li>
<li>QCR - Q4 redirects to Q5 or final classroom ranking</li>
<li>Registrars/QLR - quarter level ranking redirects to Q5 or final if Q4</li>
<li>MIS/MCA (manager of courses_quarters and advisories_quarters) - locking mechanism for attendance</li>
<li>Attendance - redirects from Q4 to final</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.150131</strong></p>
<ol>
<li>Teachers/submissions - included c) traits,conducts in addition to: &nbsp;a) parents b) children</li>
<li>Submissions/$crid/$sy/$qtr - now also viewable by mis,admins,or registrars,not only teachers</li>
<li>Registrars/gradebook - Not printable if session.coursesLocked = &nbsp;false; checks all courses from courses_quarters of classroom if any is not locked of a particular quarter</li>
<li>Guidance/index - students attendance for role guidance</li>
<li>Replace all courses.crstype_id of &lsquo;7&rsquo; (elective) to &lsquo;1&rsquo; (acad),destroy crstype_id = 7</li>
<li>MIS/dashboard - a) sessionizeMISDashboard,reset to refresh,b) improved syncs (profiles,ctp)</li>
<li>Teachers/attendance - has locking control &gt; advisers_quarters.attendance_q1 to q4; improved submit</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.141231</strong></p>
<ol>
<li>POS - Inventory Report,Sales Report</li>
<li>Sessionize Credentials</li>
<li>POS Loading Report</li>
<li>Removed InitGIS from MIS</li>
<li>Removed preport / promotions report</li>
<li>Registrars/sectioning - status (is_active,is_cleared) replaced dropouts</li>
<li>Updated promotions schema</li>
<li>Provided link of TallyAggregates view at course view</li>
<li>Open classroom after editStudentGrades</li>
<li>Registrars/QLR - LRDOMINO (if dropped from ranking 1 quarter,dropped thereafter)</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.141130</strong></p>
<ol>
<li>CCR - courses.code NOT subjects.code</li>
<li>Paths.BONUS - if BONUS == true,added to grades for ccr,mcr,qcr,scores,raw,sumscores,summarizer</li>
<li>LockCourse for a particular quarter only after sortCourseRank</li>
<li>Updated Attendance buttons - after last entry will submit form</li>
<li>Debugged editStudentGrades $readonly</li>
</ol>
<p>&nbsp;&nbsp;</p>
<p><strong>GISv3.141031</strong></p>
<ol>
<li>Constants GDECI,FGDECI for gradebook,course,summarizer</li>
<li>Added Excel export to MCR</li>
<li>GIS Backup Policy for DBGIS - a) Active,b) YYYY_DB,c) HDB</li>
<li>MIS/syncAttemps - attendance_employees</li>
<li>MIS/emplist - employees list</li>
<li>Fixed adaptor for 1) local vs. 2) remote IP address for MIS/photo</li>
<li>MIS/dashboard,syncProfiles,Photos - include inactive contacts</li>
<li>Paths.ARFID (if with RFID - 1),for tally attendance days_present and days_tardy</li>
<li>MIS/photos - resize and convert to blob</li>
<li>SQL event - delete NOT truncate attendance_daily</li>
</ol>
<p>&nbsp;&nbsp;</p>
<p><strong>GISv3.140930</strong></p>
<ol>
<li>MIS/announcements manager (CRUD)</li>
<li>Student Attendance Report - adviser,class daily,student monthly</li>
<li>QCR | Summarizer - group by courses.in_genave NO LONGER supsubject = 0</li>
<li>Ranking (course,QLR,QCR) LIMIT number of students - settings,NO ADVISABLE,copy to excel and print instead</li>
<li>MIS/classrooms - syncGrades - ctypes 1) acad,7) elective (NOT applicable anymore)</li>
<li>View Aggregates by admins</li>
<li>More reports view for class records - 1) socres (detailed),2) sumscores,3) raw (activities only without TRNS,PNV)</li>
<li>Error proofing - criteria and subcriteria - cannot be empty</li>
<li>Scores - reversed DECI constants for FTNV and TNV,store in DB with decimal places</li>
<li>CCR - complete class records (quarterly) includes all courses (in_genave or not,affects_ranking or not,link to editStudentGrades &amp; editConduct / Traits)</li>
<li>Test mis/tsg - transfer student grades (from 1 classroom or section to another carrying previous quarter grades)</li>
<li>MIS/students - classlist parameter fixed&nbsp;</li>
<li>Registrars - level subject ranking</li>
<li>Teachers/qcr - only rank aggregates,not children (replaced by crs.in_genave and crs.affects_ranking)</li>
<li>Teachers/criteriaRanks</li>
<li>Removed links in class record for editStudentScores &amp; Traits if viewed by admin</li>
<li>Selects course criteria</li>
<li>Introduced levels.with_conduct_dg</li>
<li>Scores - order by course ranks when finalized,else by qtr grades</li>
<li>New layout - smartlinks and subheader menu bar&nbsp;</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.140831</strong></p>
<ol>
<li>EditStudentTraits - upon save reload page with the student classlist on the right side to edit one by one</li>
<li>Conducts - direct grades,crsType = '5'</li>
<li>Applied selectFocused() - traits,grades,add/edit scores</li>
<li>SessionizeTeachers - increased courses handled limit from 30 to 50</li>
<li>Tracehd debug - scores,traits. conducts</li>
<li>Admins like mis/mca - link to class records - display detailed scores not sumscores</li>
<li>Forever infinity scroll - persons,comments,etc.</li>
<li>MIS/upload - file upload to public images folder,with rename option</li>
<li>Registrars/profiling - settings.with_chinese = 0,then NO chinese column</li>
<li>Removed registrars/birt index Report</li>
<li>SessionizeRegistrars - contacts_departments,mgt/users - manage departments</li>
<li>GIS - floor grades in settings,ctp for employees</li>
<li>Svr setup - 1) ubuntu,2) cat htaccess,3) 000-default conf,4) phpmyadmin,5) php.ini vars</li>
<li>MIS/descriptions</li>
<li>MIS/photo/cid</li>
<li>MIS/contacts - contact manager,password</li>
<li>MIS/tsg - transfer student grades - same level,different sections after qtr 1</li>
<li>Teachers/index - 1) removed CAT view,2) removed units also</li>
<li>MIS/dashboard - date_lockdown_q# settings,courses_quarters open lock per quarter&nbsp;</li>
</ol>
<p>&nbsp;</p>
<p><strong><strong>GISv3.140730</strong></strong></p>
<ol>
<li>Gradebook - display crs.label&nbsp;</li>
<li>Scores | Add | Edit - order by profile.is_male DESC,c.name ASC</li>
<li>Introduced crsType = '7' elective for those not included in summarizer,but later replaced by crs,in_genave</li>
<li>MIS/classrooms - syncGrades for electives,later removed due to removing crsType 7:elective</li>
<li>Levels.code (3 chars i.e. K01),lvl.label,cr.name = K12.section</li>
<li>AdminsController - for academic coors and principal</li>
<li>MIS/editMonthsQuarters - moved from admins</li>
<li>MIS/attmonths - replaced admins/editMonths</li>
<li>mis/contact - add contacts</li>
<li>Introduced decimal places constants in Paths - DECI&nbsp;</li>
<li>MIS/dashboard - tsummaries init 1 time,update succeeding years,but sync every year for new students</li>
<li>Setup Components.label from subjects.name,courses.code from label</li>
<li>Course.code substring first four chars of label TMP</li>
<li>MIS/listClassrooms - settings.with_chinese for chinese advisers</li>
<li>Removed mis/classroomCourses</li>
<li>MIS/sacs &amp; MIS/syncSACS - subject area coordinators</li>
<li>Admins/submissions /deptid/subid - for SACS</li>
<li>Attendance Tally</li>
<li>Inserted students.attendance_logs - teacher/advi,with RFID</li>
<li>MIS - dropAttendance,delete attendance logs for holidays | weekends | NO classes</li>
<li>Registrars/reports - getClassroomByDepartments($ps,$gs,$hs)</li>
<li>MIS/classrooms - hidden cr.is_init_grades set to 0,to activate syncGrades</li>
<li>scores/editStudent - show valid radio</li>
<li>etcscores/sumscores - 2T fixed raw trans</li>
<li>MIS/criteria - cri.is_raw</li>
<li>Registrars/sectioner from registration</li>
<li>Accounts/enrollment</li>
<li>Settings_gis - Paths.ranking&nbsp;</li>
<li>SetNewSY -&nbsp;</li>
<li>Merged registration &amp; enrollment</li>
<li>Error proof,controlled sort ranks to only active quarter</li>
<li>Criteria.max_trans_value / With max trans for criteria table</li>
<li>Registrars records based from history or HDB</li>
<li>Class record / Scores - is_raw (default=1) vs. percentage / pct (recitation)</li>
<li>Registrars level ranking from home</li>
<li>Share course (average) for admins and registrars at GController</li>
<li>Traits subscores</li>
<li>Accounts/tsum or tsummaries</li>
</ol>
<p>&nbsp;&nbsp;</p>
<p><strong><strong>GISv3.140631</strong></strong></p>
<ol>
<li>Removed DB courses composite index subject-crid,coz possible several languages subjects,like Filipino,English,Chinese</li>
<li>scores/editStudent - xdelete hidden</li>
<li>Removed sumscores TNV column</li>
<li>Improved cr_filter / section filter to using POST vars</li>
<li>Teachers/grades - crs.with_scores == false,direct grades input</li>
<li>Overhaul candy reports or Gcontroller/gradebook</li>
<li>Removed fxns - gmodel/getClassroomSummariesByRankAndSY,getClassroomSummariesByRank,getStudentGenaveCourses,getClassroomStudents,getStudentsByClassroom,oldclasslist,tempfullclasslist,admins/getStudentTraits,admins/getCourseTraitGrades,admins/traits,admins/conducts,admins/getConducts,admins/tempscores,admins/sumscores,classifyCourse,admins/indexTraits,admins/editTraits,gsmodel/getConductType,gsmodel/getConducts,getSettingsValue,getAveFinal,getConductFinal,getStudentBrief (now gsmodel/student),classroomIsFinalized,editStudentTraits,</li>
<li>Moved sumscores from teacherscontroller to gcontroller -&gt; for share mis,admins/coors,registrars</li>
<li>Teachers/syncStudentTraits -&gt; also for mapehs,@teachers/traits if any student lacks grades in traits</li>
<li>History systems - Registrars/qcr,mcr,classyear,candy transcript,candy gradebook</li>
<li>Fixed registrars/qcr and mcr - for students with incomplete records&nbsp;</li>
<li>MIS/editCourse - added input for crs.with_scores</li>
<li>Candy gradebook - classlist (PDBG.students) for teachers,classyear (PDBG.05_summaries) for registrars</li>
<li>MCR - classlist or classyear - not by rank but ORDER BY gender,then c.name</li>
<li>GetStudentGrades not scidGrades - qcr,summarizer,mcr,candy,bonuses,etc....</li>
<li>Classlists &amp; classpool (PDBG.students) / classyear (PDBG.05_summaries) - profiling,sectioning,teachers/classlist,attendance,bonuses,mcr,qcr</li>
<li>Paths.with_chinese -&nbsp;chinese name for spas - registrars/ profiling - utf-8 html meta</li>
<li>MIS/syncGrades -&gt; included sync summaries,sync attendance&nbsp;</li>
<li>Teachers/bonuses sync or clean grades &gt; included sync summaries,sync attendance,private fxn - fineSumAtt - test,fine-line,check,test study</li>
<li>Registrars 1) mcr,2) summarizer,3) qcr,if teacher session sy then classlist (students) else url sy for classyear (summaries)</li>
<li>Replaced all - contact_id with scid,quarter to qtr,school_year to sy&nbsp;</li>
<li>ADAPTERS - classpool,classlist,classyear,classlistSummaries - mcr,qcr,summarizer,scores,course?,bonuses,attendance?,&nbsp;cridcourses(crid,agg,ctype)</li>
<li>Improved teachers/summarizer vs. registrars/summarizer - merged at Gcontroller &amp; Gmodel</li>
<li>CridCourses - replaced getClassroomCourses,and getCoursesByClassroom</li>
<li>Registrars/registration - removed old student,redirect to sectioner if old</li>
<li>DBM.Criteria with max_trans column (spas)</li>
<li>Innovated cascading system for database design - crstype_id in both DBM.courses and DBM.subjects,cannot trickle down from subjects alone; like level.dept_id,criteria.ctype_id.&nbsp;</li>
<li>MIS/listClassrooms - active,inactive,classroom manager</li>
<li>DBG.50_grades.crstype_id - edit program for all</li>
<li>MIS/syncGrades replaced mis/initGrades -&gt; for all acad in grades like in bonuses</li>
<li>Teachers/traits syncTPG - traits and psmapeh grades</li>
<li>DBG.50_grades.crstype_id replaced is_acad</li>
<li>Registrars/course -&gt; no editGrades if not current SY (control mechanism error proofing)</li>
<li>MIS/dashboard removed sync summaries,removed sync attendance</li>
<li>MIS/initGrades at mis/classrooms/lid - removed syncGrades for acad averages/course</li>
<li>Teachers/bonuses - init grades for new classlist; should be done by mis/clsDir then mis/classrooms -&gt; syncGrades</li>
<li>Teachers/syncTPG = cri.crstype_id = crs.ctype_id</li>
<li>Activities criteria position in teachers/scores</li>
<li>Batch edit mis/criteria - for scores a) positioning,b) dept,c) is_active</li>
<li>Advisers summarizer or ranking to close the classroom,removed num_diff condition for summarize button</li>
<li>Is_active,lookups - levels,criteria,subjects,- mis controlled settings&nbsp;</li>
<li>Batch &amp; xedit - profiling - p.fname,lname,p.gender,city,prov,address,email,sms,phones,smsnetwork,brgy,address,chinese name</li>
<li>EditStudentTrow error handler,if a score exceeds max_score will be zeroed</li>
<li>Teachers &amp; registrars /mcr - quarter 5 - ave_q5 instead of q5</li>
<li>Removed sqlCourseType,classifyCourseType - is_acad to is-cocurrs from misCtlr,and TeacCtlr,retained classifyDepartment though</li>
<li>Removed deleteCriteria from misCtlr,instead use edit to de-activate,set is_active = 0</li>
<li>Subject areas manager - mis/areas,is_finalized_areas</li>
<li>Test annual attendance total</li>
<li>Registrars/classroom - toggle checkboxes batch check all,clear all</li>
<li>New registrars/classlist,no prep</li>
<li>Set new SY - 1) open all courses_quarter and adviser_quarter,2) sy,3) qtr,open settings.is_finalized_sectioning,4) open all classrooms.is_sectioned</li>
<li>EditStudentScores error handler,exceed max_score will be zero</li>
<li>Simplified sectioning - 1) c.active,c.am,2) s.crid,s.promoted = 1 if SET,2) sum.crid,sum.acid</li>
<li>Promotions - remove column is_promoted - Y/N - default is yes upon promotion whether pass or fail - classroom ctc,ntc,</li>
<li>Replaced registrars/classroom &amp; editStudents -&gt; into a single sectioning page - 1) gender,2) active,3) am,4) set,5) sy == $sess[sy]</li>
<li>Enrollment - promotions instead of touching students.is_enrolled,use students.is_promoted - enrollment,sectioning (mis &amp; registrars)</li>
<li>Honors - submit honors button,condition after tally,- $is_locked should be false</li>
<li>Removed crstypes and departments - courses,criteria,descriptions</li>
<li>Filter classroom by school_year - mis &amp; registrars/classroom - thereby eliminating classlis</li>
<li>Fixed descriptions index - exclusive department_id only 1,2,or 3,or remove dept_id from descriptions students/grades,for esp Gmodel/getRatings</li>
<li>Registrars/dashboard - enrollments (stud.is_enrolled vs summaries-sy-scid),&nbsp;</li>
<li>MIS/editCourse - subject area id edit,area_id should be in subject then cascaded to courses,DONT need to have area_id in courses</li>
<li>Clubcourse_id should be in summaries not in students table</li>
<li>Sync registrars/dashboard and mis/dashboard - active students,sy summaries,sy attendance,sy promotions,&nbsp;</li>
<li>Setup gismaster_main - levels-16,sections-TMP &amp; SPD,criteria,subjects,areas,&nbsp;</li>
<li>Accounts/tsum - tuition summaries</li>
<li>Windows FORM POS debugged</li>
<li>ID writer - readme,queries,contacts.active_card_no - for rfid,cards - active no,scid;</li>
<li>RFID reader attendance test</li>
<li>FIXED mis/classroomStudents - clsAdvi and thisAdvi -acid onchange for one and for all,like registrars/editStudents - batch sectioning</li>
<li>Registrars/classroom removed hd</li>
<li>Checked TSG vs mis/students</li>
<li>Registrars lock / open enrollment or sectioning button at dashboard</li>
<li>Registrars classroom / editStudents excluded inactive students,but retain status control</li>
<li>MIS/status &amp; registrars - re-activated dropped or inactive contacts or students</li>
<li>Removed teachers/index qcr - cr.is_finalized_qtr control</li>
<li>New &amp; cleaner registrars/enrollment module</li>
<li>Settings_gis - graduate level - c.is_active = 0,for reg dashboard not include in sync summaries</li>
<li>Live hide pr- mysql errrors,index/unauth from database querysoc</li>
<li>Countdown to finalize or lockdown</li>
<li>Removed initGrades,replaced with syncGrades</li>
<li>MIS/students,xgetClassroom - level,section,acid</li>
<li>View/elements cr_filter,remove previous/current field</li>
<li>Is_finalized_sectioning if 1,then reg &amp; mis transfer closed,open after setNewSY,closed after enrollment</li>
<li>Moved sessionize or reset session - teachers,registrars,coor,mis TO Gmodel</li>
<li>Promotions,ntc,ctc,only two classrooms TMP,yis,&nbsp;</li>
<li>Reset - sessionize Teacher,User?</li>
<li>Reset - sessionize MIS</li>
<li>Reset - sessionize Registrar</li>
<li>MIS/users - xeditUser dept_id,from home multi-users+</li>
<li>Registrars/enrollment - single students summaries</li>
<li>Is_am move from students to contacts</li>
<li>MIS/editContacts batch enrollment from contacts,enhance contacts</li>
<li>Sync instead of initGIS - mis/dashboard - promotions</li>
<li>Index mismatch error handler - conducts,cleanCourseGrades</li>
<li>Tested bonus credits,lock if quarter closed</li>
<li>EditStudentTraits - psmaphe,traits index mismatch error handling</li>
<li>Index handlers - scores,grades bonuses,traits,psmapehs,mis dashboard</li>
<li>Index mismatch error handler - scores</li>
<li>Index mismatch error handler - attendance</li>
<li>Index mismatch error handler - course (grades),bonuses for all grades</li>
<li>Index mismatch error handler - traits,psmapehs,index handler</li>
<li>Teachers / clean course scores vs. course grades</li>
<li>Registrars/classyear from index - draft</li>
<li>Candy transcript,from registrars/index - draft&nbsp;</li>
<li>Bonuses - getCoursesByClassroom - include aggregates</li>
<li>Registrars/classroom - include pcrid,pcrid,FROM pcr TO cr</li>
<li>EditStudentGrades - init/sync grades for all stud crid courses - bonuses</li>
<li>Teachers/scores &gt; editStudentScores &gt; syncScoresActivities</li>
<li>Submissions - if unlock child,will unlock parent and crid</li>
<li>Summarizer() join grades and summaries on scid and sy</li>
<li>Registrars/reports - qlr,qcr,qtr (level,cr ranking)</li>
<li>Teachers/course - getStudents by sy by classroom</li>
<li>QLR from teachers to registrars,qtr level ranking+D264</li>
<li>index mismatch error handler - bonuses</li>
<li>Teachers - bonuses for new students,message alert; getCoursesByClassroom adapter</li>
<li>Gmodel/getClassroomSummariesByRankAndSY - qcr,mcr</li>
<li>Gmodel/getClassroomStudentsBYSY - courseRanks,&nbsp;</li>
<li>Teachers/tallyAggregates - $ix - students by classlis</li>
<li>Teachers/tallyAggregates - getStudentsOfAggregates @ teachersCtlr</li>
<li>Teachers/traits - getStudentTraits - by SY</li>
<li>Teachers/editTraits delete</li>
<li>Teachers/editStudentTRow,TPRow - grades.school_year</li>
<li>Traits - editStudentTRow,or traits - exceed maximum or letter inputs = 0</li>
<li>Cleaned teachersController -&gt; addGrades,criteria,classroom,&nbsp;</li>
<li>GetCourseStudentsWithGrades</li>
<li>Cleaned Teacher model -&gt; conducts,getCourseDetails,&nbsp;</li>
<li>Tally attendance logs using dynamic timein settings</li>
<li>Attendance logs - settings timein/out,include late to present count</li>
<li>Traits - no more tally</li>
<li>Trigger attedance daily to attendance logs,attAdd,attEdit</li>
<li>Attendance,am,pm timein</li>
<li>BIRT-reports links 1) reg/mcr,2) regCtlr-reports,3) reg/creports,4) teachers/scores</li>
<li>Registrars/classroom - acea,am/pm batch</li>
<li>Traits A) grades - 1-qtr,2-fg,3-dg,4-dgf. B) summaries - 1-cq,2-cfg,3-cdg,4-cdgf</li>
<li>Traits - floor grade if below</li>
<li>Included registrars - reports params - dbm,dbg</li>
<li>Teachers/conducts - nonk12,NO dg grades/summaries,BUT NEED finals</li>
<li>EditStudents - mis,registrars,- students table - editContact with stud div</li>
<li>Students is_am,attendance am_timein and pm_timein for students only,&nbsp;</li>
<li>MIS/subcourses - edit course teac,head</li>
<li>NOT affecting classRank,levelRank - upon editGrades</li>
<li>ARC framework optimized inheritance controller,model</li>
<li>Model/getStudentsBySummary - sort order</li>
<li>MCR - teachers sort by gender,name;</li>
<li>MCR - registrars vs teachers,reg add ct,genave,rank</li>
<li>course view - teacher,registrar,mis,coor admin,&nbsp;</li>
<li>Registrars/course - editgrades &amp; bonus,affect dg - both grades,summaries genave</li>
<li>MCR - advi,reg,prin,coor,&nbsp;</li>
<li>MIS/contacts - removed user link if role==1</li>
<li>Registrars/course - removed batch,init grades,delete</li>
<li>Teachers/classlist @ index</li>
<li>Tested summarizers,finalizers-acad &amp; non-acad,cleanGrades,&nbsp;</li>
<li>Teachers/submissions - yr3 - 057,3-tier makabayan-tle-com</li>
<li>Teachers/course - ranking button hide for aggregate courses,upon sync redirect to submissions if aggregate</li>
<li>Teachers/mcr order subjects and grades by cq.is_finalized_q$qtr</li>
<li>Months table - use id for position while index for attendance tally</li>
<li>MIS/users - from mgt/contacts</li>
<li>MIS/multiusers - from index,and dashboard</li>
<li>Honors - cocurr grades</li>
<li>User mgr+</li>
</ol>
<p>&nbsp;</p>
<p><strong><strong>GISv3.140531</strong></strong></p>
<ol>
<li>EditStudentrowTP - ratings,FG,and summaries</li>
<li>EditStudentrowTP - traits psmapeh</li>
<li>MIS/dashboard sync from students.crid -&gt; summaries.crid &amp;acid</li>
<li>Overhauled registrars homepage - school_year param for reports</li>
<li>Registrars/classroom - is_enrolled toggle,ACE (is_active,cleared,enrolled)</li>
<li>Credentials for FTP in google drive</li>
<li>Registrars/classroom - hide button and row upon transfer</li>
<li>Registrars/course from summarizer</li>
<li>MIS dashboard reset courses quarters and advisers quarters</li>
<li>Hide tally aggregates when the aggregate course is finalized</li>
<li>Teachers/mcr for adviser</li>
<li>Limited range registrars/index,initial_school_year</li>
<li>Prepared / initialized testGIS for new SY</li>
<li>MIS/dashboard num_enrollees reset unenrol students.is_enrolled</li>
<li>Accelerated student - TSG2,sync,xgetClassroomCourses,level also</li>
<li>SyncSG - MIS - transfer student - courses/ classlist -&gt; tsgfxn()</li>
<li>Registrars/classroom transfer xgetAcid</li>
<li>SyncSGIn - A) sync grades has new student coming</li>
<li>SyncSG - B) retain scores from other section - not possible</li>
<li>SyncSG - C) clean syncOut grades student leaving your course - not possible</li>
<li>Deltrow(i) ajax,MIS/TSG,xdel</li>
<li>SyncTPG - init traits/psmapehs to grades multiple criteria entries,control redirect</li>
<li>Advisers/characters - non-acad finalizers,removed to scores/grades links</li>
<li>Teachers/course - cleanCourseGrades,sync scid between grades &amp; classlist</li>
<li>Sectioning. Mis/classlist vs. teachers or registrars/promotions</li>
<li>MIS/dashboard SY enrollments - from MIS/classlists</li>
<li>Fixed teachers/classlist -&gt; getPrep</li>
<li>TallyAttendance logs to attendance,attendance_schemes</li>
<li>Gisnotes to portable gis folder</li>
<li>Simplified public/images/ layout</li>
<li>MIGEN gis parents letter</li>
<li>Advisers_quarters - is_finalized_attendance_q#</li>
<li>Max case students/attendance logs</li>
<li>Syncs - students contacts profiles summaries attendance</li>
<li>Criteria position,departments,ctype_id</li>
<li>Teachers / edit student scores</li>
<li>Optimized teachers params - attendance,bonuses / credits</li>
<li>ClassifyDept for criteria components manager</li>
<li>Students child login dashboard,passb</li>
<li>Students parents login dashboard</li>
<li>Ajax edit admins/MIS advisers_quarter,courses_quarters</li>
<li>EditContact - editProfile</li>
<li>MIS parents communication via editContact / c.remarks</li>
<li>MIS setup</li>
<li>MIS dashboard</li>
<li>MIS contacts pagination</li>
<li>MIS contacts search feature</li>
<li>MIS course manager</li>
<li>MIS classrooms manager</li>
<li>MIS students manager</li>
<li>MIS contacts manager</li>
<li>MIS subjects manager</li>
<li>MIS teachers manager</li>
<li>Mifare rfid card acatek,nelson arboleda,sulit,P13K,TCPIP based,02-4372013</li>
<li>MIS classrooms advisers</li>
<li>MIS/gls get level students&nbsp;</li>
<li>crstypes,ctypes for MIS classifyCrs</li>
<li>MIS criteria</li>
<li>MIS components</li>
</ol>
<p>&nbsp;</p>
<p><strong>GISv3.140430</strong></p>
<ol>
<li>MIS / registrars classlist</li>
<li>Accounts tuitions,tuition fees,assessment</li>
<li>Registrars parents communication via status / c.remarks</li>
<li>Registrars enrollment</li>
<li>MIS / registrars informant</li>
<li>Advisers/ registrars promotions reports / preports</li>
<li>Secure password</li>
<li>Advisers/ registrars promotions</li>
<li>Registrars dashboard homepage module</li>
<li>Admin coordinators homepage dashboard</li>
<li>Teachers honors cocurr module</li>
<li>Enhanced teachers dashboard</li>
<li>Conduct no scores directly to grades&nbsp;</li>
<li>Ajax edit attendance</li>
<li>Ajax edit conducts</li>
<li>Teachers advisers year 3,4 units manager</li>
<li>Teachers advisers year 4 CAT manager</li>
<li>Elements/smartlinks</li>
<li>Elements/homelinks,$_SERVER['HTTP_REFERER']</li>
</ol>
<p>&nbsp;</p>
<p>&nbsp;</p>
<ol>
<li>mcr/view, mcr/sem - 20200521 - grid</li>
<li></li>
</ol>
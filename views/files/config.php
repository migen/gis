<h2>USEFUL COMMANDS</h2>
<ol>
<li>sudo grep -rl "httpd" /etc - recursive find / search within subdirectories - file</li>
<li></li>
<li></li>
</ol>
<h2>&nbsp;</h2>
<h2>CONFIG SETUP - Checklist</h2>
<ol>
<li>CD Installer / pendrive</li>
<li>LAN Tester</li>
<li>Config guide</li>
<li>Crimping tool, cutter, RJ45 Jacks, Belden Cat5e UTP cable</li>
<li>Switch</li>
<li>Server PC - enterprise HDD, Core i5, Disabled USB ports, optical drive, 4GB RAM, HP Server</li>
<li>With internet connection</li>
<li>GIS - a) sql and 2) software</li>
</ol>
<h2>DATABASE - *mysqldump and restore both @cmd not @mysql terminal</h2>
<p>Dump / Backup -&nbsp;in live server no bin</p>
<p>* xampp\mysql\bin - path where mysqldump.exe and mysql.exe programs are located</p>
<p>http://webcheatsheet.com/sql/mysql_backup_restore.php</p>
<p>*IMPT - run from cmd not @mysql</p>
<p>*&nbsp;mysqldump -u root -pDbpass dbone_sjam &gt; ~/gisdata/dbone_sjam.sql</p>
<ol>
<li>goto cmd cd \.. to go to root directory</li>
<li>d&gt;cd xampp\mysql\bin</li>
<li>mysqldump -d -u [root] -h 127.0.0.1 --port=[port] -p [dbname] &gt; d:\BAK\SQL\[newdbname].sql &nbsp;(-d switch = structure only)</li>
<li>the backup sql is inside mysql\bin directory</li>
</ol>
<ul>
<li>for multiple db bakup &gt;&nbsp;mysqldump -u root -p --databases&nbsp;Tutorials&nbsp;Articles Comments &gt; content_backup.sql</li>
<li>all db backup &gt;&nbsp;mysqldump -u root -p --all-databases &gt; alldb_backup.sql</li>
<li>* mysqldump -u root --port=3333 -proot --databases yyyy_dbmaster_sch yyyy_dbgis_sch &gt; d:\gisdata\sch\sch_dbmgyyyy.sql</li>
</ul>
<p>Restore</p>
<ol>
<li>Create an appropriately named database on the target machine</li>
<li>cd xampp\mysql\bin &gt;&nbsp;<span>mysql -u [uname] --port=[port] -p[pass] aiphp &lt; d:\bak\sql\aiphpbak.sql &nbsp; &nbsp;</span></li>
<li>cd xampp\mysql\bin &gt;&nbsp;mysql -u [uname] --port=[port] -p[pass] &nbsp;&lt; d:\bak\sql\aigis.sql&nbsp;</li>
</ol>
<h2>CRONTAB&nbsp;</h2>
<p>Steps</p>
<p>1) Before crontab - try without sshpass first, manually prompted password for scp transfer - to permanently add remote IP to known hosts</p>
<p>example <br /> sshpass -p "Gispass#88" rsync -r -e 'ssh -o StrictHostKeyChecking=no -p 22' --progress /home/gisuser/gisdata/sjam/07/ gisuser@122.54.217.170:/home/gisuser/gisdata/sjam/07</p>
<p>2) sudo nano /etc/crontab&nbsp;</p>
<p>30 0 * * * root mysqldump -u [dbuser] &nbsp;-p[dbpass] --databases dbone_lsm 2016_dbmaster_lsm &nbsp;2016_dbgis_lsm &nbsp;&gt; &nbsp;/data/`date "+\%m"`/`date "+\%Y\%m\%d"-vcfolder`.sql&nbsp;</p>
<p># m h dom mon dow user command</p>
<p>* * * * * root mysqldump -u root -p[DBPASS] aiphp &gt; /home/makol/aibox/`date "+\%m"`/`date "+\%Y-\%m\%d-\%H-\%M-\%S"-aiphp`.sql</p>
<p># every midnight</p>
<p>30 0 * * * makol mysqldump -u [dbuser] -p[dbpass] --databases aiphp dbone_abc &gt; /data/`date "+\%m"`/`date "+\%Y\%m\%d"-omg`.sql&nbsp;</p>
<p>45 0 * * * makol cp /home/svrname/aibox/`date "+\%m"`/`date "+\%Y\%m\%d-ao"`.sql &nbsp;/data/`date "+\%m"`/`date "+\%Y\%m\%d-ao"`.sql</p>
<p>50 0 * * * makol /usr/bin/rsync /home/svrname/aibox/04/ &nbsp;/data/04/&nbsp;</p>
<p>3) sudo apt-get install sshpass</p>
<p>$ sshpass -p "remotePass" scp /data/scopy/db.sql remoteUser@122.33.55.88:/data/scopy/db.sql</p>
<p>* * * * * user1 sshpass -p "remotePass" scp /data/`date "+\%m"`/`date +"\%Y\%m\%d"-sch`.sql &nbsp;remoteUser@111.22.33.55:/data/scopy/sch/`date "+\%m"`/`date +"\%Y\%m\%d"-sch`.sql &gt; stdout &gt; /data/scopy/stderr.txt</p>
<p>ok ----&gt; $ sshpass -p "remotePass" ssh remoteUser@119.92.120.134 mkdir /home/gisuser/data/scopy/lsm/09/test&nbsp;</p>
<p>&nbsp;</p>
<p>http://tldp.org/HOWTO/Bash-Prog-Intro-HOWTO-5.html<br />A) Samples</p>
<p>A1) assign variables<br />#!/bin/bash&nbsp;<br />STR="Hello World!"<br />echo $STR&nbsp;</p>
<p>4) php script</p>
<p>exec("/usr/bin/mysqldump -u dbuser -h 123.145.167.189 -pdbpass database_name &gt; /path-to-export/file.sql", $output);</p>
<p># every minute<br />* * * * * root /home/$svrname/aitxt.sh&nbsp;&nbsp;</p>
<h2>SECOND DRIVE - LINUX<span style="font-size: 10px;">&nbsp;</span></h2>
<p>Add a second drive to your Ubuntu server<br />- Jack Wallen</p>
<p>GASP!<br />&gt; physical drive is already installed on your machine<br />&gt; new drive will be mounted to the directory /data <br />&gt; formatted with the ext3 file system with just one partition<br />&gt; automatically mounted upon boot of the system <br />&gt; dmesg<br />&gt; /dev/sdb<br />If you can't figure it out where the drive is located with dmesg issue the command:<br />sudo fdisk -l<br />The above command will report something like:<br />/dev/sda1 * 1 18709 150280011 83 Linux<br />/dev/sda2 18710 19457 6008310 5 Extended<br />/dev/sda5 18710 19457 6008278+ 82 Linux swap / Solaris<br />But will include a listing for your new drive. If you only see listings for /dev/sda* then your new drive has not been recognized and there is a problem with the physical installation.<br />Once you know where your drive is located (again we'll use /dev/sdb for our example) it's time to create a new directory where this drive will be mounted. We are mounting our drive to the directory /data so we'll create this directory with the following command:<br />sudo mkdir /data<br />&gt; sudo chmod -R 777 /data<br />With a place to mount the drive, it's time to format the new drive. The formatting will be done with the command:<br />&gt; sudo mkfs.ext3 /dev/sdb<br />When this is complete you are ready to mount the drive. Before you edit fstab entry (so the drive will be automatically mounted) make sure it can be successfully mounted with the command:<br />&gt; sudo mount /dev/sdb /data<br />If this is successful let's create an entry in /etc/fstab. open that file with the command<br />&gt; sudo nano /etc/fstab<br />Now add the following entry at the end of that file:<br />&gt; /dev/sdb /data ext3 defaults 0 0<br />Once you save that file, mount the drive (without having to reboot) with the command:<br />&gt; sudo mount -a<br />To make sure the drive mounted successfully issue the command:<br />&gt; df<br />The above should include in the report:<br />&gt; /dev/sdb /data<br />If that's the case, success! You can run one file test by trying to write a file to the new drive with the command:<br />&gt; touch /data/test</p>
<p>* TO UNMOUNT &gt; sudo unmount /data&nbsp;</p>
<h2>Transition</h2>
<ol>
<li>cronjob - yyyy</li>
<li>roster</li>
<li>promote All / proma&nbsp;</li>
</ol>
<h2>SETUP - Grading</h2>
<ol>
<li>a) DB credentials, b) settings, c) DBYR d) db port, e) &nbsp;</li>
<li>DBINIT - DBG, DBO</li>
<li>Copy DBM - settings,subjects,criteria,titles,roles,descriptions,dashboard/stats &gt; syn calendar,attschema,tuitions,tdetails,paymodes,</li>
<li>Copy DBO - titles,roles,weekdays,departments,prefixes,smsnetworks</li>
<li>Teachers / Employees registration - mis/contact - start at pcid #51</li>
<li>Sections - mis/sections - has 1) TMP, 2) OUT</li>
<li>Classrooms - mis/classrooms/level_id &gt; assign adviser</li>
<li>Add Students - setup/students/sy</li>
<li>Enrol or section students / Batch Roster - sectioning/crid/crid - (secrets)&nbsp;</li>
<li>Subjects - mis/subjects</li>
<li>Add Courses - gset/courses/level_id/sy &gt; config</li>
<li>Config Courses - mis/clscrs/crid</li>
<li>Criteria - criteria/sy</li>
<li>Components - gset/components_id/sy</li>
<li>mis/classroomsManager - sync grades for a) Acad, b) Conducts OR Traits</li>
<li>Attendance Days - mis/attmonths/sy</li>
<li>mis syncStudents (c.crid)&nbsp;</li>
</ol>
<h2>SETUP - Server</h2>
<ul>
<li>hostname - gis, fullname - schoolname,&nbsp;</li>
<li>software to install - openssh,lamp,dns server</li>
<li>install GRUB MBR</li>
<li>Server installation - a) xampp, phpmyadmin, ssh, zip, tomcat, b) IP c) htaccess, d) symlink, e) port forwarding &amp; NAT&nbsp;</li>
</ul>
<p>max upload phpmyadmin - 1) sudo nano /etc/php5/apache2/php.ini - upload_max_filesize and post_max_size to 150MB, 2) sudo service apache2 restart 3) gc_maxlifetime (server session timeout in seconds)</p>
<ul>
<li>sudo nano /etc/network/interfaces - static IP</li>
</ul>
<p class="MsoNormal"># The loopback network interface</p>
<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; auto lo</p>
<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; iface lo inet loopback</p>
<p class="MsoNormal"># The primary network interface</p>
<p class="MsoNormal" style="margin-left: .5in;">auto p2p1</p>
<p class="MsoNormal" style="margin-left: .5in;">iface p2p1 inet static</p>
<p class="MsoNormal" style="margin-left: .5in;">address 192.168.254.201</p>
<p class="MsoNormal" style="margin-left: .5in;">netmask 255.255.255.0</p>
<p class="MsoNormal" style="margin-left: .5in;">network 192.168.254.0</p>
<p class="MsoNormal" style="margin-left: .5in;">broadcast 192.168.254.255</p>
<p class="MsoNormal" style="margin-left: .5in;"><span style="font-size: 11.0pt; line-height: 115%; font-family: 'Calibri','sans-serif'; mso-fareast-font-family: Calibri; mso-bidi-font-family: 'Times New Roman'; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA;">gateway 192.168.254.254</span>&nbsp;</p>
<p class="MsoNormal" style="margin-left: .25in;">:wq // for vi, ^O and ^X</p>
<p class="MsoNormal" style="margin-left: .25in;">&gt; sudo /etc/init.d/networking restart</p>
<p class="MsoNormal" style="margin-left: .25in;">&gt; sudo reboot (to restart)</p>
<ul>
<li>phpmyadmin</li>
</ul>
<p class="MsoNormal" style="margin-left: .75in;">&gt; sudo apt-get update</p>
<p><span style="font-size: 11.0pt; line-height: 115%; font-family: 'Calibri','sans-serif'; mso-fareast-font-family: Calibri; mso-bidi-font-family: 'Times New Roman'; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &gt; sudo apt-get install phpmyadmin</span></p>
<p class="MsoNormal" style="margin-left: .5in;">if has error &gt; sudo nano /etc/resolv.conf</p>
<p><span style="font-size: 11.0pt; line-height: 115%; font-family: 'Calibri','sans-serif'; mso-fareast-font-family: Calibri; mso-bidi-font-family: 'Times New Roman'; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA;">nameserver 8.8.8.8 // save and exit, then run install phpmyadmin again</span></p>
<p class="MsoNormal" style="margin-left: .5in;">select apache2 &gt; YES configure database with dbconfig-common (/usr/share/doc/phpmyadmin)</p>
<p class="MsoNormal" style="margin-left: .5in;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &gt;&nbsp;$dbuser="root", $dbpass="Gis***# like sasm", $mysqlapppwdpma="xxxxx"</p>
<ul>
<li>MySQL @ phpmyadmin</li>
</ul>
<p class="MsoNormal" style="margin-left: .5in;">select apache2 &gt; YES configure database with dbconfig-common (/usr/share/doc/phpmyadmin)</p>
<ul>
<li>MOD REWRITE</li>
</ul>
<p>https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite-for-apache-on-ubuntu-14-04<br />RUN Commands</p>
<p>1) cat /etc/apache2/mods-available/rewrite.load<br />2) sudo a2enmod rewrite<br />&gt; sudo service apache2 restart<br />3) sudo nano /etc/apache2/sites-enabled/000-default.conf<br />Inside that file, you will find the block on line 1. Inside of that block, add the following block:</p>
<p>Your file should now match the following. Make sure that all blocks are properly indented.</p>
<p><br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Options Indexes FollowSymLinks Multiviews<br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;AllowOverride All<br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Order allow,deny<br />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;allow from all<br /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>
<p>4) sudo service apache2 restart</p>
<ul>
<li>SYMLINKS</li>
</ul>
<p class="Quotations" style="margin-top: 0in; margin-right: 0in; margin-bottom: 14.15pt; margin-left: .75in; line-height: 13.5pt;"><span style="font-family: 'Courier New';">sudo ln -s source target</span></p>
<ul>
<li><span style="font-family: 'Courier New';">NAVICAT error 2003:10061 -&nbsp;</span><span style="line-height: 13.5pt; font-family: 'Courier New';">The command bind the locahost address like this: bind-address=127.0.0.1, just add a # before it to comment it out.&nbsp;</span></li>
<li>
<p>&gt; sudo vi /etc/mysql/my.cnf</p>
</li>
</ul>
<p class="MsoNormal" style="margin-left: .75in;">&gt; sudo ln -s /home/gisuser/gis/ /var/www/html/gis</p>
<p class="MsoNormal" style="margin-left: .75in;">&gt; sudo ln -s /home/gisuser/gisdata/ /var/www/html/gisdata</p>
<ul>
<li>WEBMIN</li>
</ul>
<p class="MsoNormal" style="margin: 0in 0in 0.0001pt 0.25in;"><span style="font-size: 10.5pt; mso-bidi-font-size: 11.0pt; font-family: 'Courier New'; mso-fareast-font-family: 'Times New Roman'; color: #333333; mso-fareast-language: ZH-CN;">sudo nano /etc/apt/sources.list</span></p>
<p class="MsoNormal" style="margin: 0in 0in 0.0001pt 0.25in;"><span style="font-family: Arial, sans-serif; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">Now press<span class="apple-converted-space">&nbsp;</span></span><code><span style="font-size: 11.5pt; mso-fareast-font-family: Calibri; color: #111111;">Ctrl-W</span></code><span class="apple-converted-space"><span style="font-family: Arial, sans-serif; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">&nbsp;</span></span><span style="font-family: Arial, sans-serif; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">then<span class="apple-converted-space">&nbsp;</span></span><code><span style="font-size: 11.5pt; mso-fareast-font-family: Calibri; color: #111111;">Ctrl-V</span></code><span class="apple-converted-space"><span style="font-family: Arial, sans-serif; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">&nbsp;</span></span><span style="font-family: Arial, sans-serif; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;">to navigate to the end of the file, then add the following lines to the file:</span></p>
<pre style="margin-left: .75in; line-height: 16.5pt;"><code><span style="font-size: 10.5pt; color: #333333;">deb http://download.webmin.com/download/repository sarge contrib</span></code></pre>
<pre style="margin-left: .75in;"><code><span style="font-size: 10.5pt; color: #333333;">deb http://webmin.mirror.somersettechsolutions.co.uk/repository sarge contrib</span></code><span style="color: #333333; font-family: 'Courier New'; font-size: 10.5pt;">&nbsp;</span></pre>
<pre style="margin-left: .25in;"><code><span style="font-size: 10.5pt; color: #333333;">wget -q http://www.webmin.com/jcameron-key.asc -O- | sudo apt-key add -</span></code></pre>
<pre style="margin-left: .25in;"><code><span style="font-size: 10.5pt; color: #333333;">sudo apt-get update</span></code></pre>
<pre style="margin-left: .25in;"><code><span style="font-size: 10.5pt; color: #333333;">sudo apt-get install webmin</span></code><code></code></pre>
<pre style="margin-left: .25in;"><code><strong><span style="text-decoration: underline;"><span style="font-size: 10.5pt; color: #333333;">https:</span></span></strong></code><code><span style="font-size: 10.5pt; color: #333333;">//server_ip:10000 &nbsp;&nbsp;&nbsp; // firefox coz chrome not supported</span></code></pre>
<ul>
<li>MySQL Config</li>
</ul>
<p class="MsoNormal">&gt; sudo vi /etc/mysql/my.cnf</p>
<p class="MsoNormal">comment out &gt; # bind address 127.0.0.1</p>
<p class="MsoNormal">comment out # skip-networking&nbsp;</p>
<p><span style="font-size: 11.0pt; line-height: 115%; font-family: 'Calibri','sans-serif'; mso-fareast-font-family: Calibri; mso-bidi-font-family: 'Times New Roman'; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA;">&gt; sudo /etc/init.d/mysql restart</span></p>
<ul>
<li>Commands</li>
</ul>
<table class="MsoNormalTable" style="border-collapse: collapse; border: none; mso-border-alt: solid windowtext .5pt; mso-yfti-tbllook: 1184; mso-padding-alt: 0in 5.4pt 0in 5.4pt; mso-border-insideh: .5pt solid windowtext; mso-border-insidev: .5pt solid windowtext;" border="1" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="width: 191.1pt; border: solid windowtext 1.0pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">clear</li>
</ul>
</td>
<td style="width: 191.1pt; border: solid windowtext 1.0pt; border-left: none; mso-border-left-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">chown</li>
</ul>
</td>
<td style="width: 191.1pt; border: solid windowtext 1.0pt; border-left: none; mso-border-left-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">&nbsp;lshw (hardware specs)</li>
</ul>
</td>
</tr>
<tr>
<td style="width: 191.1pt; border: solid windowtext 1.0pt; border-top: none; mso-border-top-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">eject -t (close tray)</li>
</ul>
</td>
<td style="width: 191.1pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-left-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">ifconfig - ^C</li>
</ul>
</td>
<td style="width: 191.1pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-left-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">fdisk -l&nbsp;</li>
</ul>
</td>
</tr>
<tr>
<td style="width: 191.1pt; border: solid windowtext 1.0pt; border-top: none; mso-border-top-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">dpkg -l grep</li>
</ul>
</td>
<td style="width: 191.1pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-left-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">--help</li>
</ul>
</td>
<td style="width: 191.1pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-left-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">&nbsp;</li>
</ul>
</td>
</tr>
<tr>
<td style="width: 191.1pt; border: solid windowtext 1.0pt; border-top: none; mso-border-top-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">nano find search = ^w</li>
</ul>
</td>
<td style="width: 191.1pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-left-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">sudo shutdown -h 0</li>
</ul>
</td>
<td style="width: 191.1pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-left-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">&nbsp;</li>
</ul>
</td>
</tr>
<tr>
<td style="width: 191.1pt; border: solid windowtext 1.0pt; border-top: none; mso-border-top-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">chmod</li>
</ul>
</td>
<td style="width: 191.1pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-left-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">&nbsp;sudo rm -rf folder</li>
</ul>
</td>
<td style="width: 191.1pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; mso-border-top-alt: solid windowtext .5pt; mso-border-left-alt: solid windowtext .5pt; mso-border-alt: solid windowtext .5pt; padding: 0in 5.4pt 0in 5.4pt;" valign="top" width="255">
<ul style="margin-top: 0in;" type="disc">
<li class="MsoNormal">&nbsp;</li>
</ul>
</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<ul>
<li>MySQL Port Security</li>
</ul>
<p class="MsoNormal">4.1 xampp/mysql/bin/my.ini &nbsp;&nbsp;&nbsp;&nbsp; &gt;&gt; 3306 to $dbport</p>
<p class="MsoNormal">4.2 xampp/phpmyadmin/config.inc.php &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &gt;&gt; $cfg['Servers'][$i]['port'] = $dbport;&nbsp;&nbsp;</p>
<p class="MsoNormal">4.3 navicat connection &gt;&gt; change connection properties &gt;&gt; $dbport</p>
<p class="MsoNormal">4.4 gis/config/paths&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &gt;&gt; define constant DBPORT = $dbport</p>
<ul>
<li>Bootdisk</li>
</ul>
<ol style="margin-top: 0in;" type="1" start="1">
<li class="MsoNormal">download linux server stable - iso or image file</li>
<li class="MsoNormal">use ultra iso or similar software to make bootdisk&nbsp;</li>
</ol>
<h2>CONFIG (OLD / Next Year)</h2>
<ol>
<li>Dump SQL DBG, DBO (Backup - DVD, HDD 2, Remote PC)</li>
<li>DBINIT - (YYYY+1)_DBG from DBG&nbsp;</li>
</ol>
<h2>MASTER DATA &amp; ALGORITHM SETTINGS (OLD / Next Year)</h2>
<ol>
<li>Course types - 1) acad, 2) traits, 5) conduct</li>
<li>Course settings - is 3-tier, is_trans,</li>
<li>Configure Classrooms - TMP sections set per level first before regular sections, OUT section only college level id 16</li>
<li>gis settings</li>
<li>&gt; month_start = 06 (jun) or 08 (aug)</li>
<li>&gt; code_prefix, code delimiter, and length for auto generating ID numbers - YYYY or YY for 2016 new registered students, delimiter sample -, default code length is 4 after prefix</li>
<li>&gt; floor score 50 if base 50 transmutation, 9/10 = 95, if floor score =0, then 9/10 is 90%</li>
<li>&gt; algo_pct = 1 means per activity percentage averaging, if 0, then sum of criteria scores over sum of criteria max</li>
<li>&gt; graduate level - 16 - college, 15 - k12, 14 - k11&nbsp;</li>
</ol>
<h2>SETUP - Accounting &amp; Inventory</h2>
<ol>
<li>Tuition Fees - tfees/details/level_id</li>
<li>Fees/feetypes - i.e. tuitions, parking, misc, tutorial, gym rental, discounts 2nd sibling</li>
<li>Fees/paymodes - comma separated values for each payment schema</li>
<li>Ledgers/student</li>
<li>Product tags - MIS DB Setup - 1) Food, 2) Drinks, 3) Misc</li>
<li>Products/types - MIS DB Setup - i.e. tag - food, then subtype - cookies, donuts</li>
<li>Products/add - clients setup using smartboard</li>
</ol>
<h2>SETUP - Excel</h2>
<ol>
<li>vlookup(value,range,column,false)</li>
<li>filter unique - Data &gt; Remove Duplicates</li>
</ol>
<h5>Subnet Mask Notation</h5>
<table class="chart" style="height: 419px; width: 552px;">
<tbody>
<tr><th>Addresses</th><th>Hosts</th><th>Netmask</th><th>Amount of a Class C</th></tr>
<tr align="center"><th>/30</th>
<td>4</td>
<td>2</td>
<td>255.255.255.252</td>
<td>1/64</td>
</tr>
<tr align="center"><th>/29</th>
<td>8</td>
<td>6</td>
<td>255.255.255.248</td>
<td>1/32</td>
</tr>
<tr align="center"><th>/28</th>
<td>16</td>
<td>14</td>
<td>255.255.255.240</td>
<td>1/16</td>
</tr>
<tr align="center"><th>/27</th>
<td>32</td>
<td>30</td>
<td>255.255.255.224</td>
<td>1/8</td>
</tr>
<tr align="center"><th>/26</th>
<td>64</td>
<td>62</td>
<td>255.255.255.192</td>
<td>1/4</td>
</tr>
<tr align="center"><th>/25</th>
<td>128</td>
<td>126</td>
<td>255.255.255.128</td>
<td>1/2</td>
</tr>
<tr align="center"><th>/24</th>
<td>256</td>
<td>254</td>
<td>255.255.255.0</td>
<td>1</td>
</tr>
<tr align="center"><th>/23</th>
<td>512</td>
<td>510</td>
<td>255.255.254.0</td>
<td>2</td>
</tr>
<tr align="center"><th>/22</th>
<td>1024</td>
<td>1022</td>
<td>255.255.252.0</td>
<td>4</td>
</tr>
<tr align="center"><th>/21</th>
<td>2048</td>
<td>2046</td>
<td>255.255.248.0</td>
<td>8</td>
</tr>
<tr align="center"><th>/20</th>
<td>4096</td>
<td>4094</td>
<td>255.255.240.0</td>
<td>16</td>
</tr>
<tr align="center"><th>/19</th>
<td>8192</td>
<td>8190</td>
<td>255.255.224.0</td>
<td>32</td>
</tr>
<tr align="center"><th>/18</th>
<td>16384</td>
<td>16382</td>
<td>255.255.192.0</td>
<td>64</td>
</tr>
<tr align="center"><th>/17</th>
<td>32768</td>
<td>32766</td>
<td>255.255.128.0</td>
<td>128</td>
</tr>
<tr align="center"><th>/16</th>
<td>65536</td>
<td>65534</td>
<td>255.255.0.0</td>
<td>256</td>
</tr>
</tbody>
</table>
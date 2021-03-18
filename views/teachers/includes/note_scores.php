<p>
Notes<br />
1) TNV not round(TNV) is transmuted. i.e. 74.51 not 75 is transmuted. <br />
2) Floor score for "Raw" criteria not "Pct", i.e. if set to 50 then 5/10 is 75% not 50%.<br />
3) If pct algorithm, i.e. Qz#1 of 0/100 + Qz#2 10/10 = 50% ELSE 9% (DepEd summation). <br />

<br />Settings <br />
1) Computing Algorithm: <?php echo ($_SESSION['settings']['algo_pct']==1)? 'Pct':'DepEd Summation'; ?>.<br />
2) Transmutation Algorithm: <?php echo ($_SESSION['settings']['eqvs']==1)? 'With EQ Lookup':'No EQ lookup'; ?>.<br />
3) If using transmutation table, a) floor score = '0', b) eqvs = '1'.<br />

</p>
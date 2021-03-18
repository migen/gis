<?php


function getOrdinalArray($num){
	switch($num){
		case 1: $data['num']="1st"; $data['word']="First";break;
		case 2: $data['num']="2nd"; $data['word']="Second";break;
		case 3: $data['num']="3rd"; $data['word']="Third";break;
		case 5: $data['num']="5th"; $data['word']="Fifth";break;
		case 8: $data['num']="8th"; $data['word']="Eighth";break;
		case 9: $data['num']="9th"; $data['word']="Ninth";break;
		case 12: $data['num']="12th"; $data['word']="Twelfth";break;
		case 20: $data['num']="20th"; $data['word']="Twentieth";break;		
		default: $data['num']=$num."th"; $x=trim(convertNumberToWord($num));$x.="th";$data['word']=$x;break;		
	}
	return $data;
}	/* fxn */



function convertNumberToWord($num = false){
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}


function amountInWords($amount){
	$amount=number_format($amount,2,NULL,"");
	$whole=floor($amount);    
	$decimal=$amount-$whole; 
	$decimal=number_format($decimal,2,NULL,"");
	$decimal=ltrim($decimal,"0.");
	$word_whole=convertNumberToWord($whole); 
	$cond_decimal=($decimal>0)? " AND ".convertNumberToWord($decimal)." CENTS":NULL; 
	$spellout=$word_whole.' '.$cond_decimal;
	return $spellout; 
}	/* fxn */

<?php



// dynamic argument list
function getSum(){
    $args = func_get_args();
    $sum=0;
    foreach($args AS $arg){
        $sum+=$arg;

    }
    return $sum;

}   /* fxn */


function getAverageOfTwo($num1,$num2){
    $ave = ($num1+$num2)/2;
    return $ave;

}   /* fxn */

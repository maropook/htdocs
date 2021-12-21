<?php

echo "こんにちは";
$hello ="こんん一は";
echo "こんにちは{$hello}ですね";

var_dump(6); //int(6)
var_dump("6"); //string(1) 6 あたいの解析
var_dump(1 == 1); //true
var_dump(1==='1');//型の比較

$score = 2;
if(1==$score){
    echo "OK";
}else if($score>1){


    echo "NO";
}else{


    echo "Whar";
}


if(1<=1 && 1<10){ //or だと ||

}else{

    echo "1";
}




[];

array();

$arr =["PHP","hello"];



foreach($arr as $lang){

    if($lang == "hello"){
        continue;
    }

    echo $lang;
}

function anime($a=0,$b=9){
    echo "わわ{$a}";
}

anime(20,30);
anime();



?>
<?php 
    $cards=array("A","2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"); 
    $suits=array("diamonds", "hearts", "spades", "clubs");
    $i=0;
    foreach ($cards as $key => $value) {
        foreach ($suits as $key2 => $value2) {
            $deck[$i]=$value." ".$value2;
            $i=$i+1;
        }
        # code...
    }
    shuffle($deck);
    
    $deck=json_encode($deck);
    print_r($deck);

?>

<?php
    date_default_timezone_set("Asia/Seoul");
    $JSONPOST = file_get_contents("php://input");
    $dataBaseNum = file_get_contents("chatcollect.csv");
    $dataBaseNum = explode(PHP_EOL, $dataBaseNum);
    $dataBaseLineCount = count($dataBaseNum);
    $messageTime = date("h:i:sa");
    $messageDate = date("Y-m-d");
    // var_dump($JSONPOST);
    $JSONPOST = json_decode($JSONPOST);

    $in_says = "";
    if(isset($JSONPOST->says))
    {
        $in_says = $JSONPOST->says;
    }
    $in_who = "";
    if(isset($JSONPOST->who))
    {
        $in_who = $JSONPOST->who;
    }
    $in_PM = "";
    if(isset($JSONPOST->privateMessage))
    {
        $in_PM = $JSONPOST->privateMessage;
    }

    // $in_time ="";
    // if(isset($JSONPOST->time))
    // {
    //     $in_time = $JSONPOST->time;
    // }
    // $in_date="";
    // if(isset($JSONPOST->date))
    // {
    //     $in_date = $JSONPOST->date;
    // }

    if($in_says !== "" && $in_who !== "" && $in_PM !== "")
    {
        $chatInput1 = "{$in_says}|{$in_who}|{$in_PM}|{$dataBaseLineCount}|{$messageTime}|{$messageDate}";
        file_put_contents("chatcollect.csv", $chatInput1 . PHP_EOL, FILE_APPEND);
        echo(json_encode([ "status" => "OK" ]));
        
    }
    else 
    {
        echo(json_encode([ "status" => "ERROR" ]));
    }
?>
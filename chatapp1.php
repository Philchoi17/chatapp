<?php
     $chatappConn = new PDO('mysql:host=localhost;dbname=chatappdb;charset=utf8mb4', 'root', '');

    date_default_timezone_set("Asia/Seoul");
    $JSONPOST = file_get_contents("php://input");
    // $dataBaseNum = file_get_contents("chatcollect.csv");
    // $dataBaseNum = explode(PHP_EOL, $dataBaseNum);
    // $dataBaseLineCount = count($dataBaseNum);
    // $dataBaseLineNum = $chatappConn->prepare('SELECT `lineNum` FROM `chatmessages`');
    // $dataBaseLineNum->execute();
    // $result = $dataBaseLine>fetchAll(PDO::FETCH_ASSOC);


    // $messageTime = date("h:i:sa");
    // $messageDate = date("Y-m-d");
    $dateTime = date("Y-m-d h:i:sa");
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
    // $in_lineNum = "";
    // if(isset($JSONPOST->lineNum))
    // {
    //     $in_lineNum = $JSON->lineNum;
    // }
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
        // $chatInput1 = "{$in_says}|{$in_who}|{$in_PM}|{$dataBaseLineCount}|{$messageTime}|{$messageDate}";
        // file_put_contents("chatcollect.csv", $chatInput1 . PHP_EOL, FILE_APPEND);

        $dataBaseLine = $chatappConn->prepare('
            INSERT INTO `chatmessages`     
            (`says`, `who`, `date_time`, `privateMessage`) VALUES 
            (?, ?, NOW(), ?)
        ');
        $dataBaseLine->execute([$JSONPOST->says, $JSONPOST->who, $JSONPOST->privateMessage]);
            
        echo(json_encode([ "status" => "OK" ]));
            // var_dump($JSONPOST);
        // else 
        // {
        //     // echo($dataBaseLine->errorInfo());
        //     echo("error");
        // }

               
    }
    else 
    {
        echo(json_encode([ "status" => "ERROR" ]));
    }

    $sth = null;
    $dataConn = null;
    
?>
<?php 
date_default_timezone_set("Asia/Seoul");
// Reading input from standard input. Stuff coming from the web.
$chatUser1 = file_get_contents("php://input");
$chatUser = json_decode($chatUser1);

// Read from the database. Reading all the lines into a single array.
$chatHistory = file_get_contents("chatcollect.csv");
$chatHistory = trim($chatHistory);
// $userPos = strpos($chatHistory, $chatUser->user);
// echo($userPos);
$chatHistoryLines = explode(PHP_EOL, $chatHistory);
// $userHistory = [];

$jsonObjArr = [];  // Going to store all results in this array.
$jsonObjArrPri =[];

for($i = $chatUser->lineNum; $i < count($chatHistoryLines); $i++)
{
    $thisLine = explode("|", $chatHistoryLines[$i]);
    if($thisLine[1] === $chatUser->user || $thisLine[2] === $chatUser->user || $thisLine[2] === "public")
    {
        $newObj = new stdClass();
        $newObj->says = $thisLine[0];
        $newObj->who = $thisLine[1];
        $newObj->lineNum = intval($thisLine[3]);
        $newObj->time = $thisLine[4];
        $newObj->date = $thisLine[5];

        // $jsonObjArr[] = $newObj;
        if($thisLine[2] !== "public")
        {
            $newObj->privateMessage = $thisLine[2];
            
            // $jsonObjArr[] = $newObj;
        }
    $jsonObjArr[] = $newObj;    
    }

}

echo(json_encode($jsonObjArr));




// for($i = $chatUser->lineNum; $i < count($chatHistoryLines); $i++)
// {
//     $thisLine = (explode("|", $chatHistoryLines[$i]));
//     if(count($thisLine) > 1)
//     {
//         if($thisLine[2] === "public")
//         {
//             $newObj = new stdClass();
//             $newObj->says = $thisLine[0];
//             $newObj->who = $thisLine[1];
//             $newObj->lineNum = intval($thisLine[3]);
//             $newObj->time = $thisLine[4];
//             $newObj->date = $thisLine[5];

//             $jsonObjArr[] = $newObj;
//             // echo(json_encode($jsonObjArr)); 
//         }
//         else
//         {
//             $newObj1 = new stdClass();
//             $newObj1->says = $thisLine[0];
//             $newObj1->who = $thisLine[1];
//             $newObj1->lineNum = intval($thisLine[3]);
//             $newObj1->time = $thisLine[4];
//             $newObj1->date = $thisLine[5];
//             $newObj1->privateMessage = $thisLine[2];

//             $jsonObjArrPri[] = $newObj1;
//             // echo(json_encode($jsonObjArr));
//         }
//     }
// }

// if(isset($chatUser[0]))
// {
//     // $jsonObjArr[] = $newObj;
//     echo(json_encode($jsonObjArr)); 
// }
// else
// {
//     // $jsonObjArrPri[] = $newObj1;
//     echo(json_encode($jsonObjArrPri));
// }








// for($i = $chatUser->lineNum ;$i < count($chatHistoryLines); $i++)
// {
//     $thisLine = explode ('|', $chatHistoryLines[$i]);
    
//     if(count($thisLine) > 1)
//     {
//         $newObj = new stdClass();
//         $newObj->says = $thisLine[0];
//         $newObj->who = $thisLine[1];
//         $newObj->lineNum = intval($thisLine[3]);
//         $newObj->time = $thisLine[4];
//         $newObj->date = $thisLine[5];

//         // $jsonObjArr[] = $newObj;
//         // echo(json_encode($jsonObjArr));
        
//         // if ($thisLine[2] !== "public" && isset($chatUser->user) && $chatUser->user !== "") // Checking to see if it's a private message.
//         if($thisLine[2] !== "public")
//         {
//             // if($chatUser->user === $thisLine[1] || $chatUser->user === $thisLine[2])
//             //  {
//                 $newObj->privateMessage = $thisLine[2];
//             //  }
//         }       
//         $jsonObjArr[] = $newObj;
//         // echo(json_encode($jsonObjArr));
        
        
//     }
// }

// echo(json_encode($jsonObjArr));
// // echo(gettype($thisLine[4]));
// ?>

<?php

    $JSONPOST = json_encode($_POST);
    $in_says = "";
    if (isset($_REQUEST['says'])) { $in_says = $_REQUEST['says']; }

    $in_who = "";
    if (isset($_REQUEST['who'])) { $in_who = $_REQUEST['who']; }

    $in_PM = "";
    if (isset($_REQUEST['privateMessage'])) { $in_PM = $_REQUEST['privateMessage']; }

    if($in_says !== "" && $in_who !== "" && $in_PM !== "")
    {
        // $chatInput1 = "{$in_says}|{$in_who}|{$in_PM}" . PHP_EOL;
        file_put_contents("chatcollect.csv", $JSONPOST . PHP_EOL, FILE_APPEND);
    }
    // var_dump($_POST);
    // $JSONPOST = json_encode($_POST);
    // var_dump($JSONPOST);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat Room</title>
</head>
<style>
    html, body, div{margin:0px;padding:0px}
    div
    {
        display:inline-block;
    }
    .chatRoom 
    {
        background-color:white;
        width:100%;
        height:500px;
        overflow:scroll;
        border-top:10px ridge darkgrey;
        border-bottom:10px ridge darkgrey;

    }
    #userArea 
    {
        background-color:lightgrey;
        width:100%;
        height:100px;
        border:1px solid black;
        margin-top:-5px;
    }
    #textInput 
    {
        position: relative;
        width: 750px;
        height: 75px;
        font-size: 20px;
        top: 10px;
        left: 25px;
        padding-left: 20px;
        border:none;
    }
    #userID
    {
        position: relative;
        width: 150px;
        height: 50px;
        font-size: 20px;
        top: 10px;
        left: 25px;
        padding-left: 20px;
        border-radius:5%;
        border: none;
        text-align:center;
    }
    #submitButton
    {
        width: 50px;
        height: 50px;
        background-color: grey;
        position: relative;
        left: 30px;
        top: 10px;
        border-radius:50%;
        border: 1px solid black;
    }
    #submitButton:hover 
    {
        cursor:pointer;
    }
    #userName
    {
        font-weight:bold;
        font-size:18px;
    }
    #chatStyle
    {
        font-size:16px;
        text-align:left;
        color:grey;
        font-style:oblique;
    }
    .chatStyleA
    {
        font-size:16px;
        text-align:left;
    }
    .chatStyleB
    {
        font-size:16px;
        text-align:left;
    }
    .chatStyleC
    {
        font-size:16px;
        text-align:left;
    }
    #aChat 
    {
        background-color:beige;;
    }
    h1
    {
        color:grey;
        font-style:oblique;
    }
    #secretMessage
    {
        position: relative;
        left: 25PX;
        height: 20px;
        margin: 0px 20px 0px;
    }
    .loggedInUser 
    {
        text-align:center;
    }
    .userName 
    {
        font-weight:bold;
    }
</style>
<body>
    <div class="chatRoom" id="aChat">
        <?php
            // READING FROM DATABASE FILE
            $userSays = file_get_contents("chatcollect.csv");
            $userSays = trim($userSays);
            $chatArr = [];
            
            if ($userSays !== "")
            {
                $chatArr = explode(PHP_EOL, $userSays);
            }
            else
            {
                echo("<h1>Start Chat...</h1>");
            }
            // echo("SIZE:" . count($chatArr));

            $chatsenders = array();
            
            for($i = 0; $i < count($chatArr); $i++)
            {
                $this_chat = trim($chatArr[$i]);  // Get rid of newlines.
                // echo($this_chat);

                if ($this_chat !== "") 
                {  // Ignore blank lines in the chat database file.



                    // $chatSubmits = explode("|", $this_chat);
                    // $sendername = $chatSubmits[1];
                    // if(!in_array($sendername, $chatsenders)) //prevent duplicate entries
                    // {
                    //     $chatsenders[] = $sendername;
                    // }

                    // if ($chatSubmits[2] === "public") 
                    // {                        
                    //     $userClass = "";
                    //     if ($in_who === $chatSubmits[1]) $userClass = "loggedInUser";

                    //     echo("<p class='chatLine {$userClass}'><span class='userName'>" . $chatSubmits[1] . "</span>: " . $chatSubmits[0] . "</p>" . PHP_EOL);
                    // }
                    // else {
                    //     $dm_recipient = $chatSubmits[2];
                    //     if ($dm_recipient === $in_who) //check if the current user is the recipient for this msg
                    //     {
                    //         echo("<p class='chatLine'><span class='userName'>" . $chatSubmits[1] . "</span> (private) : " . $chatSubmits[0] . "</p>" . PHP_EOL); 
                    //     }
                    // }
                    $chatSubmit = json_decode($this_chat);
                    $nameOfSender = $chatSubmit->who;
                    if(!in_array($nameOfSender, $chatsenders))
                    {
                        $chatsenders[] = $nameOfSender;
                    }
                    if($chatSubmit->privateMessage === "public")
                    {
                        $userClass ="";
                        if($in_who === $chatSubmit->who)
                        {   
                            $userClass = "loggedInUser";   
                            echo("<p class='chatline {$userClass}'><span class ='userName'>" . $chatSubmit->who . "</span>: " . $chatSubmit->says . "</p>" . PHP_EOL);
                        }
                    }
                    else
                    {
                        $dm_receiver = $chatSubmit->privateMessage;
                        if($dm_receiver === $in_who)
                        {
                            echo("<p class='chatline'><span class='userName'>" . $chatSubmit->who . "</span> (private) : " . $chatSubmit->says . "</p>" . PHP_EOL);
                        }
                    }
                    
                }
            }; 
        ?>
    </div>
    <div id="userArea">
        <form id="enterChat" action="chatapp1.php" method="POST">
            <input type="text" name="says" id="textInput" placeholder="text here..." autofocus="autofocus">
            <input type="text" name="who" id="userID" value="<?php echo($in_who); ?>" />
            <select name="privateMessage" id="secretMessage">
                <option value="public">DM</option>
                <?php
                // foreach ($chatsenders as $sn)
                for ($i = 0; $i < count($chatsenders); $i++)
                {
                    $sn = $chatsenders[$i];
                    ?><option value="<?php echo($sn); ?>"><?php echo($sn); ?></option><?php
                    // echo("<optione value='{$sn}'>{$sn}</option>");
                }
                ?>
            </select>
            <button type="button" id="submitButton">submit</button>
        </form>
        
    </div>
    
        Current User [ <?php echo($in_who); ?> ]
    
    <script>

        var button = document.getElementById("submitButton");
        var input = document.getElementById("textInput");
        var user = document.getElementById("userID");
        var userAChat = document.getElementById("aChat");
        var userBChat = document.getElementById("bChat");
        var userCChat = document.getElementById("cChat");
        var submit = true;
        var userACollect = document.getElementsByClassName("chatStyleA");
        var userBCollect = document.getElementsByClassName("chatStyleB");
        var userCCollect = document.getElementsByClassName("chatStyleC");
        var directMess = document.getElementById("secretMessage");

        button.addEventListener("click", function()
        {
            submit = true;

            if(user.value === "select user")
            {
                submit = false;
            }
            if(user.value !== "")
            {
                submit = true;
            }
            if(input.value === "")
            {
                submit = false;
            }

            if(submit === true)
            {
                // document.getElementById("enterChat").submit();
                var httpReq = new XMLHttpRequest();
                httpReq.onreadystatechange = function()
                {
                    if (this.readyState === 4 && this.status === 200)
                    {
                        var chatReq = httpReq.responseText;
                        console.log(chatReq);
                        userAChat.innerHtml="";
                        
                    }
                    chatReq.open("POST", "http://localhost/chatapp/chatapp1.php");
                    chatReq.setRequestHeader("Content-Type", "application/json");
                }
            }

            // if(user.value = "A" && directMess.value === "B")
            // {
            //     for( var i = 0; i < userCCollect.length; i++)
            //     {
            //         userCCollect[i].style.opacity = "0";
            //     }
            // }
        });

        input.addEventListener("keyup", function(event)
        {
            event.preventDefault();
            if(event.keyCode === 13 && submit === true)
            {
                button.click();
            }
        });

        user.addEventListener("keyup", function(event)
        {
            event.preventDefault();
            if(event.keyCode === 13 && submit === true)
            {
                button.click();
            }
        });

        user.addEventListener("keyup", function(event)
        {
            event.preventDefault();
            if(event.keyCode === 13 && submit === true)
            {
                button.click();
            }
        });

        // user.addEventListener("change", function()
        // {
        //     // console.log("SUP");
        //     var allChatsArr = document.querySelectorAll("#aChat > p");
        //     for (var i = 0; i < allChatsArr.length; i++)
        //     {
        //         thisChatElem = allChatsArr[i];
        //         thisChatElem.style.textAlign = "left";
        //         thisChatElem.style.fontStyle = "oblique";
        //         thisChatElem.style.fontColor = "grey";
        //     }

        //     var usersElemArr = document.getElementsByClassName("chatStyle" + this.value);
        //     for (var i = 0; i < usersElemArr.length; i++)
        //     {
        //         thisElem = usersElemArr[i];
        //         thisElem.style.textAlign = "center";
        //         thisElem.style.fontStyle = "normal";
        //         thisElem.style.color = "black";
        //     }
        //     // if(input.value !== "")
        //     // {
        //         document.getElementById("enterChat").submit();
        //     // }
        // });

        

        // directMess.addEventListener("change", function()
        // {
        //         // console.log("hey");
        //     if(user.value === "A" && directMess.value === "B")
        //     {
        //         for( var i = 0; i < userCCollect.length; i++)
        //         {
        //             userCCollect[i].style.opacity="0";
        //         }
        //     }
        // });

            // if(user.value === "A")
            // {
            //     for(i=0; i < userACollect.length; i++)
            //     {
            //         userACollect[i].style.textAlign="center";
            //     }
            //     // document.getElementsByClassName("chatStyleA").style.textAlign="center";
            //     for(x=0; x < userBCollect.length; x++)
            //     {
            //         userBCollect[x].style.textAlign="left";
            //     }
            //     // document.getElementsByClassName("chatStyleB").style.textAlign="left";
            //     for(y=0; y < userCCollect.length; y++)
            //     {
            //         userCCollect[y].style.textAlign="left";
            //     }
            //     document.getElementsByClassName("chatStyleC").style.textAlign="left";
            // }
            // if(user.value === "B")
            // {
            //     document.getElementsByClassName("chatStyleA").style.textAlign="left";
            //     document.getElementsByClassName("chatStyleB").style.textAlign="center";
            //     document.getElementsByClassName("chatStyleC").style.textAlign="left";
            // }
            // if(user.value === "C")
            // {
            //     document.getElementsByClassName("chatStyleA").style.textAlign="left";
            //     document.getElementsByClassName("chatStyleB").style.textAlign="left";
            //     document.getElementsByClassName("chatStyleC").style.textAlign="center";
            // }
            // if(user.value === "select user")
            // {
            //     document.getElementsByClassName("chatStyleA").style.textAlign="left";
            //     document.getElementsByClassName("chatStyleB").style.textAlign="left";
            //     document.getElementsByClassName("chatStyleC").style.textAlign="left";
            // }
        // });
    </script>
</body>
</html>
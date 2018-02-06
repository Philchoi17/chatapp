<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<>, initial-scale=1.0">
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
        outline:1px solid black;
        overflow:scroll;
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
        border: 1px solid black;
    }
    #userID
    {
        position: relative;
        width: 200px;
        height: 50px;
        font-size: 20px;
        top: 10px;
        left: 25px;
        padding-left: 20px;
        border-radius:50%;
        border: 1px solid black;
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
    #chatStyleA
    {
        font-size:16px;
        text-align:center;
    }
    #aChat 
    {
        background-color:white;;
        display:none;
    }
    #bChat 
    {
        background-color:white;;
        display:none;
    }
    #cChat
    {
        background-color:white;
        display:none;
    }
</style>
<body>
    <div class="chatRoom" id="aChat">
        <?php

            // if(($_REQUEST[$says] === "" || $_REQUEST[$who] === ""))
            // {
            //     exit;
            // }
            // else
            // {
            //     $chatInput = implode("|", $_REQUEST);
            //     file_put_contents("chatcollect.csv", $chatInput . PHP_EOL, FILE_APPEND);
            // }
            // var_dump($_REQUEST);
            $chatInput1 = implode("|", $_REQUEST);
            // echo($chatInput);
            // if()
            file_put_contents("chatcollect.csv", $chatInput1 . PHP_EOL, FILE_APPEND);

            $userSays = file_get_contents("chatcollect.csv");
            $userSays = trim($userSays);
            $chatArr = explode(PHP_EOL, $userSays);

            // echo($chatArr[2]);
            // $test = explode("|", $chatArr[1]);
            // echo($test[1]);

            for($i = 0; $i < count($chatArr); $i++)
            {
                $chatSubmits = explode("|", $chatArr[$i]);
                // echo("<p id='chatStyle'><span id='userName'>" . $chatSubmits[1] . "</span>: " . $chatSubmits[0] . "</p>");
                if($chatSubmits[1] === "A")
                {
                    echo("<p id='chatStyleA'><span id='userName'>" . $chatSubmits[1] . "</span>: " . $chatSubmits[0] . "</p>");
                }
                else
                {
                    echo("<p id='chatStyle'><span id='userName'>" . $chatSubmits[1] . "</span>: " . $chatSubmits[0] . "</p>");
                }
            }

        ?>
    </div>
    <div class="chatRoom" id="bChat">
        <?php

            // if(($_REQUEST[$says] === "" || $_REQUEST[$who] === ""))
            // {
            //     exit;
            // }
            // else
            // {
            //     $chatInput = implode("|", $_REQUEST);
            //     file_put_contents("chatcollect.csv", $chatInput . PHP_EOL, FILE_APPEND);
            // }
            // var_dump($_REQUEST);
            $chatInput2 = implode("|", $_REQUEST);
            // echo($chatInput);
            file_put_contents("chatcollect.csv", $chatInput2 . PHP_EOL, FILE_APPEND);

            $userSays = file_get_contents("chatcollect.csv");
            $userSays = trim($userSays);
            $chatArr = explode(PHP_EOL, $userSays);

            // echo($chatArr[2]);
            // $test = explode("|", $chatArr[1]);
            // echo($test[1]);

            for($i = 0; $i < count($chatArr); $i++)
            {
                $chatSubmits = explode("|", $chatArr[$i]);
                // $chatSubmits = array_unique($chatSubmits);
                // echo("<p id='chatStyle'><span id='userName'>" . $chatSubmits[1] . "</span>: " . $chatSubmits[0] . "</p>");
                if($chatSubmits[1] === "B")
                {
                    echo("<p id='chatStyleA'><span id='userName'>" . $chatSubmits[1] . "</span>: " . $chatSubmits[0] . "</p>");
                }
                else
                {
                    echo("<p id='chatStyle'><span id='userName'>" . $chatSubmits[1] . "</span>: " . $chatSubmits[0] . "</p>");
                }
            }

        ?>
    </div>
    <!-- <div class="chatRoom" id="cChat"> -->
        <!--  -->
    </div>
    <div id="userArea">
        <form id="enterChat" action="chatapp.php" method="GET">
            <input type="text" name="says" id="textInput" placeholder="text here..." autofocus="autofocus">
            <select name="who" id="userID">
                <option>select user</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
            <button type="button" id="submitButton">submit</button>
        </form>
    </div>
    <script>

        var button = document.getElementById("submitButton");
        var input = document.getElementById("textInput");
        var user = document.getElementById("userID");
        var userAChat = document.getElementById("aChat");
        var userBChat = document.getElementById("bChat");
        var userCChat = document.getElementById("cChat");
        var submit = true;

        button.addEventListener("click", function()
        {
            submit = true;

            if(user.value === "select user")
            {
                submit = false;
            }
            if((user.value === "A") || (user.value === "B") || (user.value === "C"))
            {
                submit = true;
            }
            if(input.value === "")
            {
                submit = false;
            }

            if(submit === true)
            {
                enterChat.submit();
            }
        });

        input.addEventListener("keyup", function(event)
        {
            event.preventDefault();
            if(event.keyCode === 13 && submit === true)
            {
                button.click();
            }
        })

        user.addEventListener("change", function()
        {
            console.log("SUP");
            if(user.value === "select user")
            {
                userAChat.style.display="none";
                userBChat.style.display="none";
                userCChat.style.display="none";
            }
            if(user.value === "A")
            {
                userAChat.style.display="inline-block";
                userBChat.style.display="none";
                userCChat.style.display="none";
            //     console.log("got here");
            //     if(document.getElementById("userName").innerHTML === "A")
            //    {
            //         document.getElementById("chatStyle").textAlign = "center";
            //     }
            //     else
            //     {
            //         document.getElementById("chatStyle").textAlign = "right";
            //     } 

            }
            if(user.value === "B")
            {
                userAChat.style.display="none";
                userBChat.style.display="inline-block";
                userCChat.style.display="none";
            }
            if(user.value === "C")
            {
                userAChat.style.display="none";
                userBChat.style.display="none";
                userCChat.style.display="inline-block";
            }
        })



        
        
    </script>
</body>
</html>

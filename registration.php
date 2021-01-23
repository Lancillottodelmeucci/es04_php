<?php
    if(session_status()!=PHP_SESSION_ACTIVE){
        session_start();
    }
    if(isset($_SESSION['login-id'])){
        #interrogazione db
        include ("nuovo.php");
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="author" content="Giovanni Ciaranfi"/>
        <title>Scrutini</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <style>
            form{
                width: fit-content;
                margin: auto;
                background-color: #e7e7e7;
                padding: 20px;
                margin-top: 15px;
                border-radius: 5px;
                text-align: center;
                zoom: 1.2;
            }
            label{
                display: flex;
            }
            input[type=text],input[type=password]{
                border: none;
                padding: 3px;
                border-radius: 3px;
            }
            input[type=text]:focus::after{
            }
            input[type=submit]{
                margin-top: 15px;
                padding: 5px 10px;
                background-color: #cacaca;
                border: none;
                border-radius: 3px;
                transition: background-color .3s;
            }
            input[type=submit]:hover{
                background-color: #a5a5a5;
            }
        </style>
    </head>
    <body>
        <?php $page='scrutinio';include("menu.html"); ?>
        <form action="elabora.php?ref=reg" method="post">
            <label for="utente">Username: </label><input type="text" name="user" id="utente" pattern="[a-zA-Z1-5_-]{3,20}"
                placeholder="es. Username" required><br/>
            <label for="password">Password: </label><input type="password" name="psw" id="password" pattern="[a-zA-Z1-5_-]{3,20}"
                placeholder="es. Username" required><br/>
            <input type="submit" value="Accedi/Registrati" id="submit">
        </form>
    </body>
</html>
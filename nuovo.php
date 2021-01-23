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
                border-radius: 5px;
                text-align: center;
                zoom: 1.2;
            }
            input[type=text]{
                border: none;
                padding: 3px;
                border-radius: 3px;
            }
            input[type=text]:focus::after{
            }
            input[type=submit]{
                margin-top: 5px;
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
        <form action="elabora.php?ref=nuovo" method="post">
            <label for="classe">Classe: </label><input type="text" name="classe" id="classe" pattern="[a-zA-Z1-5 _-]{2,6}"
                placeholder="es. 5bia" required><br/>
            <input type="submit" value="Inizia scrutinio" id="submit">
        </form>
    </body>
</html>
<!--mettere pagina di accesso: per ogni docente mettere un set di classi tra cui scegliere per fare lo scrutinio?-->
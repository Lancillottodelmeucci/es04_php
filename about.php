<!DOCTYPE html>
<html>
    <head>
        <meta name="author" content="Giovanni Ciaranfi"/>
        <title>About</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <style>
            img{
                transform: rotateZ(0deg);
                animation: rotate 8s infinite;
                width: 100px;
            }
            @keyframes rotate{
                0%{transform: rotateZ(0deg);filter: none;}
                25%{transform: rotateZ(180deg);filter: hue-rotate(180deg);}
                50%{transform: rotateZ(360deg);filter: none;}
                75%{transform: rotateZ(180deg);filter: hue-rotate(180deg);}
                100%{transform: rotateZ(0deg);filter: none;}
            }
            p{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php $page='info';include("menu.html"); ?>
        <p>
            <img alt="" src="time.svg"/><br/>
            Nessun contenuto da visualizzare,<br/> accontentati di questa animazione<br/>
            <a href="elabora.php?ref=logout">logout</a>
        </p>
    </body>
</html>
<!--mettere pagina di accesso: per ogni docente mettere un set di classi tra cui scegliere per fare lo scrutinio?-->
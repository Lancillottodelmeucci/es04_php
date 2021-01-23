<!DOCTYPE html>
<html>
    <head>
        <meta name="author" content="Giovanni Ciaranfi"/>
        <title>Esito - <?php echo $esito; ?></title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <style>
            strong{
                text-transform: capitalize;
            }
            .opt{
                padding: 5px;
                display: table;
                text-decoration: none;
                color: black;
                border-radius: 5px;
                background-color: #e7e7e7;
                margin: 3px auto;
                vertical-align: middle;
            }
            .opt img,form img{
                width: 10px;
                margin-left: 5px;
            }
        </style>
    </head>
    <body>
        <?php $page='scrutinio';include("menu.html"); ?>
        <p><strong><?php echo $nome." ".$cognome; ?></strong> <?php echo $esito; ?></p>
        <?php if(isset($debiti)){echo $debiti;} ?>
        <a class="opt" href="elabora.php?ref=ins">Inserisci nuovi dati<img alt="" src="add.svg"/></a>
        <a class="opt" href="elabora.php?ref=termina">Termina lo scrutinio<img alt="" src="done.svg"/></a>
    </body>
</html>
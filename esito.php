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
        </style>
    </head>
    <body>
        <p><strong><?php echo $nome." ".$cognome; ?></strong> <?php echo $esito; ?></p>
        <?php if(isset($debiti)){echo $debiti;} ?>
        <a href="elabora.php?ref=ins">Inserisci nuovi dati</a><br/>
        <a href="elabora.php?ref=termina">Termina lo scrutinio</a>
    </body>
</html>
<!DOCTYPE html>
<html>
    <head>
        <meta name="author" content="Giovanni Ciaranfi"/>
        <title>Risultati provvisori</title><!--possibilità di modificare i dati-->
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <style>
            body{
                counter-reset: number;
            }
            table{
                border-spacing: 0px;
                border-collapse: collapse;
                margin: auto;
                margin-bottom: 10px;
                zoom: 1.2;
            }
            table tr td, table tr th{
                width: fit-content;
            }
            td,th{
                border: solid black 1px;
                text-align: left;
            }
            th{
                padding: 5px;
                font-size: 1.5em;
            }
            td{
                padding: 5px 3px;
                padding-right: 3px;
                font-size: 1em;
            }
            .empty-col{
                border: none;
            }
            .nominativo{
                text-transform: capitalize;
            }
            .esito{
                text-transform: capitalize;
            }
            .pos{
                background-color: lightgreen;
            }
            .neg{
                background-color: lightcoral;
            }
            .debiti{}
            .no-data{
                padding: 3px;
                background-image: url("black-line-ground.png");
            }
            .edit{
                background-image: url("edit.png");
                border: none;
                width: 20px;
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;

            }
            .num{
                text-align: right;
                min-width: 15px;
                border: none;
            }
            .num::before{
                counter-increment: number;
                content: counter(number);
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
        <table>
            <tr>
                <th scope="col" class="empty-col"></th>
                <th scope="col">Nome</th>
                <th scope="col">Cognome</th>
                <th scope="col">Esito</th>
                <th scope="col">Debiti</th>
                <th scope="col" class="empty-col"></th>
            </tr>
            <?php echo $output; ?>
        </table>
        <a class="opt" href="elabora.php?ref=ins">Inserisci nuovi dati<img alt="" src="add.svg"/></a>
        <a class="opt" href="elabora.php?ref=termina">Termina lo scrutinio<img alt="" src="done.svg"/></a>
    </body>
</html>
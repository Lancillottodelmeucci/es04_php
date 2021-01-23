<?php
    $ERR_PAGE="errore.php";
    $EXT="."."php";
    $materie=[
        'ITA'=>'Italiano',
        'MAT'=>'Matematica',
        'TEL'=>'Telecomunicazioni',
        'INF'=>'Informatica'
    ];
    session_start();
    #session_destroy();
    include ("funzioni.php");
    if(!validazioneRichiesta()){
        $error="non è stato possibile completare la richiesta.";
        include($ERR_PAGE);
        die();
    }
    $conn=mysqli_connect("127.0.0.1","root","","scrutini",3333);
    switch($_GET['ref']){
        case "reg":
            $utente=$_POST['user'];
            $psw=$_POST['psw'];
            $dati=mysqli_query($conn,"select password from credenziali where utente='$utente';");
            if(mysqli_num_rows($dati)>0){
                if(mysqli_fetch_row($dati)[0]!=$psw){
                    $error="credenziali non corrette.";
                    include($ERR_PAGE);
                    die();
                }
            }
            else{
                $dati=mysqli_query($conn,"insert into credenziali (utente,password) values('$utente','$psw');");
            }
            do {
                $int=random_int(5000,500000);#valori casuali
                $dati=mysqli_query($conn,"select * from accessi where ID_accesso='$int';");
            } while (mysqli_num_rows($dati)>0);
            $_SESSION['login-id']=$int;
            $utente=$_POST['user'];
            $dati=mysqli_query($conn,"insert into accessi (ID_accesso,utente) values('$int','$utente');");
            include("nuovo.php");
            break;
        case "ins":
            if(!isset($_SESSION['classe'])||$_SESSION['classe']==""){
                include("index.php");
            }
            else{
                include("nuovo-scrutinio.html");
            }
            break;
        case "nuovo":
            if(!preg_match("/[a-zA-Z1-5 _-]{2,6}/",$_POST['classe'])){
                $error="dati inviati non corretti";
                include($ERR_PAGE);
                die();
            }
            if(!nuovaClasse($conn)){
                $error="classe gi&agrave; inserita";
                include($ERR_PAGE);
                die();
                #si potrà modificare la classe quando ci saranno gli accessi e bla bla bla
            }
            $_SESSION['classe']=$_POST['classe'];
            include("nuovo-scrutinio.html");
            break;
        case 'esito':
            if(!isset($_SESSION['classe'])||$_SESSION['classe']==""){
                $error="nessuno scrutinio in corso.";
                include($ERR_PAGE);
                die();
            }
            if(!controlloForm()){
                $error="dati inviati non corretti";
                include($ERR_PAGE);
                die();
            }
            if(!nuovoStudente($conn)){
                $error="dati gi&agrave; inseriti";
                include($ERR_PAGE);
                die();
            }
            $nome=strtolower($_POST['name']);
            $cognome=strtolower($_POST['surname']);
            $sesso=strtolower($_POST['sex']);
            $classe=strtolower($_SESSION['classe']);
            $pron=$sesso=='m'?"o":"a";
            $esito=isset($_POST['debs'])?(count($_POST['debs'])>2?
                "non &egrave; stat$pron ammess$pron":" &egrave; stat$pron ammess$pron"):" &egrave; stat$pron ammess$pron";
            $dati=mysqli_query($conn,"insert into studenti (nome,cognome,classe,sesso)
                values ('$nome','$cognome','$classe','$sesso');");
            if(isset($_POST['debs'])){
                for($i=0;$i<count($_POST['debs']);$i++){
                    $dati=mysqli_query($conn,"insert into debiti (id_studente,materia) values(
                        (select ID_studente from studenti where nome='$nome' and cognome='$cognome' and classe='$classe'),
                        '".$_POST['debs'][$i]."');");
                }
            }
            mysqli_close($conn);
            include("esito".$EXT);
            break;
        case "risultati":
            if(!isset($_SESSION['classe'])||$_SESSION['classe']==""){
                $error="nessuno scrutinio in corso.";
                include($ERR_PAGE);
                die();
            }
            $output=getTabellone($conn,"ris");
            mysqli_close($conn);
            include("risultati.php");
            break;
        case "termina":
            if(!isset($_SESSION['classe'])){
                $error="nessuno scrutinio in corso.";
                include($ERR_PAGE);
                die();
            }
            $output=getTabellone($conn);
            mysqli_close($conn);
            include("termina.html");
            unset($_SESSION['classe']);
            break;
        case "logout":
            session_destroy();
            include("index.php");
            break;
        default:
        $error="elaborazione non riuscita";
            include($ERR_PAGE);
            break;
    }
?>
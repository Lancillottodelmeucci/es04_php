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
    if(!validazioneRichiesta()){
        $error="non è stato possibile completare la richiesta.";
        include($ERR_PAGE);
        die();
    }
    switch($_GET['ref']){
        case "ins":
            if(!isset($_SESSION['classe'])||$_SESSION['classe']==""){
                include("index.html");
            }
            else{
                include("nuovo-scrutinio.html");
            }
            break;
        case "nuovo":
            if(!nuovaClasse()){
                $error="classe gi&agrave; inserita";
                include($ERR_PAGE);
                die();
            }
            $_SESSION['classe']=$_POST['classe'];
            include("nuovo-scrutinio.html");
            break;
        case 'esito':
            if(!controlloForm()){
                $error="dati inviati non corretti";
                include($ERR_PAGE);
                die();
            }
            if(!nuovoStudente()){
                $error="dati gi&agrave; inseriti";
                include($ERR_PAGE);
                die();
            }
            $nominativo=strtolower($_POST['name']);
            $pron=strtoupper($_POST['sex'])=='M'?"o":"a";
            $_SESSION['studenti'][]=strtolower($nominativo).".".
                strtolower($_POST['sex']).".".
                strtolower(isset($_POST['debs'])?(count($_POST['debs'])>2?"non ammess$pron":"ammess$pron"):"ammess$pron").
                strtoupper(isset($_POST['debs'])?".".join("-",$_POST['debs']):"");
            #echo "".join("-",$_SESSION['studenti']);
            $esito=isset($_POST['debs'])?(count($_POST['debs'])>2?
                "non &egrave; stat$pron ammess$pron":" &egrave; stat$pron ammess$pron"):" &egrave; stat$pron ammess$pron";
            include("esito".$EXT);
            break;
        case "risultati":
            if(isset($_SESSION['studenti'])){
                if(count($_SESSION['studenti'])<1){
                    $studenti="<tr><td class='empty-col'></td><td class='no-data'
                     colspan='3'>Nessun dato refistrato.</td></tr>";
                }
                else{
                    $dati=$_SESSION['studenti'];
                    $studenti="";
                    for($i=0;$i<count($dati);$i++){
                        $studente=explode(".",$dati[$i]);
                        $row="<tr><td class='num'></td><td class='nominativo'>".$studente[0]."</td>
                            <td class='esito ".(substr($studente[2],0,3)=="non"?"neg":"pos")."'>".$studente[2]."</td>";
                        if(isset($studente[3])){
                            $debiti=explode("-",$studente[3]);
                            $row=$row."<td class='debiti'>";
                            for ($j=0; $j < count($debiti); $j++) { 
                                $mat=$debiti[$j];
                                #echo "".join("-",$debiti);
                                $row=$row.$materie[$mat];
                                if($j<count($debiti)-1){
                                    $row=$row.", ";
                                }
                            }
                            $row=$row."</td>";
                        }
                        else{
                            $row=$row."<td class='no-data'></td>";
                        }
                        $row=$row."<td class='edit'></td></tr>";
                        $studenti=$studenti.$row;
                    }
                }
            }
            else{
                $studenti="<tr><td class='empty-col'></td><td
                 colspan='3'>Nessun dato registrato.</td></tr>";
            }
            include("risultati.php");
            break;
        case "termina":
            if(isset($_SESSION['studenti'])){
                if(count($_SESSION['studenti'])<1){
                    $studenti="<tr><td class='empty-col'></td><td class='no-data'
                     colspan='3'>Nessun dato refistrato.</td></tr>";
                }
                else{
                    $dati=$_SESSION['studenti'];
                    $studenti="";
                    for($i=0;$i<count($dati);$i++){
                        $studente=explode(".",$dati[$i]);
                        $row="<tr><td></td><td>".$studente[0]."</td><td>".$studente[2]."</td>";
                        if(isset($studente[3])){
                            $debiti=explode("-",$studente[3]);
                            $row=$row."<td>";
                            for ($j=0; $j < count($debiti); $j++) { 
                                $mat=$debiti[$j];
                                #echo "".join("-",$debiti);
                                $row=$row.$materie[$mat];
                                if($j<count($debiti)-1){
                                    $row=$row.", ";
                                }
                            }
                            $row=$row."</td>";
                        }
                        else{
                            $row=$row."<td></td>";
                        }
                        $row=$row."</tr>";
                        $studenti=$studenti.$row;
                    }
                }
            }
            else{
                $studenti="<tr><td class='empty-col'></td><td
                 colspan='3'>Nessun dato registrato.</td></tr>";
            }
            include("termina.html");
            if (isset($_SESSION['studenti'])) {
                salvaScrutinio($_SESSION['classe']);
            }
            session_destroy();
            break;
        default:
        $error="elaborazione non riuscita";
            include($ERR_PAGE);
            break;
    }
    function salvaScrutinio($n){
        $file=fopen("scrutini/$n","w");
        for ($i=0; $i < count($_SESSION['studenti']); $i++) { 
            fwrite($file,$_SESSION['studenti'][$i]."\n");
        }
        fclose($file);
    }
    function nuovaClasse(){
        return true;
    }
    function nuovoStudente(){
        $s=0;$s++;
        return true;
    }
    function controlloForm(){
        if(!isset($_POST['name'])||!isset($_POST['sex'])){
            return false;
        }
        return true;
    }
    function validazioneRichiesta(){
        if(!isset($_GET['ref'])){
            return false;
        }
        $ref=$_GET['ref'];
        if($ref!='esito'&&$ref!='risultati'&&$ref!='termina'&&$ref!='nuovo'&&$ref!='ins'){
            return false;
        }
        return true;
    }
?>
<?php
    function getTabellone($conn,$mod=null){
        $dati=mysqli_query($conn,"select nome, cognome, sesso from studenti where classe='".$_SESSION['classe']."'
                order by cognome, nome;");
        $output="";
        if(mysqli_num_rows($dati)>0){
            $num_rows=mysqli_num_rows($dati);
            $studenti=$dati;
            for($r=0;$r<$num_rows;$r++){
                $studente=mysqli_fetch_row($studenti);
                $studente=array("nome"=>$studente[0],"cognome"=>$studente[1],"sesso"=>$studente[2]);
                $row="<tr><td class='num'></td><td class='nome'>".$studente['nome']."</td><td class='cognome'>".$studente['cognome']."</td>";
                $dati=mysqli_query($conn,"select materia from debiti where id_studente=(
                    select ID_studente from studenti where nome='".$studente['nome']."' and cognome='".$studente['cognome']."' and
                    classe='".$_SESSION['classe']."') order by materia;");
                $debiti=$dati;
                if(mysqli_num_rows($debiti)>0){
                    if(mysqli_num_rows($debiti)>2){
                        $row=$row."<td class='esito neg'>non ammess".($studente['sesso']=='m'?"o":"a")."</td><td class='debiti'>";
                    }
                    else{
                        $row=$row."<td class='esito pos'>ammess".($studente['sesso']=='m'?"o":"a")."</td><td class='debiti'>";
                    }
                    $num_debiti=mysqli_num_rows($debiti);
                    for($i=0;$i<$num_debiti;$i++){
                        $debito=mysqli_fetch_row($debiti);
                        $row=$row.$debito[0];
                        if($i!=$num_debiti-1){
                            $row=$row.", ";
                        }
                    }
                    $row=$row."</td>";
                }
                else{
                    $row=$row."<td class='esito pos'>ammess".($studente['sesso']=='m'?"o":"a")."</td><td class='no-data'></td>";
                }
                if($mod=='ris'){
                    $row=$row."<td class='edit'></td></tr>";
                }
                $output=$output.$row;
            }
        }
        else{
            $output="<tr><td class='empty-col'></td><td colspan='4'>Nessun dato registrato.</td></tr>";
        }
        return($output);
    }
    function nuovaClasse($conn){
        $dati=mysqli_query($conn,"select ID_studente from studenti where classe='".$_POST['classe']."' limit 1");
        if(mysqli_num_rows($dati)>0){
            return false;
        }
        return true;
    }
    function nuovoStudente($conn){
        $dati=mysqli_query($conn,"select ID_studente from studenti where nome='".$_POST['name']."' and cognome=
            '".$_POST['surname']."' and classe='".$_SESSION['classe']."';");
        echo " arriva qui: ".join(" - ",mysqli_fetch_row($dati));
        if(mysqli_num_rows($dati)>0){
            return false;
        }
        return true;
    }
    function controlloForm(){
        echo "".join("; ",$_POST);
        if(!isset($_POST['name'])||!isset($_POST['surname'])||!isset($_POST['sex'])){
            return false;
        }
        if(isset($_POST['debs'])){
            foreach ($_POST['debs'] as $deb) {
                switch(strtolower($deb)){
                    case 'ita':
                    case 'mat':
                    case 'tel':
                    case 'inf':
                        break;
                    default:
                        return false;
                        break;
                }
            }
        }
        $word_pat="/[a-zA-Z ]{2,60}/";
        if(!preg_match($word_pat,$_POST['name'])||!preg_match($word_pat,$_POST['surname'])||!preg_match("/[mf]{1}/i",$_POST['sex'])){
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
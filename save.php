<?php 
    if(isset($_POST['action'])) {
        $userid = $_POST['userid'];
        $fileName="./files/" . $userid . ".py";

        if ($_POST['action'] == 'read') {
            if (file_exists($fileName)) {
                echo file_get_contents($fileName);
            }
        } else if ($_POST['action'] == 'write') {
            if( isset($_POST['data'])) {
                $myfile = fopen($fileName, "w") or die("Errore nell'apertura del file!");
                $txt = $_POST['data'];
                fwrite($myfile, $txt);
                fclose($myfile);
                echo "File salvato con successo!";
            }
        }
    }
?>
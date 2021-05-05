<?php
    $fileid = $_GET['fileid'];

    $fileName="./files/" . $fileid . ".py";

    $fileSize = filesize($fileName);

    header("Content-type: Application/octet-stream");
    header("Content-Disposition: attachment; filename=$fileName");
    header("Content-Description: Your PyBox code file");
    header("Content-Length: $fileSize");
    readfile($fileName);
?>
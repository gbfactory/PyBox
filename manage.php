<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

// User vars
$username = $_SESSION['username'];
$fileid = $_SESSION['fileid'];
$classroom = $_SESSION['classroom'];
$classroomowned = $_SESSION['classroomowned'];

if (isset($_GET['classroom'])) {
    $getClassroom = $_GET['classroom'];

    if ($getClassroom != $classroomowned) {
        header("Location: welcome.php");
    }

} else {
    header("Location: welcome.php");
}

include('navbar.php');

include('database.php');

// Get users
$sql = "SELECT * FROM users WHERE classroom = '$getClassroom'";
$result = mysqli_query($db, $sql);

// $count = mysqli_num_rows($result);
// echo($count);

function niceNickname($testo) {
    $userSplit = explode('_', $testo);
    $niceUsername = ucfirst($userSplit[0]) . ' ' . ucfirst($userSplit[1]);
    return $niceUsername;
}

?>

<div class="container page-wrapper">
    <div class="columns is-desktop">
        <div class="column">
            <h3 class="title is-3">📚 Utenti</h3>
            <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                <button id="<?= $row['fileid'] ?>" class="button is-warning user-card" onclick="readDataAjax('<?= $row['fileid'] ?>', '<?= niceNickname($row['username']) ?>')">
                    <p class="subtitle"><span id="selected"></span> <?= niceNickname($row['username']) ?></p>
                </button>
            <?php } ?>
        </div>
        <div class="column is-four-fifths">
            <h3 class="title is-3">👀 Viewing code of: <span id="username"></span></h3>
            <div id="manageEditor"></div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- Codemirror -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/mode/python/python.min.js"></script>

<script>
    let codeEditor = CodeMirror(document.querySelector('#manageEditor'), {
        lineNumbers: true,
        lineWrapping: true,
        tabSize: 2,
        mode: 'python',
        theme: 'ayu-mirage',
        readOnly: true
    });

    function readDataAjax(userFile, userName) {
        let xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                codeEditor.setValue(xmlhttp.responseText)
            }
        }

        xmlhttp.open("POST", 'save.php', true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("action=read&userid=" + userFile);

        // aggiorna titolo
        $('#username').html(userName);
    }
</script>

<?php include('footer.php'); ?>

</body>

</html>
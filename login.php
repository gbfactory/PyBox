<?php
    session_start();

    include('navbar.php');

    if (isset($_SESSION['username'])) {
        echo '<script type="text/javascript">window.location = "welcome.php"</script>';
    }
?>

<div class="container page-wrapper" style="max-width: 350px">
    <img src="./assets/img/pyboxlogo.png" alt="">

    <form action="" method="POST">
        <div class="field">
            <label class="label">Nome utente</label>
            <div class="control">
                <input class="input" id="username" name="username" type="text" placeholder="Inserisci il nome utente" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" id="password" name="password" type="password" placeholder="Inserisci la password" required>
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button type="submit" name="login" class="button is-link">Login</button>
            </div>
        </div>
    </form>

    <?php
        // Database
        include('database.php');

        $error = "";

        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $safeUsername = mysqli_real_escape_string($db, $username);
            $safePassword = mysqli_real_escape_string($db, $password);

            $sql = "SELECT * FROM users WHERE username = '$safeUsername' and password = '$safePassword'";
            $result = mysqli_query($db, $sql);

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $count = mysqli_num_rows($result);

            if ($count == 1) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['fileid'] = $row['fileid'];
                $_SESSION['classroom'] = $row['classroom'];
                $_SESSION['classroomowned'] = $row['classroomowned'];

                echo '<script type="text/javascript">window.location = "welcome.php"</script>';
            } else {
                $error = "<div class=\"notification is-danger\">Accesso fallito!</div>";
            }
        }

        echo $error;
    ?>
</div>

<?php include('footer.php'); ?>

</body>

</html>
<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
    }

    include('navbar.php');

    $username = $_SESSION['username'];
    $fileid = $_SESSION['fileid'];
    $classroom = $_SESSION['classroom'];
    $classroomowned = $_SESSION['classroomowned'];

    $userSplit = explode('_', $username);
    $niceUsername = ucfirst($userSplit[0]) . ' ' . ucfirst($userSplit[1]);
?>

<div class="page-wrapper">
    <section class="hero is-warning">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Welcome to PyBox 👋
                </h1>
                <h2 class="subtitle">
                    <?= $niceUsername ?>
                </h2>
            </div>
        </div>
    </section>

    <div class="container">
        <a href="index.php">
            <section class="hero is-link" style="margin-top: 2rem; border-radius: 8px">
                <div class="hero-body">
                    <div class="container">
                        <h1 class="title">
                            👨‍💻 Python Editor
                        </h1>
                        <h2 class="subtitle">
                            Go to the Python Editor and start coding!
                        </h2>
                    </div>
                </div>
            </section>
        </a>

        <?php if ($classroom == $classroomowned) { echo('<a href="manage.php?classroom=' . $classroomowned . '">'); } ?>
            <section class="hero is-danger" style="margin-top: 2rem; border-radius: 8px">
                <div class="hero-body">
                    <div class="container">
                        <h1 class="title">
                            👩‍🏫 Classroom
                        </h1>
                        <h2 class="subtitle">
                            <?php
                                if ($classroom != "") {
                                    echo ("You are part of the classroom <strong>" . $classroom . "</strong>.");
                                    if ($classroom == $classroomowned) {
                                        echo (" You can manage this classroom.");
                                    }
                                } else {
                                    echo ("You are not part of a classroom.");
                                }
                            ?>
                        </h2>
                    </div>
                </div>
            </section>
        <?php if ($classroom == $classroomowned) { echo('</a>'); } ?>
    </div>
</div>

<?php include('footer.php'); ?>
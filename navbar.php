<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PyBox</title>

    <!-- Materialize CSS -->
    <link rel="stylesheet" href="./static/bulma/bulmaswatch.min.css">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.css">
    </link>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/theme/ayu-mirage.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/style.css">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="./assets/img/pyboxlogo_new.png" />
</head>

<body>
    <nav id="navbar" class="bd-navbar navbar has-shadow is-spaced">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="./index.php">
                    <img src="./assets/img/pyboxlogo.png" alt="PyBox: Code with Python, from your browser!" height="28" width="auto">
                </a>

                <div id="navbarBurger" class="navbar-burger burger" data-target="navMenuDocumentation">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div id="navMenuDocumentation" class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item pb-nav-editor" href="./index.php">
                        <span class="icon has-text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M24 10.935v2.131l-8 3.947v-2.23l5.64-2.783-5.64-2.79v-2.223l8 3.948zm-16 3.848l-5.64-2.783 5.64-2.79v-2.223l-8 3.948v2.131l8 3.947v-2.23zm7.047-10.783h-2.078l-4.011 16h2.073l4.016-16z" />
                            </svg>
                        </span>
                        <span>Python Editor</span>
                    </a>

                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="field is-grouped is-grouped-multiline">

                            <?php if (isset($_SESSION['username'])) { ?>
                                <p class="control">
                                    <a class="button is-primary" href="./welcome.php">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path d="M24 13.616v-3.232c-1.651-.587-2.694-.752-3.219-2.019v-.001c-.527-1.271.1-2.134.847-3.707l-2.285-2.285c-1.561.742-2.433 1.375-3.707.847h-.001c-1.269-.526-1.435-1.576-2.019-3.219h-3.232c-.582 1.635-.749 2.692-2.019 3.219h-.001c-1.271.528-2.132-.098-3.707-.847l-2.285 2.285c.745 1.568 1.375 2.434.847 3.707-.527 1.271-1.584 1.438-3.219 2.02v3.232c1.632.58 2.692.749 3.219 2.019.53 1.282-.114 2.166-.847 3.707l2.285 2.286c1.562-.743 2.434-1.375 3.707-.847h.001c1.27.526 1.436 1.579 2.019 3.219h3.232c.582-1.636.75-2.69 2.027-3.222h.001c1.262-.524 2.12.101 3.698.851l2.285-2.286c-.744-1.563-1.375-2.433-.848-3.706.527-1.271 1.588-1.44 3.221-2.021zm-12 2.384c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4z" />
                                            </svg>
                                        </span>
                                        <strong>Dashboard</strong>
                                    </a>
                                </p>

                                <p class="control">
                                    <a class="button is-primary" href="./logout.php">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path d="M16 9v-4l8 7-8 7v-4h-8v-6h8zm-2 10v-.083c-1.178.685-2.542 1.083-4 1.083-4.411 0-8-3.589-8-8s3.589-8 8-8c1.458 0 2.822.398 4 1.083v-2.245c-1.226-.536-2.577-.838-4-.838-5.522 0-10 4.477-10 10s4.478 10 10 10c1.423 0 2.774-.302 4-.838v-2.162z" />
                                            </svg>
                                        </span>
                                        <strong>Logout</strong>
                                    </a>
                                </p>
                            <?php } else { ?>
                                <p class="control">
                                    <a class="button is-primary" href="./login.php">
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path d="M12.451 17.337l-2.451 2.663h-2v2h-2v2h-6v-5l6.865-6.949c1.08 2.424 3.095 4.336 5.586 5.286zm11.549-9.337c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-3-3c0-1.104-.896-2-2-2s-2 .896-2 2 .896 2 2 2 2-.896 2-2z" />
                                            </svg>
                                        </span>
                                        <strong>Login</strong>
                                    </a>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
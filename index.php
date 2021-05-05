<?php
session_start();

include('navbar.php');

if (isset($_SESSION['username'])) {
    echo '<script type="text/javascript">window.location = "editor.php"</script>';
}
?>

<div class="container page-wrapper">

    <div class="columns is-desktop">
        <div class="column">
            <h3 class="title is-3">Code Editor</h3>

            <form method="post">
                <div class="button-bar code">
                    <button type="button" class="button is-success" id="pyRun">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M3 22v-20l18 10-18 10z" />
                        </svg>
                    </button>
                    <button type="button" class="button is-danger" id="pyStop">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M2 2h20v20h-20z" />
                        </svg>
                    </button>
                    <a type="button" class="button is-warning" id="codeDownload">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M16 11h5l-9 10-9-10h5v-11h8v11zm3 8v3h-14v-3h-2v5h18v-5h-2z" />
                        </svg>
                    </a>
                </div>
                <textarea id="editor"></textarea>
            </form>

        </div>
        <div class="column">
            <h3 class="title is-3">Output</h3>
            <div class="button-bar output">
                <button type="button" class="button is-danger" id="outputClear">
                    <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                        <path d="M5.662 23l-5.369-5.365c-.195-.195-.293-.45-.293-.707 0-.256.098-.512.293-.707l14.929-14.928c.195-.194.451-.293.707-.293.255 0 .512.099.707.293l7.071 7.073c.196.195.293.451.293.708 0 .256-.097.511-.293.707l-11.216 11.219h5.514v2h-12.343zm3.657-2l-5.486-5.486-1.419 1.414 4.076 4.072h2.829zm6.605-17.581l-10.677 10.68 5.658 5.659 10.676-10.682-5.657-5.657z" />
                    </svg>
                </button>
                <button type="button" class="button is-link is-primary" id="trtAnimate" data-status="on">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M18 13.45l2-2.023v4.573h-2v-2.55zm-11-5.45h1.743l1.978-2h-3.721v2zm1.361 3.216l11.103-11.216 4.536 4.534-11.102 11.218-5.898 1.248 1.361-5.784zm1.306 3.176l2.23-.472 9.281-9.378-1.707-1.707-9.293 9.388-.511 2.169zm3.333 7.608v-2h-6v2h6zm-8-2h-3v-2h-2v4h5v-2zm13-2v2h-3v2h5v-4h-2zm-18-2h2v-4h-2v4zm2-6v-2h3v-2h-5v4h2z" />
                    </svg>
                </button>
                <a type="button" class="button is-warning" id="trtDownload">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M5 8.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5zm9 .5l-2.519 4-2.481-1.96-4 5.96h14l-5-8zm8-4v14h-20v-14h20zm2-2h-24v18h24v-18z" />
                    </svg>
                </a>
            </div>

            <div class="console-container">
                <div id="console"></div>
            </div>

            <div class="canvas-container">
                <div id="canvas"></div>
            </div>

        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.7.1.min.js"></script> -->
<!-- Jq Console -->
<script src="./static/jqconsole/jqconsole.js"></script>
<!-- Codemirror -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/mode/python/python.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.56.0/addon/edit/closebrackets.min.js" integrity="sha512-SS70d62R68X0qaUE9PPzc0+zXNvJzg11XpniHKLv46GS7SN99iboTRgc9f/guIFFh7d4ehoPi7iQJIojIQeJnQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.56.0/addon/selection/active-line.min.js" integrity="sha512-ysQeDEwbdvERZqZCqFd64rVjSx4ExrC/r581h40cMF4e6rFWS6VxvdVxmSf/cLr+oe9mVxxzWSMhPJYSFyiVew==" crossorigin="anonymous"></script>
<!-- Skulpt -->
<script src="./static/skulpt/skulpt.min.js" type="text/javascript"></script>
<script src="./static/skulpt/skulpt-stdlib.js" type="text/javascript"></script>
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous"></script>
<!-- Custom JS -->
<script src="./assets/script.js"></script>

<!-- Python -->
<script>
    $(document).ready(function() {
        // Nuovo PyBox
        let pb = new PyBox({
            codeSourceId: 'editor',
            // codeDisplayId: 'output',
            jqConsole: 'console',
            turtleCanvasId: 'canvas',
            codeMirrorId: 'mirror',
            // logToConsole: false,
        });

        // Carica il codice dal local storage, se presente
        let storageCode = window.localStorage.getItem('code') ? window.localStorage.getItem('code') : '';
        pb.getEditor().setValue(storageCode);

        // Salva il codice nel local storage
        pb.getEditor().on('change', function() {
            let code = $('#mirror').val();
            window.localStorage.setItem('code', code);
        });

        // Bottone esecuzione codice
        $('#pyRun').click(function() {
            pb.runPython();
        })

        // Bottone stop esecuzione
        $('#pyStop').click(function() {
            pb.stopPython();
        })

        // Bottone pulisci output
        $('#outputClear').click(function() {
            pb.clearOutput();
            pb.killTurtle();
        })

        // Bottone animazione
        $('#trtAnimate').click(function() {
            let dataStatus = $(this).data('status');

            if (dataStatus == 'on') {
                pb.animate(false);
                $(this).data('status', 'off');
                $(this).removeClass('is-link');
            } else if (dataStatus == 'off') {
                pb.animate(true);
                $(this).data('status', 'on')
                $(this).addClass('is-link');
            }
        })

        // Bottone download codice
        $('#codeDownload').click(function() {
            pb.downloadCode();
        })

        // Bottone download immagine
        $('#trtDownload').click(function() {
            pb.downloadTurtle();
        })

    });
</script>

<?php include('footer.php'); ?>

</body>

</html>
class PyBox {
    // Costruttore
    constructor(options) {
        this.source = $('#' + options.codeSourceId);
        // this.display = $('#' + options.codeDisplayId);
        this.jsconsole = $('#' + options.jqConsole);
        this.turtle = $('#' + options.turtleCanvasId);
        // this.logToConsole = options.logToConsole ? options.logToConsole : false;
        this.theme = options.theme ? options.theme : 'ayu-mirage';
        this.lineNumbers = options.lineNumbers ? options.lineNumbers : true;
        this.mirrorId = options.codeMirrorId ? options.codeMirrorId : 'mirror';
        this.animateTurtle = options.animateTurtle ? options.animateTurtle : true;
        this.mirror = '';
        this.fancyEditor = '';
        this.fancyConsole = '';
        this.defaultTimeLimit = Sk.execLimit;
        this.setupMirror();
        this.setupEditor();
        this.setupConsole();
        this.setupTurtleCanvas();
    }

    // Python : turtle : kill turtle
    killTurtle() {
        if (typeof Sk.TurtleGraphics.reset === "function") {
            Sk.TurtleGraphics.reset();
        }
    }

    // Python : output : clear output
    clearOutput() {
        // this.display.html('');
        this.fancyConsole.Reset();
        toastr.error('Output cleared');
    }

    // CodeMirror : get editor
    getEditor() {
        return this.fancyEditor;
    }

    // Python : turtle : setup turtle canvas
    setupTurtleCanvas() {
        (Sk.TurtleGraphics || (Sk.TurtleGraphics = {
            width: this.turtle.width(),
            height: this.turtle.height(),
            animate: this.animateTurtle
        })).target = this.turtle.prop('id');
    }

    // Python : turtle : animazione turtle
    animate(bool) {
        this.animateTurtle = bool;
        Sk.TurtleGraphics.animate = this.animateTurtle;

        if (bool) {
            toastr.success('Turtle animations turned on');
        } else {
            toastr.error('Turtle animations turned off');
        }
    }

    // Python : turtle : velocità turtle
    speed(speed) {
        Sk.TurtleGraphics.speed = speed;
    }

    // CodeMirror : setup mirror textarea
    setupMirror() {
        this.source.clone().prop('id', this.mirrorId).prop('name', this.mirrorId).addClass('hidden').appendTo(this.source.parent());
        this.mirror = $('#' + this.mirrorId);
    }

    // CodeMirror : setup main editor
    setupEditor() {
        this.fancyEditor = CodeMirror.fromTextArea(this.source.get(0), {
            mode: 'python',
            theme: this.theme,
            lineWrapping: true,
            lineNumbers: this.lineNumbers,
            tabSize: 2,
            autofocus: true,
            autoCloseBrackets: true,
            styleActiveLine: true,
        });
        let mirrorObj = this.mirror;
        this.fancyEditor.on('change', function (instance, obj) {
            mirrorObj.html(instance.getValue());
        });
    }

    setupConsole() {
        this.fancyConsole = (this.jsconsole).jqconsole('', '');
    }

    // Download code to file
    downloadCode() {
        let data = $('#' + this.mirrorId).val();

        if (!data || data.length === 0) {
            toastr.error('No code to download!');
        } else {
            $('#codeDownload').attr({
                'download': 'code.py',
                'href': 'data:text/plain;charset=UTF-8,' + encodeURIComponent(data)
            })

            toastr.success('Code downloaded!');
        }
    }

    // Download turtle canvas image to file
    downloadTurtle() {
        let canvas = $('#canvas').find('canvas');
        let numCanv = canvas.length;

        if (canvas.get(1)) {
            $('#trtDownload').attr({
                'download': 'turtle.png',
                'href': canvas.get(numCanv - 1).toDataURL('image/png')
            })

            toastr.success('Turlet image downloaded!');
        } else {
            toastr.error('No image to download!');
        }
    }

    // Python : run
    runPython() {
        Sk.execLimit = this.defaultTimeLimit;
        let psObj = this;
        let code = this.mirror.val();
        // let out = this.display;

        if (code == '' || code == ' ') {
            return toastr.error('No code to run!');
        }

        toastr.info('Running code');

        this.fancyConsole.Reset();

        // out.html('');
        // Sk.pre = out.prop('id'); // set the ID of the output area for Skulpt
        Sk.configure({
            output: function (txt) { psObj.handleOutput(txt); },
            read: function (f) { return psObj.readBuiltInFile(f); },
            killableWhile: true,
            killableFor: true,
            inputfun: pyboxInput,
            inputfunTakesPrompt: true
        });
        // (Sk.TurtleGraphics || (Sk.TurtleGraphics = {width:0,height:0})).target = this.turtle.prop('id');
        let myPromise = Sk.misceval.asyncToPromise(function () {
            return Sk.importMainWithBody("<stdin>", false, code, true);
            return skulptObj.importMainWithBody("<stdin>", false, code, true);
        });
        myPromise.then(function (mod) {
            // if (psObj.logToConsole)
            //     console.log('success');
        }, function (err) {
            psObj.handleError(err.toString());
            // if (psObj.logToConsole)
            //     console.log(err.toString());
        });

        // Funzione inserimento input con custom jqconsole
        function pyboxInput(prompt) {
            return new Promise((resolte, reject) => {
                psObj.fancyConsole.Write(prompt)
                psObj.fancyConsole.Input(function (input) {
                    resolte(input);
                })
            })
        }

    }

    // Python : run : file
    readBuiltInFile(f) {
        if (Sk.builtinFiles === undefined || Sk.builtinFiles["files"][f] === undefined)
            throw "File not found: '" + f + "'";
        return Sk.builtinFiles["files"][f];
    }

    // Python : run : output
    handleOutput(txt) {
        // this.display.append(txt);
        this.fancyConsole.Write(txt);
    }

    // Python : run : error
    handleError(txt) {
        if (this.errorHandler) {
            this.errorHandler(txt);
        } else {
            this.fancyConsole.Write(txt, 'has-text-danger');
            // this.display.append('<p class="has-text-danger">' + txt + '</p>');
            toastr.error('Error. Check your output.');
        }
    }

    // Python : stop
    stopPython() {
        Sk.execLimit = 1;
        Sk.timeoutMsg = function () {
            Sk.execLimit = this.defaultTimeLimit;
            // console.log('stop');
            toastr.error('Code stopped!');
            return "Code stopped";
        }
    }

}
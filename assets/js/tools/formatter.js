const cf = $('#formatter-code-format');
const ci = $('#formatter-code-input');
const st = $('#snippet-title');

const cm = CodeMirror.fromTextArea(ci.get(0), {
    styleActiveLine: true,
    styleSelectedText: true,
    showTrailingSpace: true,
    ...cmOptions
});

const cms = [cm];

const params = parsePath(window.location.pathname);

if (params[2]) {
    const lines = params[2].split('-')
    lines[0] = lines[0] - 1;
    lines[1] = lines[1] ? lines[1] - 1 : lines[0];
    
    if (lines[0] <= lines[1]) {
        for (let l = lines[0]; l <= lines[1]; l++) {
            cm.addLineClass(l, 'text', 'highlighted');
        }   
    }
}

let delay = null;
cm.on('optionChange', function (cm, option) {
    if (option === 'mode') {
        clearTimeout(delay);
        delay = setTimeout(function () {
            cm.setOption('lint', cm.getOption(option) === 'application/json');
        }, 1000);
    }
});

cm.on('changes', function (cm, change) {
    if (!cm.doc.isClean()) {
        st.removeAttr('readonly');
    } else {
        st.attr('readonly', true);
    }
});

cf.on('change', function () {    
    if ($(this).val() == 'json') {        
        $('#function-cleanup').removeAttr('disabled');
    } else {
        $('#function-cleanup').attr('disabled', 'disabled');
    }
    
    let mode = selectToCMMode($(this).val());

    CodeMirror.autoLoadMode(cm, mode, {
        path: selectToAutoMode
    });
    cm.setOption('mode', mode);
});

$('#function-auto-format').on('click', function () {
    switch (cf.val()) {
        // case 'json':
        //     cm.setValue(jsonBeautify(cm.getValue()));
        //     break;
        default:
            const btn = $(this);
            setButtonBusy(btn);
            const snippet = cm.getValue();
            if (snippet) {
                ajax('/autoformat.php',
                    {
                        snippet: snippet,
                        format: cf.val()
                    },
                    function (response) {
                        cm.setValue(response.snippet);
                    },
                    handleAjaxError,
                    function () {
                        setButtonReady(btn);
                    }
                );
            }
            break;
    }
});

$('#function-share').on('click', function () {
    const btn = $(this);
    setButtonBusy(btn);
    ajax('/share.php',
        {
            left: cm.getValue(),
            tool: 'formatter',
            title: st.val(),
            format: cf.val()
        },
        function (response) {
            window.history.pushState({}, '', '/f/' + response.hash);
            for (const cm of cms) {
                cm.doc.markClean();
            }
            showToast('<i class="bi bi-hand-thumbs-up-fill"></i> Copy & paste current URL to share snippet', 'bg-success');
            st.attr('readonly', true);
            setTitle(st.val());
        },
        handleAjaxError,
        function () {
            setButtonReady(btn);
        }
    );
});

$('#function-word-wrap').on('click', function () {
    cm.setOption('lineWrapping', !cm.getOption('lineWrapping'));
});

$('#function-diff').on('click', function () {
    const params = parsePath(window.location.pathname);
    params[0] = 'd';
    if (params[1]) {
        window.location.href = '/' + params.join('/');    
    } else {
        showToast('<i class="bi bi-share"></i> Share snippet first');
    }
});

$('#function-n-to-newline').on('click', function () {
    const origText = cm.getValue();    
    const changedText = origText.replace(/(\\r)?\\n/g, "\n");
    cm.setValue(changedText);
});

$('#function-cleanup').on('click', function () {    
    const origText = cm.getValue();
    let changedText = origText;
    switch (cf.val()) {
        case 'json':
            changedText = origText.replace(/\\t/g, '').replace(/\\"/g, '"');
            break;
    }
    cm.setValue(changedText);
});

if (activeSnippetFormat) {
    cf.val(activeSnippetFormat).trigger('change');
} else {
    cf.val('json').trigger('change');
}

if (st.val()) {
    setTitle(st.val());
}
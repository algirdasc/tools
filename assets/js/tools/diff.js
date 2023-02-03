const df = $('#diff-code-format');
const dt = $('#diff-text');

const cm = CodeMirror.MergeView(dt.get(0), {
    value: $('#snippet-left').text(),
    allowEditingOriginals: true,
    orig: $('#snippet-right').text(),
    lineNumbers: true,
    connect: 'align',
    collapseIdentical: true,
    ...cmOptions
});

const cms = [
    $('.CodeMirror').first().get(0).CodeMirror,
    $('.CodeMirror').last().get(0).CodeMirror,
];

function setOptions(option, value) {
    $('.CodeMirror').each(function () {
        $(this).get(0).CodeMirror.setOption(option, value);
    });
}

function autoLoadMode(mode) {
    $('.CodeMirror').each(function () {
        CodeMirror.autoLoadMode($(this).get(0).CodeMirror, mode, {
            path: selectToAutoMode
        })
    });
}

function resize() {
    const height = dt.height();

    cm.editor().setSize(null, height);
    if (cm.rightOriginal()) {
        cm.rightOriginal().setSize(null, height);
    }
}

df.on('change', function () {
    let mode = selectToCMMode($(this).val());

    autoLoadMode(mode);
    setOptions('mode', mode);
});

$('#function-share').on('click', function () {
    const snippetLeft = $('.CodeMirror').first().get(0).CodeMirror.getValue();
    const snippetRight = $('.CodeMirror').last().get(0).CodeMirror.getValue();

    const btn = $(this);
    setButtonBusy(btn);
    ajax('/share.php', 
        { 
            left: snippetLeft, 
            right: snippetRight, 
            tool: 'diff', 
            format: df.val() 
        }, 
        function (response) {        
            window.history.pushState({}, '', '/d/' + response.hash);
            for (const cm of cms) {
                cm.doc.markClean();
            }
            showToast('<i class="bi bi-hand-thumbs-up-fill"></i> Copy & paste current URL to share diff', 'bg-success');
        },
        handleAjaxError,
        function () {
            setButtonReady(btn);
        }
    );
});

$('#function-word-wrap').on('click', function () {
    setOptions('lineWrapping', !cm.editor().getOption('lineWrapping'));
});

if (activeSnippetFormat) {
    df.val(activeSnippetFormat).trigger('change');
} else {
    df.val('json').trigger('change');
}

resize();
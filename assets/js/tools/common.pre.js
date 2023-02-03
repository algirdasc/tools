const cmOptions = {
    lineNumbers: true,
    matchBrackets: true,
    matchTags: {
        bothTags: true
    },    
    foldGutter: true,
    gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter', 'CodeMirror-lint-markers'],
    lint: false,
    theme: 'idea',
}

window.addEventListener('beforeunload', function (e) {  
    if (typeof cms === 'undefined') {
        return;
    }
    
    for (let cm of cms) {        
        if (!cm.doc.isClean()) {
            e.preventDefault();
            e.returnValue = '';
        }
    }
});

function selectToCMMode(mode)
{
    switch (mode) {
        case 'json':
            mode = 'application/json';
            break;
        case 'text':
            mode = 'yaml';
            break;
        case 'sql':
            mode = 'text/x-mysql';
            break;
        case 'd':
            mode = 'text/x-d';
            break;
        case 'cpp':
            mode = 'text/x-objectivec';
            break;
    }
    
    return mode;
}

function selectToAutoMode(mode)
{
    switch (mode) {
        case 'application/json':
            mode = 'javascript';
            break;
        case 'text/x-mysql':
            mode = 'sql';
            break;
        case 'text/x-d':
            mode = 'd';
            break;
        case 'text/x-objectivec':
            mode = 'clike';
            break;
    }
    
    return '/assets/js/mode/' + mode + '/' + mode + '.js'
}


function setTitle(title)
{
    $('title').text('ČiČi Tools - ' + title);
}

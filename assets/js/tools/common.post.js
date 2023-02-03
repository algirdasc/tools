$('span.highlighted-line').parents('.CodeMirror-line').each(function () {
    $(this).parent().addClass('highlighted-line');
});

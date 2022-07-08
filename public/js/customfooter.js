$('form')
    .on('blur', 'input[required], input.optional, select.required', validator.checkField)
    .on('change', 'select.required', validator.checkField)
    .on('keypress', 'input[required][pattern]', validator.keypress);

$('form').submit(function (e) {
        e.preventDefault();
        var submit = true;
        if (!validator.checkAll($(this))) {
            submit = false;
        }
        if (submit)
            this.submit();
        return false;
});
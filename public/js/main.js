$(function () {
    $('.select-class').change(function () {
        var url = $(this).attr('href');
        var class_id = $(this).val();

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            async: true,
            data: {
                class_id: class_id
            }
        }).done(function (result) {
            $('.select-subject').html(result.html)
        }).fail(function (XMLHttpRequest, textStatus, thrownError) {
            console.log(thrownError)
        });
    })
    $('.detail_answer').click(function (event) {
        event.preventDefault();
        var url = $(this).data('url');

        $.ajax({
            url: url,
            type: 'POST',
            async: false
        }).done(function (result) {
             $('#detail_Answer_1').html(result.html.toString());
        });
    })

    $(document).on('click', '.btn-save-mark', function () {
        var url = $(this).attr('url');
        var mark = $(this).parent().parent().find('#mark_assignment').val();
        var comments = $(this).parent().parent().find('#comments').val();

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            async: true,
            data: {
                mark: mark,
                comments: comments
            }
        }).done(function (result) {
            if (result.code == 200) {
                $('.result_mark_'+ result.result_id).text(result.mark);
                toastr.success('Update resulted success', {timeOut: 3000});
            }
        }).fail(function (XMLHttpRequest, textStatus, thrownError) {
            console.log(thrownError)
        });
    })

    $(document).on('click', '.join-by-link', function () {
        var link_join = $('.link-join-class').val();
        if (isValidURL(link_join)) {
            window.location.href = link_join
        } else {
            toastr.error('The link is not in the correct format', {timeOut: 3000});
        }
    })

    function isValidURL(string) {
        var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
        return (res !== null)
    }

    $(document).on('click', '.join-by-code', function () {

        var url = $(this).attr('url')
        var code_join_class = $('.code-join-class').val();

        if (code_join_class == '') {
            toastr.error('Class code join is not empty', {timeOut: 3000});
        } else {
            window.location.href = url + '/' + code_join_class;
        }
    })
})

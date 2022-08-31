$(document).ready(function () {
    $('.game-table').on(
        "click", 'td', clickOnCell
    );
    $('#submit').click(
        function () {
            sendAjaxForm('registration-form', './registration/send', 'Вы успешно зарегистрировались');
            return false;
        }
    );
    $('#submit-login').click(
        function () {
            sendAjaxForm('login-form', './login/send', 'Вы успешно авторизовались');
            return false;
        }
    );
});

function clickOnCell() {
    if ($(this).html() !== '') {
        return;
    }
    $(this).html('X');
    sendData({board: getBoard()}, './helpers/game.php');
    return false;
}

function getBoard() {
    const board = [[], [], []];
    $('.game-table td').each(function () {
        board[$(this).parent().index()][$(this).index()] = $(this).text();
    });
    return (board);
};

function sendData(data, url) {
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'html',
        data: data,
        success: function (response) {
            const result = $.parseJSON(response);
            if (result.step) {
                const row = $('.game-table tr').eq(result.step.row);
                row.children().eq(result.step.col).html(result.step.symb);
            }
            if (result.message) {
                $('.game-table').off(
                    "click", 'td', clickOnCell
                );
                setTimeout(() => alert(result.message), 100);
                return;
            }
        },
        error: function (response) {
            console.log('Ошибка сервера!');
        }
    });
}

function sendAjaxForm(ajax_form, url, message) {
    $('.error').remove();
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'html',
        data: $('#' + ajax_form).serialize(),
        success: function (response) {
            result = $.parseJSON(response);
            if (typeof result === 'object' && Object.keys(result.errors).length > 0) {
                result.errors.forEach(error => $('#' + ajax_form).after(`<p class="error">${error}</p>`))
            } else {
                setTimeout(() => window.location.href = './', 1000);
                $('#' + ajax_form).after(`<p class="message">${message}</p>`);
                $('#' + ajax_form)[0].reset();
            }
        },
        error: function (response) {
            console.log('Ошибка сервера!');
        }
    });
}

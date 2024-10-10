$(document).ready(function () {

    $('#contactForm').on('submit', function (e) {
        e.preventDefault();

        let url = "assets/php/sendMail.php";

        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                name: $('#name-field').val(),
                email: $('#email-field').val(),
                subject: $('#subject-field').val(),
                message: $('#message-field').val()
            },
            success: function (response) {
                console.log(JSON.stringify(response));

                if (response.success === true) {
                    $('#response').html('<p class="success">Message sent successfully!</p>')
                    $('#contactForm')[0].reset();
                } else {
                    $('#response').html('<p class="error">Error: ' + response.message + '</p>');
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
                $('#response').html('<p class="error">Error: Could not send message.</p>');
            }
        });
    })
});
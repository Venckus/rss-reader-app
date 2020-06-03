
$('document').ready(function(){
    var email_state = false;
    
    $('#email').on('blur', function(){
        var email = $('#email').val();
        console.log(email)
        if (email == '') {
            email_state = false;
            $('#email').removeClass("is-invalid").removeClass("is-valid");
            $('#email-response').removeClass();
            $('#email-response').text('');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content') //$('meta[name="_token"]').val() //
            },
            url: '/check-email',
            type: 'post',
            data: {
                'email_check' : 1,
                'email' : email,
            },
            success: function (response) {
                console.log(response)
                if (response == 'taken' || response == undefined) {
                    email_state = false;
                    $('#email').parent().removeClass("is-valid");
                    $('#email').addClass("is-invalid");
                    $('#email-response').addClass("invalid-feedback");
                    $('#email-response').text('Sorry... Email already taken');
                } else if (response == 'not_taken') {
                    email_state = true;
                    $('#email').parent().removeClass("is-invalid");
                    $('#email').addClass("is-valid");
                    $('#email-response').addClass("valid-feedback");
                    $('#email-response').text('Email available');
                }
            }
        });
    });
});

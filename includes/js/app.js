$(function () {

    $(document).ready(function () {
        // scroll to top - starts
        // Hide the toTop button when the page loads.
        $("#toTop").css("display", "none");

        // This function runs every time the user scrolls the page.
        $(window).scroll(function () {

            // Check weather the user has scrolled down (if "scrollTop()"" is more than 0)
            if ($(window).scrollTop() > 0) {

                // If it's more than or equal to 0, show the toTop button.
                console.log("is more");
                $("#toTop").fadeIn("slow");
            }
            else {
                // If it's less than 0 (at the top), hide the toTop button.
                console.log("is less");
                $("#toTop").fadeOut("slow");

            }
        });

        // When the user clicks the toTop button, we want the page to scroll to the top.
        $("#toTop").click(function () {

            // Disable the default behaviour when a user clicks an empty anchor link.
            // (The page jumps to the top instead of // animating)
            event.preventDefault();

            // Animate the scrolling motion.
            $("html, body").animate({
                scrollTop: 0
            }, "slow");

        });
        // scroll to top - ends
    });
    
    $('#btnfclose').click(function () {

        $('#failureAlert').slideUp();
    });

    $('#btnsclose').click(function () {

        $('#successAlert').slideUp();
    });

    $('.thumbnail').hover(
        function () {
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function () {
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
    );

    // Get the form.
    var form = $('#ajax-contact');

    // Get the messages div.
    var formMessages = $('#form-messages');

    // Get the error messages div.
    var formError = $('#form-error');


    // Set up an event listener for the contact form.
    $(form).submit(function (event) {
        // Stop the browser from submitting the form.
        event.preventDefault();

        // Serialize the form data.
        var formData = $(form).serialize();

        // Submit the form using AJAX.
        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: formData
        })

        .done(function (response) {

            $('#successAlert').slideDown();

            // Set the message text.
            $(formMessages).text(response);

            // Clear the form.
            $('#name').val('');
            $('#email').val('');
            $('#message').val('');
            $('#subject').val('');
            $('#securitycode').val('');
        })

        .fail(function (data) {

            $('#failureAlert').slideDown();

            // Set the message text.
            if (data.responseText !== '') {
                $(formError).text(data.responseText);
            } else {
                $(formError).text('Oops! An error occured and your message could not be sent.');
            }
        });
    });


});
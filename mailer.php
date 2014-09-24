<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        function encrypt($string, $key) {
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
           $char = substr($string, $i, 1);
           $keychar = substr($key, ($i % strlen($key))-1, 1);
           $char = chr(ord($char)+ord($keychar));
           $result.=$char;
        }
          return base64_encode($result);
        }
        $sicherheits_eingabe = encrypt($_POST["securitycode"], "8h384ls94");
        $sicherheits_eingabe = str_replace("=", "", $sicherheits_eingabe);
        
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);
        $remote = getenv("REMOTE_ADDR");

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }
        
     /* if($sicherheits_eingabe != $_SESSION['captcha_spam']){
          unset($_SESSION['captcha_spam']);
          http_response_code(400);
          echo "Oops! You entered a wrong security code. Please correct it and try again.";
          exit;
         }
       */ 

        // Set the recipient email address.
        $recipient = "tagmodo@gmail.com";

        // Set the email subject.
        $subject = "tagMODO.com - New contact from $name";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";
        $email_content .= "IP Address:\n$remote\n";
        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank you for writing to us! Your message has been sent. We will get back to you promptly.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
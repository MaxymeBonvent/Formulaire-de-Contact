<?php
    // Writer's info
    $writer_name = htmlspecialchars($_POST["writer_name"]); // Writer's Name
    $writer_email = htmlspecialchars($_POST["writer_email"]); //Writer's Adress
    $writer_password = htmlspecialchars($_POST["writer_password"]); // Writer's Email Password

    // Variable to store the writer's password after hashing it
    $hashed_password = password_hash($writer_password, PASSWORD_DEFAULT);
    echo "<p>Hashed Password : $hashed_password.</p>";

    // Recipient's info
    $recipient_name = htmlspecialchars($_POST["recipient_name"]); // Recipient's Name
    $recipient_email = htmlspecialchars($_POST["recipient_email"]); // Recipient's Adress

    // Mail info
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // MAIL VALIDATIONS
    // If there is no @ in the Writer's Mail
    if(!str_contains($writer_email, "@"))
    {
        // Inform the user of the error
        echo "<p>Error : Your email must contain an @ character.</p>";

        // End the script
        die;
    }

    // If there is no @ in the Recipient's Mail
    else if(!str_contains($writer_email, "@"))
    {
        // Inform the user of the error
        echo "<p>Error : The recipient's email must contain an @ character.</p>";

        // End the script
        die;
    }

    // Use a script of the vendor folder
    require "vendor/autoload.php";

    // Import the PHPMailer and the SMTP (Simple Mail Transfer Protocol) namespaces
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    // Object of the PHPMailer class
    $mail = new PHPMailer(true);

    // Telling PHPMailer we're using SMTP
    $mail->isSMTP();

    // Enable SMTP Authentication
    $mail->SMTPAuth = true;

    // To find SMTP settings, log into your Microsoft account, click the gear icon, find the search bar (with the loop icon), type SMTP, click "POP and IMAP", click "Display POP, IMAP and SMTP settings"
    $mail->Host = "smtp-mail.outlook.com";
    echo "<p>Host : ".$mail->Host.".</p>";

    // Type of information encryption
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    echo "<p>SMTPSecure : ".$mail->SMTPSecure.".</p>";

    // Port number
    $mail->Port = 587;
    echo "<p>Port : ".$mail->Port.".</p>";

    // Write's Adress
    $mail->Username = $writer_email;

    // Writer's adress and name
    echo "<p>Write's Adress : ".$mail->Username.".</p>";
    echo "<p>Write's Name : $writer_name.</p>";

    // Write's Password
    $mail->Password = $writer_password;

    // Set Writer Adress and Writer Name
    $mail->setFrom($mail->Username, $writer_name);

    // Recipient's Adress
    echo "<p>Recipient's Adress : $recipient_email.</p>";

    // Recipient's Name
    echo "<p>Recipient's Name : $recipient_name.</p>";

    // Add a recipient adress
    $mail->addAddress($recipient_email, $recipient_name);

    // Mail Subject
    $mail->Subject = $subject;
    echo "<p>Mail Subject : $mail->Subject.</p>";

    // Mail Message
    $mail->Body = $message;
    echo "<p>Mail Message : $mail->Body.</p>";

    // Try to send the mail
    try
    {
        // Send mail
        $mail->send();

        // Direct user to email_sent.html
        header("Location: email_sent.html");
    }

    // If the mail couldn't be sent
    catch(Exception $exc)
    {
        // Tell the user
        echo "<p>Error : $exc</p>";
    }      
?>
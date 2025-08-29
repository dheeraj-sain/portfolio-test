<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['concern']) || empty($_POST['query'])) {
        die("Error: All fields are required.");
    }
    
    // Retrieve and sanitize form data
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $phone = trim(htmlspecialchars($_POST['phone']));
    $concern = trim(htmlspecialchars($_POST['concern']));
    $query = trim(htmlspecialchars($_POST['query']));
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format.");
    }
    
    // Email configuration
    $to = "kanishk8950@gmail.com"; // Your email address
    $subject = "New Contact Form Submission - " . $concern;
    
    // Create email body
    $message = "New contact form submission received:\n\n";
    $message .= "Name: " . $name . "\n";
    $message .= "Email: " . $email . "\n";
    $message .= "Phone: " . $phone . "\n";
    $message .= "Concern Area: " . $concern . "\n\n";
    $message .= "Message:\n" . $query . "\n\n";
    $message .= "---\n";
    $message .= "Submitted on: " . date('Y-m-d H:i:s') . "\n";
    $message .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
    
    // Email headers
    $headers = array();
    $headers[] = "From: Thinknyx Contact Form <noreply@thinknyx.com>";
    $headers[] = "Reply-To: " . $name . " <" . $email . ">";
    $headers[] = "X-Mailer: PHP/" . phpversion();
    $headers[] = "Content-Type: text/plain; charset=UTF-8";
    $headers[] = "MIME-Version: 1.0";
    
    // Convert headers array to string
    $headers_string = implode("\r\n", $headers);
    
    // Attempt to send email
    $mail_sent = mail($to, $subject, $message, $headers_string);
    
    if ($mail_sent) {
        // Success - redirect to thank you page
        header("Location: /thank_you.html");
        exit();
    } else {
        // Log the error for debugging
        error_log("Mail sending failed for: " . $email);
        
        // Show user-friendly error message
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Message Error</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                .error { color: #d32f2f; background: #ffebee; padding: 20px; border-radius: 5px; display: inline-block; }
            </style>
        </head>
        <body>
            <div class='error'>
                <h2>Unable to send message</h2>
                <p>There was a problem sending your message. Please try again later or contact us directly at support@thinknyx.com</p>
                <a href='javascript:history.back()'>Go Back</a>
            </div>
        </body>
        </html>";
    }
    
} else {
    // Not a POST request
    header("Location: /contact.html");
    exit();
}
?>
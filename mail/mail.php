<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Define recipient email
  $to = 'support@thinknyx.com';

  // Form data variables
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $concern = $_POST['concern'];
  $query = $_POST['query'];

  // Construct email body
  $message = "**New Quote Request:**\n\n";
  $message .= "Name: $name\n";
  $message .= "Email: $email\n";
  $message .= "Phone: $phone\n";
  $message .= "Concern Area: $concern\n";
  $message .= "Query: $query\n";

  // Set email headers
  $headers = 'From: noreply@thinknyx.com' . "\r\n";
  $headers .= 'Reply-To: ' . $email . "\r\n";
  $headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";

  // Send email
  $success = mail($to, 'Website Quote Request', $message, $headers);

  if ($success) {
    echo 'Your message has been sent successfully!';
  } else {
    echo 'There was an error sending your message. Please try again later.';
  }
}

?>
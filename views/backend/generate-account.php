<?php

if (isset($_POST['submit'])) {

  require_once '../../config/config.php'; // INCLUDE CONFIG
  require_once '../../classes/authcode.php'; // PASSWORD GENERATOR

  //Recipients
  $email = strtolower($_POST['email']);
  $mail->addAddress($email);     //Add a recipient

  $password = authCode(); // GENERATE PASSWORD
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $mail_check = $connection->prepare("
      SELECT email
      FROM users
      WHERE EXISTS 
      (SELECT email from users WHERE email = :email)
  ");
  $mail_check->bindParam(":email", $email);
  $mail_check->execute();
  $exists = $mail_check->fetch(PDO::FETCH_ASSOC);
  if ($exists) {
    $msg->error('User already exists!', 'http://localhost/zmaturuj.me/', true);
  } else {

    $insert = $connection->prepare("
    INSERT INTO users (email, password) 
    VALUES (:email, :password);
    "); // PREPARE SQL QUERY TO INSERT DATA

    $insert->bindParam(":email", $email);
    $insert->bindParam(":password", $hashed_password);
    $insert->execute();
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Your account has been generated';
    $mail->Body    = 'Your account has been successfully generated your credentials are
                      <br><b>E-mail: ' . $email . '</b>
                      <br> <b>Password: ' . $password . '</b>
                      <br> Please login and change your password: <a href="localhost/zmaturuj.me/">here</a>! ';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if ($mail->send()) {
      $msg->success('User added', 'http://localhost/zmaturuj.me/', true);
    } else {
      $msg->error('Message could not be sent. Mailer Error', 'http://localhost/zmaturuj.me/', true);
    }
  }
} else {
  header("Location: /zmaturuj.me/error");
}

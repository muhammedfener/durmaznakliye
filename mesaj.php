<?php
require("class.phpmailer.php");

$errors = [];
$data = [];

if (empty($_POST['name'])) {
    $errors['name'] = 'İsim gerekli.';
}

if (empty($_POST['email'])) {
    $errors['email'] = 'Mail gerekli.';
}

if (empty($_POST['phone'])) {
    $errors['phone'] = 'Telefon gerekli.';
}

if (empty($_POST['mesaj'])) {
    $errors['mesaj'] = 'Mesaj gerekli.';
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$mesaj = $_POST['mesaj'];

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $data['success'] = true;
    $data['message'] = 'Success!';
}

if($data['success'] == true){
  $mail = new PHPMailer(); // create a new object
  $mail->IsSMTP(); // enable SMTP
  $mail->SMTPAuth = true; // authentication enabled
  $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
  $mail->Host = "mail.durmaznakliye.com";
  $mail->Port = 465; // or 587
  $mail->IsHTML(true);
  $mail->SetLanguage("tr", "phpmailer/language");
  $mail->CharSet  ="utf-8";

  $mail->Username = ""; // Mail adresi
  $mail->Password = ""; // Parola
  $mail->SetFrom($email, $name); // Mail adresi

  $mail->AddAddress("info@durmaznakliye.com"); // Gönderilecek kişi

  $mail->Subject = "Siteden Gönderildi";
  $mail->Body = "$name<br />$email<br />$phone<br />$mesaj";
  if(!$mail->Send()){
                $data['mailerror'] = $mail->ErrorInfo;
	} else {
                $data['mailsent'] = "success";
	}
}


echo json_encode($data);
?>

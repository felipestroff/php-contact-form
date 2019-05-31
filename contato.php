<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './vendor/autoload.php';

use FormGuide\Handlx\FormHandler;

$pp = new FormHandler();

$name = strip_tags($_POST['name']);
$email = strip_tags($_POST['email']);
$subject = '=?UTF-8?B?'.base64_encode($_POST['subject']).'?=';
$msg = strip_tags($_POST['message']);

$content = '';
$content .= '<html><body>';
$content .= '<h1>Contato pelo site <a href="#" target="_blank">Site</a></h1>';
$content .= '<table style="width: 100%;" cellpadding="10">';
$content .= "<tr><td><strong>Nome:</strong> </td><td>" . $name . "</td></tr>";
$content .= "<tr><td><strong>Email:</strong> </td><td><a href='mailto:" . $email . "'>" . $email . "</a></td></tr>";
$content .= "<tr><td><strong>Assunto:</strong> </td><td>" . $_POST['subject'] . "</td></tr>";
$content .= "<tr><td><strong>Mensagem:</strong> </td><td>" . $msg . "</td></tr>";
$content .= '</table>';
$content .= '</body></html>';

$pp->mailer->Subject = $subject;
$pp->mailer->setFrom($email, $name, false); 
$pp->mailer->Body = $content;
$pp->mailer->IsHTML(true);

$validator = $pp->getValidator();
$validator->fields(['name','email', 'subject'])->areRequired()->maxLength(50);
$validator->field('email')->isEmail();
$validator->field('message')->areRequired()->maxLength(6000);

// Configurar
$pp->sendEmailTo('destino');

echo $pp->process($_POST);
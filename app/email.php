<?php
// Função única para mandar e-mail:  enviar_email($para, $assunto, $mensagem)
// Devolve true se deu certo, false se deu erro.
// Usa PHPMailer (Método B do manual): Gmail, porta 587, STARTTLS.

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once __DIR__ . "/cons.php";

// Modo teste = falta o PHPMailer (pasta vendor) ou o arquivo smtp.php
function email_modo_teste() {
    global $smtp_config;
    return !file_exists($smtp_config) || !file_exists(__DIR__ . "/../vendor/autoload.php");
}

function enviar_email($para, $assunto, $mensagem) {
    global $smtp_config, $loja_nome;

    if (!filter_var($para, FILTER_VALIDATE_EMAIL)) return false;
    $assunto = str_replace(["\r", "\n"], " ", $assunto);

    // MODO TESTE: só salva num arquivo para você ler
    if (email_modo_teste()) {
        $texto = "[" . date("d/m/Y H:i:s") . "] PARA: $para\nASSUNTO: $assunto\n$mensagem\n----------------------------------------\n";
        file_put_contents(__DIR__ . "/emails.log", $texto, FILE_APPEND);
        return true;
    }

    // MODO REAL: PHPMailer
    require_once __DIR__ . "/../vendor/autoload.php";
    $config = require $smtp_config;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['usuario'];
        $mail->Password = $config['senha'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom($config['usuario'], $loja_nome);
        $mail->addAddress($para);

        $mail->isHTML(false);
        $mail->Subject = $assunto;
        $mail->Body = $mensagem;

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log('Erro PHPMailer: ' . $mail->ErrorInfo);
        return false;
    }
}

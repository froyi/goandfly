<?php
declare (strict_types=1);

namespace Project\Controller;

use Project\Utilities\Tools;

/**
 * Class MailerController
 * @package Project\Controller
 */
class MailerController extends DefaultController
{
    public function contactFormAction(): void
    {
        // Variablen holen
        $anrede = $_POST["anrede"];
        $vorname = $_POST["vorname"];
        $nachname = $_POST["name"];
        $email = $_POST["email"];
        $telefon = $_POST["telefon"];
        $plz = $_POST["plz"];
        $ort = $_POST["ort"];
        $adresse = $_POST["adresse"];
        $frage = $_POST["frage"];

        $to = "go.and.fly@t-online.de";

        $message = $anrede . " " . $vorname . " " . $nachname . "\r\n" .
            $email . "\r\n" .
            $telefon . "\r\n" .
            $adresse . "\r\n" .
            $plz . " " . $ort . "\r\n" .
            "\r\n" .
            "Frage: \r\n" . $frage;

        $header = utf8_encode('From: GO AND FLY - Kontaktformular <go.and.fly@t-online.de>' . "\r\n" .
            'Reply-To: Kontakt <' . $email . '>' . "\r\n" .
            "Content-Type: text/plain; charset=utf-8");

        $subject = "Kontaktformular - www.go-and-fly.de";

        mail($to, $subject, $message, $header);

        header('Location: ' . Tools::getRouteUrl('kontakt'));
    }

    public function reiseContactAction(): void
    {
            // Variablen holen
            $anrede = $_POST["anrede"];
            $vorname = $_POST["vorname"];
            $nachname = $_POST["name"];
            $email = $_POST["email"];
            $telefon = $_POST["telefon"];
            $adresse = $_POST["adresse"];
            $plz = $_POST["plz"];
            $ort = $_POST["ort"];
            $termin = $_POST["termin"];
            $anmerkung = $_POST["anmerkung"];
            $route = $_POST["route"];
            $titel = $_POST["titel"];

            $reiseId = $_POST['reiseId'];

            $to = "go.and.fly@t-online.de";

            $message = $titel . "\r\n" .
                $anrede . " " . $vorname . " " . $nachname . "\r\n" .
                $email . "\r\n" .
                $telefon . "\r\n" .
                $adresse . "\r\n" .
                $plz . " " . $ort . "\r\n" .
                "\r\n" .
                "Termin: " . $termin . "\r\n" .
                "Anmerkungen: " . $anmerkung;


            $header = utf8_encode('From: GO AND FLY - Kontaktformular <go.and.fly@t-online.de>' . "\r\n" .
                'Reply-To: Kontakt <' . $email . '>' . "\r\n" .
                "Content-Type: text/plain; charset=utf-8");
            $subject = "Kontaktformular - www.go-and-fly.de";

            mail($to, $subject, $message, $header);

        header('Location: ' . Tools::getRouteUrl($route, ['reiseId' => $reiseId]));
    }

    public function footerContactAction(): void
    {
        $name = $_POST['name'];
        $mail = $_POST['email'];
        $nachricht = $_POST['nachricht'];

        $route = $_POST["route"];

        if ($route === 'reise') {
            $route = 'index';
        }

        if (strlen(trim($nachricht)) > 5) {

            $to = "go.and.fly@t-online.de";

            $message = $name . " schrieb: \r\n" . $nachricht;

            $header = utf8_encode('From: GO AND FLY - Kontaktformular <go.and.fly@t-online.de>' . "\r\n" .
                'Reply-To: Kontakt <' . $mail . '>' . "\r\n" .
                "Content-Type: text/plain; charset=utf-8");
            $subject = "Kontaktformular - www.go-and-fly.de";

            mail($to, $subject, $message, $header);
        }

        header('Location: ' . Tools::getRouteUrl($route));
    }
}
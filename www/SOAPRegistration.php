<?php

class SOAPRegistration {
    protected $messages = Array();
    protected $db;
    protected $soap;
    protected $showForm = true;

    public function __construct() {
        try {
            $this -> dbConnect();
            if ($this -> validateInput()) {
                $this -> soapConnect();
                $this -> showForm = false;
                $this -> soapCommand('bnetaccount create '.$_POST["email"].' '.$_POST["password"]);
                $stmt = $this -> db -> prepare("UPDATE `account` SET `username` = ?, `expansion` = ? WHERE `reg_mail` = ?;");
                $stmt -> bind_param('sis', $_POST["accountname"], $_POST["expansion"], $_POST["email"]);
                $stmt -> execute();
            }
        }
        catch (Exception $e) {
            $this -> addMessage($e -> getMessage());
        }
    }

    protected function validateInput() {
        if (empty($_POST["accountname"])) {
            $this -> addMessage('Bitte gib einen Accountnamen an.');
        }
        elseif (!preg_match('/^[a-z0-9@.@]{5,50}$/i', $_POST["accountname"])) {
            $this -> addMessage('Ein Accountname muss zwischen 5 und 32 Zeichen lang sein und darf nur Buchstaben und Ziffern enthalten.');
        }
        else {
            $stmt = $this -> db -> prepare("SELECT `username` FROM `account` WHERE `username` = ?;");
            $stmt -> bind_param('s', $_POST["accountname"]);
            $stmt -> execute();
            $stmt -> store_result();
            if ($stmt->num_rows > 0) {
                $this -> addMessage('Es gibt bereits einen Account mit diesem Namen. Bitte wähle einen anderen Accountnamen.');
            }
        }

        if (empty($_POST["password"])) {
            $this -> addMessage('Bitte gib ein Passwort an.');
        }
        else {
            if (!preg_match('/^[a-z0-9!"#$%]{8,16}$/i', $_POST["password"])) {
                $this -> addMessage('Ein Passwort muss zwischen 8 und 16 Zeichen lang sein und darf nur Buchstaben, Ziffern und die folgenden Spezialzeichen enthalten: !"#$%');
            }
            if (empty($_POST["password2"])) {
                $this -> addMessage('Bitte bestätige das Passwort.');
            }
            elseif ($_POST["password"] !== $_POST["password2"]) {
                $this -> addMessage('Die beiden Passwortangaben stimmen nicht überein.');
            }
        }

        if (empty($_POST["email"])) {
            $this -> addMessage('Bitte gib eine gültige E-Mail-Adresse an.');
        }
        elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $this -> addMessage('Die angegebene E-Mail-Adresse ist ungültig.');
        }
        elseif (strlen($_POST["email"]) > 254) {
            $this -> addMessage('Eine E-Mail-Adresse darf nicht länger als 254 Zeichen sein.');
        }
        else {
            $stmt = $this -> db -> prepare("SELECT `reg_mail` FROM `account` WHERE `reg_mail` = ?;");
            $stmt -> bind_param('s', $_POST["email"]);
            $stmt -> execute();
            $stmt -> store_result();
            if ($stmt->num_rows > 0) {
                $this -> addMessage('Es gibt bereits einen Account mit dieser E-Mail-Adresse. Bitte wähle eine andere E-Mail-Adresse.');
            }
        }

        if (!isset($_POST["expansion"]) || $_POST["expansion"] != intval($_POST["expansion"]) || intval($_POST["expansion"]) < 0 || intval($_POST["expansion"]) > 5) {
            $this -> addMessage('Bitte wähle deine WoW-Erweiterung.');
        }

        return empty($this -> messages);
    }
    
    protected function dbConnect() {
        $this -> db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
            throw new Exception("Datenbank-Verbindung gescheitert: ". mysqli_connect_error());
        }
        return true;
    }

    protected function soapConnect() {
        $this -> soap = new SoapClient(NULL, Array(
            'location'=> 'http://'. SOAP_IP .':'. SOAP_PORT .'/',
            'uri' => 'urn:TC',
            'style' => SOAP_RPC,
            'login' => SOAP_USER,
            'password' => SOAP_PASS,
            'keep_alive' => false //keep_alive funktioniert nu in PHP 5.4.
        ));
    }

    protected function soapCommand($command) {
        $result = $this -> soap -> executeCommand(new SoapParam($command, 'command'));
        $this -> addMessage($result);
        return true;
    }

    protected function addMessage($message) {
        $this -> messages[] = $message;
        return true;
    }

    public function getMessages() {
        return $this -> messages;
    }

    public function showForm() {
        return $this -> showForm;
    }

    public function __destruct() {
        $this -> db -> close();
    }
}
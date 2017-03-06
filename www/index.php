<?php
// Konfiguration und Registrierung
require_once("config.php");
require_once("SOAPRegistration.php");

// Sssion und Variable initialisieren
$messages = Array();
$showForm = true;

// werden Formulardaten übermittelt, Registrierung durchführen
if(!empty($_POST["submit"]))
{
    $reg = new SOAPRegistration();
    $messages = $reg -> getMessages();
    $showForm = $reg -> showForm();
}

// Rückmeldungen des Registrierungsskripts
$messagesDisplay = '';
foreach($messages as $msg) {
   $messagesDisplay .= '                    <div class="errors">'.$msg.'</div>';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="site.css" />
        <meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
        <meta name="robots" content="<?php echo META_ROBOTS; ?>" />
        <title><?php echo SITE_TITLE; ?></title>
    </head>
    <body>
        <table class="global">
            <tr>
                <td><h1><a href="<?php echo $_SERVER["PHP_SELF"]; ?>">Account-Registrierung</a></h1></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <?php
                        echo $messagesDisplay."\n";
                        if ($showForm) {
                    ?>
                    <form action="" method="post" name="reg">
                        <table class="form">
                            <tr>
                                <td align="right">Bnet-Account (E-Mail-Adresse):</td>
                                <td align="left"><input name="email" type="text" maxlength="254" /></td>
                            </tr>
                            <tr>
                                <td align="right">Account-Name:</td>
                                <td align="left"><input name="accountname" type="text" maxlength="32" /></td>
                            </tr>
                            <tr>
                                <td align="right">Passwort:</td>
                                <td align="left"><input name="password" type="password" maxlength="16" /></td>
                            </tr>
                            <tr>
                                <td align="right">Passwort bestätigen:</td>
                                <td align="left"><input name="password2" type="password" maxlength="16" /></td>
                            </tr>
                            <tr>
                                <td align="right">Expansion:</td>
                                <td align="left">
                                    <select name="expansion">
                                        <option value="0">Vanilla</option>
                                        <option value="1">The Burning Crusade</option>
                                        <option value="2">Wrath of the Lich King</option>
                                        <option value="3">Cataclysm</option>
                                        <option value="4">Mists of Pandaria</option>
                                        <option selected value="5">Warlords Of Draenor</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><input type="submit" class="submit" value="Registrieren" name='submit' /></td>
                            </tr>
                        </table>
                    </form>
                    <?php
                        }
                    ?>
					<br />
                </td>
            </tr>
        </table>
    </body>
</html>
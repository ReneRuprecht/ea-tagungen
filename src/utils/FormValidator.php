<?php
include_once('ValidatorInterface.php');
/**
 * FormValidator, is used to validate the form
 * 
 * @author ReneRuprecht
 */
class FormValidator implements Validator
{
    /**
     * validate, checks if the form is valid. returns a message if the form is
     * invalid or an empty string if the form is valid
     *
     * @return string error message or an empty string
     */
    public function validate(): string
    {

        if (!isset($_POST['eventDate']) || !preg_match(eventDateRegex, $_POST['eventDate'])) {
            return "<h1>Das Datum beinhaltet ungültige Zeichen</h1>";
        }

        if (!isset($_POST['eventName']) || !preg_match('/^(?!\s*$).+/', $_POST['eventName'])) {
            return "<h1>Der Eventname beinhaltet ungültige Zeichen</h1>";
        }

        if (!isset($_POST['startTime']) || !preg_match(timeRegex, $_POST['startTime'])) {
            return "<h1>Die Startzeit beinhaltet ungültige Zeichen</h1>";
        }
        if (!isset($_POST['endTime']) || !preg_match(timeRegex, $_POST['endTime'])) {
            return "<h1>Die Endzeit beinhaltet ungültige Zeichen</h1>";
        }

        if (!isset($_POST['speaker'])) {
            return "<h1>Die Redner beinhaltet ungültige Zeichen</h1>";
        } else {
            if (strpos($_POST['speaker'], ',')) {
                $explodedSpeakerArray = explode(',', $_POST['speaker']);
                foreach ($explodedSpeakerArray as $speakerElement) {

                    if (!preg_match(speakerRegex, $speakerElement)) {
                        return "<h1>Die Redner beinhaltet ungültige Zeichen </h1>" .  $speakerElement;
                    }
                }
            } else {
                if (!preg_match(speakerRegex, $_POST['speaker'])) {
                    return "<h1>Die Redner beinhaltet ungültige Zeichen</h1>";
                }
            }
        }

        return "";
    }
}

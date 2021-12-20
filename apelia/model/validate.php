<?php
class Validate {
    private $fields;

    public function __construct() {
        $this->fields = new Fields();
    }

    public function getFields() {
        return $this->fields;
    }

    // Validate a generic text field
    public function text($name, $value,
            $required = true, $min = 1, $max = 51) {

        // Get Field object
        $field = $this->fields->getField($name);

        // If field is not required and empty, remove error and exit
        if (!$required && empty($value)) {
            $field->clearErrorMessage();
            return;
        }

        // Check field and set or clear error message
        if ($required && empty($value)) {
            $field->setErrorMessage('Required.');
        } else if (strlen($value) < $min) {
            $field->setErrorMessage('Too short.');
        } else if (strlen($value) > $max) {
            $field->setErrorMessage('Too long.');
        } else {
            $field->clearErrorMessage();
        }
    }

    // Validate a field with a generic pattern
    public function pattern($name, $value, $pattern, $message,
            $required = true) {

        // Get Field object
        $field = $this->fields->getField($name);

        // If field is not required and empty, remove errors and exit
        if (!$required && empty($value)) {
            $field->clearErrorMessage();
            return;
        }

        // Check field and set or clear error message
        $match = preg_match($pattern, $value);
        if ($match === false) {
            $field->setErrorMessage('Error testing field.');
        } else if ( $match != 1 ) {
            $field->setErrorMessage($message);
        } else {
            $field->clearErrorMessage();
        }
    }
    
    
    public function phone($name, $value, $required = true) {
        $field = $this->fields->getField($name);

        // Call the text method and exit if it yields an error
        $this->text($name, $value, $required);
        if ($field->hasError()) { return; }

        // Call the pattern method to validate a phone number
        $pattern = '/^\d{3}\-\d{3}-\d{4}$/';
        $message = 'Invalid phone number.';
        $this->pattern($name, $value, $pattern, $message, $required);
    }
    
    public function email($name, $value, $required = true) {
        $field = $this->fields->getField($name);

        // If field is not required and empty, remove errors and exit
        if (!$required && empty($value)) {
            $field->clearErrorMessage();
            return;
        }

        // Call the text method and exit if it yields an error
        $this->text($name, $value, $required);
        if ($field->hasError()) { return; }

        // Split email address on @ sign and check parts
        $parts = explode('@', $value);
        if (count($parts) < 2) {
            $field->setErrorMessage('At sign required.');
            return;
        }
        if (count($parts) > 2) {
            $field->setErrorMessage('Only one at sign allowed.');
            return;
        }
        $local = $parts[0];
        $domain = $parts[1];

        // Check lengths of local and domain parts
        if (strlen($local) > 64) {
            $field->setErrorMessage('Username part too long.');
            return;
        }
        if (strlen($domain) > 255) {
            $field->setErrorMessage('Domain name part too long.');
            return;
        }

        // Patterns for address formatted local part
        $atom = '[[:alnum:]_!#$%&\'*+\/=?^`{|}~-]+';
        $dotatom = '(\.' . $atom . ')*';
        $address = '(^' . $atom . $dotatom . '$)';

        // Patterns for quoted text formatted local part
        $char = '([^\\\\"])';
        $esc  = '(\\\\[\\\\"])';
        $text = '(' . $char . '|' . $esc . ')+';
        $quoted = '(^"' . $text . '"$)';

        // Combined pattern for testing local part
        $localPattern = '/' . $address . '|' . $quoted . '/';

        // Call the pattern method and exit if it yields an error
        $this->pattern($name, $local, $localPattern,
                'Invalid username part.');
        if ($field->hasError()) { return; }

        // Patterns for domain part
        $hostname = '([[:alnum:]]([-[:alnum:]]{0,62}[[:alnum:]])?)';
        $hostnames = '(' . $hostname . '(\.' . $hostname . ')*)';
        $top = '\.[[:alnum:]]{2,6}';
        $domainPattern = '/^' . $hostnames . $top . '$/';

        // Call the pattern method
        $this->pattern($name, $domain, $domainPattern,
                'Invalid domain name part.');
    }
     public function pword($name, $pword, $required = true) {
        $field = $this->fields->getField($name);

        if (!$required && empty($pword)) {
            $field->clearErrorMessage();
            return;
        }

        $this->text($name, $pword, $required, 8);
        if ($field->hasError()) { return; }

        $pw = '/^(?=.*[[:digit:]])(?=.*[[:upper:]])[[:print:]]{8,}$/';

        $pwMatch = preg_match($pw, $pword);

        if ($pwMatch === false) {
            $field->setErrorMessage('Error testing password.');
            return;
        } else if ($pwMatch != 1) {
            $field->setErrorMessage(
                    'Must have one each of upper, lower and be of length 8.');
            return;
        }
    }
    
    public function verify($name, $pword, $verify, $required = true) {
        $field = $this->fields->getField($name);
        $this->text($name, $verify, $required, 6);
        if ($field->hasError()) { return; }

        if (strcmp($pword, $verify) != 0) {
            $field->setErrorMessage('Passwords do not match.');
            return;
        }
    }
    
    public function date($name, $value){
        $field = $this->fields->getField($name);
        $interval = new DateInterval('P1M');
        $max_date = new DateTime();
        $max_date->add($interval);
        $max_date_f = $max_date->format('n/j/Y');
        
        try{
            $req_date = new DateTime($value);         
        } catch (Exception $ex) {
            $field->setErrorMessage('Invalid date format.');
            return;
        }
        $req_date_f = $req_date->format('Y-m-d');
        $today = date("Y-m-d");
        $today_time = strtotime($today);
        $expire_time = strtotime($req_date_f);
        if ($expire_time < $today_time) {
            $field->setErrorMessage('Date must be greater than today');
            return;           
        }
        
        if ($req_date_f > $max_date_f){
            $field->setErrorMessage('Date must be less than a month from now.');
            return;
        }
        
        // Convert string to time
        $dt1 = strtotime($req_date_f);
        // Get day name from the date
        $dt2 = date("l", $dt1);
        // Convert day name to lower case
        $dt3 = strtolower($dt2);
          if(($dt3 == "saturday" )|| ($dt3 == "sunday"))
          {
              $field->setErrorMessage('Date cannot be on the weekend');
            return;
              }else{
                  $field->clearErrorMessage();
          }
    }
}
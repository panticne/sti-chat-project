<?php

function check_password_strong($password)
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 10) {
        echo 'Password should be at least 10 characters in length and should include at least one upper case letter, one number, and one special character.';
        return false;
    }
    else {
        return true;
    }
}

function antixss($input) {
    return htmlspecialchars($input, ENT_QUOTES);
}

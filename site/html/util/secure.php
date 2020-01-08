<?php

/**
 * Verifies that the given password is strong enough.
 */
function verify_password_strength($password)
{
    $uppercase = preg_match('@[A-Z]@', $password); // one uppercase letter
    $lowercase = preg_match('@[a-z]@', $password); // one lowercase letter
    $number = preg_match('@[0-9]@', $password); // a digit
    $specialChars = preg_match('@[^\w]@', $password); // a special character

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 10) {
        echo 'The password should be at least 10 characters in length and should include at least one uppercase and lowercase letter, one digit, and one special character.';
        return false;
    }

    return true;
}

/**
 * Escapes the input string to avoid XSS attacks.
 */
function anti_xss($input)
{
    return htmlspecialchars($input, ENT_QUOTES);
}

/**
 * Generates and returns a CSRF protection token.
 */
function get_csrf_token()
{
    return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32);
}

<?php
// Login to database variables
$hn = 'localhost';      // Hostname
$db = 'tenmaint';       // Database name
$un = 'root';           // Username
$pw = 'tenmaint123';     // Password

// Function for MySQL errors
function mysql_fatal_error($msg)
{
    $msg2 = mysql_error();
    echo <<<_END
    Niestety nie udało się zrealizować zadania.<br>
    Komunikat błędu:<br>
    
    <p>$msg: $msg2</p><br>
    
    Kliknij przycisk wstecz w przeglądarce i spróbuj ponownie.<br>
    W razie dalszych problemów prosimy o wysłanie
    <a href="mailto:admin@serwer.com">maila do administratora</a><br>
    Dziękujemy.<br>
_END;
}

// Function to prevent XSS attacks
// signs <, > are exchanged to &lt and &gt etc.
function mysql_entities_fix_string($conn, $string)
{    
    return htmlentities(mysql_fix_string($conn, $string));
}
// Function for check magic quotes option is active
// if yes additional sings will be deleted, otherwise we put it extra
function mysql_fix_string($conn, $string)
{
    if(get_magic_quotes_gpc()) $string = stripcslashes ($string);
    return $conn->real_escape_string($string);
}
// Function for clearing variable to prevent xss and others attacks
function clear_text($conn, $text) 
{    
    if(get_magic_quotes_gpc())
    {
        // trim($text) - erase white signs on beggining and at the end
        // mysql_real_escape_string($text) - sql injection prevent function
        // htmlspecialchars($text) - html code deactivation
        $text = htmlspecialchars(mysqli_real_escape_string($conn, trim(stripslashes($text))));
    }
    else 
    {
        $text = htmlspecialchars(mysqli_real_escape_string($conn, trim($text)));
    }
    return $text;
}


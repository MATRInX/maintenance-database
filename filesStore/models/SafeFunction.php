<?php
class SafeFunction{
    private $conn;

    function __construct($conn){
        $this->conn = $conn;
    }
    // Function for MySQL errors
    public static function mysql_fatal_error($msg)
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
    public function mysql_entities_fix_string($string)
    {
        return htmlentities(mysql_fix_string($this->conn, $string));
    }
    // Function for check magic quotes option is active
    // if yes additional sings will be deleted, otherwise we put it extra
    public function mysql_fix_string($string)
    {
        if(get_magic_quotes_gpc()) $string = stripcslashes ($string);
        return $this->conn->real_escape_string($string);
    }
    // Function for clearing variable to prevent xss and others attacks
    public function clear_text($text)
    {
        if(is_string($text)){
            if(get_magic_quotes_gpc())
            {
                // trim($text) - erase white signs on beggining and at the end
                // mysql_real_escape_string($text) - sql injection prevent function
                // htmlspecialchars($text) - html code deactivation
                $text = htmlspecialchars(mysqli_real_escape_string($this->conn, trim(stripslashes($text))));
            }
            else
            {
                //echo 'Text to clear = '.$text;
                $text = htmlspecialchars(mysqli_real_escape_string($this->conn, trim($text)));
            }
        }        
        return $text;
    }
}
?>
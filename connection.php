<?php
function db_connect()
{
    // Define connection as a static variable, to avoid connecting more than once
    static $connection;
    // Try and connect to the database, if a connection has not been established yet
    if (!isset($connection)) {
        // Load configuration as an array. Use the actual location of your configuration file
        $config = parse_ini_file('db/config.ini');
        $connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['database']);
        // If connection was not successful, handle the error
        if ($connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return mysqli_connect_error();
        }
    }
    return $connection;
}
function db_query($query)
{
    // Connect to the database
    $connection = db_connect();
    // Query the database
    $result = mysqli_query($connection, $query);
    return $result;
}
function db_error()
{
    $connection = db_connect();
    return mysqli_error($connection);
}
function db_select($query)
{
    $rows = array();
    $result = db_query($query);
    // If query failed, return `false`
    if ($result === false) {
        return false;
    }
    // If query was successful, retrieve all the rows into an array
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function db_select2($query)
{
    $rows = array();
    $result = db_query($query);
    // If query failed, return `false`
    if ($result === false) {
        return false;
    }
    // If query was successful, retrieve all the rows into an array
    $rows = mysqli_fetch_assoc($result);
    return $rows;
}

function db_quote($value)
{
    $connection = db_connect();
    return "'" . mysqli_real_escape_string($connection, $value) . "'";
}
function db_signin($username, $password)
{
    session_start();
    $username = db_quote($username);
    // check if username already exists
    $query = "SELECT * FROM `accounts` WHERE `username` =" . $username;
    $result = db_select($query);
    // username doesn't exist
    if ($result == array()) {
        // hash password
        $password = db_quote(password_hash($password, PASSWORD_DEFAULT));
        $query =  $query = "INSERT INTO `accounts` (`username`,`password`) VALUES (" . $username . "," . $password . ")";
        $result = db_query($query);
        $query = "SELECT * FROM `accounts` WHERE `username` =" . $username;
        $_SESSION['player'] = db_select($query)[0];
        header("Location: game.php");
    }
    // if user exists
    else {

        // verify password
        $x = password_verify($password, $result[0]['password']);
        if ($x) {
            $query = "UPDATE `accounts` SET `roomID` = NULL WHERE `username` =" . $username;
            $result = db_query($query);
            $query = "SELECT * FROM `accounts` WHERE `username` =" . $username;
            $result = db_select($query);
            session_start();
            $_SESSION['player'] = $result[0];
            header("Location: game.php");
        } else {
            print_r($_SESSION);
            header("Location: index.php");
        }
    }
}
function joinRoom($invite, $manali, $id)
{
}
function console($var)
{
    echo '<script>console.log("PHP: "+"' . json_encode($var) . '")</script>';
}
function consoleJSON($var)
{
    echo '<script>console.log(' . json_encode($var) . ')</script>';
}

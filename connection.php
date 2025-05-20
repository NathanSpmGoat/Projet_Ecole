<?php

    $host='localhost';
    $dbname='projet';
    $user='root';
    $passwd='';
    
    try
    {
        $connection=new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user,$passwd);
        $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        die("Erreur : ". $e->getMessage());
    }
?>
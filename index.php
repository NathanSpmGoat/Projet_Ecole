<?php
require_once "connection.php";
session_start();

if(isset($_COOKIE["remember_me"]))
{
    $cookiesvalues=$_COOKIE["remember_me"];
    list($user_id,$token)=explode(":", $cookiesvalues);
    $requête="SELECT * FROM user_infos WHERE id = :user_id AND token = :token";
    $stmt=$connection->prepare($requête);
    $hash_token=hash('sha256', $token);
    $stmt->execute([
        ':user_id' => $user_id,
        ':token' => $hash_token
    ]);
    $res=$stmt->fetch();

    if($res)
    {
        $_SESSION["user_id"]=$res["id"];
        $_SESSION["username"]=$res["Username"];
        $_SESSION["email"]=$res["Email"];
        $_SESSION["admin"]=$res["Admin"];
    }
    header("location:accueil.php");
    exit;
    
}
else
{
    if (isset($_COOKIE["Already"]))
        {header("location:login.php"); exit;}
    else
        {header("location:game.php"); exit;}
}

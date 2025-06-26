<?php
require_once "connection.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_user = $_SESSION["user_id"] ?? null;

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

if (isset($_COOKIE['remember_me'])) {
    setcookie("remember_me", '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    unset($_COOKIE['remember_me']);
}

if ($id_user !== null) {
    $requête = "UPDATE user_infos SET token = NULL WHERE id = :id";
    $stmt = $connection->prepare($requête);
    $stmt->bindParam(':id', $id_user);
    $stmt->execute();
}

session_destroy();

usleep(800000);
header("location:login.php");
exit;
?>

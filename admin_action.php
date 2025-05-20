<?php
require_once "connection.php";
    foreach ($_POST as $id => $value) 
    {
        //echo $value;
        if ($value=="delete")
        {
            // Suppression dans la base de données
            $stmt = $connection->prepare("DELETE FROM articles WHERE id = :id");
            $stmt->bindParam(':id', $id,);
            $stmt->execute();
            header("location:admin.php");
            exit;
        }
        else
        {
            header("location:edit_item.php");
            exit;
        }
    }
?>
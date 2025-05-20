<?php
        require_once "connection.php";
        $requête="SELECT * FROM articles";
        $stmt=$connection->query($requête);
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once "_header.php";?> 
<head>
    <link rel="stylesheet" href="Css/style2.css">
</head>
<body>
    <div class="container">
        <?php if (count($res)>0) :?>
            <table class="table">
                <thead class="header">
                    <tr class="main">
                        <th>TITRE</th>
                        <th>GENRE</th>
                        <th>IMAGE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

                <?php
                    for($i=0;$i<count($res);$i++)
                    {?> 
                        <tr class="content">
                            <td class="titre"><?= $res[$i]["titre"] ?></td>
                            <td class="genre"><?= $res[$i]["genre"] ?></td>
                            <td class="image"><img src=<?= $res[$i]["image"]?> alt="image film" width="120" height="150"></td>
                            <td class="action">
                                <form action="admin_action.php" method="post">
                                    <button type="submit" name=<?= $res[$i]["id"] ?> class="button delete" value="delete">Supprimer</button>
                                    <button type="submit" name=<?= $res[$i]["id"] ?> class="button edit" value="edit">Modifier</button>
                                </form>
                            </td>
                        </tr>
                <?php } ?>
            </table>
            <?php else :?>
                <h2 style="color:red ; font-size:50px">DATABASE EMPTY</h2>
            <?php endif ?>
        </div> 

</body>
</html>
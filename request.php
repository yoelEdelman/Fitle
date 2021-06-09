<?php

require_once('db_connect.php');

$query = $pdo->query('PRAGMA table_info(census_learn_sql)');
$columns = $query->fetchAll(PDO::FETCH_ASSOC);

//La boucle et la condition sert juste à verifier que nom de la colonne envoyer par l’utilisateur n’a pas été modifié (par soucis de sécurité)
foreach ($columns as $column) {
    if (in_array($_GET['column'], $column)) {
        $columnName = $column['name'];
        $queryString = "SELECT COUNT(`$columnName`) AS duplicates, `$columnName` AS row, ROUND(AVG(age), 0) AS average
                FROM census_learn_sql
                GROUP BY `$columnName`
                HAVING duplicates > 1";
        $query = $pdo->prepare($queryString);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }
}

<?php

require_once('db_connect.php');

$query = $pdo->query('SELECT * FROM census_learn_sql ORDER BY age DESC limit 100');
$rows = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $pdo->query('PRAGMA table_info(census_learn_sql)');
$columns = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Fitle</title>
</head>
<body>
<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-dark">
            <thead>
            <tr>
                <?php foreach ($columns as $column): ?>
                    <th scope="col"><a class="link-danger column-link" data-bs-toggle="modal" data-bs-target="#exampleModal" id="<?= $column['name']; ?>" href=""><?= $column['name']; ?></a></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <?php foreach ($row as $value): ?>
                        <td><?= $value; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="exampleModal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Count of rows, values and average of the selected column</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered border-primary">
                    <thead>
                    <tr>
                        <th scope="col">Row</th>
                        <th scope="col">Duplicates</th>
                        <th scope="col">Average</th>
                    </tr>
                    </thead>
                    <tbody id="modal-body">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script>
    let links = document.querySelectorAll('.column-link')
    let modalBody = document.querySelector('#modal-body')
    let rows = ''

    for (let i = 0; i < links.length; i++) {
        links[i].addEventListener("click", (e) => {
            e.preventDefault()
            getData(links[i])
        })
    }

    const getData = (columnName) => {
        fetch(`request.php?column=${columnName.id}`)
            .then(response => response.json())
            .then(data => showData(data))
    }

    const showData = (data) => {
        rows = ''
        for (let i = 0; i < data.length; i++) {
            rows += `<tr>
                      <th>${data[i].row}</th>
                      <td>${data[i].duplicates}</td>
                      <td>${data[i].average}</td>
                    </tr>`

        }
        modalBody.innerHTML = rows
    }
</script>
</body>
</html>
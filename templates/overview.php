<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.2/TweenMax.min.js"></script>

    <meta charset = "UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <title>PiTS</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Temperatur 1</th>
                <th>Temperatur 2</th>
                <th>Erstellungszeitpunkt</th>
                <th>Eintragungsdatum</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($datasets as $dataset)
            { ?>
            <tr>
                <td><?= $dataset->getId();?></td>
                <td><?= $dataset->getTempIn();?></td>
                <td><?= $dataset->getTempOut();?></td>
                <td><?= $dataset->getCreateDate();?></td>
                <td><?= $dataset->getWriteDate();?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">

    <meta charset = "UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <title>PiTS</title>

    <style>
        body{
            background-color: lightgrey;
        }

        .heading{
            background-color: white;
            padding: 20px;
        }

        .card, .export-button{
            margin-bottom: 25px;
            margin-top: 25px;
        }
    </style>
</head>
<body>

<div class="heading shadow">
    <span class="heading-body">
        <h1>
            <b>PiTS</b>
        </h1>
    </span>
</div>

<div class="container">
    <div class="export-button">
        <button class="btn shadow" id="export" data-export="index.php?controller=OverviewController&action=downloadAction">
            <i class="fas fa-cloud-download-alt"></i>
        </button>
    </div>

    <canvas>

    </canvas>

    <div class="card shadow">
        <div class="card-header">
            <h3>Temperatur</h3>
        </div>

        <div class="card-body">
            <table class="table table-striped">
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
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.2/TweenMax.min.js"></script>
<script src="https://d3js.org/d3.v5.min.js"></script>
<script>
    $(document).on('click', '#export', function(){
        $.ajax({
            url: window.location.href + '?action=downloadAction',
            type: 'POST',
            success: function() {
                console.log('success');
            },
            error: function (data) {
                console.error(data);
            }
        });
    })
</script>
</body>
</html>
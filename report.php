<?php
include 'config/config.php';
$reportpage = $db->prepare("SELECT * FROM analiysis where analiysis_id=:id");
$reportpage->execute(array(
    'id' => $_GET['analiysis_id']
));
$showreport = $reportpage->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo  csjs(); ?>
    <title><?php echo $showreport['analiysis_title'] ?> | Report</title>
</head>

<body>
    <section class="container pt-2 pb-2">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a href="index.php" class="nav-link ">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page">Report</a>
            </li>
        </ul>
    </section>
    <section class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="card m-1" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Data Information</h5>
                        <p class="card-text">You are searched for <strong class="text-info"> <?php echo $showreport['analiysis_url'] ?></strong> url. We are found some data for you. </p>
                    </div>
                </div>
                <div class="card m-1" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Robots.txt Data</h5>
                        <p class="card-text"><?php echo $showreport['analiysis_robots'] ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <ul class="list-group">
                    <li class="list-group-item">Page Title : <?php echo $showreport['analiysis_title'] ?></li>
                    <li class="list-group-item">Page URL : <?php echo $showreport['analiysis_url'] ?></li>
                    <li class="list-group-item">Canonical URL : <?php echo $showreport['analiysis_canonical'] ?></li>
                    <li class="list-group-item">We Found <strong><?php echo $showreport['analiysis_h1'] ?></strong> H1 Tag.</li>
                    <li class="list-group-item">We Found <strong><?php echo $showreport['analiysis_h2'] ?></strong> H2 Tag.</li>
                    <li class="list-group-item">We Found <strong><?php echo $showreport['analiysis_h3'] ?></strong> H3 Tag.</li>
                    <li class="list-group-item">We Found <strong><?php echo $showreport['analiysis_h4'] ?></strong> H4 Tag.m</li>
                    <li class="list-group-item">We Found <strong><?php echo $showreport['analiysis_h5'] ?></strong> H5 Tag.</li>
                    <li class="list-group-item">We Found <strong><?php echo $showreport['analiysis_h6'] ?></strong> H6 Tag.</li>
                </ul>
                <div class="card">
                    <div class="card-body">
                        <h6>Most Used Words</h6>
                        <?php echo  tagcleaner($showreport['analiysis_mostwords'])  ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6>Images</h6>
                        <?php echo $showreport['analiysis_images']; ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6>Image Alt Tags</h6>
                        <?php
                        $text = AltTextAnalyzer($showreport['analiysis_images'], $showreport['analiysis_imagesalt']);
                        echo $text["items"] . "<p>" . $text["counter"] . " Image have missed alt tags.</p>";
                        ?>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6>Page URLs</h6>
                        <?php
                        echo  tagcleaner($showreport['analiysis_urls']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>

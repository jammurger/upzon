<?php include 'config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php echo  csjs(); ?>
  <title>upzon Data Analiysis</title>
  <style>
    th {
      background: white;
      position: sticky;
      top: 0;
      /* Don't forget this, required for the stickiness */
      box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>

<body>
  <section class="container pt-2 pb-2">
<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Report</a>
  </li>
</ul>
</section>
  <section class="container">
    <table class="table">
      <tr>
        <th>Analyzed ID</th>
        <th>URL</th>
        <th>Page Title</th>
        <th>Canonical</th>
        <th>H1 Count</th>
        <th>H2 Count</th>
        <th>H3 Count</th>
        <th>H4 Count</th>
        <th>H5 Count</th>
        <th>H6 Count</th>
        <th>Image Alt Tag</th>
        <th>Analyzed Time</th>
        <th>Report</th>
      </tr>
      <?php
      $analiysis = $db->prepare("SELECT * from analiysis ORDER BY analiysis_id DESC");
      $analiysis->execute();
      while ($show = $analiysis->fetch(PDO::FETCH_ASSOC)) {
      ?>
        <tr>
          <td><?php echo $show['analiysis_id'] ?></td>
          <td><?php echo $show['analiysis_url'] ?></td>
          <td><?php echo $show['analiysis_title'] ?></td>
          <td><?php echo $show['analiysis_canonical'] ?></td>
          <?php if ($show['analiysis_h1'] == 1) { ?>
            <td class="text-success"><?php echo $show['analiysis_h1'] ?></td>
          <?php } elseif ($show['analiysis_h1'] != 1) { ?>
            <td class="bg-danger"><?php echo $show['analiysis_h1'] ?></td>
          <?php } ?>
          <?php if ($show['analiysis_h2'] == 0 and $show['analiysis_h3'] > $show['analiysis_h2']) { ?>
            <td class="bg-danger"><?php echo $show['analiysis_h2'] ?></td>
          <?php  } else { ?>
            <td class="bg-success"><?php echo $show['analiysis_h2'] ?></td>
          <?php  }
          ?>

          <td><?php echo $show['analiysis_h3'] ?></td>
          <td><?php echo $show['analiysis_h4'] ?></td>
          <?php if ($show['analiysis_h5'] == 0 and $show['analiysis_h6'] > $show['analiysis_h5']) { ?>
            <td class="bg-danger"><?php echo $show['analiysis_h5'] ?></td>
          <?php   } else { ?>
            <td class="bg-success"><?php echo $show['analiysis_h5'] ?></td>
          <?php } ?>

          <td><?php echo $show['analiysis_h6'] ?></td>
          <?php
          $text = AltTextAnalyzer($show['analiysis_images'], $show['analiysis_imagesalt']);
          if ($text["counter"] != 0) { ?>
            <td class="bg-danger"> <?php echo $text["counter"] . " Missed Alt Tag"; ?> </td>
          <?php  } else { ?>
            <td class="bg-success">Good</td>
          <?php  }
          ?>
          <td>
            <?php $published = date_create($show['analiysis_time']);
            echo date_format($published, 'M d, Y'); ?>
          </td>
          <th> <a href="report.php?analiysis_id=<?php echo $show['analiysis_id']; ?>"> <Button class="btn btn-info">Watch Report</Button></a></th>
        </tr>
      <?php } ?>
    </table>
    <p>For more <a href="https://github.com/upzerk/upzon">upzerk github </a></p>
  </section>
</body>

</html>

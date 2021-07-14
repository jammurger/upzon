<?php include 'config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>upzon Data Analiysis</title>
</head>

<body>

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
        <th>Analyzed Time</th>
        <th>Report</th>
      </tr>
      <?php
      $analiysis = $db->prepare("SELECT * from analiysis ORDER BY analiysis_id DESC");
      $analiysis->execute();
      while ($show = $analiysis->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
          <td><?php echo $show['analiysis_id'] ?></td>
          <td><?php echo $show['analiysis_url'] ?></td>
          <td><?php echo $show['analiysis_title'] ?></td>
          <td><?php echo $show['analiysis_canonical'] ?></td>
          <td><?php echo $show['analiysis_h1'] ?></td>
          <td><?php echo $show['analiysis_h2'] ?></td>
          <td><?php echo $show['analiysis_h3'] ?></td>
          <td><?php echo $show['analiysis_h4'] ?></td>
          <td><?php echo $show['analiysis_h5'] ?></td>
          <td><?php echo $show['analiysis_h6'] ?></td>
          <td>
            <?php $published = date_create($show['analiysis_time']);
            echo date_format($published, 'M d, Y'); ?>
          </td>
          <th> <a href="report.php?analiysis_id=<?php echo $show['analiysis_id']; ?>"> <Button class="btn btn-info">Watch Report</Button></a></th>
        </tr>
      <?php } ?>
    </table>
  </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</html>
<?php

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();


function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Calendar</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <table>
    <thead>
      <tr>
        <th><a href="/?t=<?php echo h($exhibit->prev); ?>">&laquo;</a></th>
        <th colspan="5"><?php echo h($exhibit->yearMonth); ?></th>
        <th><a href="'$title'.php/?t=<?php echo h($exhibit->next); ?>">&raquo;</a></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Sun</td>
        <td>Mon</td>
        <td>Tue</td>
        <td>Wed</td>
        <td>Thu</td>
        <td>Fri</td>
        <td>Sat</td>
      </tr>
      <?php $exhibit->show(); ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="7"><a href="/">Today</a></th>
      </tr>
    </tfoot>
  </table>
</body>
</html>

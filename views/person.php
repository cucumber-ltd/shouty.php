<!DOCTYPE html>
<html>
<head>
    <title>Shouty</title>
</head>
<body>
<h1><?php echo $personName; ?></h1>
<form action="/messages" method="POST">
    <input name="personName" value="<?php echo $personName; ?>" type="hidden">
    <input id="message" name="message" placeholder="What's happening?">
    <input id="shout" type="submit" value="Shout">
</form>
<ul id="messages">
  <?php
  foreach($messages as $message) {
    echo "<li>$message</li>";
  }
  ?>
</ul>
</body>
</html>

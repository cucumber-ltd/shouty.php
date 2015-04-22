<!DOCTYPE html>
<html>
<head>
    <title>Shouty</title>
</head>
<body>
<h1><?php echo $personName; ?></h1>
<form action="/messages" method="POST">
    <input name="personName" value="<?php echo $personName; ?>" type="hidden">
    <input name="message" placeholder="What's happening?">
</form>
<ul id="messages">
  <?php foreach($messages as $message) { ?>
    <li><?php $message ?></li>
  <?php } ?>
</ul>
</body>
</html>

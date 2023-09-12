<!DOCTYPE html>
<html>
<?php
include_once 'head.php';
?>
<body>
<?php
include_once 'nav.php';
if (isset($_POST['add-edition'])) {
    require_once 'add_edition_handler.php';
}
else {
    require_once 'add_edition_form.php';
}
?>
</body>
</html>


<?php

$classBuilder['Index'] = new IndexView();

class IndexView {

public function show($args) {
/* Content Starts Here */
?>
<html>
<head>
<title>Wishit Index</title>
</head>
<body>
<?php print_r($args); ?>
</body>
</html>
<?
/* Content Ends Here */
}

}

?>

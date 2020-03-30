<?php
include_once(dirname(__FILE__) . "/../config/config.php");
if (isset($_REQUEST['Event'])) {
    $Event = $_REQUEST['Event'];
} else {
    $Event = 'Purchase';
}

$Price = "&price={$_REQUEST['price']}";


?>
<script>
    window.location = "fb.php?<?php echo "Event=$Event$Price"; ?>";
</script>

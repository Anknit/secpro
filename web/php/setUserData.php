<?php
?>
<script type="text/javascript">
    var appdata = appdata || {};
    appdata.userdata = {};
    appdata.userdata = <?php echo json_encode($_SESSION['userdata']); ?>
</script>
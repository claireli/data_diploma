

<script type="text/javascript"> 
var username = <?php echo json_encode($user_name) ?> ; 
var userID = <?php echo json_encode($user_ID) ?> ; 
</script>

<script type="text/javascript"> 
document.domain = "MYDOMAIN.com"; 
</script> 
<iframe id="example1" style="border: none; width: 100%; height: 500px;" src="PATH_TO_SHINY_APP" width="300" height="150" frameborder="0"></iframe>
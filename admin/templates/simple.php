<?php
$settings = get_option( 'mailtpl_opts' );
echo '<pre>';
var_dump($settings);
echo '<pre>';
include_once( 'simple/header.php');?>
%%MAILCONTENT%%
<?php include_once( 'simple/footer.php');?>

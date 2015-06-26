<?php
if( is_customize_preview() ) {
	include_once('default-message.php');
} else {
	echo '%%MAILCONTENT%%';
}
<?php
//' OR '1'='1
//echo md5('admin');

function escape($String){
    return htmlentities(trim($String),ENT_QUOTES,'UTF-8');
	
}



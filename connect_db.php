<?php
if (strpos($_SERVER['SERVER_NAME'], "jose") !== false)
{
$dbc = mysqli_connect("jose.stca.herts.ac.uk", "UrJoseId", "UrJosePw", "dbUrJoseId")
OR die(mysqli_connect_error());
}
else
{
//for mamp users its "root","root" rather than "root",""
$dbc = mysqli_connect("localhost", "root", "root", "site_db") 
OR die(mysqli_connect_error());
}


# Set encoding to match PHP script encoding.
mysqli_set_charset( $dbc, 'utf8' ) ;
?>
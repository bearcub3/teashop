<?php # PROCESS LOGIN ATTEMPT.

# Check form submitted.
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
  # Open database connection.
  require ( 'connect_db.php' ) ;

  # Get connection, load, and validate functions.
  require ( 'login_tools.php' ) ;

  $redirect = NULL;
  if($_POST['location'] != '') $redirect = $_POST['location'];

  # Check login.
  list ( $check, $data ) = validate ( $dbc, $_POST[ 'email' ], $_POST[ 'password' ] ) ;

  # On success set session data and display logged in page.
  if ( $check )  
  {
    session_start();
    $_SESSION[ 'user_id' ] = $data[ 'user_id' ];
    $_SESSION[ 'first_name' ] = $data[ 'first_name' ];
    $_SESSION[ 'last_name' ] = $data[ 'last_name' ];
    
    if($redirect) {
      header("Location:". $redirect);
    } else {
      load ( 'home.php' );
    }
    

  } else { 
    $errors = $data; 
  }

  # Close database connection.
  mysqli_close( $dbc ) ; 
}

# Continue to display login page on failure.
include ( 'login.php' ) ;

?>
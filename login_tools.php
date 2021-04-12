<?php # LOGIN HELPER FUNCTIONS.

# Function to load specified or default URL.
function load( $page = 'login.php' )
{
  $scheme='http';
  if(isset($_SERVER['HTTPS'])) $scheme = 'https';
  $url = $scheme . '://' . $_SERVER[ 'HTTP_HOST' ] . dirname( $_SERVER[ 'PHP_SELF' ] ) ;

  # Remove trailing slashes then append page name to URL.
  $url = rtrim( $url, '/\\' ) ;

  echo $url;
  $url .= '/' . $page ;

  # Execute redirect then quit. 
  header( "Location: $url" ) ;
  exit() ;
}

# Function to check email address and password. 
function validate( $dbc, $email = '', $pwd = '' )
{
  # Initialize errors array.
  $errors = array() ; 
  $type = ['email', 'password', 'no account'];

  # Check email field.
  if ( empty( $email ) ) 
  { $errors[] = $type[0] ; } 
  else  { $e = mysqli_real_escape_string( $dbc, trim( $email ) ) ; }

  # Check password field.
  if ( empty( $pwd ) ) 
  { $errors[] = $type[1] ; } 
  else { $p = mysqli_real_escape_string( $dbc, trim( $pwd ) ) ; }

  # On success retrieve user_id, first_name, and last name from 'users' database.
  if ( empty( $errors ) ) 
  {
    $q = "SELECT user_id, first_name, last_name FROM users WHERE email='$e' AND pass=SHA1('$p')" ;  
    $r = mysqli_query ( $dbc, $q ) ;
    if ( @mysqli_num_rows( $r ) == 1 ) 
    {
      $row = mysqli_fetch_array ( $r, MYSQLI_ASSOC ) ;
      return array( true, $row ) ; 
    }
    # Or on failure set error message.
    else { $errors[] = $type[2] ; }
  }
  # On failure retrieve error message/s.
  return array( false, $errors ) ; 
}
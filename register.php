<?php # DISPLAY COMPLETE REGISTRATION PAGE.

# Set page title and display header section.
$page_title = 'Register' ;
include ( 'includes/header.html' ) ;

# Check form submitted.
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
  # Connect to the database.
  require ('connect_db.php'); 
  
  # Initialize an error array.
  $errors = array();
  $fields = ['first_name', 'last_name', 'email', 'pass1', 'pass2'];


  foreach ($fields as $field) {
    if (empty($_POST[$field])) 
    {
      $errors[] = $field;
      mysqli_close( $dbc ); 
    }
  }

  if (!empty($_POST[ 'first_name' ]))
  {
    if (preg_match('/[^a-zA-Z\d]|\d/', $_POST['first_name']))
      {
        $errors[] = $fields[0];
      }
  }

  if (!empty($_POST[ 'last_name' ]))
  {
    if (preg_match('/[^a-zA-Z\d]|\d/', $_POST['last_name']))
      {
        $errors[] = $fields[1];
      }
  }

  if ( !empty($_POST[ 'pass1' ] ) )
  {
    if ( $_POST[ 'pass1' ] != $_POST[ 'pass2' ] )
    { $errors[] = $fields[3]; }
  }

  $fn = mysqli_real_escape_string( $dbc, trim( $_POST[ 'first_name' ] ) );
  $ln = mysqli_real_escape_string( $dbc, trim( $_POST[ 'last_name' ] ) );
  $e = mysqli_real_escape_string( $dbc, trim( $_POST[ 'email' ] ) );
  $p = mysqli_real_escape_string( $dbc, trim( $_POST[ 'pass1' ] ) );

  if ( empty( $errors ) )
  {
    $q = "SELECT user_id FROM users WHERE email='$e'" ;
    $r = @mysqli_query( $dbc, $q ) ;
    if ( mysqli_num_rows( $r ) != 0 ) 
    {
      echo 'Email address already registered. <a href="login.php">Login</a>';
    }
  }

  if ( empty( $errors ) ) 
  {
    $q = "INSERT INTO users (first_name, last_name, email, pass, reg_date) VALUES ('$fn', '$ln', '$e', SHA1('$p'), NOW())";
    $r = @mysqli_query ( $dbc, $q ) ;

    if ($r) echo '<h1>Registered!</h1><p>You are now registered.</p><p><a href="login.php">Login</a></p>';

    # Close database connection.
    mysqli_close($dbc);
    include ( 'includes/footer.html' ) ; 
    exit();
  }
}
?>

<!-- Display body section with sticky form. -->
<h1>Register</h1>
<form action="register.php" method="post">
  <div class="row justify-content-end mt-3">
    <label for="first_name" class="col-3">First Name</label>
    <input class="col-9" type="text" name="first_name" id="first_name" size="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>">
    <?php if (in_array('first_name', $errors)): ?>
      <p class="col-9 text-warning">First name must have a value without special characters or numbers.</p>
    <?php endif; ?>
    </div>
  <div class="row justify-content-end mt-3">
    <label for="last_name" class="col-3">Last Name</label>
    <input class="col-9" type="text" name="last_name" id="last_name" size="20" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>">
    <?php if (in_array('last_name', $errors)): ?>
      <p class="col-9 text-warning">Last name must have a value without special characters or numbers.</p>
    <?php endif; ?>
  </div>
  <div class="row justify-content-end mt-3">
    <label for="email" class="col-3">Email Address</label>
    <input class="col-9" type="text" name="email" size="50" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
    <?php if (in_array('email', $errors)): ?>
      <p class="col-9 text-warning">Enter your email.</p>
    <?php endif; ?>
  </div>
  <div class="row justify-content-end mt-3">
    <label for="pass1" class="col-3">Password</label>
    <input class="col-9" type="password" name="pass1" id="pass1" size="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" >
    <?php if (in_array('pass1', $errors)): ?>
      <p class="col-9 text-warning">Passwords must be entered or they do not match. Try again.</p>
    <?php endif; ?>
  </div>
  <div class="row justify-content-end mt-3">
    <label for="pass2" class="col-3">Confirm Password: </label>
    <input class="col-9" type="password" name="pass2" id="pass2" size="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>">
  </div>
  <div class="d-flex justify-content-center mt-3">
    <input class="w-50 btn btn-primary" type="submit" value="Register">
  </div>
</form>

<?php 
# Display footer section.
include ( 'includes/footer.html' ) ; 
?>

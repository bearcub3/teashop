<?php # DISPLAY COMPLETE LOGIN PAGE.

# Set page title and display header section.
$page_title = 'Login' ;
include ( 'includes/header.html' ) ;


// for a better usability in case of users failing to login at their first attempt
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
    $email = array();
    $email[] = $_POST['email'];
}
?>


<!-- Display body section. -->
<h1>Login</h1>
<form action="login_action.php" method="post">
    <div class="row justify-content-end mt-3">  
        <label for="email" class="col-3">Email Address</label>
        <input class="col-9" type="text" name="email" id="email" size="20" value="<?php if (!empty( $errors ) && in_array('password', $errors)) echo $email[0] ?>">
        <?php if (!empty( $errors ) && in_array('email', $errors)): ?>
            <p class="col-9 text-warning"><i class="bi bi-exclamation-circle"></i>Enter your email address.</p>
        <?php endif; ?>
    </div>
    <div class="row justify-content-end mt-3">  
        <label for="password" class="col-3">Password</label>
        <input class="col-9" type="password" name="password" id="password" size="20">
        <?php if (!empty( $errors ) && in_array('password', $errors)): ?>
            <p class="col-9 text-warning"><i class="bi bi-exclamation-circle"></i>Enter your password.</p>
        <?php endif; ?>
    </div>
    <?php if (!empty( $errors ) && in_array('no account', $errors)): ?>
    <div class="row mt-3">
        
        <p class="text-warning text-center">
        <i class="bi bi-exclamation-circle"></i>
            Email address and/or password not found. Please, Try again.
        </p>
    </div>
    <?php endif; ?>
    
    <div class="d-flex justify-content-center mt-3">
        <input class="w-50 btn btn-primary" type="submit" value="Log In">
    </div>
</form>

<?php 

# Display footer section.
include ( 'includes/footer.html' ) ; 

?>

<?php # DISPLAY COMPLETE LOGIN PAGE.

# Set page title and display header section.
$page_title = 'Login' ;
include ( 'includes/header.php' ) ;


// for a better usability in case of users failing to login at their first attempt
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
    $email = array();
    $email[] = $_POST['email'];
}
?>


<!-- Display body section. -->
<div class="d-flex flex-column my-5">
<h2>Log In</h2>
<div class="bg-light rounded border">
<form action="login_action.php" method="post">
    <div class="row justify-content-start mx-3 my-3">  
        <label for="email" class="col-4 col-sm-2 col-md-3">Email Address</label>
        <div class="col-8 col-sm-4 col-md-5">
            <input class="w-100" type="text" name="email" id="email" size="20" value="<?php if (!empty( $errors ) && in_array('password', $errors)) echo $email[0] ?>">
            <?php if (!empty( $errors ) && in_array('email', $errors)): ?>
                <p class="mt-2 text-warning"><i class="bi bi-exclamation-circle"></i> Enter your email address.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row justify-content-start mx-3">  
        <label for="password" class="col-4 col-sm-2 col-md-3">Password</label>
        <div class="col-8 col-sm-4 col-md-5">
            <input class="w-100" type="password" name="password" id="password" size="20">
            <?php if (!empty( $errors ) && in_array('password', $errors)): ?>
                <p class="mt-2 text-warning"><i class="bi bi-exclamation-circle"></i> Enter your password.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!empty( $errors ) && in_array('no account', $errors)): ?>
    <div class="row justify-content-start mx-3 my-2">
        <p class="text-warning text-center">
        <i class="bi bi-exclamation-circle"></i>
            Email address and/or password not found. Please, Try again.
        </p>
    </div>
    <?php endif; ?>
    
    <div class="row justify-content-center mx-3 my-3">
        <input class="w-50 btn btn-dark" type="submit" value="Log In">
    </div>
    <div class="d-flex justify-content-center mx-3 my-3">
        <a href="register.php">not registered yet?</a>
    </div>
</form>
    </div>
    </div>

<?php 

# Display footer section.
include ( 'includes/footer.html' ) ; 

?>

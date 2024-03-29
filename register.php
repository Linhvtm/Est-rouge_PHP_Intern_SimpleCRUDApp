<?php

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: /');
}

require 'database.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])):
    // Enter the new user in the database
    $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':name', $_POST['name']);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->bindValue(':password', password_hash($_POST['password'], PASSWORD_BCRYPT));

    if ($stmt->execute()):
        $message = 'Successfully created new user';
        header('Location: '.'../Est-rouge_PHP_Intern_SimpleCRUDApp/login.php');
    else:
        $message = 'Sorry there must have been an issue creating your account';
    endif;

endif;

?>

<!DOCTYPE html>
<html>

<head>
    <title>Register Below</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>

<body>

    <div class="header">
        <a href="/">Your App Name</a>
    </div>

    <?php if (!empty($message)): ?>
    <p><?= $message; ?></p>
    <?php endif; ?>

    <h1>Register</h1>
    <span>or <a href="login.php">login here</a></span>

    <form action="register.php" method="POST">
        <input type="text" placeholder="Enter your name" name="name">
        <input type="text" placeholder="Enter your email" name="email">
        <input type="password" placeholder="and password" name="password">
        <input type="password" placeholder="confirm password" name="confirm_password">
        <input type="submit">

    </form>

</body>

</html>
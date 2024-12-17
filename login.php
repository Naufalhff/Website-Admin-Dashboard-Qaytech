<?php
session_start();
if (isset($_POST['submit'])) {
    include './pages/conixion.php';
    $email = $_POST['email'];
    $password = $_POST['pass'];

    if (empty($email) || empty($password)) {
        header("location:index.php?error=please enter your email or password");
        exit();
    }

    $requete = "SELECT * FROM login WHERE email = :email and Password = :password";
    $statment = $conn->prepare($requete);
    $statment->bindParam(':email', $email);
    $statment->bindParam(':password', $password);
    $statment->execute();
    $result = $statment->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['email'] === $email && $result['password'] === $password) {
        $_SESSION['email'] = $result['email'];
        $_SESSION['password'] = $result['password'];
        if (isset($_POST['check'])) {
            setcookie('email', $_SESSION['email'], time() + 3600);
            setcookie('password', $_SESSION['password'], time() + 3600);
        }
        header("location:./pages/dashboard.php");
    } else {
        header("location:index.php?error=email or password not found");
    }
}
?>
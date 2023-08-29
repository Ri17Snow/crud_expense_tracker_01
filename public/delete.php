<?php session_start(); ?>
<?php include('config.php'); ?>
<?php include('header.php'); ?>

<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM expenses WHERE `id` = '$id'";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query Failed" . mysqli_error($connection));
    } else {
        $_SESSION['deleteMessage'] = 'Expenses Deleted!';
        header("Location: index.php");
    }
}

?>

<?php include('footer.php'); ?>


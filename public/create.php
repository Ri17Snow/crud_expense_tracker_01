<?php include('config.php'); ?>
<?php session_start(); ?>
<?php include('header.php'); ?>

<?php
if (isset($_POST['add_expense'])) {
    $category_id = $_POST["category_id"];
    $amount = $_POST["amount"];
    $date = $_POST["date"];
    $description = mysqli_real_escape_string($connection, $_POST["description"]);

    //validation 
    if (empty($category_id) || empty($amount) || empty($amount) || empty($description)) {
        $_SESSION['warningMessage'] = "All fields are required!";
        header("Location: index.php");
    } else {
        $query = "INSERT INTO `expenses`(`category_id`, `amount`, `date`, `description`)
                  VALUES ('$category_id', '$amount', '$date', '$description')";

        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Query Failed: " . mysqli_error($connection));
        } else {
            $_SESSION['addMessage'] = "Expenses Added!";
            header("Location: index.php");
        }
    }
}
?>

<?php include('footer.php'); ?>


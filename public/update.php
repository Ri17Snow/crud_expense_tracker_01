<?php include('config.php'); ?>
<?php session_start(); ?>
<?php include('header.php'); ?>


<!--This PHP ensure that correct data input (id) is correct-->
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM expenses WHERE `id` = '$id'";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

?>

<?php
if (isset($_POST['update_expense'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $category_id = $_POST['category_id'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $query = "UPDATE expenses SET `category_id` = '$category_id', `amount` = '$amount', `date` = '$date', `description` = '$description' WHERE `id` = '$id'";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    } else {
        $_SESSION['updateMessage'] = "Successfully updated!";
        header("Location: index.php");
    }
}

?>


<div class="container-fluid bg-light" style="height: 80vh;">
    <div class="row justify-content-center align-items-center" style="height: 90%;">
        <div class="col-lg-7 col-md-9 col-sm-10 col-12 bg-white p-4 rounded shadow">

            <form action="update.php?id=<?php echo $id; ?> " method="post">

                <div class="form-group">
                    <label for="name" class="fs-5 fw-semibold">Name</label>
                    <select id="name" name="category_id" class="form-select fs-6">
                        <option value="">Select Category</option>

                        <?php
                        $query = "SELECT * FROM categories";
                        $result = mysqli_query($connection, $query);
                        while ($category = mysqli_fetch_assoc($result)) {
                            $selected = ($row['category_id'] == $category['id']) ? "selected" : "";
                            echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                        }
                        ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="amount" class="fs-5 fw-semibold">Amount</label>
                    <input type="number" id="amount" name="amount" class="form-control fs-6" step="0.01" min="1" value="<?php echo isset($row['amount']) ? $row['amount'] : ''; ?>">
                </div>


                <div class="form-group">
                    <label for="date" class="fs-5 fw-semibold mt-2">Date</label>
                    <input type="date" name="date" class="form-control" id="date" value="<?php echo isset($row['date']) ? $row['date'] : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="description" class="fs-5 fw-semibold mt-2">Description</label>
                    <input type="text" name="description" class="form-control" id="description" value="<?php echo isset($row['description']) ? $row['description'] : ''; ?>">
                </div>

                <div class="d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-success mt-3 fs-5 me-2" name="update_expense">UPDATE</button>
                    <a href="index.php" class="btn btn-primary mt-3 fs-5">CLOSE</a>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include('footer.php'); ?>
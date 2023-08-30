<?php include('config.php'); ?>
<?php session_start(); ?>
<?php include('header.php'); ?>

<a href="add_expenses.php" class="btn btn-primary float-end m-2">ADD EXPENSES</a>

<?php
if (isset($_SESSION['warningMessage'])) {
    echo "<h6 class='text-danger text-center  mt-5'>" . $_SESSION['warningMessage'] . "</h6>";
    unset($_SESSION['warningMessage']);
}

if (isset($_SESSION['addMessage'])) {
    echo "<h6 class='text-success text-center  mt-5'>" . $_SESSION['addMessage'] . "</h6>";
    unset($_SESSION['addMessage']);
}

if (isset($_SESSION['updateMessage'])) {
    echo "<h6 class='text-success text-center  mt-5'>" . $_SESSION['updateMessage'] . "</h6>";
    unset($_SESSION['updateMessage']);
}

if (isset($_SESSION['deleteMessage'])) {
    echo "<h6 class='text-danger text-center  mt-5'>" . $_SESSION['deleteMessage'] . "</h6>";
    unset($_SESSION['deleteMessage']);
}
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Description</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>

        <?php

        $query = "SELECT expenses.id, categories.name, expenses.amount, expenses.date, expenses.description
                  FROM expenses
                  INNER JOIN categories ON expenses.category_id = categories.id";

        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("Query Failed" . mysqli_error($connection));
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "
                    <tr>
                        <td>{$row['id']}</td>   
                        <td>{$row['name']}</td>   
                        <td>{$row['amount']}</td>   
                        <td>{$row['date']}</td>   
                        <td>{$row['description']}</td>
                        <td class='d-flex gap-2'>
                            <a href='update.php?id={$row['id']}' class='btn btn-primary'>Update</a>
                            <a href='delete.php?id={$row['id']}' class='btn btn-danger'>Delete</a>
                        </td>
                    </tr>";
            }
        }

        ?>
    </tbody>
</table>

<div class="mt-5 mb-2">
    <!--Filter Form-->
    <form id="filterForm" method="post">
        <div class="row">
            <div class="col-md-3">
                <label for="dateFrom" class="form-label">From Date</label>
                <input type="date" class="form-control" id="dateFrom" name="date_from">
            </div>
            <div class="col-md-3">
                <label for="dateTo" class="form-label">To Date</label>
                <input type="date" class="form-control" id="dateTo" name="date_to">
            </div>
            <div class="col-md-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category">
                    <!-- Populate options dynamically from database -->
                    <option value="">Select Category</option>
                    <?php
                    $categoryQuery = "SELECT * FROM categories";
                    $categoryResult = mysqli_query($connection, $categoryQuery);
                    while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
                        echo '<option value="' . $categoryRow['id'] . '">' . $categoryRow['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="minAmount" class="form-label">Min Amount</label>
                <input type="number" class="form-control" id="minAmount" name="min_amount">
            </div>
            <div class="col-md-3">
                <label for="maxAmount" class="form-label">Max Amount</label>
                <input type="number" class="form-control" id="maxAmount" name="max_amount">
            </div>
            <div class="col-md-3 mt-4">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
    </form>
</div>


<!--Chart Canvas-->
<div class="chart-container mb-5" style="height: 100%">
    <canvas id="expenseChart"></canvas>
</div>

<?php include('footer.php'); ?>
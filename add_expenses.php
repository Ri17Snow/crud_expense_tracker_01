<?php include('config.php'); ?>
<?php session_start(); ?>
<?php include('header.php'); ?>

<div class="container-fluid bg-light" style="height: 80vh;">
    <div class="row justify-content-center align-items-center" style="height: 90%;">
        <div class="col-lg-7 col-md-9 col-sm-10 col-12 bg-white p-4 rounded shadow">
            <form action="create.php" method="post">

                <div class="form-group">
                    <label for="name" class="fs-5 fw-semibold">Name</label>
                    <select id="name" name="category_id" class="form-select fs-6">
                        <option value="">Select Category</option>
                        <?php
                        $query = "SELECT * FROM categories";
                        $result = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="amount" class="fs-5 fw-semibold">Amount</label>
                    <input type="number" id="amount" name="amount" class="form-control fs-6" step="0.01" min="1">
                </div>


                <div class="form-group">
                    <label for="date" class="fs-5 fw-semibold mt-2">Date</label>
                    <input type="date" name="date" class="form-control" id="date">
                </div>

                <div class="form-group">
                    <label for="description" class="fs-5 fw-semibold mt-2">Description</label>
                    <input type="text" name="description" class="form-control" id="description">
                </div>

                <div class="d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-success mt-3 fs-5 me-2" name="add_expense">ADD</button>
                    <a href="index.php" class="btn btn-primary mt-3 fs-5">CLOSE</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
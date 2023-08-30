<?php
include('config.php');

// Fetch and sanitize filter values from POST
$dateFrom = mysqli_real_escape_string($connection, $_POST['date_from']);
$dateTo = mysqli_real_escape_string($connection, $_POST['date_to']);
$category = mysqli_real_escape_string($connection, $_POST['category']);
$minAmount = mysqli_real_escape_string($connection, $_POST['min_amount']);
$maxAmount = mysqli_real_escape_string($connection, $_POST['max_amount']);

// Construct the SQL query based on the filters
$query = "SELECT expenses.id, categories.name, expenses.amount, expenses.date, expenses.description
          FROM expenses
          INNER JOIN categories ON expenses.category_id = categories.id
          WHERE 1"; // Start the query with 1 to include all rows

if (!empty($dateFrom)) {
    $query .= " AND expenses.date >= '$dateFrom'";
}

if (!empty($dateTo)) {
    $query .= " AND expenses.date <= '$dateTo'";
}

if (!empty($category)) {
    $query .= " AND expenses.category_id = '$category'";
}

if (!empty($minAmount)) {
    $query .= " AND expenses.amount >= '$minAmount'";
}

if (!empty($maxAmount)) {
    $query .= " AND expenses.amount <= '$maxAmount'";
}

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query Failed" . mysqli_error($connection));
}

$data = array();
$labels = array();
$dataset = array();

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['name'];
    $dataset[] = $row['amount'];
}

$data['labels'] = $labels;
$data['datasets'] = array(
    array(
        'label' => 'Expenses by Category',
        'data' => $dataset,
        'backgroundColor' => array('red', 'blue', 'green'), // Replace with colors
        'borderWidth' => 1
    )
);

// Send the filtered data as JSON response
header('Content-Type: application/json');
echo json_encode($data);

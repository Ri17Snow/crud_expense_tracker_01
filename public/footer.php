</div>

<div class="mb-5">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fetch data from the server using PHP and encode as JSON
        <?php
        $query = "SELECT categories.name AS category_name, SUM(expenses.amount) AS total_amount
              FROM expenses
              INNER JOIN categories ON expenses.category_id = categories.id
              GROUP BY categories.id";

        $result = mysqli_query($connection, $query);

        $data = array();
        $labels = array();
        $dataset = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $labels[] = $row['category_name'];
            $dataset[] = $row['total_amount'];
        }

        $data['labels'] = $labels;
        $data['datasets'] = array(
            array(
                'label' => 'Expenses by Category',
                'data' => $dataset,
                'backgroundColor' => array('red', 'blue', 'yellow', 'green'), // Replace with colors
                'borderWidth' => 1
            )
        );

        echo "var data = " . json_encode($data) . ";";
        ?>

        // Get the canvas element
        var ctx = document.getElementById('expenseChart').getContext('2d');

        // Create the chart using Chart.js
        var myChart = new Chart(ctx, {
            type: 'bar', // Use 'pie' for a pie chart
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Expenses'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Expense Categories'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                        position: 'right' // Position the legend to the right
                    },
                    title: {
                        display: true,
                        text: 'Expenses by Category'

                    }
                }
            }
        });

        // Adjust canvas width to 40-50% of page width
        var canvas = document.getElementById('expenseChart');
        var container = canvas.parentNode;
        var desiredWidth = container.offsetWidth * 0.4; // Adjust this value as needed
        canvas.width = desiredWidth;


        // Add event listener to the filter form
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            // Fetch filtered data using AJAX
            var formData = new FormData(document.getElementById('filterForm'));
            fetch('filter_data.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(filteredData => {
                    // Update the chart with the new filtered data
                    myChart.data = filteredData;
                    myChart.update();
                });
        });
    </script>
</div>

<footer class="mt-5 text-center fixed-bottom bg-secondary pt-3 text-light">
    <p class="fw-semibold">This is a simple expense tracker - <?php echo date("F Y"); ?></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
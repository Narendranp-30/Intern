<?php
include 'master.php';

if (isset($_GET['branch'])) {
    $branchName = $_GET['branch'];

    // Fetch branch ID by name
    $branchId = getBranchIdByName($conn, $branchName);

    if ($branchId) {
        // Check if search data is submitted
        $search = isset($_POST['search']) ? $_POST['search'] : '';

        // Fetch invoice details for the specified branch with search filter
        $invoiceDetails = getInvoiceDetailsByBranchWithSearch($conn, $branchId, $search);
    } else {
        // Handle the case where the branch ID is not found
        echo "Branch ID not found for the selected branch name.";
        exit();
    }
} else {
    // Redirect to the master dashboard if the branch is not specified
    header("Location: master_dashboard.php");
    exit();
}

// Function to fetch invoice details by branch with search filter
function getInvoiceDetailsByBranchWithSearch($conn, $branchId, $search)
{
    // Use prepared statements to avoid SQL injection
    $query = "SELECT * FROM invoices WHERE branch_id = ?";

    // Add search filter to the query if the search input is not empty
    if (!empty($search)) {
        $search = '%' . mysqli_real_escape_string($conn, $search) . '%';
        $query .= " AND (invoice_number LIKE ? OR student_id LIKE ? OR student_name LIKE ? OR contact_number LIKE ? OR subject_name LIKE ? OR due_amount LIKE ? OR invoice_status LIKE ?)";
    }

    $query .= " ORDER BY invoice_date DESC";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        // Log the SQL error for debugging
        echo "Error preparing the query: " . mysqli_error($conn);
        exit();
    }

   // Bind parameters if the search input is not empty
if (!empty($search)) {
    mysqli_stmt_bind_param($stmt, "ssssssss", $branchId, $search, $search, $search, $search, $search, $search, $search);
} else {
    mysqli_stmt_bind_param($stmt, "s", $branchId);
}

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result === false) {
        // Log the SQL error for debugging
        echo "Error executing the query: " . mysqli_error($conn);
        exit();
    }

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    $invoiceDetails = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $invoiceDetails[] = $row;
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    return $invoiceDetails;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Report - <?php echo $branchName; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Invoice Report - <?php echo $branchName; ?></h1>

      <!-- Add search bar -->
      <form method="post" class="form-inline mb-3">
            <div class="form-group">
                <input type="text" class="form-control" id="search" name="search" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-primary ml-2">Search</button>
            <button type="button" class="btn btn-secondary ml-2" onclick="resetSearch()">Reset</button>
        </form>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Branch ID</th>
                    <th>Invoice Number</th>
                    <th>Student ID</th>
                    <th>Invoice Date</th>
                    <th>Subject Name</th>
                    <th>Student Name</th>
                    <th>Contact</th>
                    <th>Due Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoiceDetails as $invoice) : ?>
                    <tr>
                        <td><?php echo $invoice['branch_id']; ?></td>
                        <td><?php echo $invoice['invoice_number']; ?></td>
                        <td><?php echo $invoice['student_id']; ?></td>
                        <td><?php echo substr($invoice['invoice_date'], 0, 10); ?></td>
                        <td>
                            <?php
                            $subjectName = $invoice['subject_name'];
                            $subjectArray = json_decode($subjectName);

                            if (is_array($subjectArray) && count($subjectArray) > 0) {
                                echo '<ul>';
                                foreach ($subjectArray as $subjectGroup) {
                                    foreach ($subjectGroup as $subject) {
                                        echo '<li>' . $subject . '</li>';
                                    }
                                }
                                echo '</ul>';
                            } else {
                                echo $subjectName;
                            }
                            ?>
                        </td>
                        <td><?php echo $invoice['student_name']; ?></td>
                        <td><?php echo $invoice['contact_number']; ?></td>
                        <td><?php echo $invoice['due_amount']; ?></td>
                        <td><?php echo $invoice['invoice_status']; ?></td>
                        <td>
                            <button class="btn btn-success" onclick="printInvoice('<?php echo $invoice['invoice_number']; ?>')">Print</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="master_dashboard.php" class="btn btn-primary">Back to Master Dashboard</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function printInvoice(invoiceNumber) {
            // Redirect to the print_invoice.php with the invoice number
            window.open('print_invoice.php?invoice_number=' + invoiceNumber, '_blank');
        }
        function resetSearch() {
            // Reset the search input value to empty
            document.getElementById('search').value = '';

            // Submit the form to show all details
            document.querySelector('form').submit();
        }
    </script>
</body>

</html>

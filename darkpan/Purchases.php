<?php
session_start();
include 'aside.php';
include 'db.php';
?>

<div class="col-12">
    <div class="bg-secondary rounded h-100 p-4">
        <h6 class="mb-4">Payments Table</h6>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Payment ID</th>
                        <th scope="col">Movie ID</th>
                        <th scope="col">User  ID</th>
                        <th scope="col">Payment Date</th>
                        <th scope="col">Payment Amount</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to retrieve payments data
                    $query = "SELECT * FROM payments";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $row['payment_id']; ?></th>
                            <td><?php echo $row['movie_id']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo $row['payment_date']; ?></td>
                            <td><?php echo $row['payment_amount']; ?></td>
                            <td><?php echo $row['payment_method']; ?></td>
                            <td><?php echo $row['payment_status']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
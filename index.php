<?php
// Connect to database
$db = new PDO("sqlite:data/stocks.db");
$db ->setAttribure(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get customers
$sql = "SELECT * FROM users";
$result = $db ->query($sql);
$customers = $result->fetchAll(PDO::FETCH_ASSOC);
?>


// set page title, create headers and link to css
<!DOCTYPE html>
<html>
    <head>
        <title>Stock Portfolio - Home</title>
        <link rel="stylesheet" href="style.css">
    </head>

<body>
    <header>
        <h1>Stock Portfolio Tracker</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="companies.php">Companies</a>
            <a href="about.php">About</a>
        </nav>
    </header>

    <main>
        <h2>Customers</h2>
        <p>Select a customer to view portfolio</p>

        // Display customers in a table
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
            <?php foreach ($customers as $customer) { ?>
            <tr>
                //assign customer to row with name and portfolio link
                <td><?php echo $customer['lastname'] . ", " . $customer['firstname']; ?></td>
                <td>
                    <a href="index.php?userId=<?php echo $customer['id']; ?>">portfolio</a>
                </td>
            
            </tr>
            <?php } ?>
        </table>
    </main>
</body>
</html>
<?php
$db = null;
?>






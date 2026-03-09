<?php
// Connect to database
$db = new PDO("sqlite:data/stocks.db");
$db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get customers
$sql = "SELECT * FROM users";
$result = $db ->query($sql);
$customers = $result->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- // set page title, create headers and link to css -->
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

        <!--// Display customers in a table -->
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
            <?php foreach ($customers as $customer) { ?>
            <tr>
                <!-- //assign customer to row with name and portfolio link -->
                <td><?php echo $customer['lastname'] . ", " . $customer['firstname']; ?></td>
                <td>
                    <a href="index.php?userId=<?php echo $customer['id']; ?>">portfolio</a>
                </td>
            
            </tr>
            <?php } ?>
        </table>

        <?php
        // Check if user clicked portfolio
        if (isset($_GET['userId'])) {
            $userId = $_GET['userId'];

            // Get user details

            $sql = "SELECT * FROM users WHERE id = $userId";
            $result = $db->query($sql);
            $user = $result->fetch(PDO::FETCH_ASSOC);

            echo "<h2>" . $user['firstname'] . " " . $user['lastname'] . "</h2>";

            // Get user portfolio with company names
            $sql = "SELECT portfolio.symbol, portfolio.amount, companies.name
                    FROM portfolio
                    INNER JOIN companies ON portfolio.symbol = companies.symbol
                    WHERE portfolio.userId = $userId";
            $result = $db->query($sql);
            $stocks = $result->fetchAll(PDO::FETCH_ASSOC);

            //Calculate total
            $totalShares = 0;
            $numCompanies = count($stocks);
            $totalValue = 0;

            // Read closing price for each stock and calculate the value
            
        foreach ($stocks as $stock) {
                $totalShares = $totalShares + $stock['amount'];

            $symbol = $stock['symbol'];
            $sql = "SELECT close FROM history
                    WHERE symbol = '$symbol'
                    ORDER BY DATE DESC
                    LIMIT 1";
            $result = $db->query($sql);
            $priceRow = $result->fetch(PDO::FETCH_ASSOC);
            $closePrice = $priceRow['close'];

            // Calculate stock value
            $stockValue = $stock['amount'] * $closePrice;
            $totalValue = $totalValue + $stockValue;

            // Store the value to display in the table
            $stocks[$index]['value'] = $stockValue;
   
        }

            echo "<p><strong># Shares:</strong> " . $totalShares . "</p>";
            echo "<p><strong># Companies:</strong> " . $numCompanies . "</p>";
            echo "<p><strong># Total Value:</strong> " . number_format($totalValue, 2) . "</p>";

            // Display portfolio table

            echo "<table border='1'>";
            echo "<tr><th>Symbol</th><th>Name</th><th>Share Amounth</th></tr>";

            //Display each stock in a table
            foreach ($stocks as $stock) {
                echo "<tr>";
                echo "<td>" . $stock['symbol'] . "</td>";
                echo "<td>" . $stock['name'] . "</td>";
                echo "<td>" . $stock['amount'] . "</td>";
                echo "<td>" . number_format($stock['value'], 2) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            
        }
        ?>
    

    </main>
</body>
</html>
<?php
$db = null;
?>






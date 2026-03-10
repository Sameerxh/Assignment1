<?php
// Connect to database
$db = new PDO("sqlite:data/stocks.db");
$db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get customers
$sql = "SELECT * FROM companies";
$result = $db ->query($sql);
$companies = $result->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- // set page title, create headers and link to css -->
<!DOCTYPE html>
<html>
    <head>
        <title>Stock Portfolio - Companies</title>
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
        <h2>Companies</h2>
        <p>Select a company to view details</p>

        <ul>
            <?php foreach ($companies as $company) { ?>

            <li>
                <a href="companies.php?symbol=<?php echo $company['symbol']; ?>">
                    <?php echo $company['name']; ?>
                </a>
            </li>


          <?php } ?>
        </ul>

        <?php
        // Check if user clicked company
        if (isset($_GET['symbol'])) {
            $symbol = $_GET['symbol'];

            //Get this company's info
            $sql = "SELECT * FROM companies WHERE symbol = '$symbol'";
            $result = $db->query($sql);
            $company = $result->fetch(PDO::FETCH_ASSOC);

            //Display company details
            echo "<h2>" . $company['name'] . "</h2>";
            echo "<p><strong>Symbol:</strong> " . $company['symbol'] . "</p>";
            echo "<p><strong>Sector:</strong> " . $company['sector'] . "</p>";
            echo "<p><strong>Sub-Industry:</strong> " . $company['subindustry'] . "</p>";
            echo "<p><strong>Address:</strong> " . $company['address'] . "</p>";
            echo "<p><strong>Website:</strong> " . $company['website'] . "</p>";
            echo "<p><strong>Description:</strong> " . $company['description'] . "</p>";

            //Get high History
            $sql = "SELECT MAX(high) as highHistory FROM history WHERE symbol = '$symbol'";
            $result = $db->query($sql);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $highHistory = $row['highHistory'];

            //Get Low History
            $sql = "SELECT MIN(low) as lowHistory FROM history WHERE symbol = '$symbol'";
            $result = $db->query($sql);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $lowHistory = $row['lowHistory'];

            //Get total volume
            $sql = "SELECT SUM(volume) as totalVolume FROM history WHERE symbol = '$symbol'";
            $result = $db->query($sql);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $totalVolume = $row['totalVolume'];

            // Get average volume
            $sql = "SELECT AVG(volume) as avgVolume FROM history WHERE symbol = '$symbol'";
            $result = $db->query($sql);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $avgVolume = $row['avgVolume'];

            // Display the statistics 
            echo "<h3>Stock Statistics</h3>";
            echo "<p><strong>High History:</strong> $" . number_format($highHistory, 2) . "</p>";
            echo "<p><strong>Low History:</strong> $" . number_format($lowHistory, 2) . "</p>";
            echo "<p><strong>Total Volume:</strong> " . number_format($totalVolume) . "</p>";
            echo "<p><strong>Average Volume:</strong> " . number_format($avgVolume, 2) . "</p>";
        


            // Get history info for the table
            $sql = "SELECT * FROM history WHERE symbol = '$symbol' ORDER BY date ASC";
            $result = $db->query($sql);
            $company = $result->fetchAll(PDO::FETCH_ASSOC);

            // Display history table
            echo "<h3>History (3 Months)</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Date</th><th>Volume</th><th>Open</th><th>Close</th><th>High</th><th>Low</th></tr>";

            foreach ($history as $record) {
                echo "<tr>";
                echo "<td>" . $record['date'] . "</td>";
                echo "<td>" . number_format($record['volume']) . "</td>";
                echo "<td>" . number_format($record['open'], 2) . "</td>";
                echo "<td>" . number_format($record['close'], 2) . "</td>";
                echo "<td>" . number_format($record['high'], 2) . "</td>";
                echo "<td>" . number_format($record['low'], 2) . "</td>";
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
<?php
// Connect to database
$db = new PDO("sqlite:data/stocks.db");
$db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get customers
$sql = "SELECT * FROM companies";
$result = $db ->query($sql);
$customers = $result->fetchAll(PDO::FETCH_ASSOC);
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
    </main>
</body>
</html>
<?php
$db = null;
?>

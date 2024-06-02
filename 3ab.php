<!DOCTYPE html>
<html>
<head>
    <title>Customer List by City</title>
</head>
<style>
    p {
        color: #ffffff;
    }

    h1 {
        color: #0e4c92; 
    }
    body {
        background: #fff;
        color: #222;
        font-family: 'Source Sans Pro', sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    form {
        text-align: center;
    }
    label {
        color: #0e4c92;
        text-align: center;
    }

    input {
        background-color: #0e4c92;
        color: #ffffff;
        padding: 5px 10px;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 10px;
        justify-content: center;
        align-items: center;
    }

    input#city {
        background-color: #0e4c92;
        color: #ffffff; /* Ubah warna teks menjadi putih */
        padding: 5px 10px;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 10px;
        justify-content: center;
        align-items: center;
    }

    button {
        background-color: #0e4c92;
        color: #ffffff;
        padding: 5px 10px;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 10px;
        justify-content: center;
        align-items: center;
    }
    table {
        border-collapse: collapse;
        width: 80%;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #0e4c92;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #0e4c92;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    tr:hover {
        background-color: #ddd;
    }
</style>
<body>
    <h1>Customer Name by City</h1>

    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="city">City :</label>
        <input type="text" id="city" name="city" value="<?php echo isset($_GET['city']) ? $_GET['city'] : ''; ?>">
        <button type="submit">Submit</button>
    </form>

    <?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classicmodels";
    $port = 3307;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ambil kota dari form input
    $city = isset($_GET['city']) ? $_GET['city'] : '';

    // Query untuk mengambil daftar customer berdasarkan kota
    $sql = "SELECT customerName, city FROM customers WHERE city = '$city'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Customer Name</th><th>City</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["customerName"] . "</td><td>" . $row["city"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No customers found for the city : " . $city;
    }

    $conn->close();
    ?>

    <h1>Customers with Shipped Date</h1>

    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="shippedDate">Shipped Date :</label>
        <input type="date" id="shippedDate" name="shippedDate" required>
        <button type="submit">Submit</button>
    </form>

    <?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "classicmodels";
    $port = 3307;

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Create connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Ambil Shipped Date dari form input
    $shippedDate = isset($_GET['shippedDate']) ? $_GET['shippedDate'] : '';

    if (!empty($shippedDate)) {
        // Query untuk mengambil daftar customer berdasarkan Shipped Date
        $sql = "
            SELECT c.customerName, o.shippedDate
            FROM customers c
            JOIN orders o ON c.customerNumber = o.customerNumber
            WHERE o.shippedDate = '$shippedDate'
            GROUP BY c.customerName, o.shippedDate
        ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Customer Name</th><th>Shipped Date</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["customerName"] . "</td><td>" . $row["shippedDate"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No customers found for the Shipped Date: " . $shippedDate;
        }
    }

    $conn->close();
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Order Baru</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro|PT+Mono" rel="stylesheet">
    <style>
        p {
            color: #ffffff;
        }
        form {
            margin-top: 20px;
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
        .code {
            font-family: 'PT Mono', serif;
            color: #090;
        }
        .writing {
            width: 74%;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }
        @media (max-width: 560px) {
            .writing {
                width: 96%;
            }
        }
        .background-oregon-grapes {
            background-color: rgb(5, 79, 79);
            background-size: 100%;
            height: 420px;
            width: 420px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
        }
        @media (max-width: 767px) {
            .background-oregon-grapes {
                height: 330px;
                width: 330px;
            }
        }
        img {
            height: 100%;
            width: 100%;
        }
        h1 {
            color: rgb(5, 79, 79);
        }

        p {
        padding-bottom: 25px;
        color: rgb(53, 162, 162);
        }

        label {
            color: rgb(5, 79, 79);
        }
        input {
            background-color: rgb(5, 79, 79);
            color: #ffffff;
            padding: 5px 10px;
            border-radius: 10px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        a {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        a {
            display: inline-block;
            background-color: rgb(5, 79, 79);
            color: white;
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 10px;
            margin: 10 0px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #045f5f;
        }
    </style>
</head>
<body>
    <h1>Form Order Baru</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "classicmodels";
        $port = 3307;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname, $port);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the latest order number and increment it
        $result = $conn->query("SELECT MAX(orderNumber) AS maxOrderNumber FROM orders");
        $row = $result->fetch_assoc();
        $orderNumber = $row['maxOrderNumber'] + 1;

        // Get form data
        $customerNumber = $_POST['customernumber'];

        // Check if customer number exists in the customers table
        $checkCustomerSql = "SELECT * FROM customers WHERE customerNumber = $customerNumber";
        $checkCustomerResult = $conn->query($checkCustomerSql);

        if ($checkCustomerResult->num_rows == 0) {
            echo "<p>Nomor pelanggan belum terdaftar</p>";
        } else {
            $orderDate = $_POST['date'];
            $comments = $_POST['comments'];
            $status = 'Shipped';
    
            if (empty($comments)) {
                $comments = NULL;
            }

            // Calculate shipped date (3 days after order date) and required date (5 days after shipped date)
            $orderDateObject = new DateTime($orderDate);
            $shippedDateObject = clone $orderDateObject;
            $requiredDateObject = clone $orderDateObject;
            
            $shippedDateObject->modify('+3 days');
            $requiredDateObject->modify('+8 days'); // +3 days for shippedDate + 5 days for requiredDate

            $shippedDate = $shippedDateObject->format('Y-m-d');
            $requiredDate = $requiredDateObject->format('Y-m-d');

            // Insert data into database
            $sql = "INSERT INTO orders (orderNumber, orderDate, requiredDate, shippedDate, status, comments, customerNumber)
                    VALUES ('$orderNumber', '$orderDate', '$requiredDate', '$shippedDate', '$status', '$comments', '$customerNumber')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Order berhasil ditambahkan</p>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        // Close connection
        $conn->close();
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="customernumber">Nomor Pelanggan : </label>
        <input type="number" id="customernumber" name="customernumber" required>

        <label for="date">Order Date :</label>
        <input type="date" id="date" name="date" required>

        <label for="comments">Comments : </label>
        <input type="text" id="comments" name="comments">

        <input type="submit" id='button' value="Submit">
    </form>

    <a href="tabelorders.php" class="btn">SHOW TABLES</a>

    <script>
        // JavaScript to set the date input to today's date
        document.addEventListener('DOMContentLoaded', (event) => {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;
        });
    </script>

    <div class="background-oregon-grapes">
        <img src="https://aeoneal.com/imagery/brain-reverse-cutout.svg">
    </div>
</body>
</html>

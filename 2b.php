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
            background-color: rgb(114, 47, 55);
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
            color: rgb(114, 47, 55);
        }

        p {
        padding-bottom: 25px;
        color: rgb(53, 162, 162);
        }

        form {
            text-align: center;
        }
        label {
            color: rgb(114, 47, 55);
            text-align: center;
        }

        input {
            background-color: rgb(114, 47, 55);
            color: #ffffff;
            padding: 5px 10px;
            border-radius: 10px;
            cursor: pointer;
            margin-bottom: 10px;
            justify-content: center;
            align-items: center;
        }

        select {
            background-color: rgb(114, 47, 55);
            color: #ffffff;
            padding: 5px 10px;
            border-radius: 10px;
            cursor: pointer;
            margin-bottom: 10px;
            justify-content: center;
        }

        a {
            margin-top: 20px;
            float: center;
        }

        a {
            display: inline-block;
            background-color: rgb(114, 47, 55);
            color: white;
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 10px;
            margin: 10 0px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #fadadd;
        }
    </style>
</head>
<body>
    <h1>Form Product Baru</h1>

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

        // Get form data
        $productCode = $_POST['productcode'];
        $productName = $_POST['productname'];
        $productLine = $_POST['productline'];
        $productScale = $_POST['productscale'];
        $productVendor = $_POST['productvendor'];
        $productDescription = $_POST['productdescription'];
        $quantityInStock = $_POST['quantityinstock'];
        $buyPrice = $_POST['buyprice'];
        $MSRP = $_POST['msrp'];

        $sql_check = "SELECT * FROM products WHERE productCode = '$productCode'";
        $result = $conn->query($sql_check);

        if ($result->num_rows > 0) {
            echo "<p>Product Code sudah terdaftar</p>";
        } else {
            // Insert data into database
            $sql = "INSERT INTO products (productCode, productName, productLine, productScale, productVendor, productDescription, quantityInStock, buyPrice, MSRP)
                    VALUES ('$productCode', '$productName', '$productLine', '$productScale', '$productVendor', '$productDescription', '$quantityInStock', '$buyPrice', '$MSRP')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Product berhasil ditambahkan</p>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Close connection
        $conn->close();
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="productcode">Product Code (ex: S10_1678) : </label>
        <input type="text" id="productcode" name="productcode" required>

        <label for="productname">Product Name (ex: 2022 Harley) : </label>
        <input type="text" id="productname" name="productname" required>

        <label for="productline">Product Line : </label>
        <select id="productline" name="productline" required>
            <option value="">Select Product Line</option>
            <option value="Motorcycles">Motorcycles</option>
            <option value="Classic Cars">Classic Cars</option>
            <option value="Vintage Cars">Vintage Cars</option>
            <option value="Planes">Planes</option>
            <option value="Ships">Ships</option>
            <option value="Trains">Trains</option>
            <option value="Trains">Trucks and Buses</option>
        </select><br><br>

        <label for="productscale">Product Scale (ex: 1:72) : </label>
        <input type="text" id="productscale" name="productscale" required>

        <label for="productvendor">Product Vendor (ex: Classic Metals) : </label>
        <input type="text" id="productvendor" name="productvendor" required>

        <label for="productdescription">Product Description : </label>
        <input type="text" id="productdescription" name="productdescription" required><br><br>

        <label for="quantityinstock">Quantity in Stock : </label>
        <input type="number" id="quantityinstock" name="quantityinstock" required>

        <label for="buyprice">Buy Price (ex: 48.10) : </label>
        <input type="number" step="0.01" id="buyprice" name="buyprice" required>

        <label for="buyprice">MSRP (ex: 68.50) : </label>
        <input type="number" step="0.01" id="msrp" name="msrp" required><br><br>

        <input type="submit" id='button' value="Submit">
    </form>

    <a href="tabelproducts.php" class="btn">SHOW TABLES</a>

    <script>
        // JavaScript to set the date input to today's date
        document.addEventListener('DOMContentLoaded', (event) => {
            // No need to set the date input here
        });
    </script>

    <div class="background-oregon-grapes">
        <img src="https://aeoneal.com/imagery/brain-reverse-cutout.svg">
    </div>
</body>
</html>

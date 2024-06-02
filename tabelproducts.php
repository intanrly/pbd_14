<!DOCTYPE html>
<html>
<head>
    <title>Tabel Products</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro|PT+Mono" rel="stylesheet">
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro|PT+Mono" rel="stylesheet">
    <style>
        p {
            color: #ffffff;
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
        label {
            color: rgb(114, 47, 55);
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid rgb(114, 47, 55);
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: rgb(114, 47, 55);
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .pagination {
            margin-top: 20px;
        }
        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
        }

        .pagination button {
            background-color: rgb(114, 47, 55);
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
        }

        .pagination button:hover {
            background-color: #fadadd;
        }

        .writing a {
            color: black;
            float: center;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
        }

        .writing button {
            background-color: rgb(114, 47, 55);
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
        }

        .writing button:hover {
            background-color: #fadadd;
        }
    </style>
</head>
<body>
    <h1>Tabel Products</h1>
    <div class="writing">
        <a href="2b.php"><button>Kembali ke Form Product</button></a>
    </div>
    <?php
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

    // Pagination variables
    $limit = 50; // Jumlah data per halaman
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman yang diminta pengguna
    $start = ($page - 1) * $limit; // Offset untuk query

    // Query untuk mengambil data dengan urutan terbaru hingga terlama dan membatasi jumlah data sesuai paginasi
    $sql = "SELECT * FROM products ORDER BY productCode ASC LIMIT $start, $limit";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Menampilkan data dalam tabel
        echo "<table border='1'>";
        echo "<tr><th>Product Code</th><th>Product Name</th><th>Product Line</th><th>Product Scale</th><th>Product Vendor</th><th>Product Description</th><th>Quantity In Stock</th><th>Buy Price</th><th>MSRP</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["productCode"]."</td>";
            echo "<td>".$row["productName"]."</td>";
            echo "<td>".$row["productLine"]."</td>";
            echo "<td>".$row["productScale"]."</td>";
            echo "<td>".$row["productVendor"]."</td>";
            echo "<td>".$row["productDescription"]."</td>";
            echo "<td>".$row["quantityInStock"]."</td>";
            echo "<td>".$row["buyPrice"]."</td>";
            echo "<td>".$row["MSRP"]."</td>";
            echo "</tr>";
        }
        echo "</table>";

        $sql_total = "SELECT COUNT(*) AS total FROM products";
        $result_total = $conn->query($sql_total);
        $row_total = $result_total->fetch_assoc();
        $total_pages = ceil($row_total["total"] / $limit); // Jumlah total halaman
        echo "<div class='pagination'>";
        if ($page > 1) {
            $prev_page = $page - 1;
            echo "<a href='?page=$prev_page'><button>Previous</button></a>";
        }
        if ($page < $total_pages) {
            $next_page = $page + 1;
            echo "<a href='?page=$next_page'><button>Next</button></a>";
        }
        echo "</div>";
    } else {
        echo "0 results";
    }

    // Close connection
    $conn->close();
    ?>

</body>
</html>
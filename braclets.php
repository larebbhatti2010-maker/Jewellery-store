
<?php

// ================= DATABASE CONNECTION =================

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jewellery store";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// ================= GET PRODUCT NAME =================

$selected_product = "";

if (isset($_GET['product'])) {
    $selected_product = $_GET['product'];
}

// ================= FORM SUBMIT =================

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $product = trim($_POST['product']);
    $color = trim($_POST['color']);

    // Prepare SQL query
    $stmt = $conn->prepare(
        "INSERT INTO orders (product, color) VALUES (?, ?)"
    );

    if ($stmt) {

        $stmt->bind_param("ss", $product, $color);

        if ($stmt->execute()) {
            $message = "
                <div class='alert alert-success'>
                    Order submitted successfully!
                </div>";
        } else {
            $message = "
                <div class='alert alert-danger'>
                    Order not submitted: " . htmlspecialchars($stmt->error) . "
                </div>";
        }

        $stmt->close();

    } else {
        $message = "
            <div class='alert alert-danger'>
                Query error: " . htmlspecialchars($conn->error) . "
            </div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Order Now - Lareb Store</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">


<style>
.card-header {
    background-color:#b08d57;
  
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
}
.btn{
     background-color:#b08d57;
}
</style>
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card shadow">

                    <div class="card-header  text-white text-center">
                        <h2>ORDER NOW</h2>
                    </div>

                    <div class="card-body">

                        <?php echo $message; ?>

                        <form action="BRACLETS.php" method="POST">

                            <!-- Product Name -->
                            <div class="mb-3">

                                <label class="form-label fw-bold">
                                    Product Name
                                </label>

                                <input
                                    type="text"
                                    name="product"
                                    class="form-control"
                                    value="<?php echo htmlspecialchars($selected_product, ENT_QUOTES, 'UTF-8'); ?>"
                                    required
                                    placeholder="Enter Product Name">

                            </div>

                            <!-- Color -->
                            <div class="mb-3">

                                <label class="form-label fw-bold">
                                    Color
                                </label>

                                <input
                                    type="text"
                                    name="color"
                                    class="form-control"
                                    required
                                    placeholder="Enter Color (e.g. Red, Black)">

                            </div>

                            <!-- Buttons -->
                            <div class="d-grid gap-2">

                                <button 
                                    type="submit"
                                    name="submit"
                                    class="btn  btn-lg">

                                    Submit Order

                                </button>

                                <a
                                    href="index.html"
                                    class="btn btn-outline-secondary">

                                    Back to Shopping

                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>

<?php
$conn->close();
?>

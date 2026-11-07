<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jewellery store";

// Database Connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$message = "";

// URL se product aur image fetch karna
$selected_product = "";
$selected_img = "";

if (isset($_GET['product'])) {
    $selected_product = $_GET['product'];
}

if (isset($_GET['img'])) {
    $selected_img = $_GET['img'];
}


// Jab form submit ho
if (isset($_POST['submit'])) {

    $product = mysqli_real_escape_string($conn, $_POST['product']);
    $img = mysqli_real_escape_string($conn, $_POST['img']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);

    // Data orders table mein insert hoga
    $query = "INSERT INTO orders (product, img, color)
              VALUES ('$product', '$img', '$color')";

    $data = mysqli_query($conn, $query);

    if ($data) {
        $message = "
        <div class='alert alert-success'>
            Order placed successfully!
        </div>";
    } else {
        $message = "
        <div class='alert alert-danger'>
            Data not inserted. Error: " . mysqli_error($conn) . "
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Order Now - Jewellery Store</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">


<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-danger text-white text-center">

                    <h2>ORDER NOW</h2>

                </div>


                <div class="card-body">

                    <?php echo $message; ?>


                    <!-- Product Image -->

                    <?php if (!empty($selected_img)) { ?>

                        <div class="text-center mb-3">

                            <img
                                src="<?php echo htmlspecialchars($selected_img); ?>"
                                alt="Product Image"
                                style="
                                    width: 200px;
                                    height: 200px;
                                    object-fit: cover;
                                    border-radius: 10px;
                                ">

                        </div>

                    <?php } ?>


                    <form action="shop.php" method="POST">


                        <!-- Product Name -->

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Product Name
                            </label>

                            <input
                                type="text"
                                name="product"
                                class="form-control"
                                value="<?php echo htmlspecialchars($selected_product); ?>"
                                required
                                placeholder="Enter Product Name">

                        </div>


                        <!-- Image -->

                        <input
                            type="hidden"
                            name="img"
                            value="<?php echo htmlspecialchars($selected_img); ?>">


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
                                class="btn btn-danger btn-lg">

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
<?php
$conn = mysqli_connect("localhost", "root", "", "hotel_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// INSERT
if (isset($_POST['insert'])) {
    $name = $_POST['hotel_name'];
    $food = $_POST['food_menu'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO hotels (hotel_name, food_menu, location, price, rating)
            VALUES ('$name', '$food', '$location', '$price', '$rating')";
    mysqli_query($conn, $sql);
}

// SEARCH
$result = null;
if (isset($_POST['search'])) {
    $column = $_POST['column'];
    $value = $_POST['search_value'];

    $sql = "SELECT * FROM hotels WHERE $column LIKE '%$value%'";
    $result = mysqli_query($conn, $sql);
}

// DELETE
if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];
    mysqli_query($conn, "DELETE FROM hotels WHERE id=$id");
}

// RETRIEVE
$all = mysqli_query($conn, "SELECT * FROM hotels");
?>

<!DOCTYPE html>
<html>
<head>
<title>Hotel Management System</title>

<style>
body {
    font-family: Arial;
    background: linear-gradient(to right, #1e3c72, #2a5298);
    color: white;
    text-align: center;
}

h1 {
    background: #ff4b2b;
    padding: 15px;
    border-radius: 10px;
}

.container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.box {
    background: white;
    color: black;
    width: 40%;
    padding: 20px;
    margin: 20px;
    border-radius: 15px;
    box-shadow: 0px 0px 15px black;
}

input, select {
    width: 80%;
    padding: 10px;
    margin: 5px;
    border-radius: 8px;
    border: 1px solid gray;
}

button {
    padding: 10px 20px;
    margin-top: 10px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    color: white;
}

.insert-btn { background: green; }
.search-btn { background: blue; }
.delete-btn { background: red; }

table {
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #2a5298;
    color: white;
}

td, th {
    padding: 10px;
    border: 1px solid black;
}

tr:nth-child(even) {
    background: #f2f2f2;
}
</style>

</head>

<body>

<h1>🏨 HOTEL MANAGEMENT SYSTEM</h1>

<div class="container">

<!-- BOX 1 -->
<div class="box">
    <h2>➕ Insert Hotel</h2>
    <form method="POST">
        <input type="text" name="hotel_name" placeholder="Hotel Name" required><br>
        <input type="text" name="food_menu" placeholder="Food Menu" required><br>

        <select name="location">
            <option>Chennai</option>
            <option>Madurai</option>
            <option>Coimbatore</option>
        </select><br>

        <input type="number" name="price" placeholder="Price" required><br>
        <input type="text" name="rating" placeholder="Rating" required><br>

        <button class="insert-btn" name="insert">INSERT</button>
    </form>
</div>

<!-- BOX 2 -->
<div class="box">
    <h2>🔍 Search / Delete</h2>

    <form method="POST">
        <select name="column">
            <option value="hotel_name">Hotel Name</option>
            <option value="location">Location</option>
            <option value="food_menu">Food</option>
        </select>

        <input type="text" name="search_value" placeholder="Search...">
        <button class="search-btn" name="search">SEARCH</button>
    </form>

    <br>

    <form method="POST">
        <input type="number" name="delete_id" placeholder="Enter ID to delete">
        <button class="delete-btn" name="delete">DELETE</button>
    </form>
</div>

</div>

<!-- TABLE -->
<div class="box" style="width:90%; margin:auto;">
    <h2>📋 Hotel Records</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Hotel</th>
            <th>Food</th>
            <th>Location</th>
            <th>Price</th>
            <th>Rating</th>
        </tr>

        <?php
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['hotel_name']}</td>
                <td>{$row['food_menu']}</td>
                <td>{$row['location']}</td>
                <td>{$row['price']}</td>
                <td>{$row['rating']}</td>
                </tr>";
            }
        } else {
            while ($row = mysqli_fetch_assoc($all)) {
                echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['hotel_name']}</td>
                <td>{$row['food_menu']}</td>
                <td>{$row['location']}</td>
                <td>{$row['price']}</td>
                <td>{$row['rating']}</td>
                </tr>";
            }
        }
        ?>
    </table>
</div>

</body>
</html>
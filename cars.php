<?php
require_once 'db.php';
$conn = getConnection();

if (!$conn) {
    die("Database connection failed. Please check db.php configuration.");
}

$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$startDate = isset($_GET['startDate']) ? trim($_GET['startDate']) : '';
$endDate = isset($_GET['endDate']) ? trim($_GET['endDate']) : '';
$carType = isset($_GET['carType']) ? trim($_GET['carType']) : '';
$priceRange = isset($_GET['priceRange']) ? trim($_GET['priceRange']) : '';
$fuelType = isset($_GET['fuelType']) ? trim($_GET['fuelType']) : '';
$brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';
$sort = isset($_GET['sort']) ? trim($_GET['sort']) : 'price_asc';

$query = "SELECT * FROM cars WHERE 1=1";
$params = [];
$types = '';

if ($location) {
    $query .= " AND location LIKE ?";
    $params[] = "%$location%";
    $types .= 's';
}
if ($carType) {
    $query .= " AND car_type = ?";
    $params[] = $carType;
    $types .= 's';
}
if ($fuelType) {
    $query .= " AND fuel_type = ?";
    $params[] = $fuelType;
    $types .= 's';
}
if ($brand) {
    $query .= " AND brand = ?";
    $params[] = $brand;
    $types .= 's';
}
if ($priceRange) {
    $range = explode('-', $priceRange);
    if (count($range) === 2) {
        $query .= " AND price_per_day BETWEEN ? AND ?";
        $params[] = $range[0];
        $params[] = $range[1];
        $types .= 'dd';
    }
}
if ($startDate && $endDate) {
    $query .= " AND car_id NOT IN (
        SELECT car_id FROM bookings 
        WHERE (start_date <= ? AND end_date >= ?)
    )";
    $params[] = $endDate;
    $params[] = $startDate;
    $types .= 'ss';
}

if ($sort === 'price_asc') {
    $query .= " ORDER BY price_per_day ASC";
} elseif ($sort === 'price_desc') {
    $query .= " ORDER BY price_per_day DESC";
} elseif ($sort === 'rating') {
    $query .= " ORDER BY rating DESC";
}

try {
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $cars = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    die("Query execution failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar - Cars</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>RentACar</h1>
        <nav>
            <a href="home.php">Home</a>
            <a href="cars.php">Cars</a>
            <a href="booking.php">Book Now</a>
            <a href="contact.php">Contact</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        </nav>
    </header>
    <main>
        <section class="car-listing">
            <h2>Available Cars</h2>
            <div class="sort-filter">
                <form action="cars.php" method="GET">
                    <select name="sort" onchange="this.form.submit()">
                        <option value="price_asc" <?php echo $sort === 'price_asc' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_desc" <?php echo $sort === 'price_desc' ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="rating" <?php echo $sort === 'rating' ? 'selected' : ''; ?>>Best Rated</option>
                    </select>
                    <input type="hidden" name="location" value="<?php echo htmlspecialchars($location); ?>">
                    <input type="hidden" name="startDate" value="<?php echo htmlspecialchars($startDate); ?>">
                    <input type="hidden" name="endDate" value="<?php echo htmlspecialchars($endDate); ?>">
                    <input type="hidden" name="carType" value="<?php echo htmlspecialchars($carType); ?>">
                    <input type="hidden" name="priceRange" value="<?php echo htmlspecialchars($priceRange); ?>">
                    <input type="hidden" name="fuelType" value="<?php echo htmlspecialchars($fuelType); ?>">
                    <input type="hidden" name="brand" value="<?php echo htmlspecialchars($brand); ?>">
                </form>
            </div>
            <div class="car-grid">
                <?php if (empty($cars)): ?>
                    <p>No cars found matching your criteria.</p>
                <?php else: ?>
                    <?php foreach ($cars as $car): ?>
                        <div class="car-card">
                            <img src="<?php echo htmlspecialchars($car['image_url']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>">
                            <h3><?php echo htmlspecialchars($car['name']); ?></h3>
                            <p class="price">$<?php echo htmlspecialchars($car['price_per_day']); ?>/day</p>
                            <p><?php echo htmlspecialchars($car['car_type']); ?> | <?php echo htmlspecialchars($car['fuel_type']); ?></p>
                            <p>Rating: <?php echo htmlspecialchars($car['rating']); ?>/5</p>
                            <a href="booking.php?car_id=<?php echo $car['car_id']; ?>" class="book-button">Book Now</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <footer>
        <p>© 2025 RentACar. All rights reserved.</p>
    </footer>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #007bff, #ff8c00);
            color: #333;
            min-height: 100vh;
        }
        header {
            background: linear-gradient(45deg, #007bff, #00b7eb);
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        header h1 {
            margin: 0;
            font-size: 2.8em;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        nav a {
            color: white;
            margin: 0 20px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1em;
            transition: color 0.3s ease, transform 0.2s ease;
        }
        nav a:hover {
            color: #ff8c00;
            transform: scale(1.1);
        }
        .car-listing {
            padding: 30px;
            text-align: center;
            background: white;
            margin: 30px auto;
            max-width: 1200px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .car-listing h2 {
            color: #007bff;
            font-weight: 600;
            font-size: 2em;
            margin-bottom: 25px;
        }
        .sort-filter {
            margin-bottom: 20px;
        }
        .sort-filter select {
            padding: 10px;
            font-size: 1em;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease;
        }
        .sort-filter select:focus {
            border-color: #ff8c00;
            outline: none;
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px;
        }
        .car-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .car-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }
        .car-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 10px;
        }
        .car-card h3 {
            margin: 15px 0;
            color: #007bff;
            font-size: 1.6em;
            font-weight: 600;
        }
        .car-card .price {
            color: #ff8c00;
            font-weight: 500;
            font-size: 1.2em;
        }
        .car-card p {
            color: #555;
            margin: 5px 0;
        }
        .book-button {
            background: linear-gradient(45deg, #007bff, #00b7eb);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .book-button:hover {
            background: linear-gradient(45deg, #0056b3, #0098c7);
            transform: scale(1.05);
        }
        footer {
            background: linear-gradient(45deg, #007bff, #ff8c00);
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.3);
        }
        @media (max-width: 600px) {
            .sort-filter {
                text-align: center;
            }
            .car-grid {
                grid-template-columns: 1fr;
            }
            .car-card img {
                height: 120px;
            }
        }
    </style>
</body>
</html>

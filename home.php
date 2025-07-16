<?php
session_start();
require_once 'db.php';
$conn = getConnection();
if (!$conn) {
    die("Database connection failed. Please check db.php configuration.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar - Home</title>
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
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <section class="search-section">
            <h2>Find Your Perfect Car</h2>
            <form id="searchForm" action="cars.php" method="GET">
                <input type="text" id="location" name="location" placeholder="Enter pickup location" required>
                <input type="date" id="startDate" name="startDate" required>
                <input type="date" id="endDate" name="endDate" required>
                <button type="submit">Search Cars</button>
            </form>
            <div class="filters">
                <select id="carType" name="carType">
                    <option value="">All Car Types</option>
                    <option value="Sedan">Sedan</option>
                    <option value="SUV">SUV</option>
                    <option value="Luxury">Luxury</option>
                </select>
                <select id="priceRange" name="priceRange">
                    <option value="">All Prices</option>
                    <option value="0-50">$0 - $50</option>
                    <option value="51-100">$51 - $100</option>
                    <option value="101-200">$101 - $200</option>
                </select>
                <select id="fuelType" name="fuelType">
                    <option value="">All Fuel Types</option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Electric">Electric</option>
                </select>
                <select id="brand" name="brand">
                    <option value="">All Brands</option>
                    <option value="Toyota">Toyota</option>
                    <option value="BMW">BMW</option>
                    <option value="Mercedes">Mercedes</option>
                </select>
            </div>
        </section>
        <section class="featured-cars">
            <h2>Featured Cars</h2>
            <div class="car-grid">
                <div class="car-card">
                    <img src="https://images.unsplash.com/photo-1502877338535-766e1452684a" alt="Toyota Camry">
                    <h3>Toyota Camry</h3>
                    <p>$50/day</p>
                    <a href="booking.php?car_id=1" class="book-button">Book Now</a>
                </div>
                <div class="car-card">
                    <img src="https://images.unsplash.com/photo-1519641471654-76ce0107ad1b" alt="BMW X5">
                    <h3>BMW X5</h3>
                    <p>$100/day</p>
                    <a href="booking.php?car_id=2" class="book-button">Book Now</a>
                </div>
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
        .search-section {
            padding: 30px;
            text-align: center;
            background: white;
            margin: 30px auto;
            max-width: 900px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .search-section h2 {
            margin-bottom: 25px;
            color: #007bff;
            font-weight: 600;
            font-size: 2em;
        }
        form {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        input, select, button {
            padding: 12px;
            font-size: 1em;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        input:focus, select:focus {
            border-color: #ff8c00;
            box-shadow: 0 0 5px rgba(255, 140, 0, 0.5);
            outline: none;
        }
        button, .book-button {
            background: linear-gradient(45deg, #007bff, #00b7eb);
            color: white;
            border: none;
            cursor: pointer;
            padding: 12px 25px;
            font-weight: 600;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        button:hover, .book-button:hover {
            background: linear-gradient(45deg, #0056b3, #0098c7);
            transform: scale(1.05);
        }
        .filters {
            margin-top: 20px;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .featured-cars {
            padding: 30px;
            text-align: center;
        }
        .featured-cars h2 {
            color: #fff;
            font-weight: 600;
            font-size: 2em;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
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
        .car-card p {
            color: #ff8c00;
            font-weight: 500;
            font-size: 1.2em;
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
            form {
                flex-direction: column;
            }
            .filters {
                flex-direction: column;
            }
            .car-card img {
                height: 120px;
            }
        }
    </style>
</body>
</html>

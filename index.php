<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar - Home</title>
</head>
<body>
    <header>
        <h1>RentACar</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="#" onclick="navigateTo('cars.php')">Cars</a>
            <a href="#" onclick="navigateTo('booking.php')">Book Now</a>
        </nav>
    </header>
    <main>
        <section class="search-section">
            <h2>Find Your Perfect Car</h2>
            <form id="searchForm" onsubmit="handleSearch(event)">
                <input type="text" id="location" placeholder="Enter pickup location" required>
                <input type="date" id="startDate" required>
                <input type="date" id="endDate" required>
                <button type="submit">Search Cars</button>
            </form>
            <div class="filters">
                <select id="carType">
                    <option value="">All Car Types</option>
                    <option value="Sedan">Sedan</option>
                    <option value="SUV">SUV</option>
                    <option value="Luxury">Luxury</option>
                </select>
                <select id="priceRange">
                    <option value="">All Prices</option>
                    <option value="0-50">$0 - $50</option>
                    <option value="51-100">$51 - $100</option>
                    <option value="101-200">$101 - $200</option>
                </select>
                <select id="fuelType">
                    <option value="">All Fuel Types</option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Electric">Electric</option>
                </select>
                <select id="brand">
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
                    <img src="https://via.placeholder.com/300x200" alt="Toyota Camry">
                    <h3>Toyota Camry</h3>
                    <p>$50/day</p>
                    <button onclick="navigateTo('booking.php?car_id=1')">Book Now</button>
                </div>
                <div class="car-card">
                    <img src="https://via.placeholder.com/300x200" alt="BMW X5">
                    <h3>BMW X5</h3>
                    <p>$100/day</p>
                    <button onclick="navigateTo('booking.php?car_id=2')">Book Now</button>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 RentACar. All rights reserved.</p>
    </footer>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .search-section {
            padding: 20px;
            text-align: center;
            background-color: #fff;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .search-section h2 {
            margin-bottom: 20px;
            color: #007bff;
        }
        form {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        input, select, button {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .filters {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .featured-cars {
            padding: 20px;
            text-align: center;
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .car-card {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .car-card:hover {
            transform: translateY(-5px);
        }
        .car-card img {
            width: 100%;
            border-radius: 10px;
        }
        .car-card h3 {
            margin: 10px 0;
            color: #007bff;
        }
        .car-card p {
            color: #555;
        }
        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        @media (max-width: 600px) {
            form {
                flex-direction: column;
            }
            .filters {
                flex-direction: column;
            }
        }
    </style>

    <script>
        function navigateTo(page) {
            window.location.href = page;
        }

        function handleSearch(event) {
            event.preventDefault();
            const location = document.getElementById('location').value;
            const startDate = document.getElementById('startDate').value;
}
    </script>
</body>
</html>

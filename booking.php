<?php
session_start();
require_once 'db.php';
$conn = getConnection();

$car_id = isset($_GET['car_id']) ? intval($_GET['car_id']) : 0;
$car = null;
if ($car_id) {
    $stmt = $conn->prepare("SELECT * FROM cars WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    $stmt = $conn->prepare("INSERT INTO bookings (car_id, user_name, user_email, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $car_id, $user_name, $user_email, $start_date, $end_date);
    if ($stmt->execute()) {
        header("Location: confirmation.php?booking_id=" . $conn->insert_id);
        exit;
    } else {
        echo "<p style='color: red;'>Error: Unable to book the car.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar - Book a Car</title>
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
        <section class="booking-form">
            <h2>Book Your Car</h2>
            <?php if ($car): ?>
                <div class="car-details">
                    <img src="<?php echo htmlspecialchars($car['image_url']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>">
                    <h3><?php echo htmlspecialchars($car['name']); ?></h3>
                    <p>$<?php echo htmlspecialchars($car['price_per_day']); ?>/day</p>
                </div>
                <form id="bookingForm" method="POST">
                    <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
                    <label for="user_name">Full Name:</label>
                    <input type="text" id="user_name" name="user_name" required>
                    <label for="user_email">Email:</label>
                    <input type="email" id="user_email" name="user_email" required>
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" required>
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" required>
                    <button type="submit">Confirm Booking</button>
                </form>
            <?php else: ?>
                <p>Please select a car to book.</p>
            <?php endif; ?>
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
        .booking-form {
            padding: 30px;
            text-align: center;
            background: white;
            margin: 30px auto;
            max-width: 500px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .booking-form h2 {
            color: #007bff;
            font-weight: 600;
            font-size: 2em;
            margin-bottom: 25px;
        }
        .car-details {
            margin-bottom: 25px;
        }
        .car-details img {
            width: 100%;
            max-width: 350px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .car-details h3 {
            color: #007bff;
            font-size: 1.6em;
            font-weight: 600;
        }
        .car-details p {
            color: #ff8c00;
            font-weight: 500;
            font-size: 1.2em;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-weight: 600;
            color: #333;
        }
        input, button {
            padding: 12px;
            font-size: 1em;
            border-radius: 8px;
            border: 1px solid #ccc;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        input:focus {
            border-color: #ff8c00;
            box-shadow: 0 0 5px rgba(255, 140, 0, 0.5);
            outline: none;
        }
        button {
            background: linear-gradient(45deg, #007bff, #00b7eb);
            color: white;
            border: none;
            cursor: pointer;
            padding: 12px 25px;
            font-weight: 600;
            border-radius: 25px;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        button:hover {
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
            .car-details img {
                max-width: 100%;
                height: 150px;
            }
            .booking-form {
                margin: 20px;
            }
        }
    </style>
</body>
</html>

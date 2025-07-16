<?php
session_start();
require_once 'db.php';
$conn = getConnection();

$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;
$booking = null;
if ($booking_id) {
    $stmt = $conn->prepare("SELECT b.*, c.name AS car_name FROM bookings b JOIN cars c ON b.car_id = c.car_id WHERE b.booking_id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar - Booking Confirmation</title>
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
        <section class="confirmation">
            <h2>Booking Confirmed!</h2>
            <?php if ($booking): ?>
                <p>Thank you, <?php echo htmlspecialchars($booking['user_name']); ?>!</p>
                <p>Your booking for <strong><?php echo htmlspecialchars($booking['car_name']); ?></strong> has been confirmed.</p>
                <p>Details:</p>
                <ul>
                    <li>Email: <?php echo htmlspecialchars($booking['user_email']); ?></li>
                    <li>Start Date: <?php echo htmlspecialchars($booking['start_date']); ?></li>
                    <li>End Date: <?php echo htmlspecialchars($booking['end_date']); ?></li>
                </ul>
                <a href="home.php" class="book-button">Back to Home</a>
            <?php else: ?>
                <p>Invalid booking ID.</p>
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
        .confirmation {
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
        .confirmation h2 {
            color: #007bff;
            font-weight: 600;
            font-size: 2em;
            margin-bottom: 25px;
        }
        .confirmation p {
            color: #333;
            font-size: 1.1em;
        }
        .confirmation strong {
            color: #ff8c00;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        ul li {
            margin: 10px 0;
            font-size: 1em;
            color: #555;
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
            .confirmation {
                margin: 20px;
            }
        }
    </style>
</body>
</html>

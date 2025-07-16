<?php
session_start();
require_once 'db.php';
$conn = getConnection();

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $error = "Email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $success = "Registration successful! Redirecting to login...";
            header("Location: login.php");
            exit;
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar - Sign Up</title>
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
        </nav>
    </header>
    <main>
        <section class="signup-form">
            <h2>Create an Account</h2>
            <?php if ($error): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <form id="signupForm" method="POST">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="login.php">Login here</a></p>
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
        .signup-form {
            padding: 30px;
            text-align: center;
            background: white;
            margin: 30px auto;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .signup-form h2 {
            color: #007bff;
            font-weight: 600;
            font-size: 2em;
            margin-bottom: 25px;
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
        p a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        p a:hover {
            color: #ff8c00;
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
            .signup-form {
                margin: 20px;
            }
        }
    </style>
</body>
</html>

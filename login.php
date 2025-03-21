<?php

session_start(); // Start session
include "connectiondb.php"; // Database connection file
include "functions.php"; // Additional helper functions

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve and sanitize input
    $regnumber = trim($_POST['regnumber']);
    $password = trim($_POST['password']);

    // Validate regnumber and password
    $regnumber_pattern = "/^h\d{6}[a-z]$/"; // Must start with 'h', followed by 6 digits and end with a letter
    $valid_password = "Hit@2023Intake";

    if (preg_match($regnumber_pattern, $regnumber) && $password === $valid_password) {
        // Check database connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Use prepared statements to prevent SQL injection
        $query = "SELECT * FROM users WHERE regnumber = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $regnumber);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();

            // Store user data in session
            $_SESSION['user_id'] = $user_data['id'];

            // Redirect to the profile creation page
            header("Location:profiles.php");
            exit;
        } else {
            echo "No matching user found in the database.";
        }
    } else {
    }
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTERNREC Login PAGE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
        }

        .bg-img {
            background: url('https://img.freepik.com/premium-photo/laptop-with-bright-neon-outline_1187703-50400.jpg?w=2000') no-repeat center center fixed;
            height: 100vh;
            background-size: cover;
            position: relative;
        }

        .bg-img:after {
            position: absolute;
            content: '';
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 999;
            text-align: center;
            padding: 60px 32px;
            width: 370px;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.04);
            box-shadow: -1px 4px 28px 0px rgba(0, 0, 0, 0.75);
        }

        .content header {
            color: white;
            font-size: 33px;
            font-weight: 600;
            margin: 0 0 35px 0;
            font-family: 'Montserrat', sans-serif;
        }

        .field {
            position: relative;
            height: 45px;
            width: 100%;
            display: flex;
            background: rgba(255, 255, 255, 0.94);
        }

        .field span {
            color: #222;
            width: 40px;
            line-height: 45px;
        }

        .field input {
            height: 100%;
            width: 100%;
            background: transparent;
            border: none;
            outline: none;
            color: #222;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }

        .space {
            margin-top: 16px;
        }

        .show {
            position: absolute;
            right: 13px;
            font-size: 13px;
            font-weight: 700;
            color: #222;
            display: none;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
        }

        .pass-key:valid~.show {
            display: block;
        }

        .pass {
            text-align: left;
            margin: 10px 0;
        }

        .pass a {
            color: white;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }

        .pass:hover a {
            text-decoration: underline;
        }

        .field input[type="submit"] {
            background: #808080;
            border: none;
            color: white;
            font-size: 18px;
            letter-spacing: 1px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(128, 128, 128, 0.5), 0 0 25px rgba(128, 128, 128, 0.7);
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .field input[type="submit"]:hover {
            background: #696969;
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(128, 128, 128, 0.7), 0 0 30px rgba(128, 128, 128, 0.9);
        }

        .login {
            color: white;
            margin: 20px 0;
            font-family: 'Poppins', sans-serif;
        }

        .links {
            display: flex;
            cursor: pointer;
            color: white;
            margin: 0 0 20px 0;
        }

        .facebook,
        .instagram {
            width: 100%;
            height: 45px;
            line-height: 45px;
            margin-left: 10px;
        }

        .facebook {
            margin-left: 0;
            background: #4267B2;
            border: 1px solid #3e61a8;
        }

        .instagram {
            background: #E1306C;
            border: 1px solid #df2060;
        }

        .facebook:hover {
            background: #3e61a8;
        }

        .instagram:hover {
            background: #df2060;
        }

        .links i {
            font-size: 17px;
        }

        i span {
            margin-left: 8px;
            font-weight: 500;
            letter-spacing: 1px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }

        .signup {
            font-size: 15px;
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        .signup a {
            color: #3498db;
            text-decoration: none;
        }

        .signup a:hover {
            text-decoration: underline;
        }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <form action="login.php" method="POST">
        <div class="bg-img">
            <div class="content">
                <header>Login</header>
                <div>
                    <div class="field">
                        <span class="fa fa-user"></span>
                        <input type="text" name="regnumber" required placeholder="regnumber">
                    </div>
                    <div class="field space">
                        <span class="fa fa-lock"></span>
                        <input type="password" class="pass-key" name="password" required placeholder="Password">
                        <span class="show">SHOW</span>
                    </div>
                    <div class="pass">
                        <a href="#">Forgot Password?</a>
                    </div>
                    <div class="field">
                        <input type="submit" value="LOGIN">
                    </div>
                </div>
                <div class="login">Or login with</div>
                <div class="links">
                    <div class="facebook">
                        <i class="fab fa-facebook-f"><span>Facebook</span></i>
                    </div>
                    <div class="instagram">
                        <i class="fab fa-instagram"><span>Instagram</span></i>
                    </div>
                </div>
                <div class="signup">Don't have an account?
                    <a href="sign_up.php">Signup Now</a>
                </div>
            </div>
        </div>
    </form>
    <script>
        const pass_field = document.querySelector('.pass-key');
        const showBtn = document.querySelector('.show');
        showBtn.addEventListener('click', function() {
            if (pass_field.type === "password") {
                pass_field.type = "text";
                showBtn.textContent = "HIDE";
                showBtn.style.color = "#3498db";
            } else {
                pass_field.type = "password";
                showBtn.textContent = "SHOW";
                showBtn.style.color = "#222";
            }
        });
    </script>
</body>

</html>

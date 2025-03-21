<?php
include "connectiondb.php";
include "functions.php";
// Connect to the database
// Database connection
$server = "localhost"; // or use "127.0.0.1"
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "interndb"; // Replace with your database name

// Connect to the database
$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve POST data
    $fullname = $_POST['fullname'];
    $regnumber = $_POST['regnumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs
    if (!empty($fullname) && !empty($regnumber) && !empty($email) && !empty($password)) {
        // Prepare SQL statement to avoid SQL injection
        $query = "INSERT INTO users (fullname, regnumber, email, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            // Bind and sanitize parameters
            mysqli_stmt_bind_param($stmt, "ssss", $fullname, $regnumber, $email, $password);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                echo "New record added successfully!";
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Failed to prepare the SQL statement.";
        }

        // Redirect to login page
        header("Location:login.php");
        exit;
    } else {
        echo "All fields are required!";
    }
}

// Close the connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InternRec signup page</title>
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
            /* Adjust opacity for transparency */
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

        .field input[type="button"] {
            background: #808080;
            /* Solid grey */
            border: none;
            color: white;
            font-size: 18px;
            letter-spacing: 1px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            border-radius: 25px;
            /* Rounded corners */
            box-shadow: 0 4px 15px rgba(128, 128, 128, 0.5), 0 0 25px rgba(128, 128, 128, 0.7);
            /* Glassy effect */
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .field input[type="button"]:hover {
            background: #696969;
            /* Darker grey on hover */
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(128, 128, 128, 0.7), 0 0 30px rgba(128, 128, 128, 0.9);
            /* Stronger glow on hover */
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
<form action="sign_up.php" method="POST">

    <body>
        <div class="bg-img">
            <div class="content">
                <header>Signup</header>
                <div>
                    <div class="field">
                        <span class="fa fa-user"></span>
                        <input type="text" required placeholder="fullname" name="funame"><br></br>
                    </div><br></br>
                    <div class="field">
                        <span class="fa fa-user"></span>
                        <input type="text" required placeholder="regnumber" name="regnumber">
                    </div><br></br>
                    <div class="field">
                        <span class="fa fa-user"></span>
                        <input type="email" required placeholder="Email" name="email"><br></br>
                    </div>
                    <div class="field space">
                        <span class="fa fa-lock"></span>
                        <input type="password" class="pass-key" required placeholder="Password" name="password">
                        <span class="show">SHOW</span>
                    </div>

                    <div class="pass">
                        <br></br>
                    </div>


                    <div class="field">
                        <input type="button" value="sign up">
                    </div>
                </div>
                <div class="sign up"></div>

                <div class="signup">

                </div>
            </div>
        </div>

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
</form>

</html>

<?php 
session_start(); 
require_once 'koneksi.php'; 

$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $username = mysqli_real_escape_string($koneksi, trim($_POST['username'])); 
    $password = mysqli_real_escape_string($koneksi, trim($_POST['password'])); 

    if (empty($username) || empty($password)) {
        $error = "Username dan password tidak boleh kosong.";
    } else {
        $query = "SELECT * FROM users WHERE username = '$username'"; 
        $result = mysqli_query($koneksi, $query); 

        if (!$result) {
            die("Query error: " . mysqli_error($koneksi));
        }

        if (mysqli_num_rows($result) == 1) { 
            $row = mysqli_fetch_assoc($result); 
            if ($password == $row['password']) { 
                $_SESSION['username'] = $username; 
                header("Location: dashboard.php"); 
                exit();
            } else { 
                $error = "Password salah.";
            } 
        } else { 
            $error = "Username tidak ditemukan.";
        } 
    }
}
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <title>Login</title> 
    <link rel="stylesheet" href="style.css"> 
</head> 
<body> 
    <div class="container"> 
        <div class="main-content"></div> 
        <div class="sidebar"> 
            <div class="login-box"> 
                <div class="logo"> 
                    <img src="logo.jpg" alt="Logo"> 
                </div> 
                <form action="" method="post"> 
                    <div class="input-group"> 
                        <input type="text" placeholder="Username" name="username" required> 
                    </div> 
                    <div class="input-group"> 
                        <input type="password" placeholder="Password" name="password" required> 
                    </div> 
                    <button type="submit" class="login-btn">Login</button> 
                    <div class="forgot-password">Lupa password?</div>    
                </form> 
                <?php if (!empty($error)): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
            </div> 
        </div> 
    </div> 
</body> 
</html>

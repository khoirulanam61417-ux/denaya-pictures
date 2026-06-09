<?php
session_start();
include 'koneksi.php';

// Jika admin sudah login, langsung lempar ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit;
}

$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = $_POST['username'];
    $pass_input = md5($_POST['password']); // Menggunakan MD5 sesuai database Anda

    // Menggunakan Prepared Statement untuk keamanan dari SQL Injection
    $stmt = $conn->prepare("SELECT id, username, nama_lengkap FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user_input, $pass_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Set Session
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $data['username'];
        $_SESSION['admin_nama'] = $data['nama_lengkap'];

        header("Location: admin.php");
        exit;
    } else {
        $error_msg = "Kombinasi username atau password salah.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Denaya Pictures Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/btn/css/all.min.css">
    <style>
        /* Gaya Estetik Senada dengan Index.php */
        body {
            background-color: #f7f5f0;
            color: #3a3835;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* Efek Grain/Film khas Denaya */
        .grain-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none;
            z-index: 9999;
            opacity: 0.3;
            background-image: url('data:image/svg+xml;utf8,%3Csvg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"%3E%3Cfilter id="noiseFilter"%3E%3CfeTurbulence type="fractalNoise" baseFrequency="0.65" numOctaves="3" stitchTiles="stitch"/%3E%3C/filter%3E%3Crect width="100%25" height="100%25" filter="url(%23noiseFilter)"/%3E%3C/svg%3E');
        }

        .login-card {
            background: #fff;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #dcd7ce;
            z-index: 10;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            font-family: 'Playfair Display', serif;
            letter-spacing: 4px;
            margin-bottom: 5px;
        }

        .login-header p {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #888;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dcd7ce;
            background: #faf9f7;
            font-family: inherit;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3a3835;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: #3a3835;
            color: #fff;
            border: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #55514d;
        }

        .error-box {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <div class="grain-overlay"></div>

    <div class="login-card">
        <div class="login-header">
            <h2>DENAYA</h2>
            <p>Admin Authentication</p>
        </div>

        <?php if ($error_msg != ""): ?>
            <div class="error-box"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Sign In</button>
        </form>
    </div>

</body>
</html>
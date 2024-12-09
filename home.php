<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3DES Encryption</title>
    <style>
        /* CSS untuk halaman home.php */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            background-color: #333;
            padding: 10px;
            color: white;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
        }

        .navbar a:hover {
            background-color: #575757;
        }

        .navbar-right button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        .navbar-right button:hover {
            background-color: #45a049;
        }

        .container {
            padding: 20px;
        }

        .container h1 {
            color: #333;
        }

        .container form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .container form input,
        .container form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .container form button {
            width: 48%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .container form button:hover {
            background-color: #45a049;
        }

        .container form button[type="submit"]:nth-child(2) {
            background-color: #008CBA;
        }

        .container form button[type="submit"]:nth-child(2):hover {
            background-color: #007bb5;
        }

        .container hr {
            margin: 20px 0;
        }

        .container p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-left">
            <a href="?page=home">Home</a>
            <a href="?page=features">Features</a>
            <a href="?page=about">About</a>
        </div>
        <div class="navbar-right">
            <button onclick="window.location.href='logout.php'">Logout</button>
        </div>
    </div>
    <div class="container">
        <?php if ($page === 'home') : ?>
            <h1>Welcome to 3DES Encryption</h1>
            <p>Gunakan fitur Triple DES untuk enkripsi dan dekripsi.</p>
            <hr>
            <form action="process.php" method="post" enctype="multipart/form-data">
                <textarea name="plaintext" placeholder="Masukkan teks yang akan dienkripsi" rows="5"></textarea>
                <input type="file" name="file" />
                <input type="text" name="key1" placeholder="Masukkan Kunci 1 (8 karakter)" maxlength="8" required>
                <input type="text" name="key2" placeholder="Masukkan Kunci 2 (8 karakter)" maxlength="8" required>
                <input type="text" name="key3" placeholder="Masukkan Kunci 3 (8 karakter)" maxlength="8" required>
                <button type="submit" name="action" value="encrypt">Enkripsi</button>
                <button type="submit" name="action" value="decrypt">Dekripsi</button>
            </form>

            <?php if (isset($_SESSION['result_message'])): ?>
                <hr>
                <h2>Hasil:</h2>
                <p><?php echo $_SESSION['result_message']; ?></p>
                <?php unset($_SESSION['result_message']); ?>
            <?php endif; ?>

        <?php elseif ($page === 'features') : ?>
            <h1>Features</h1>
            <p>Triple DES (3DES) adalah algoritma enkripsi yang menggunakan tiga kunci DES secara berurutan untuk meningkatkan keamanan. Fitur utama 3DES adalah:</p>
            <ul>
                <li>Penggunaan tiga kunci DES yang berbeda atau berulang.</li>
                <li>Meningkatkan keamanan data dibandingkan DES tunggal.</li>
                <li>Cocok untuk aplikasi yang membutuhkan enkripsi simetris dengan keamanan lebih tinggi.</li>
            </ul>
        <?php elseif ($page === 'about') : ?>
            <h1>About Triple DES</h1>
            <p>Triple DES (3DES) adalah algoritma enkripsi blok yang diperkenalkan untuk menggantikan DES karena kelemahan keamanan pada DES tunggal. Metode ini bekerja dengan mengenkripsi data tiga kali menggunakan kunci berbeda atau kombinasi kunci yang sama. 3DES banyak digunakan dalam industri perbankan dan pembayaran elektronik.</p>
        <?php endif; ?>
    </div>
</body>
</html>

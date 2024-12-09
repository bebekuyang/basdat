<?php
session_start();

// Fungsi untuk enkripsi dan dekripsi dengan Triple DES
function triple_des($data, $key1, $key2, $key3, $action = 'encrypt') {
    // Ubah kunci menjadi panjang 8 karakter untuk DES
    $key1 = str_pad($key1, 8, '0');
    $key2 = str_pad($key2, 8, '0');
    $key3 = str_pad($key3, 8, '0');
    
    // Proses enkripsi atau dekripsi
    if ($action === 'encrypt') {
        return openssl_encrypt($data, 'DES-EDE3', $key1 . $key2 . $key3, OPENSSL_RAW_DATA);
    } elseif ($action === 'decrypt') {
        return openssl_decrypt($data, 'DES-EDE3', $key1 . $key2 . $key3, OPENSSL_RAW_DATA);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cek jika file diupload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fileContent = file_get_contents($_FILES['file']['tmp_name']);
    } elseif (!empty($_POST['plaintext'])) {
        // Jika tidak ada file, gunakan teks dari textarea
        $fileContent = $_POST['plaintext'];
    } else {
        $_SESSION['result_message'] = 'File atau teks harus diisi!';
        header('Location: home.php');
        exit;
    }

    $key1 = $_POST['key1'] ?? '';
    $key2 = $_POST['key2'] ?? '';
    $key3 = $_POST['key3'] ?? '';
    $action = $_POST['action'] ?? '';

    if (empty($key1) || empty($key2) || empty($key3)) {
        $_SESSION['result_message'] = 'Semua kolom kunci harus diisi!';
        header('Location: home.php');
        exit;
    }

    if ($action == 'encrypt') {
        // Proses enkripsi
        $encryptedData = triple_des($fileContent, $key1, $key2, $key3, 'encrypt');
        $encryptedBase64 = base64_encode($encryptedData);  // Encode hasil enkripsi ke base64
        $message = "Hasil Enkripsi (Base64):<br>" . $encryptedBase64;
    } elseif ($action == 'decrypt') {
        // Proses dekripsi
        $decryptedData = triple_des(base64_decode($fileContent), $key1, $key2, $key3, 'decrypt');
        $message = "Hasil Dekripsi:<br>" . $decryptedData;
    }

    // Simpan hasilnya di session agar bisa ditampilkan di home.php
    $_SESSION['result_message'] = $message;
    header('Location: home.php');
    exit;
}

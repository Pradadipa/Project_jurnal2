<?php
include 'dbconn.php';

$id = $_POST['id'];
$nama_akun = $_POST['nama_akun'];
$pos_saldo = $_POST['pos_saldo'];
$pos_laporan = $_POST['pos_laporan'];

// Lakukan sanitasi pada data yang diterima dari input pengguna
$id = mysqli_real_escape_string($conn, $id);
$nama_akun = mysqli_real_escape_string($conn, $nama_akun);
$pos_saldo = mysqli_real_escape_string($conn, $pos_saldo);
$pos_laporan = mysqli_real_escape_string($conn, $pos_laporan);

$sql = "INSERT INTO `daftar_akun` (`id`, `nama_akun`, `pos_saldo`, `pos_laporan`) VALUES ('$id','$nama_akun','$pos_saldo','$pos_laporan')";

// Jalankan kueri SQL menggunakan metode query() dari objek koneksi mysqli
$result = $conn->query($sql);

// Periksa apakah kueri berhasil dijalankan
if (!$result) {
    // Jika gagal, tangani kesalahan
    echo "Error: " . $sql . "<br>" . $conn->error;
} else {
    echo "Data berhasil ditambahkan";
    header("Location: master_akun.php");
    exit();
}

// Tutup koneksi
$conn->close();

<?php
// Koneksikan ke database
include 'dbconn.php';

// Periksa apakah tanggal_awal dan tanggal_akhir telah diberikan
if (isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir'])) {
    // Ambil nilai yang diposting dari form
    $tanggal_awal = $_GET['tanggal_awal'];
    $tanggal_akhir = $_GET['tanggal_akhir'];

    // Lakukan filter data berdasarkan tanggal
    // Pastikan untuk mengutip tanggal dengan benar dalam query SQL
    $sql = "SELECT * FROM `jurnal` WHERE `tanggal` BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
    $result = $conn->query($sql);

    // Periksa apakah query berhasil dijalankan
    if ($result) {
        // Periksa apakah ada data yang ditemukan
        if ($result->num_rows > 0) {
            // Iterasi melalui setiap baris hasil query
            while ($row = $result->fetch_assoc()) {
                // Tampilkan data yang ditemukan
                echo "ID: " . $row["id_jurnal"]. " - Tanggal: " . $row["tanggal"]. " - Keterangan: " . $row["keterangan"]. "<br>";
            }
        } else {
            // Jika tidak ada data ditemukan, tampilkan pesan
            echo "Tidak ada data yang ditemukan.";
        }
    } else {
        // Jika query gagal dijalankan, tampilkan pesan kesalahan
        echo "Error: " . $conn->error;
    }

    // Tutup koneksi database setelah selesai
    $conn->close();
} else {
    // Tampilkan pesan jika tanggal_awal dan tanggal_akhir tidak diberikan
    echo "Tanggal awal dan tanggal akhir harus dipilih.";
}
?>

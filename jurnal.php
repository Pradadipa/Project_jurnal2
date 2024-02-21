<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            text-align: center;
            /* Mengatur elemen body menjadi berada di tengah */
        }

        table {
            margin: auto;
        }

        .form-input {
            margin-top: 5px;
        }

        .td {
            text-align: center;
        }

        th {
            border: 1px solid black;
        }

        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Jurnal Umum</h1>
    <form class="form" action="insert_jurnal.php" method="post">
        <div class="form-input">
            <label for="">Tanggal</label>
            <input type="date" value="<?= date('Y-m-d') ?>" name="tanggal" id="tanggal">

        </div>

        <div class="form-input">
            <label for="keterangan">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan">
        </div>
        <div id="additional-inputs">
            <div class=" form-input">
                <label for="nama_akun">Nama Akun</label>
                <select name="nama_akun[]" id="nama_akun">
                    <option value="">Pilih Akun</option>
                    <?php
                    // Include file koneksi database
                    include 'dbconn.php';

                    // Query untuk mengambil data akun dari database
                    $sql = "SELECT `id`, `nama_akun` FROM `daftar_akun`";
                    $result = $conn->query($sql);

                    // Periksa apakah ada data yang ditemukan
                    if ($result->num_rows > 0) {
                        // Iterasi melalui setiap baris hasil query
                        while ($row = $result->fetch_assoc()) {
                            // Tampilkan opsi untuk setiap akun
                            echo '<option value="' . $row['id'] . '">[' . $row['id'] . '] ' . $row['nama_akun'] . '</option>';
                        }
                    } else {
                        // Jika tidak ada data ditemukan, tampilkan opsi default
                        echo '<option value="">Tidak ada data akun</option>';
                    }

                    // Tutup koneksi database
                    $conn->close();
                    ?>
                </select>

            </div>
            <div class="form-input">
                <label for="debet">Debet</label>
                <input type="number" name="debet[]" class="debet" value="0">
            </div>
            <div class="form-input">
                <label for="kredit">Kredit</label>
                <input type="number" name="kredit[]" class="kredit" value="0">
            </div>
        </div>

        <button style="margin-top: 20px;" type="submit">Tambah</button>
    </form>
    <button id="add-form">Tambah Form Input</button>
    <div>
        <h3>Filter tanggal</h3>
        <form method="GET" action="action_filter.php">
        <div>
            <label for="tanggal-awal">Tanggal-awal:</label>
            <input type="date" id="tanggal-awal" name="tanggal_awal">
            <label for="tanggal-akhir">Tanggal-akhir:</label>
            <input type="date" id="tanggal-akhir" name="tanggal_akhir">
            <button type="submit" name="submit">Filter</button>
        </div>
        </form>
    </div>
    

    <div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nomor Bukti</th>
                    <th>Kode Akun</th>
                    <th>Debet</th>
                    <th>Kredit</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'dbconn.php';
                $sql = "SELECT `id_jurnal`, `nomor_bukti`, `tanggal`, `keterangan` FROM `jurnal` WHERE 1";
                $result = $conn->query($sql);

                $total_debet = 0;
                $total_kredit = 0;

                if ($result->num_rows > 0) {
                    while ($row_jurnal = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo '<td colspan="5" style="text-align:left">' . $row_jurnal['keterangan'] . '</td>';
                        echo "</tr>";
                        echo "<tr>";
                        echo '<td rowspan="2" style="text-align:center">' . $row_jurnal['tanggal'] . '</td>';
                        echo '<td rowspan="2" style="text-align:left">' . $row_jurnal['nomor_bukti'] . '</td>';


                        // Lakukan query untuk detail jurnal berdasarkan ID jurnal saat ini
                        $jurnal_id = $row_jurnal['id_jurnal'];
                        $sql_detail = "SELECT * FROM jurnal_detail WHERE id_jurnal = '$jurnal_id'";
                        $result_detail = $conn->query($sql_detail);

                        // Periksa apakah ada data detail jurnal untuk jurnal saat ini
                        if ($result_detail->num_rows > 0) {
                            while ($row_detail = $result_detail->fetch_assoc()) {
                                echo '<td style="text-align:center">' . $row_detail['id_akun'] . '</td>';
                                echo '<td style="text-align:left">' . $row_detail['debit'] . '</td>';
                                echo '<td style="text-align:left">' . $row_detail['kredit'] . '</td>';
                                echo "</tr>";

                                $total_debet += $row_detail['debit'];
                                $total_kredit += $row_detail['kredit'];
                            }
                        } else {
                            // Tidak ada data detail jurnal untuk jurnal saat ini
                            echo "<tr><td colspan='5'>Tidak ada detail jurnal</td></tr>";
                        }
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
                }

                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td style="text-align:center"><strong>
                            <?php echo number_format($total_debet, 0, ',', '.'); ?>
                        </strong></td>
                    <td style="text-align:center"><strong>
                            <?php echo number_format($total_kredit, 0, ',', '.'); ?>
                        </strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div>
        <a href="index.php">Back</a>
    </div>



    <script>
        document.getElementById('add-form').addEventListener('click', function () {
            var additionalInputs = document.getElementById('additional-inputs');

            // Buat elemen div untuk wadah form input baru
            var newInputGroup = document.createElement('div');
            newInputGroup.classList.add('form-input');

            // Tambahkan form input untuk nama akun
            var namaAkunLabel = document.createElement('label');
            namaAkunLabel.textContent = 'Nama Akun';
            var namaAkunSelect = document.createElement('select');
            namaAkunSelect.name = 'nama_akun[]';
            namaAkunSelect.id = 'nama_akun';
            // Tambahkan opsi default
            var defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Pilih Akun';
            namaAkunSelect.appendChild(defaultOption);
            // Tambahkan opsi-opsi akun dari database
            <?php
            // Include file koneksi database
            include 'dbconn.php';

            // Query untuk mengambil data akun dari database
            $sql = "SELECT `id`, `nama_akun` FROM `daftar_akun`";
            $result = $conn->query($sql);

            // Periksa apakah ada data yang ditemukan
            if ($result->num_rows > 0) {
                // Iterasi melalui setiap baris hasil query
                while ($row = $result->fetch_assoc()) {
                    // Tambahkan opsi untuk setiap akun
                    echo "var option = document.createElement('option');";
                    echo "option.value = '{$row['id']}';";
                    echo "option.textContent = '[{$row['id']}] {$row['nama_akun']}';";
                    echo "namaAkunSelect.appendChild(option);";
                }
            }
            // Tutup koneksi database
            $conn->close();
            ?>
            // Tambahkan elemen label dan select ke dalam wadah form input baru
            newInputGroup.appendChild(namaAkunLabel);
            newInputGroup.appendChild(namaAkunSelect);

            // Tambahkan form input untuk debet
            var debetLabel = document.createElement('label');
            debetLabel.textContent = 'Debet';
            var debetInput = document.createElement('input');
            debetInput.type = 'number';
            debetInput.name = 'debet[]';
            debetInput.classList.add('debet');
            debetInput.value = '0';
            // Tambahkan elemen label dan input ke dalam wadah form input baru
            newInputGroup.appendChild(debetLabel);
            newInputGroup.appendChild(debetInput);

            // Tambahkan form input untuk kredit
            var kreditLabel = document.createElement('label');
            kreditLabel.textContent = 'Kredit';
            var kreditInput = document.createElement('input');
            kreditInput.type = 'number';
            kreditInput.name = 'kredit[]';
            kreditInput.classList.add('kredit');
            kreditInput.value = '0';
            // Tambahkan elemen label dan input ke dalam wadah form input baru
            newInputGroup.appendChild(kreditLabel);
            newInputGroup.appendChild(kreditInput);

            // Tambahkan wadah form input baru ke dalam div additional-inputs
            additionalInputs.appendChild(newInputGroup);
        });


    </script>
</body>

</html>
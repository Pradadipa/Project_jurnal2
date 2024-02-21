<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <style>
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
    <h1>Master Akun</h1>
    <form class="form" method="post" action="insert_akun.php">
        <label for="id">id:</label>
        <input type="text" id="id" name="id"><br><br>

        <label for="nama_akun">Nama Akun:</label>
        <input type="text" id="nama_akun" name="nama_akun"><br><br>

        <label for="pos_saldo">Posisi Saldo:</label>
        <input type="text" id="pos_saldo" name="pos_saldo"><br><br>

        <label for="pos_laporan">Posisi Laporan:</label>
        <input type="text" id="pos_laporan" name="pos_laporan"><br><br>

        <label for="pos_laporan">Saldo debit awal:</label>
        <input type="text" id="pos_laporan" value="0" name="pos_laporan"><br><br>

        <label for="pos_laporan">Saldo kredit awal:</label>
        <input type="text" id="pos_laporan" value="0" name="pos_laporan"><br><br>

        <input type="submit" value="Submit">
    </form>

    <table id="table_akun" class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>Nama Akun</th>
                <th>Posisi Saldo</th>
                <th>Posisi Laporan</th>
                <th>Saldo Debet Awal</th>
                <th>Saldo Kredit Awal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'dbconn.php';

            $sql = "SELECT `id`, `nama_akun`, `pos_saldo`, `pos_laporan`, `saldo_debit_awal`, `saldo_kredit_awal` FROM `daftar_akun` WHERE 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo '<td style="text-align:center">' . $row['id'] . '</td>';
                    echo '<td style="text-align:left">' . $row['nama_akun'] . '</td>';
                    echo '<td style="text-align:center">' . $row['pos_saldo'] . '</td>';
                    echo '<td style="text-align:center">' . $row['pos_laporan'] . '</td>';
                    echo '<td style="text-align:center">' . $row['saldo_debit_awal'] . '</td>';
                    echo '<td style="text-align:center">' . $row['saldo_kredit_awal'] . '</td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>


    <div>
        <a href="index.php">Back</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // $.ajax({
        //     url: 'https://reqres.in/api/users',
        //     dataType: 'json',
        //     success: function (response) {
        //         console.log('Data berhasil diterima:', response);

        //         $('#table_akun');

        //         var table = $('#table_akun');

        //         // Iterasi melalui data yang diterima
        //         $.each(response.data, function (index, user) {
        //             // Membuat baris baru untuk setiap pengguna
        //             var row = $('<tr>');

        //             // Menambahkan sel-sel dengan data pengguna
        //             row.append($('<td>').text(user.id));
        //             row.append($('<td>').text(user.email));
        //             row.append($('<td>').text(user.first_name));
        //             row.append($('<td>').text(user.last_name));
        //             row.append($('<td>').text(user.avatar));

        //             // Menambahkan baris ke dalam tubuh tabel
        //             table.find('tbody').append(row);
        //         });

        //     },
        //     error: function (xhr, status, error) {
        //         console.log('Terjadi kesalahan:', error);
        //     }
        // });
    </script>
</body>

</html>
<?php 
    session_start();
    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }

require 'functions.php';

//Pagination
$jumlah_pingin = 2;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData/$jumlah_pingin);
$halamanAktif = ( isset($_GET['p'])) ? $_GET['p'] : 1;
$dataAwal = ($jumlah_pingin * $halamanAktif) - $jumlah_pingin;
//Connect table
$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $dataAwal, $jumlah_pingin");

if(isset($_POST['cari'])){
    $mahasiswa = cari($_POST['keyword']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Mahasiswa</title>
    <style>
        .container{
            width: 80%;
        }

        

        a{
            text-decoration: none;
            color:black;
        }

        td {
            vertical-align: middle;
            text-align: center;
            padding: 1em;
        }

        .tambah{
            margin-bottom:1em;
            color: black;
        }

        .ubah{
            background-color:#57a0d3;
            color: white;
            margin-bottom: 0.5em;
            border-radius: 5px;
        }

        .red{
            background-color:#df2800;
            color: white;
            border-radius: 5px;
        }

        .pagination{
            text-decoration: underline;
            color:blue;
            font-size: 1.5em;
            padding: 0.5em;
        }

        .active{
            font-weight: 900px;
            color: red;
        }
    </style>
</head>
<body>
    
    <div class="container">
        

        <h1>Daftar Mahasiswa</h1>
        <button class="red"><a href="logout.php" style="text-decoration: none; color: black">Logout</a></button>
        <button class="tambah"><a href="insert.php">Tambah data</a></button>
        
        <form action="" method="post">
            <input type="text" name="keyword" placeholder="Masukkan keyword.." >
            <button type="submit" name="cari">Cari</button>
        </form>

        <br>

        <table border="3", cellpadding = "4", cellspacing = "1">

        <thead>
            <tr>
                <td>No</td>
                <td>Aksi</td>
                <td>Foto</td>
                <td>Nama</td>
                <td>NIM</td>
                <td>Jurusan</td>
                <td>Email</td>
                
            </tr>
        </thead>

        <tbody>
            <?php $i = 1; ?>
            <?php foreach($mahasiswa as $row) : ?>


            <tr>
                <td><?= $i; ?></td>
                <td>
                    <button class="ubah"><a href="update.php?n=<?= $row["id"]?>">Ubah</a></button>
                    <br>
                    <button class="red" onclick="return confirm('Anda yakin ingin menghapus?')"><a href="delete.php?n=<?php echo $row["id"]?>">Hapus</a></button>
                </td>
                <td><img src="img/<?= $row["gambar"]; ?>" alt="" width="70px"></td>
                <td><?= $row["nama"]; ?></td>
                <td><?= $row["nim"];  ?></td>
                <td><?= $row["jurusan"]; ?></td>
                <td><?= $row["email"]; ?></td>
                
            </tr>

            <?php $i++; ?>
            <?php endforeach; ?>

        </tbody>

        </table>

        <br>
        <?php if($halamanAktif > 1) :?>
        <a href="?p=<?= $halamanAktif - 1?>">&laquo;</a>
        <?php endif; ?>

        <?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
            <?php if ($i == $halamanAktif) :?>
                <a class="pagination active" href="?p=<?= $i ?>"><?= $i?></a>

            <?php else :?>
                
                <a class="pagination" href="?p=<?= $i ?>"><?= $i?></a>
            
            <?php endif; ?>
            
        <?php endfor; ?>

        <?php if($halamanAktif < $jumlahHalaman) :?>
        <a href="?p=<?= $halamanAktif + 1?>">&raquo;</a>
        <?php endif; ?>
    </div>
    
</body>
</html>
<?php
    require 'functions.php';
    $id = $_GET['n'];

    $mahasiswa = query("SELECT * FROM mahasiswa WHERE id=$id")[0];

    if (isset($_POST['submit'])) {
        
        if(update($_POST) > 0){
            echo "<script> 
                    alert('Data BERHASIL diubah');
                    window.location.href = 'table.php';
                </script>";
        }else{
            echo "<script> 
                    alert('Data GAGAL diubah');
                </script>";
            echo mysqli_error($db);
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .container{
            width: 80%;
            margin: auto;
            
        }
        ul {
            background-color: whitesmoke;
            list-style-type: none;
            padding: 0;
            border-radius: 3px;
        }
        li {
            display: flex;
            justify-content: space-between;
            padding: .5em;
        }
        li > label {
            padding: .5em 0 .5em 0;
            flex: 1;
        }
        li > input {
            flex: 10;
        }
        
        li > button {
    
            background-color: #222222;
            color: white;
            padding: .5em;
            flex: 8;
            border-radius: 20px;
            font-weight: 500;
        }

        li > button:hover {
            cursor: pointer;
        
        }
    </style>
    <title>Ubah Data</title>
</head>

<body>
    <div class="container">

        <h1>Update Data</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <ul>
                <li><input type="text" name="id" id="id" value="<?=$mahasiswa['id'] ?>" hidden></li>
                <li><input type="text" name="gambarLama" id="gambarLama" value="<?=$mahasiswa['gambar'] ?>" hidden></li>
                <li>
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" required value="<?=$mahasiswa['nama'] ?>">
                </li>
                <li>
                    <label for="nim">NIM</label>
                    <input type="text" name="nim" id="nim" required value="<?=$mahasiswa['nim'] ?>">
                </li>
                <li>
                    <label for="jurusan">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" required value="<?=$mahasiswa['jurusan'] ?>">
                </li>
                <li>
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" required value="<?=$mahasiswa['email'] ?>">
                </li>
                <li>
                    <label for="gambar">Gambar</label> <br>
                    <img src="img/<?=$mahasiswa['gambar'] ?>" alt="" width="100px" height="100px"> <br>
                    <input type="file" name="gambar" id="gambar">
                </li>

                <li>
                    <button type="submit" name="submit">Submit</button>
                </li>
            </ul>
        </form>
    </div>
    
</body>
</html>
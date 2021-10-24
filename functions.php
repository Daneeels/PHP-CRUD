<?php 
//Connect database
$db = mysqli_connect("localhost","root","paw48","pemweb");


//READ
function query($query){

    global $db;

    $table = mysqli_query($db, $query);
    $row_tampung = [];
    while ($row = mysqli_fetch_assoc($table)) {
        $row_tampung[] = $row;
    }
    return $row_tampung;
}

//INSERT
function insert($data){

    global $db;

    $nama = htmlspecialchars($data["nama"]);
    $nim = htmlspecialchars($data["nim"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email = htmlspecialchars($data["email"]);
    
    $gambar = upload();
    if ( !$gambar ){
        return false;
    }
    
    $query = "INSERT INTO mahasiswa VALUES
                ('', '$nama', '$nim', '$email', '$jurusan', '$gambar')";
                
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//Upload

function upload(){
    
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $errorFile = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //Mengecek apakah ada gambar yang diupload
    if( $errorFile === 4){
        echo "
            <script>
                alert('Masukkan file gambar terlebih dahulu');
            </script>
        ";

        return false;
    }

    //Mengecek ekstensi file
    $ekstensiValid = ['jpeg', 'jpg', 'png'];
    $ekstensi = explode('.', $namaFile);
    $ekstensi = strtolower(end($ekstensi));

    if ( !in_array($ekstensi, $ekstensiValid) ){
        echo "
            <script>
                alert('Ekstensi file salah');
            </script>
        ";

        return false;
    }

    //Mengecek ukuran file
    if ($ukuranFile > 2000000) {
        echo "
            <script>
                alert('Ukuran file maksimal 2mb');
            </script>
        ";

        return false;
    }

    //Lolos pengecekan
    $namaFileBaru = uniqid() . '.' . $ekstensi;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

//UPDATE
function update($data){

    global $db;

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nim = htmlspecialchars($data["nim"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email = htmlspecialchars($data["email"]);
    $gambarLama = $data["gambarLama"];
    
    if ($_FILES['gambar']['error'] === 4) {

        $gambar = $gambarLama;
        
    }else{

        $gambar = upload();
    }
    
    $query = "UPDATE mahasiswa SET
            nama = '$nama',
            nim = '$nim',
            email = '$email',
            jurusan = '$jurusan',
            gambar = '$gambar'
            WHERE id = '$id'";
                
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//DELETE
function delete($id){

    global $db;
    $query = "DELETE FROM mahasiswa WHERE id=$id";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//SEARCH

 function cari($keyword){

    $key_query = "SELECT * FROM mahasiswa
                    WHERE
                    nama LIKE '%$keyword%' OR
                    nim LIKE '%$keyword%' OR 
                    jurusan LIKE '%$keyword%' OR
                    email LIKE '%$keyword%'
                    ";
    return query($key_query);
 }

//Sign Up

function signup($data){

    global $db;
    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_real_escape_string($db, $data['pass']);
    $password2 = mysqli_real_escape_string($db, $data['pass2']);

    //Cek ketersediaan username

    $terambil = mysqli_query($db, "SELECT username FROM user_practice 
                WHERE username = '$username' ");

    if(mysqli_fetch_assoc($terambil)){
        echo "<script>
                    alert('Username has already TAKEN');
                </script>
            ";
            return false;
    }

    //Cek konfirmasi password
    if($password !== $password2){
        
            echo "<script>
                    alert('WRONG password confirmation');
                </script>
            ";
        
        return false;
    }

    
    //Enkripsi
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user_practice VALUES
                (
                    '', '$username', '$password'
                )";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

?>
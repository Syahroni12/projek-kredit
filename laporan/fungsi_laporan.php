<?php

$conn = mysqli_connect("localhost", "root", "", "angsur_database");


function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row; // Perbaikan disini
    }
    return $rows;
}
function tambah_data($data)
{
    global $conn;
    $email =  htmlspecialchars($data["email"]);
    $nama =  htmlspecialchars($data["nama"]);
    $username =  htmlspecialchars($data["username"]);
    $password = md5($data["password"]);
    $no_telfon =  htmlspecialchars($data["no_telfon"]);
    $akses =  htmlspecialchars($data["akses"]);

 
    $query_cek = "SELECT * FROM pegawai WHERE username = '$username'";
    $query_cek2 = "SELECT * FROM pegawai WHERE email = '$email'";
  


    $result = mysqli_query($conn, $query_cek);
    $result2 = mysqli_query($conn, $query_cek2);
    if (mysqli_num_rows($result) > 0) {
        // Jika nama jenis sudah ada, atur session alert Bootstrap
        session_start();
        $_SESSION['username_terdaftar'] = '<div class="alert alert-danger" role="alert">username  sudah ada dalam database.</div>';
        header("Location:../pengguna/tambah_pengguna.php");
     
       
       
        
    }elseif (mysqli_num_rows($result2) > 0) {
        # code...
        session_start(); 
        $_SESSION['email'] = '<div class="alert alert-danger" role="alert"> email sudah terdaftar sudah ada dalam database.</div>';
    
        header("Location:../pengguna/tambah_pengguna.php");
     
        
    }else {
        # code...
    
     
        // Jika nama jenis belum ada, lakukan penambahan data
        $query = "INSERT INTO pegawai VALUES ('', '$nama','$email','$username','$password','$no_telfon','$akses')";
        mysqli_query($conn, $query);
        // Atur session alert Bootstrap untuk sukses
        session_start();
        $_SESSION['berhasil_tambah'] = '<div class="alert alert-success" role="alert">Data berhasil ditambahkan.</div>';
        
        header("Location:../pengguna/pengguna.php");
        
        
    }

    
  
}
function hapus_pengguna($id_pegawai)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM pegawai WHERE kode_pegawai=$id_pegawai");
    return mysqli_affected_rows($conn);
}
function ubah_pengguna($data)
{
    global $conn;

    $id_pegawai =  $data["kode_pegawai"];
    $email =  htmlspecialchars($data["email"]);
    $nama =  htmlspecialchars($data["nama"]);
    $username =  htmlspecialchars($data["username"]);
    // $password = mysqli_real_escape_string($conn, $data["password"]);
    $no_telfon =  htmlspecialchars($data["no_telfon"]);
    $akses =  htmlspecialchars($data["akses"]);
    $query = "UPDATE pegawai SET nama='$nama',email='$email',username='$username',no_telfon='$no_telfon',akses='$akses' WHERE kode_pegawai=$id_pegawai";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

  

 
}


// Fungsi cetak_pembelian
function cetak_pembelian($kode_pembelian) {
    try {
        // Menggunakan PDO untuk koneksi ke database
        $pdo = new PDO('mysql:host=localhost;dbname=angsur_database', 'root', '');

        // Mengatur mode error PDO ke exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Membuat query SQL
        $query = "SELECT * FROM pembelian";

        // Menyiapkan statement PDO
        $statement = $pdo->prepare($query);

        // Mengikat parameter
        $statement->bindParam(':kode_pembelian', $kode_pembelian, PDO::PARAM_INT);

        // Mengeksekusi statement
        $statement->execute();

        // Mengambil hasil
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Menampilkan hasil cetak
        echo "Kode Pembelian: " . $result['kode_pembelian'] . "<br>";
        echo "Kode Barang: " . $result['kode_barang'] . "<br>";
        echo "Tanggal Pembelian: " . $result['tgl_pembelian'] . "<br>";
        echo "Nama Toko: " . $result['nama_toko'] . "<br>";
        echo "Alamat Toko: " . $result['alamat_toko'] . "<br>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}






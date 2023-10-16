<?php
$conn = mysqli_connect("localhost", "root", "", "kreditan");


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

function upload()
{
    $nameFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];



    // cek apakah data berhasil di tambahkan atau belum
    if ($error === 4) {
        echo "<script>
 alert ('silahkan pilih gambar terlebih dahulu!' );
</script>";

        return false;
    }

    // cek apakah  yang di upload itu gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensiGambar = explode('.', $nameFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
 alert ('silahkan pilih gambar terlebih dahulu!' );
</script>";
        return false;
    }
    // cek ukuran file yang di upload
    if ($ukuranFile > 1000000) {
        echo "<script>
 alert ('ukuran gambar terlalu besar' );
</script>";
        return false;
    }




    // lolos pengecekan ,gambar siapmdi upload
    // generate nama gambar baru

    $nameFileBaru = uniqid();
    $nameFileBaru .= '.';
    $nameFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpName, '../upload/' . $nameFileBaru);

    return $nameFileBaru;
}
function tambah_data($data)
{
    global $conn;
    
    $nama_barang = htmlspecialchars($data["nama_barang"]);
    $harga_jual = htmlspecialchars($data["harga_jual"]);
    $harga_jual_fix = preg_replace("/[^0-9]/", "", $harga_jual);
    $harga_beli = htmlspecialchars($data["harga_beli"]);
    $harga_beli_fix = preg_replace("/[^0-9]/", "", $harga_beli);
    $tanggal_exp = htmlspecialchars($data["tanggal_exp"]);
   
    $id_jenis = htmlspecialchars($data["id_jenis"]);
    $gambar = upload();
    if (!$gambar) {
        return false;
    }
    $query = "INSERT INTO barang (nama_barang,harga_jual,harga_beli,id_jenis,tanggal_exp,gambar)
    VALUES
    ('$nama_barang','$harga_jual_fix','$harga_beli_fix','$id_jenis',$tanggal_exp,'$gambar')";
        mysqli_query($conn, $query);
    
        return mysqli_affected_rows($conn);
    }


    
  

    function hapus_barang($id_barang)
    {
        global $conn;
    
        // Dapatkan nama file gambar yang terkait dengan data yang akan dihapus
        $query = "SELECT gambar FROM barang WHERE id_barang = $id_barang";
        $result = mysqli_query($conn, $query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $namaGambar = $row['gambar'];
    
            // Hapus file gambar dari sistem file
            $pathToGambar = '../upload/' . $namaGambar;
            if (file_exists($pathToGambar)) {
                unlink($pathToGambar);
            }
    
            // Hapus data dari tabel "barang" dalam database
            $query = "DELETE FROM barang WHERE id_barang = $id_barang";
            mysqli_query($conn, $query);
    
            if (mysqli_affected_rows($conn) > 0) {
                return true; // Data dan gambar berhasil dihapus
            } else {
                return false; // Gagal menghapus data dari database
            }
        } else {
            return false; // Data tidak ditemukan
        }
    }
    
function ubah_pengguna($data)
{
    global $conn;

    $id_pegawai =  $data["id_pegawai"];
    $email =  htmlspecialchars($data["email"]);
    $nama =  htmlspecialchars($data["nama"]);
    $username =  htmlspecialchars($data["username"]);
    // $password = mysqli_real_escape_string($conn, $data["password"]);
    $no_telfon =  htmlspecialchars($data["no_telfon"]);
    $akses =  htmlspecialchars($data["akses"]);
    $query = "UPDATE pegawai SET nama='$nama',email='$email',username='$username',no_telfon='$no_telfon',akses='$akses' WHERE id_pegawai=$id_pegawai";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

  

 
}

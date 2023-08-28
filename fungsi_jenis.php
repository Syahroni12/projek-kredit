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
function tambah_data($data)
{
    global $conn;
    $nama_jeniss =  $data["nama_jenis"];
    $query = "INSERT INTO jenis_barang  VALUES ('', '$nama_jeniss')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

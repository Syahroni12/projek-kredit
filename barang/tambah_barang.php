<?php 
  session_start();

  require '../barang/fungsi_barang.php';
 
  if (!isset($_SESSION['id_pegawai'])) {
    header("Location:../awal.php");
    exit;
 }
  if (isset($_POST["tambah"])) {

  
      // Panggil fungsi tambah_data
      
     
  if (tambah_data($_POST)>0) {
  
      $_SESSION['berhasil_tambah'] = '<div class="alert alert-success" role="alert">Data berhasil di tambah.</div>';
                  
      header("Location:../barang/data_barang.php");
  }else {
  var_dump(tambah_data($_POST));
  
  }
  
  }?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>barang</title>
<link rel="stylesheet" href="../dist/css/styles.css">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Kreditan</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->

        <!-- Navbar-->
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Activity Log</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="login.html">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="../index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">data </div>
                        <a class="nav-link" href="../jenis_barang.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            data jenis barang
                        </a>
                        <a class="nav-link" href="../pengguna/pengguna.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></i></div>
                            pengguna
                        </a>

                        <a class="nav-link" href="../suplier/data_suplier.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Data suplier
                        </a>
                        <a class="nav-link active" href="../barang/data_barang.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-shopping-bag"></i></div>
                            Data barang
                        </a>

                        <div class="sb-sidenav-menu-heading">Addons</div>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">syahroni pride</div>
                    Start Bootstrap
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">barang</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">barang</li>
                    </ol>
                    



                  
                    <a  class="btn btn-outline-danger mb-4" href="../barang/data_barang.php" >Kembali</a> 
                    
                    <form action=""method="post"enctype="multipart/form-data">
  <div class="form-group">

    <input type="text" class="form-control" id="nama_barang"name="nama_barang" placeholder="Masukkan nama_barang"required>
    </div>
  
  <div class="form-group">
  <input type="text" class="form-control"name="harga_jual" id="harga_jual" oninput="formatCurrency(this)"placeholder="masukkan harga_jual"required>
     </div> 
    
   
  <div class="form-group">

    <input type="text" class="form-control" id="harga_beli" name="harga_beli" oninput="formatCurrency(this)" placeholder="Masukkan harga beli"required >

    </div>


  

  <?php ?>
  <div class="form-group">

        <select class="form-control" id="id_jenis"name="id_jenis">
        <?php 

$jenis_brg=query("select * from jenis_barang");
foreach ($jenis_brg as $jnb ) {

?>
            <option value="<?= $jnb['id_jenis'] ?>"><?= $jnb['nama_jenis'] ?></option>
            <?php } ?>
 
        </select>

    </div>
    <div class="form-group">
    <label for="tanggal">Pilih Tanggal expired:</label>
    <input type="date" class="form-control" id="tanggal" name="tanggal_exp" required>
</div>


        <div class="form-group">
    <label for="gambar">Gambar</label>
    <input type="file" class="form-control-file" id="gambar" name="gambar" onchange="previewImage(this);">
    <img id="gambar-preview" src="#" alt="Gambar Pratinjau" style="max-width: 100%; display: none;">
      </div>
  <button type="submit"name="tambah" class="btn btn-primary">Submit</button>
</form>



                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2020</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
  

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../dist/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../dist/assets/demo/chart-area-demo.js"></script>
    <script src="../dist/assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="../dist/assets/demo/datatables-demo.js"></script>
    <script>
    function previewImage(input) {
        var preview = document.getElementById('gambar-preview');
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Tampilkan gambar terpilih
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none'; // Sembunyikan gambar jika tidak ada file yang dipilih
        }
    }
    
 

    
</script>

<script>
function formatCurrency(input) {
    // Hapus tanda titik atau koma jika ada
    let valueWithoutCommas = input.value.replace(/[,.]/g, '');

    // Format angka dengan tanda titik sebagai pemisah ribuan
    let formattedValue = new Intl.NumberFormat('id-ID').format(valueWithoutCommas);

    // Tampilkan nilai yang diformat pada input
    input.value = formattedValue;
}
</script>
</body>

</html>
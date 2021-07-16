<?php
session_start();
require_once '../../koneksi.php';
// =================RESTRIKSI==================================
if (!isset($_SESSION["logged"]) && !isset($_SESSION["user"])) {
    $_SESSION["error"] = "Login terlebih dahulu";
    header("Location: ../auth/login.php");
}
if (isset($_SESSION["logged"]) && !isset($_SESSION["user"])) {
    $_SESSION["error"] = "Anda bukan nasabah";
    header("Location: ../dashboard.php");
}
// =================RESTRIKSI==================================

$logged_id = $_SESSION["id"];
$result = mysqli_query($conn, "select p.* from pembiayaan as p where p.nasabah_id = '$logged_id'");
$result_rekening = mysqli_query($conn, "select r.*, n.nama from rekening as r inner join nasabah as n on r.nasabah_id = n.id where r.id not in (select p.rekening_id from pembiayaan as p) and r.nasabah_id = '$logged_id'") or die(mysqli_error($conn));
$data_pembiayaan = mysqli_fetch_all($result, MYSQLI_ASSOC);
$data_rekening = mysqli_fetch_all($result_rekening, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BMT Ash Shaddiq | Data Pengajuan</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="../../assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../assets/css/shared/style.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../assets/css/demo_1/style.css">
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="../../assets/images/favicon.ico" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
                <a class="navbar-brand brand-logo" href="../dashboard.php">
                    <img style="height: 37px !important; width: auto;" src="../../assets/images/auth/LOGO BMT MINI.png" alt="logo" />
                </a>
                <a class="navbar-brand brand-logo-mini" href="../dashboard.php>
                    <img style=" height: 37px !important; width: auto;" src="../../assets/images/auth/LOGO BMT MINI.png" alt="logo" />
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
                        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                            <img class="img-xs rounded-circle" src="../../assets/images/faces/face8.jpg" alt="Profile image"> </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                            <div class="dropdown-header text-center">
                                <img class="img-md rounded-circle" src="../../assets/images/faces/face8.jpg" alt="Profile image">
                                <p class="mb-1 mt-3 font-weight-semibold"><?php echo $_SESSION["nama"]; ?></p>
                                <p class="font-weight-light text-muted mb-0"><?php echo $_SESSION["username"]; ?></p>
                            </div>
                            <a href="../auth/logout.php" class="dropdown-item text-danger">Sign Out</a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-category">Main Menu</li>
                    <li class="nav-item">
                        <a class="nav-link" href="../dashboard.php">
                            <i class="menu-icon typcn typcn-document-text"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./rekeninghome.php">
                            <i class="menu-icon typcn typcn-th-large-outline"></i>
                            <span class="menu-title">Rekening</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <i class="menu-icon typcn typcn-coffee"></i>
                            <span class="menu-title">Mudharabah</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="./pengajuanhome.php">Pengajuan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./pembiayaanhome.php">Pembiayaan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./transaksihome.php">Transaksi</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Page Title Header Starts-->
                    <div class="row page-title-header">
                        <div class="col-12">
                            <?php include "../inc/messageslogged.php" ?>
                            <div class="page-header">
                                <h3 class="page-title">Data Pengajuan</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Page Title Header Ends-->
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#tambah_pengajuan">Tambah Pengajuan</button>
                                    <!-- ==================================MODAL TAMBAH================================ -->
                                    <div class="modal fade" id="tambah_pengajuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Pengajuan Pembiayaan</h5>
                                                    <button type="button" class="btn btn-icons p-0" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close mdi-24px"></i></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="forms-sample" action="./pengajuancreate.php" method="POST">
                                                        <div class="form-group">
                                                            <label>No Rekening</label>
                                                            <select name="rekening_id" class="form-control" required>
                                                                <?php foreach ($data_rekening as $rekening) { ?>
                                                                    <option value="<?php echo $rekening["id"] ?>-<?php echo $rekening["nasabah_id"] ?>"><?php echo $rekening["id"] ?> - <?php echo $rekening["nama"] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Jangka Waktu</label>
                                                            <div class="input-group">
                                                                <input name="jangka_waktu" type="number" min=1 class="form-control" placeholder="Masukkan Jangka Waktu Pembiayaan" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">Bulan</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" name="tambah_pengajuan" class="btn btn-success mr-2">Ajukan</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ==================================MODAL TAMBAH================================ -->

                                    <?php if (count($data_pembiayaan) < 1) { ?>
                                        <div class="p-3">
                                            <p class="text-center">Tidak Ada Data</p>
                                        </div>
                                    <?php } else { ?>
                                        <table class="table table-hover table-responsive-lg mt-4">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Tanggal Pengajuan</th>
                                                    <th>Jangka Waktu</th>
                                                    <th>Persetujuan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data_pembiayaan as $pembiayaan) { ?>
                                                    <tr>
                                                        <td> <?php echo "PMB-" . $pembiayaan["id"] ?> </td>
                                                        <td> <?php echo $pembiayaan["tanggal_pengajuan"] ?></td>
                                                        <td> <?php echo $pembiayaan["jangka_waktu"] ?> bln</td>
                                                        <?php if ($pembiayaan["manager_approved"] == 0 && $pembiayaan["admin_approved"] == 0) echo '<td>Belum Disetujui</td>';
                                                        elseif ($pembiayaan["manager_approved"] == 1 && $pembiayaan["admin_approved"] == 0) echo '<td class="text-info">On Proccess</td>';
                                                        elseif ($pembiayaan["manager_approved"] == 2 && $pembiayaan["admin_approved"] == 0) echo '<td class="text-info">On Proccess</td>';
                                                        elseif ($pembiayaan["admin_approved"] == 2) echo '<td class="text-danger">Ditolak</td>';
                                                        else echo '<td class="text-success">Disetujui</td>'   ?>
                                                        <td>
                                                            <?php if ($pembiayaan["manager_approved"] == 1 && $pembiayaan["admin_approved"] == 1) { ?>
                                                                <a href=<?php echo "./pengajuanshow.php?id={$pembiayaan['id']}" ?>><button class="btn btn-primary">Detail</button></a>
                                                            <?php } elseif ($pembiayaan["admin_approved"] == 2) { ?>
                                                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#tambah_pengajuan_ulang">Ajukan ulang</button>
                                                                <!-- ==================================MODAL ULANG================================ -->
                                                                <div class="modal fade" id="tambah_pengajuan_ulang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Pengajuan Pembiayaan</h5>
                                                                                <button type="button" class="btn btn-icons p-0" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close mdi-24px"></i></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form class="forms-sample" action=<?php echo "./pengajuanupdate.php?id=" . $pembiayaan["id"] ?> method="POST">
                                                                                    <div class="form-group">
                                                                                        <label>Jangka Waktu</label>
                                                                                        <div class="input-group">
                                                                                            <input name="jangka_waktu" type="number" min=1 class="form-control" placeholder="Masukkan Jangka Waktu Pembiayaan" required>
                                                                                            <div class="input-group-append">
                                                                                                <span class="input-group-text">Bulan</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <button type="submit" name="tambah_pengajuan_ulang" class="btn btn-success mr-2">Ajukan</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- ==================================MODAL ULANG================================ -->
                                                            <?php } else { ?>
                                                                <a href=<?php echo "./pengajuanshow.php?id={$pembiayaan['id']}" ?>><button class="btn btn-primary">Detail</i></button></a>
                                                            <?php } ?>
                                                            <!-- <a href=<?php echo "./pengajuandelete.php?id={$pembiayaan['id']}" ?>><button class="btn btn-icons btn-danger" data-toggle="tooltip" title="Hapus Pengajuan" onclick="return confirm('Apakah Anda Yakin?')"><i class="mdi mdi-delete"></i></button></a> -->
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="container-fluid clearfix">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2021</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <!-- BOOTSTRAP 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="../../assets/js/shared/off-canvas.js"></script>
    <script src="../../assets/js/shared/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../../assets/js/demo_1/dashboard.js"></script>
    <!-- End custom js for this page-->
    <script src="../../assets/js/shared/jquery.cookie.js" type="text/javascript"></script>
</body>

</html>
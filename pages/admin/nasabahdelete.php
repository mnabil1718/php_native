<?php
session_start();
require_once "../../koneksi.php";

if (isset($_GET["id"])) {
    $id_old = $_GET["id"];
    $delete_result = mysqli_query($conn, "delete from nasabah where id = '$id_old'") or die(mysqli_error($conn));
    if ($delete_result) {
        $_SESSION["success"] = "Data berhasil dihapus";
        header("Location: ./nasabahhome.php");
    }
} else {
    $_SESSION["error"] = "ID tidak ditemukan";
    header("Location: ./nasabahhome.php");
}

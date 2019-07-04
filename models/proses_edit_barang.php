<?php
// require class OOP
require_once('../config/+koneksi.php');
require_once('../models/database.php');
include "../models/m_barang.php";

// modul koneksi database
$connection = new Database($host, $user, $pass, $database);

// inisiasi model database
$brg = new Barang($connection);

// inisiasi data hasil post ke database
$id_brg = $_POST['id_brg'];
$nama_brg = $connection->conn->real_escape_string($_POST['nama_brg']);
$harga_brg = $connection->conn->real_escape_string($_POST['harga_brg']);
$stok_brg = $connection->conn->real_escape_string($_POST['stok_brg']);

// inisiasi file gambar
$pict 		= $_FILES['gbr_brg']['name'];

if ($pict == null) {
	// kondisi jika gambar kosong

	// script dan query update tabel barang
	$query =  "UPDATE tb_barang SET nama_brg ='$nama_brg', harga_brg='$harga_brg', stok_brg='$stok_brg' WHERE id_brg = '$id_brg'";
	$brg->edit($query);

	echo "Upload Sukses! <br>";
	echo $query;

} else {
	// kondisi jika gambar diisi

	// proses mengambil filename, extension gambar
	$extensi 	= explode(".", $_FILES['gbr_brg']['name']);
	$gbr_brg = "brg-".round(microtime(true)).".".end($extensi);
	$sumber 	= $_FILES['gbr_brg']['tmp_name'];

    // gambar awal untuk replace
	

	// proses upload gambar
	$upload = move_uploaded_file($sumber, "../assets/img/barang/".$gbr_brg);

		if ($upload) {
			// kondisi jika upload sukses
			// $gbr_awal = $brg->tampil($id_brg)->fetch_object()->gbr_brg;
			// unlink("../assets/img/barang/".$gbr_awal);
			// script dan query update tabel barang
$query = "UPDATE tb_barang SET nama_brg ='$nama_brg', harga_brg='$harga_brg', stok_brg='$stok_brg', gbr_brg='$gbr_brg' WHERE id_brg= '$id_brg'";
			 $brg->edit($query);

			echo "<script language='javascript'>window.location.href='?page=barang'</script>";
			// echo $query;

		} else {
			// kondisi jika upload gagal

			echo "upload Gagal! <br>";
		}

	}


		 ?>

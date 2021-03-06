<?php
// function untuk melakukan koneksi ke database
function koneksi()
{
	$conn = mysqli_connect("localhost", "root", "") or die("koneksi ke DB gagal");
	mysqli_select_db($conn, "pw_1830400") or die("Database salah!");

	return $conn;
}

// function untuk melakukan query ke database
function query($sql)
{
	$conn = koneksi();
	$result = mysqli_query($conn, "$sql");

	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}

	return $rows;
}

function tambah($data)
{
	$conn = koneksi();

	$nama = htmlspecialchars($data['nama']);
	$gambar = htmlspecialchars($data['gambar']);

	$query = "INSERT INTO mahasiswa2 VALUES
			('', '$nama','$gambar')";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function hapus($id)
{
	$conn = koneksi();
	mysqli_query($conn, "DELETE FROM mahasiswa2 WHERE id = $id");
	return mysqli_affected_rows($conn);
}

function ubah($data)
{
	$conn = koneksi();
	$id = htmlspecialchars($data['id']);
	$nama = htmlspecialchars($data['nama']);
	$gambar = htmlspecialchars($data['gambar']);
	$query = "UPDATE mahasiswa2
			SET 
			nama = '$nama',
			gambar = '$gambar'
			WHERE id = '$id'
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function registrasi($data)
{
	$conn = koneksi();
	$username = htmlspecialchars($data['username']);
	$password = htmlspecialchars($data['password']);

	$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
	if (mysqli_fetch_assoc($result)) {
		echo "<script>
            alert('Username sudah digunakan');
		</script>";
		return false;
	}

	$password = password_hash($password, PASSWORD_DEFAULT);

	$query = "INSERT INTO user VALUES
			('', '$username','$password')";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

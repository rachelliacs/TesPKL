<?php 

$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "db_sekolah";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die ("Gagal menghubungkan ke database");
}

$ID             = "";
$Nama           = "";
$Jenis_kelamin  = "";
$Alamat         = "";
$sukses         = "";
$error          = "";

if (isset($_GET['Aksi'])) {
    $Aksi = $_GET['Aksi'];
} else {
    $Aksi = "";
}

if ($Aksi == 'Delete') {
    $ID             = $_GET['ID'];
    $sql            = "DELETE FROM tb_siswa WHERE ID = '$ID'";
    $query          = mysqli_query($koneksi, $sql);

    if ($query) {
        $sukses = "Berhasil menghapus data";
    } else {
        $error  = "Gagal menghapus data";
    }
}

if ($Aksi == 'Edit') {
    $ID             = $_GET['ID'];
    $sql            = "SELECT * FROM tb_siswa WHERE ID = '$ID'";
    $query          = mysqli_query($koneksi, $sql);
    $read           = mysqli_fetch_array($query);
    $Nama           = $read['Nama'];
    $Jenis_kelamin  = $read['Jenis_kelamin'];
    $Alamat         = $read['Alamat'];

    if ($ID == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['submit'])) {
    $Nama           = $_POST['Nama'];
    $Jenis_kelamin  = $_POST['Jenis_kelamin'];
    $Alamat         = $_POST['Alamat'];

    if ($Nama && $Jenis_kelamin && $Alamat) {
        if ($Aksi == 'Edit') {
            $sql    = "UPDATE tb_siswa set Nama='$Nama', Jenis_kelamin='$Jenis_kelamin', Alamat='$Alamat' WHERE ID='$ID'";
            $query  = mysqli_query($koneksi, $sql);
            if ($query) {
                $sukses = "Berhasil mengubah data";
            } else {
                $error  = "Gagal mengubah data";
            }
        } else {
            $sql    = "INSERT INTO tb_siswa (Nama, Jenis_kelamin, Alamat) VALUES ('$Nama', '$Jenis_kelamin', '$Alamat')";
            $query  = mysqli_query($koneksi, $sql);
            if ($query) {
                $sukses = "Berhasil menambahkan data";
            } else {
                $error  = "Gagal menambahkan data";
            }
        }  
    } else {
        $error = "Anda belum memasukkan data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        .mx-auto { width: 80% }
        .card { margin-top: 20px }
    </style>
</head>
<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Create & Edit Data
            </div>
            <div class="card-body">
                <?php 
                if ($error) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                        </div>
                    <?php
                }
                ?>
                <?php 
                if ($sukses) {
                    ?>
                        <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                        </div>
                    <?php
                }
                ?>
                <form action="" method="post">
                    <div class="mb-3 row">
                        <label for="Nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Nama" name="Nama" value="<?php echo $Nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Jenis_kelamin" class="col-sm-2 col-form-label">Jenis kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="Jenis_kelamin" id="Jenis_kelamin">
                                <option value="">- Pilih -</option>
                                <option value="0" <?php if($Jenis_kelamin == "0") echo "selected" ?> >Laki-laki</option>
                                <option value="1" <?php if($Jenis_kelamin == "1") echo "selected" ?> >Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="Alamat" name="Alamat" value="<?php echo $Alamat ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="submit" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header text-white bg-primary">
                Data Siswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql2   = "SELECT * FROM tb_siswa order by ID asc";
                        $query2 = mysqli_query($koneksi, $sql2);
                        while ($read = mysqli_fetch_array($query2)) {
                            $ID             = $read['ID'];
                            $Nama           = $read['Nama'];
                            $Jenis_kelamin  = $read['Jenis_kelamin'];
                            $Alamat         = $read['Alamat'];
                            ?>
                            <tr>
                                <th scope="row"><?php echo $ID ?></th>
                                <td scope="row"><?php echo $Nama ?></td>
                                <td scope="row"><?php if ($Jenis_kelamin == 0) {
                                    echo "Laki-laki";
                                } elseif ($Jenis_kelamin == 1) {
                                    echo "Perempuan";
                                }?></td>
                                <td scope="row"><?php echo $Alamat ?></td>
                                <td scope="row">
                                    <a href="index.php?Aksi=Edit&ID=<?php echo $ID?>">
                                        <button type="button" class="btn btn-warning">Edit</button>
                                    </a>
                                    <a href="index.php?Aksi=Delete&ID=<?php echo $ID?>" onclick="return confirm('Yakin hapus data ini?')">
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <style>
        .about-card {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .about-card h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        .about-card p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            text-align: justify;
        }
    </style>
</head>

<body class="bg-content">
    <main class="dashboard d-flex">
        <!-- start sidebar -->
        <?php
        include "component/sidebar.php";
        include 'conixion.php';

        // Query untuk mendapatkan semua tabel kecuali tabel 'login'
        $query = "SHOW TABLES";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Hitung jumlah tabel kecuali tabel 'login'
        $event_count = 0;
        $total_participants = 0;
        $total_faults = 0;
        foreach ($tables as $table) {
            if ($table !== 'login') {
                $event_count++;
                // Hitung jumlah peserta di tabel ini
                $count_query = "SELECT COUNT(*) FROM $table";
                $count_stmt = $conn->prepare($count_query);
                $count_stmt->execute();
                $total_participants += $count_stmt->fetchColumn();

                // Cek apakah kolom fault ada di tabel ini
                $column_query = "SHOW COLUMNS FROM $table LIKE 'fault'";
                $column_stmt = $conn->prepare($column_query);
                $column_stmt->execute();
                $fault_column_exists = $column_stmt->rowCount();

                // Jika kolom fault ada, hitung jumlah fault di tabel ini
                if ($fault_column_exists) {
                    $fault_query = "SELECT COUNT(*) FROM $table WHERE fault IS NOT NULL";
                    $fault_stmt = $conn->prepare($fault_query);
                    $fault_stmt->execute();
                    $total_faults += $fault_stmt->fetchColumn();
                }
            }
        }
        ?>
        <!-- end sidebar -->

        <!-- start content page -->
        <div class="container-fluid px">
            <div class="cards row gap-3 justify-content-center mt-5">
                <div class="card__items card__items--blue col-md-3 position-relative">
                    <div class="card__students d-flex flex-column gap-2 mt-3">
                        <i class="far fa-calendar h3"></i>
                        <span>Total Events</span>
                    </div>
                    <div class="card__nbr-students">
                        <span class="h5 fw-bold nbr"><?php echo $event_count; ?></span>
                    </div>
                </div>

                <div class="card__items card__items--rose col-md-3 position-relative">
                    <div class="card__Course d-flex flex-column gap-2 mt-3">
                        <i class="fal fa-users h3"></i>
                        <span>Total Peserta</span>
                    </div>
                    <div class="card__nbr-course">
                        <span class="h5 fw-bold nbr"><?php echo $total_participants; ?></span>
                    </div>
                </div>
            </div>

            <!-- About Us Card -->
            <div class="row justify-content-center mt-5">
                <div class="col-md-10 col-lg-100">
                    <div class="about-card">
                        <div class="card__about d-flex flex-column gap-2 mt-3">
                        </div>
                        <div class="card__about-content">
                            <h2>Tentang Kami</h2>
                            <p>
                                PERKUMPULAN KINOLOGI INDONESIA (PERKIN) adalah organisasi yang menjadi induk organisasi
                                penggemar anjing ras (anjing trah) di Indonesia. Organisasi ini adalah satu-satunya
                                lembaga
                                pendaftaran yang berwenang mengeluarkan surat silsilah (stamboom) anjing trah di
                                Indonesia, dan menetapkan
                                standar anjing trah Indonesia (Anjing Kintamani).
                                PERKIN adalah tempat pendaftaran ganti nama pemilik, kelahiran anak anjing, nama
                                panggilan,
                                nama kandang, pembuatan duplikat silsilah, dan registrasi ulang anjing impor. Selain
                                itu, PERKIN
                                dengan dukungan klub-klub anjing trah adalah satu-satunya penyelenggara resmi kontes
                                anjing trah di
                                Indonesia.
                                Sejak masih bernama Nederlansch Indische Kinologi Vereeninging, PERKIN sudah terdaftar
                                sebagai
                                anggota Federasi Kinologi Internasional (FCI). Di tingkat Asia, PERKIN adalah salah satu
                                dari 11
                                negara anggota Asia Kennel Union yang berkantor pusat di Japan Kennel Club, Tokyo.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end content page -->
    </main>
    <script src="../js/script.js"></script>
    <script src="/js/bootstrap.bundle.js"></script>
</body>

</html>
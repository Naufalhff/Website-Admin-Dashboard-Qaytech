<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERKIN</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-content">
    <main class="dashboard d-flex">
        <!-- start sidebar -->
        <?php
        include "component/sidebar.php";
        ?>
        <!-- end sidebar -->

        <!-- start content page -->
        <div class="container-fluid px-4">
            <?php
            include "component/searchtabel.php";
            ?>
            <div id="searchResults" class="mt-4">
                <!-- Hasil pencarian akan muncul di sini -->
            </div>
            <!-- start student list table -->
            <div class="student-list-header d-flex justify-content-between align-items-center py-2">
                <div class="title h6 fw-bold">Data</div>
                <div class="btn-add d-flex gap-3 align-items-center">
                    <div class="short">
                        <i class="far fa-sort"></i>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <div class="container mt-4">
                    <div class="row">
                        <?php
                        include 'conixion.php';

                        try {
                            // Ambil daftar tabel dari database
                            $tables_result = $conn->query("SHOW TABLES");
                            while ($row = $tables_result->fetch(PDO::FETCH_NUM)) {
                                $table_name = $row[0];
                                // Sembunyikan tabel dengan nama 'login'
                                if ($table_name !== 'login') {
                                    ?>
                                    <div class="col-md-4 mb-3">
                                        <div class="card shadow-sm border-0">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h1 class="card-title h4"><?php echo htmlspecialchars($table_name); ?></h1>
                                                </div>
                                                <p class="card-text text-muted fs-6">
                                                    Temukan informasi mendetail dan eksplorasi data di tabel
                                                    <?php echo htmlspecialchars($table_name); ?>.
                                                </p>

                                                <div class="d-flex justify-content-end">
                                                    <a href="detailtabel.php?table_name=<?php echo urlencode($table_name); ?>"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-arrow-right"></i> Lihat Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                }
                            }
                        } catch (PDOException $e) {
                            echo "<div class='col-12'><div class='alert alert-danger'>Tidak bisa mendapatkan daftar tabel: " . $e->getMessage() . "</div></div>";
                        }
                        ?>
                    </div>
                </div>
    </main>
    <script src="../js/script.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
</body>

</html>
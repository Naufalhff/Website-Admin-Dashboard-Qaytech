<!DOCTYPE html>
<html>
<head>

<title>DATA TIMER</title>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    #c4ytable {
        width: 80%;
        margin: auto;
        border-collapse: collapse;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    #c4ytable th, #c4ytable td {
        padding: 12px 15px;
        border: 1px solid #ddd;
        text-align: center;
    }

    #c4ytable th {
        background-color: #007BFF;
        color: white;
        font-size: 16px;
    }

    #c4ytable tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #c4ytable tr:hover {
        background-color: #ddd;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    function fetchData() {
        $.ajax({
            url: 'fetch_data.php',
            type: 'GET',
            success: function(data) {
                $('#c4ytable tbody').html(data);
            }
        });
    }

    setInterval(fetchData, 2000); // Check for new data every 2 seconds
});
</script>
</head>
<body>
    <div id="cards" class="cards">
        <table id="c4ytable">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>TANGGAL</th>
                    <th>HARI</th>
                    <th>WAKTU</th>
                    <th>NAMA</th>
                    <th>DATA</th>
                    <th>KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            require_once('koneksi.php');
            $query1="select * from tbQay ";		
            $result=mysqli_query($conn,$query1);
            
            $no  = 1;
            while($data=mysqli_fetch_array($result))
            {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['tanggal'] ?></td>
                    <td><?php echo $data['hari'] ?></td>
                    <td><?php echo $data['waktu'] ?></td>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['data'] ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
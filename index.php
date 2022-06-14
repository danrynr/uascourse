<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIX Course | Dashboard</title>
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        $timeout = 300; //SESSION TIMEOUT 5 MENIT
        ini_set("session.gc_maxlifetime", $timeout);

        $session_name = session_name();
        session_start();

        if(!isset($_COOKIE[$session_name])) {
            setcookie($session_name, "", -70000, '/');
            session_unset();
            session_destroy();
            header("location:login.php");
            exit;
        }

        if(isset($_COOKIE[$session_name])) {
            setcookie($session_name, $_COOKIE[$session_name], time() + $timeout, '/');
        }

        //Harga per item
        $ps = 120000;   
        $vc = 110000;
        $net = 100000;
        $hp = 80000;

        $username = $_SESSION['username'];

        $json_cart = json_decode(file_get_contents('usercart.txt'), true);
        $json_cart_prev = json_decode(file_get_contents('usercart.txt'), true);
        
        $percent_diskon1 = "0%";
        $percent_diskon2 = "0%";
        $diskon1 = 0;
        $diskon2 = 0;

        if(isset($_POST['save'])) {
            $queryUser = "INSERT INTO UserCart (username) VALUES ('$username')";
            $data1 = mysqli_query($conn, $queryUser);
            
            //Jumlah item yang dibeli
            $jumps = $_POST['ps-q'];
            $jumvc = $_POST['vc-q'];
            $jumnet = $_POST['net-q'];
            $jumhp = $_POST['hp-q'];

            if($jumps <= 0) {
                $jumps = 0;
            }
            if($jumvc <= 0) {
                $jumvc = 0;
            }
            if($jumnet <= 0) {
                $jumnet = 0;
            }
            if($jumhp <= 0) {
                $jumhp = 0;
            }

            //Kalkulasi jumlah item yang dibeli + diskon
            $ps1 = $ps * $jumps;
            $vc1 = $vc * $jumvc;
            $net1 = $net * $jumnet;
            $hp1 = $hp * $jumhp;

            $kursus = $ps1 + $vc1 + $net1 + $hp1;
            $pilkursus = ($jumps ? 1 : 0) + ($jumvc ? 1 : 0) + ($jumnet ? 1 : 0) + ($jumhp ? 1 : 0);
            $gender = $_SESSION['gender'];

            if($kursus > 2000000) {
                $diskon1 = ($kursus * 10) / 100;
                $percent_diskon1 = "10%";
            } else if($pilkursus == 4) {
                $diskon1 = ($kursus * 5) / 100;
                $percent_diskon1 = "5%";
            } else if($pilkursus == 3) {
                $diskon1 = ($kursus * 2) / 100;
                $percent_diskon1 = "2%";
            }

            if($kursus > 0) {
                if($gender == "L") {
                    $diskon2 = ($kursus * 5) / 100;
                    $percent_diskon2 = "5%";
                } else {
                    $diskon2 = ($kursus * 3) / 100;
                    $percent_diskon2 = "3%";
                }
            }

            $subtotal = $kursus - ($diskon1 + $diskon2);

            //SIMPAN DATA
            $array_cart = Array (
                $username => Array (
                    "jumps" => "$jumps",
                    "hargaps" => "$ps1",
                    "jumvc" => "$jumvc",
                    "hargavc" => "$vc1",
                    "jumnet" => "$jumnet",
                    "harganet" => "$net1",
                    "jumhp" => "$jumhp",
                    "hargahp" => "$hp1",
                    "total" => "$kursus",
                    "diskon1" => "$diskon1",
                    "diskon1_percent" => "$percent_diskon1",
                    "diskon2" => "$diskon2",
                    "diskon2_percent" => "$percent_diskon2",
                    "subtotal" => "$subtotal"
                )
            );

            if ($json_cart == NULL) {
                $json_cart = json_encode($array_cart);
                file_put_contents('usercart.txt', $json_cart);
            } else {
                if ($json_cart[$username] != NULL) {
                    $json_cart[$username] = Array();
                    $json_cart = array_merge($json_cart_prev, $array_cart);
                    $json_cart = json_encode($json_cart);
                    file_put_contents('usercart.txt', $json_cart);
                } else {
                    $json_cart = array_merge($json_cart_prev, $array_cart);
                    $json_cart = json_encode($json_cart);
                    file_put_contents('usercart.txt', $json_cart);
                }
            }

            $msg = "<script>Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Berhasil menambahkan ke keranjang!',
                showConfirmButton: false,
                timer: 1500
              });</script>";
        }

        //AMBIL DATA
        $json_output = json_decode(file_get_contents('usercart.txt'), true);

        $data_jumps = $json_output[$username]['jumps'];
        $data_jumvc = $json_output[$username]['jumvc'];
        $data_jumnet = $json_output[$username]['jumnet'];
        $data_jumhp = $json_output[$username]['jumhp'];
        $data_hargaps = $json_output[$username]['hargaps'];
        $data_hargavc = $json_output[$username]['hargavc'];
        $data_harganet = $json_output[$username]['harganet'];
        $data_hargahp = $json_output[$username]['hargahp'];
        $data_total = $json_output[$username]['total'];
        $data_diskon1 = $json_output[$username]['diskon1'];
        $percent_diskon1_text = $json_output[$username]['diskon1_percent'];
        $data_diskon2 = $json_output[$username]['diskon2'];
        $percent_diskon2_text = $json_output[$username]['diskon2_percent'];
        $data_subtotal = $json_output[$username]['subtotal'];

        //NUMBER FORMATTING
        $ps_text = number_format($data_hargaps, 2, ',', '.');
        $vc_text = number_format($data_hargavc, 2, ',', '.');
        $net_text = number_format($data_harganet, 2, ',', '.');
        $hp_text = number_format($data_hargahp, 2, ',', '.');
        $total_text = number_format($data_total, 2, ',', '.');
        $diskon1_text = number_format($data_diskon1, 2, ',', '.');
        $diskon2_text = number_format($data_diskon2, 2, ',', '.');
        $subtotal_text = number_format($data_subtotal, 2, ',', '.');
        $ps_init = number_format($ps, 2, '.', ',');
        $vc_init = number_format($vc, 2, '.', ',');
        $net_init = number_format($net, 2, '.', ',');
        $hp_init = number_format($hp, 2, '.', ',');
        
        //PAY AND CLEAR ORDER
        if (isset($_POST['order']) && $data_subtotal != 0) {
            $json_data_cart = json_decode(file_get_contents('usercart.txt'), true);
            $json_data_cart[$username] = Array();
            $json_data_cart = json_encode($json_data_cart);
            file_put_contents('usercart.txt', $json_data_cart);

            $data_jumps = 0;
            $data_jumvc = 0;
            $data_jumnet = 0;
            $data_jumhp = 0;
            $percent_diskon1_text = "0%";
            $percent_diskon2_text = "0%";
            $ps_text = number_format(0, 2, ',', '.');
            $vc_text = number_format(0, 2, ',', '.');
            $net_text = number_format(0, 2, ',', '.');
            $hp_text = number_format(0, 2, ',', '.');
            $total_text = number_format(0, 2, ',', '.');
            $diskon1_text = number_format(0, 2, ',', '.');            
            $diskon2_text = number_format(0, 2, ',', '.');
            $subtotal_text = number_format(0, 2, ',', '.');

            $msg = "<script>Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Checkout Berhasil!',
                showConfirmButton: false,
                timer: 1500
              });</script>";
        }
    ?>

    <header class="shadow">
        <div class="container1">
            <h1>NIX Course</h1>
        </div>
        <div class="container2">
            <nav>
                <ul>
                    <li><?php echo "Hello, <b>$username</b>"; ?></li>
                    <li><a href="logout.php">Logout <ion-icon name="log-out-outline"></ion-icon></a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="shop">
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            <?php echo $msg;?>
            <div class="card shadow">
                <h2>Pilih Kursus</h2>
                <div class="course">
                    <p>PHP + MySQL (1x pertemuan <?php echo "Rp $ps_init";?>)</p><input type=number name="ps-q">
                    <p>Virtualisasi + Cloud (1x pertemuan <?php echo "Rp $vc_init";?>)</p><input type=number name="vc-q">
                    <p>Networking (1x pertemuan <?php echo "Rp $net_init";?>)</p><input type=number name="net-q">
                    <p>Hardware + Peripheral (1x pertemuan <?php echo "Rp $hp_init";?>)</p><input type=number name="hp-q">
                    <button class="cart" name="save">Simpan Keranjang</button>
                </div>
            </div>
        </form>

        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            <?php echo $msg;?>
            <div class="listcart card shadow" id="right">
                <h2>Keranjang Pembelian</h2>
                <div class="container-b">
                    <section class="course-section">
                    <a class="course-name">PHP + MySQL</a>&nbsp;<span class="pertemuan"><?php echo " ($data_jumps) Pertemuan";?></span>&nbsp;&nbsp;<span class="nominal"><?php echo " Rp $ps_text";?></span>
                    </section>
                    <section class="course-section">
                    <a class="course-name">Virtualisasi + Cloud</a>&nbsp;<span class="pertemuan"><?php echo " ($data_jumvc) Pertemuan";?></span>&nbsp;&nbsp;<span class="nominal"><?php echo " Rp $vc_text";?></span>
                    </section>
                    <section class="course-section">
                    <a class="course-name">Networking</a>&nbsp;<span class="pertemuan"><?php echo " ($data_jumnet) Pertemuan";?></span>&nbsp;&nbsp;<span class="nominal"><?php echo " Rp $net_text";?></span>
                    </section>
                    <section class="course-section">
                    <a class="course-name">Hardware + Peripheral</a>&nbsp;<span class="pertemuan"><?php echo " ($data_jumhp) Pertemuan";?></span>&nbsp;&nbsp;<span class="nominal"><?php echo "Rp $hp_text";?></span>
                    </section>
                    <section class="total-section">
                    <a class="total-info">Total</a>&nbsp;&nbsp;<span class="nominal"><?php echo "Rp $total_text";?></span>
                    </section>
                    <section class="discount-section">
                    <a class="discount-info discount-one">Diskon Pembelian <?php echo $percent_diskon1_text;?></a>&nbsp;&nbsp;<span class="nominal"><?php echo "- Rp $diskon1_text";?></span>
                    </section>
                    <section class="discount-section">
                    <a class="discount-info discount-two">Diskon Tambahan <?php echo $percent_diskon2_text;?></a>&nbsp;&nbsp;<span class="nominal"><?php echo "- Rp $diskon2_text";?></span>
                    </section>
                    <section class="subtotal-section">
                    <a class="subtotal-info">Total Pembayaran</a>&nbsp;&nbsp;<span class="nominal"><?php echo "Rp $subtotal_text";?></span>
                    </section>
                </div>

                <button class="order" name="order">Checkout</button>
            </div>
        </form>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
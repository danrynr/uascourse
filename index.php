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

        include 'market.php';
    ?>

    <header class="shadow">
        <div class="container1">
            <h1>NIX Course</h1>
        </div>
        <div class="menu">
            <nav>
                <ul>
                    <li><a href="#">Beli</a></li>
                    <li><a href="history.php">History</a></li>
                </ul>
            </nav>
        </div>
        <div class="container2">
            <nav>
                <ul>
                    <li><?php echo "Hello, <b>$username</b>"; ?></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="shop">
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
            <?php echo $msg;?>
            <div class="card shadow" id="left">
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
                    <a class="total-info">Total</a>&nbsp;&nbsp;<span class="nominal"><?php echo "Rp $subtotal_text";?></span>
                    </section>
                    <section class="discount-section">
                    <a class="discount-info discount-one">Diskon Pembelian <?php echo $percent_diskon1_text;?></a>&nbsp;&nbsp;<span class="nominal"><?php echo "- Rp $diskon1_text";?></span>
                    </section>
                    <section class="discount-section">
                    <a class="discount-info discount-two">Diskon Tambahan <?php echo $percent_diskon2_text;?></a>&nbsp;&nbsp;<span class="nominal"><?php echo "- Rp $diskon2_text";?></span>
                    </section>
                    <section class="subtotal-section">
                    <a class="subtotal-info">Total Pembayaran</a>&nbsp;&nbsp;<span class="nominal"><?php echo "Rp $total_text";?></span>
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
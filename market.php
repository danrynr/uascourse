<?php
    //Harga per item

    $username = $_SESSION['username'];
    
    $percent_diskon1 = "0%";
    $percent_diskon2 = "0%";
    $diskon1 = 0;
    $diskon2 = 0;

    if(isset($_POST['save'])) {
        include 'config.php';
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

        $msg = "<script>Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Berhasil menambahkan ke keranjang!',
            showConfirmButton: false,
            timer: 1500
            });</script>";
    }

    //AMBIL DATA


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
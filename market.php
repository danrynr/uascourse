<?php
    $username = $_SESSION['username'];
    
    $percent_diskon1 = "0%";
    $percent_diskon2 = "0%";
    $diskon1 = 0;
    $diskon2 = 0;

    if(isset($_POST['save'])) {
        // 
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

        // STORE ITEM QUANTITY TO CART
        include 'config.php';
        $queryUserCart = "SELECT username FROM usercart WHERE username = '$username'";
        $dataUserCart = mysqli_query($conn, $queryUserCart);
        $dataUserCart = mysqli_fetch_assoc($dataUserCart);
        if ($dataUserCart['username'] == $username) {
            $queryUpdate = "UPDATE UserCart SET quantity_ps = '$jumps', quantity_vc = '$jumvc', quantity_net = '$jumnet', quantity_hp = '$jumhp' WHERE username = '$username'";
            mysqli_query($conn, $queryUpdate) or die ('Error, query failed1. ' . mysqli_error($conn));
        } else {
            $queryUserCart = "INSERT INTO UserCart (username, quantity_ps, quantity_vc, quantity_net, quantity_hp) VALUES ('$username', '$jumps', '$jumvc',  '$jumnet', '$jumhp')";
            mysqli_query($conn, $queryUserCart) or die ('Error, query failed2. ' . mysqli_error($conn));
        }
        mysqli_close($conn);

        $msg = "<script>Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Berhasil menambahkan ke keranjang!',
            showConfirmButton: false,
            timer: 1500
            });</script>";
    }

    //GET COURSE PRICE
    include 'config.php';
    $marketDataPS = "SELECT price FROM course WHERE name = 'phpsql'";
    $marketDataVC = "SELECT price FROM course WHERE name = 'virtcloud'";
    $marketDataNET = "SELECT price FROM course WHERE name = 'network'";
    $marketDataHP = "SELECT price FROM course WHERE name = 'hardperi'";
    $ps = mysqli_fetch_assoc(mysqli_query($conn, $marketDataPS));
    $ps = $ps['price'];
    $vc = mysqli_fetch_assoc(mysqli_query($conn, $marketDataVC));
    $vc = $vc['price'];
    $net = mysqli_fetch_assoc(mysqli_query($conn, $marketDataNET));
    $net = $net['price'];
    $hp = mysqli_fetch_assoc(mysqli_query($conn, $marketDataHP));
    $hp = $hp['price'];

    // GET ITEM QUANTITY
    $queryPullUserCart = "SELECT quantity_ps, quantity_vc, quantity_net, quantity_hp FROM usercart WHERE username = '$username'";
    $dataPullUserCart = mysqli_query($conn, $queryPullUserCart);
    $dataPullUserCart = mysqli_fetch_assoc($dataPullUserCart);
    $jumps = isset($dataPullUserCart['quantity_ps']) ? $dataPullUserCart['quantity_ps'] : 0;
    $jumvc = isset($dataPullUserCart['quantity_vc']) ? $dataPullUserCart['quantity_vc'] : 0;
    $jumnet = isset($dataPullUserCart['quantity_net']) ? $dataPullUserCart['quantity_net'] : 0;
    $jumhp = isset($dataPullUserCart['quantity_hp']) ? $dataPullUserCart['quantity_hp'] : 0;
   
    // MULTIPLY PRICE WITH QUANTITY
    $ps1 = $ps * $jumps;
    $vc1 = $vc * $jumvc;
    $net1 = $net * $jumnet;
    $hp1 = $hp * $jumhp;

    $subtotal = $ps1 + $vc1 + $net1 + $hp1;
    $pilkursus = ($jumps ? 1 : 0) + ($jumvc ? 1 : 0) + ($jumnet ? 1 : 0) + ($jumhp ? 1 : 0);

    $diskon1 = 0;
    $diskon2 = 0;

    // DISCOUNT 1
    if($subtotal > 2000000) {
        $diskon1 = ($subtotal * 10) / 100;
        $percent_diskon1 = "10%";
    } else if($pilkursus == 4) {
        $diskon1 = ($subtotal * 5) / 100;
        $percent_diskon1 = "5%";
    } else if($pilkursus == 3) {
        $diskon1 = ($subtotal * 2) / 100;
        $percent_diskon1 = "2%";
    }

    // DISCOUNT 2
    $queryGender = "SELECT gender FROM usercre WHERE username = '$username'";
    $dataGender = mysqli_query($conn, $queryGender);
    $gender = mysqli_fetch_assoc($dataGender);

    mysqli_close($conn);

    if($subtotal > 0) {
        if($gender['gender'] == "L") {
            $diskon2 = ($subtotal * 5) / 100;
            $percent_diskon2 = "5%";
        } else {
            $diskon2 = ($subtotal * 3) / 100;
            $percent_diskon2 = "3%";
        }
    }

    $total = $subtotal - ($diskon1 + $diskon2);

    //AMBIL DATA
    $data_jumps = isset($dataPullUserCart['quantity_ps']) ? $dataPullUserCart['quantity_ps'] : 0;
    $data_jumvc = isset($dataPullUserCart['quantity_vc']) ? $dataPullUserCart['quantity_vc'] : 0;
    $data_jumnet = isset($dataPullUserCart['quantity_net']) ? $dataPullUserCart['quantity_net'] : 0;
    $data_jumhp = isset($dataPullUserCart['quantity_hp']) ? $dataPullUserCart['quantity_hp'] : 0;  
    $data_hargaps = $ps1;
    $data_hargavc = $vc1;
    $data_harganet = $net1;
    $data_hargahp = $hp1;
    $data_subtotal = $subtotal;
    $data_diskon1 = $diskon1;
    $percent_diskon1_text = $percent_diskon1;
    $data_diskon2 = $diskon2;
    $percent_diskon2_text = $percent_diskon2;
    $data_total = $total;

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
    
    //PAY AND CLEAR CART
    if (isset($_POST['order']) && $data_total != 0) {
        include 'config.php';
        $queryPurchase = "INSERT INTO userhistory (username, price_ps, quantity_ps, price_vc, quantity_vc, price_net, quantity_net, price_hp, quantity_hp, diskon, diskon_tambahan, subtotal, total, waktu_beli) VALUES ('$username', '$data_hargaps', '$data_jumps', '$data_hargavc', '$data_jumvc', '$data_harganet', '$data_jumnet', '$data_hargahp', '$data_jumhp', '$data_diskon1', '$data_diskon2', '$data_subtotal', '$data_total', NOW())";
        $queryClearCart = "DELETE FROM usercart WHERE username = '$username'";
        
        mysqli_query($conn, $queryPurchase);
        mysqli_query($conn, $queryClearCart);
        mysqli_close($conn);

        $data_jumps = "0";
        $data_jumvc = "0";
        $data_jumnet = "0";
        $data_jumhp = "0";
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
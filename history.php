<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIX Course | Purchase history</title>
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        $timeout = 300; //SESSION TIMEOUT 5 MINUTES
        ini_set("session.gc_maxlifetime", $timeout);

        $session_name = session_name();
        session_start();

        //GET USERNAME FROM INDEX.php
        $username = $_SESSION['history'];

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

        // GET USERNAME'S HISTORY

        $rowsPerPage = 4;
        $pageNum = 1;

        if(isset($_GET['page'])) {
            $pageNum = $_GET['page'];
        }

        $offset = ($pageNum - 1) * $rowsPerPage;

        include 'config.php';
        $queryHistory = "SELECT * FROM userhistory WHERE username = '$username' ORDER BY waktu_beli DESC LIMIT $offset, $rowsPerPage";
        $dataHistory = mysqli_query($conn, $queryHistory);
        

    ?>

    <header class="shadow">
        <div class="container">
            <h1>NIX Course</h1>
        </div>
        <div class="menu">
            <nav>
                <ul>
                    <li><a href="index.php">Shop</a></li>
                    <li><a href="#">History</a></li>
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

    <div class="history">
        <div class="card-l shadow">
            <h2><?php echo "$username's ";?>Purchase History</h2>
            <?php
            $no = 0;
                while ($no < mysqli_num_rows($dataHistory)) {
                    $data = mysqli_fetch_array($dataHistory);
                    echo "<div class='card-list shadow'>";
                    echo "<div class='left-container'>";
                    echo "Order-ID #" . $data['order_id'];
                    echo "</div>";
                    echo "<div class='mid-container'>";
                    echo "<div class='item headlabel'>Course Name&nbsp;&nbsp;&nbsp;</div><div class='item headlabel'>Quantity&nbsp;&nbsp;&nbsp;</div><div></div><div class='item headlabel'>Price</div>";
                    echo "<div class='item'>PHP + SQL</div>";
                    echo "<div class='item'>" . $data['quantity_ps'] . "x</div>";
                    echo "<div class='item'>Rp. &nbsp;&nbsp;</div>";
                    echo "<div class='item money'>" . number_format($data['price_ps'], 2, ',','.') . "</div>";
                    echo "<div class='item'>Virtualization + Cloud</div>";
                    echo "<div class='item'>" . $data['quantity_vc'] . "x</div>";
                    echo "<div class='item'>Rp. &nbsp;&nbsp;</div>";
                    echo "<div class='item money'>" . number_format($data['price_vc'], 2, '.', ',') . "</div>";
                    echo "<div class='item'>Networking</div>";
                    echo "<div class='item'>" . $data['quantity_net'] . "x</div>";
                    echo "<div class='item'>Rp. &nbsp;&nbsp;</div>";
                    echo "<div class='item money'>" . number_format($data['price_net'], 2, '.', ',') . "</div>";
                    echo "<div class='item'>Hardware +  Peripheral&nbsp;&nbsp;&nbsp;</div>";
                    echo "<div class='item'>" . $data['quantity_hp'] . "x</div>";
                    echo "<div class='item'>Rp. &nbsp;&nbsp;</div>";
                    echo "<div class='item money'>" . number_format($data['price_hp'], 2, '.', ',') . "</div>";
                    echo "<div class='item'>Subtotal&nbsp;&nbsp;&nbsp;</div>";
                    echo "<div></div>";
                    echo "<div class='item'>Rp. &nbsp;&nbsp;</div>";
                    echo "<div class='item money'>" . number_format($data['subtotal'], 2, '.', ',') . "</div>";
                    echo "<div class='item'>Diskon&nbsp;&nbsp;&nbsp;</div>";
                    echo "<div></div>";
                    echo "<div class='item'>Rp. &nbsp;&nbsp;</div>";
                    echo "<div class='item money'>" . number_format($data['diskon'], 2, '.', ',') . "</div>";
                    echo "<div class='item'>Diskon ++&nbsp;&nbsp;&nbsp;</div>";
                    echo "<div></div>";
                    echo "<div class='item'>Rp. &nbsp;&nbsp;</div>";
                    echo "<div class='item money'>" . number_format($data['sdiskon_tambahan'], 2, '.', ',') . "</div>";
                    echo "<div class='item'>Total&nbsp;&nbsp;&nbsp;</div>";
                    echo "<div></div>";
                    echo "<div class='item'>Rp.&nbsp;&nbsp;</div>";
                    echo "<div class='item money'>" . number_format($data['total'], 2, '.', ',') . "</div>";
                    echo "</div>";
                    echo "<div class='right-container>'";
                    echo "<a>purchased on " . $data['waktu_beli'] . "</a>";
                    echo "</div>";
                    echo "</div>";
                    $no++;
                }

                $dataHistoryAll = "SELECT * FROM userhistory WHERE username = '$username'";
                $dataHistoryAll = mysqli_query($conn, $dataHistoryAll);
                $row = mysqli_fetch_assoc($dataHistoryAll);
                $total_rows = mysqli_num_rows($dataHistoryAll);
                $maxPage = ceil($total_rows / $rowsPerPage);
                
                $nav = "";
                $page = 1;
                $self = $_SERVER['PHP_SELF'];

                for ($i = 1; $i < 0; $i++) {
                    if ($page == $pageNum) {
                        $nav .= " $page ";
                    } else {
                        $nav .= "<div class='pagination-btn'><a href='$self?page=$page'>$page</a></div>";
                    }
                }

                if ($pageNum > 1 ) {
                    $page = $pageNum - 1;
                    $prev = "<div class='pagination-btn shadow'><a href='$self?page=$page'>[Prev]</a></div>";
                    $first = "<div class='pagination-btn shadow'><a href='$self?page=1'>[First Page]</a></div>";
                } else {
                    $prev = '&nbsp;';
                    $first = '&nbsp;';
                }
            
                if ($pageNum < $maxPage) {
                    $page = $pageNum + 1;
                    $next = "<div class='pagination-btn shadow'><a href='$self?page=$page'>Next</a></div>";
                    $last = "<div class='pagination-btn shadow'><a href='$self?page=$maxPage'>Last</a></div>";
                } else {
                    $next = '&nbsp;';
                    $last = '&nbsp;';
                }
                
                echo "<div class='pagination'>";
                echo $first . $prev . $nav . $next . $last;
                echo "</div>";

                mysqli_close($conn); 
            ?>
        </div>
    </div>
</body>
</html>
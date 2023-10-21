<?php
include 'connection.php';

session_start();
$admin_id = $_SESSION['admin_name'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
}

include('admin_header.php');
?>

<body>
    <div class="container">
        <?php
        include('admin_navigation.php');
        ?>
        <div class="main">
            <?php
            include('admin_title.php');
            ?>
                        <div class="cardBox">
                <div class="card">
                    <div>
                    <?php
                $select_booked = mysqli_query($conn, "SELECT * FROM booked_flight") or die('query failed');
                $num_of_booked = mysqli_num_rows($select_booked);
                ?>
                        <div class="numbers"><?php echo $num_of_booked; ?></div>
                        <div class="cardName">Total Booked</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="book-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                    <?php
                $select_airport = mysqli_query($conn, "SELECT * FROM airport_list") or die('query failed');
                $num_of_airport = mysqli_num_rows($select_airport);
                ?>
                        <div class="numbers"><?php echo $num_of_airport; ?></div>
                        <div class="cardName">Airport</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="airplane-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                    <?php
                $select_users = mysqli_query($conn, "SELECT * FROM users") or die('query failed');
                $num_of_users = mysqli_num_rows($select_users);
                ?>

                        <div class="numbers"><?php echo $num_of_users; ?></div>
                        <div class="cardName">Users</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="people-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                    <?php
                $total_earning = mysqli_query($conn, "SELECT SUM(price) FROM flight_list f JOIN booked_flight b ON (b.flight_id=f.flight_id)") or die('query failed');
                $rowData = mysqli_fetch_array($total_earning)
                ?>
                        <div class="numbers">$<?php echo $rowData['SUM(price)']; ?></div>
                        <div class="cardName">Earning</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Booked</h2>
                        <a href="booked_flight.php" class="btn">View All</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Contact</td>
                                <td>Plane no.</td>
                                <td>Departure</td>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
							$airport = $conn->query("SELECT * FROM airport_list ");
							while($row = $airport->fetch_assoc()){
								$aname[$row['airport_id']] = ucwords($row['airport_name'].', '.$row['location']);
							}
							$i=1;
							$qry = $conn->query("SELECT b.*,f.*,a.airlines,b.booked_flight_id as bid FROM  booked_flight b inner join flight_list f on f.flight_id = b.flight_id inner join airlines_list a on f.airline_id = a.airline_id  order by b.booked_flight_id desc");
							while(($row = $qry->fetch_assoc()) && $i<=6):
                                $i++;
						 ?>
                                <tr>
                                    <td> <?php echo $row['name'] ?> </td>
                                    <td> <?php echo $row['contact'] ?> </td>
                                    <td> <?php echo $row['plane_no'] ?> </td>
                                    <?php $currentDateTime = new DateTime('now'); 
                                    $currentDate = $currentDateTime->format('M d,Y h:i A'); 
                                    $del = date('M d,Y h:i A',strtotime($row['departure_datetime']));
                                    $retVal = ($currentDate < $del) ? "status delivered" : "status return" ;
                                    ?>
                                    <td><span class="<?php echo $retVal ?>"> <?php echo date('M d,Y h:i A',strtotime($row['departure_datetime'])) ?> </span></td>
                                </tr>
                        <?php endwhile; ?>


                            <!-- <tr>
                                <td>Dell Laptop</td>
                                <td>$110</td>
                                <td>Due</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>Apple Watch</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status return">Return</span></td>
                            </tr>

                            <tr>
                                <td>Addidas Shoes</td>
                                <td>$620</td>
                                <td>Due</td>
                                <td><span class="status inProgress">In Progress</span></td>
                            </tr>

                            <tr>
                                <td>Star Refrigerator</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>

                            <tr>
                                <td>Dell Laptop</td>
                                <td>$110</td>
                                <td>Due</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>Apple Watch</td>
                                <td>$1200</td>
                                <td>Paid</td>
                                <td><span class="status return">Return</span></td>
                            </tr>

                            <tr>
                                <td>Addidas Shoes</td>
                                <td>$620</td>
                                <td>Due</td>
                                <td><span class="status inProgress">In Progress</span></td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Airport List</h2>
                    </div>

                    <table>
                        <?php
                            $i = 1;
							$airport = $conn->query("SELECT * FROM airport_list");
							while($row = $airport->fetch_assoc()):
						?>
                            <tr>
                            <td width="60px">
                                <div class="imgBx">
                                    <img src="imgs/airport.png" alt="">
                                </div>
                            </td>
                            <td>
                                <h4><?php echo $row['airport_name'] ?><br> <span><?php echo $row['location'] ?></span></h4>
                            </td>
                        </tr>
                        <?php endwhile; ?>




                        <!-- <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Amit <br> <span>India</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>David <br> <span>Dhaka</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Amit <br> <span>India</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>David <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Amit <br> <span>India</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer01.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>David <br> <span>Italy</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Amit <br> <span>India</span></h4>
                            </td>
                        </tr> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
        <!-- =========== Scripts =========  -->
        <script src="js/main.js"></script>

<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
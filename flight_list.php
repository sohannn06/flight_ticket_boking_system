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



if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    mysqli_query($conn, "DELETE FROM `flight_list` WHERE flight_id = '$delete_id'") or die('query failed');

    header('location:flight_list.php');
}
//update product
if (isset($_POST['update_product'])) {
    $update_id = $_POST['update_id'];
    $update_airline = $_POST['update_airline'];
    $update_plane = $_POST['update_plane'];
    $update_departure_airport_id = $_POST['update_departure_airport_id'];
    $update_arrival_airport_id = $_POST['update_arrival_airport_id'];
    $update_departure_datetime = $_POST['update_departure_datetime'];
    $update_arrival_datetime = $_POST['update_arrival_datetime'];
    $update_seats = $_POST['update_seats'];
    $update_price = $_POST['update_price'];

    // $sql = "UPDATE `flight_list` SET `flight_id`=?,`airline_id`=?,`plane_no`=?,`departure_airport_id`=?,`arrival_airport_id`=?,`departure_datetime`=?,`arrival_datetime`=?,`seats`=?,`price`=? WHERE flight_id=?";

    // // Prepare and bind the statement
    // $stmt = $conn->prepare($sql);

    // // Check for errors in statement preparation
    // if (!$stmt) {
    //     die("Error in statement preparation: " . $conn->error);
    // }

    // // Bind the variables
    // $stmt->bind_param("sssssssssi", $update_id, $update_airline, $update_plane, $update_departure_airport_id, $update_arrival_airport_id, $update_departure_datetime, $update_arrival_datetime, $update_seats, $update_price, $update_id);

    // $stmt->close();
    // header('location:flight_list.php');


    $update_query = mysqli_query($conn, "UPDATE `flight_list` SET `flight_id`='$update_id',`airline_id`='$update_airline',`plane_no`='$update_plane',`departure_airport_id`='$update_departure_airport_id',`arrival_airport_id`='$update_arrival_airport_id',`departure_datetime`='$update_departure_datetime',`arrival_datetime`='$update_arrival_datetime',`seats`='$update_seats',`price`='$update_price' WHERE flight_id='$update_id'") or die('query failed');

    if ($update_query) {
        header('location:flight_list.php');
    }
}

if (isset($_POST['cancel'])) {
    header('location:flight_list.php');
}


?>


<style>
    .add_products {
        margin-top: -3.5rem;
        height: auto;
        background: #f5f5f5;
        position: relative;
    }

    .show-products {
        position: relative;
        background: var(--orange);
        margin-top: -3.5rem;
    }

    .show-products::before {
        background-image: url();
        top: -100px;
    }

    .show-products .box-container {
        grid-template-columns: repeat(auto-fit, minmax(20rem, 1fr));
    }

    .box-container .box {
        line-height: 2;
    }

    .box-container .box h4 {
        text-transform: capitalize;
    }

    .box-container .box img {
        width: 100%;
        margin-bottom: 1rem;
    }

    .edit,
    .delete {
        color: #000;
        background: #99FFFF;
        padding: .5rem 1.5rem;
        text-transform: capitalize;
        line-height: 2;
    }

    .update-container {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        overflow-y: auto;
        background-color: #99FFFF;
        overflow-y: auto;
        z-index: 1100;
        padding: 2rem;
        align-items: center;
        justify-content: center;
        display: none;
    }

    .update-container form {
        display: flex;
        box-shadow: 0px 0px 0px 6px rgb(255 255 255/40%);
        width: 50%;
        background: #fff;
        padding: 1rem;
        margin: 2rem auto;
        text-align: center;
        height: 700px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .update-container .edit,
    .update-container .btn {
        /* width: 40%; */
        padding: 0;
        cursor: pointer;
    }

    .update-container form img {
        width: 60%;
    }

    .update-container form label {
        padding-top: 10px;
        font-size: 3vh;
    }

    input[type=text],
    input[type=number] {
        width: 20vh;
        height: 30px;
    }

    input[type=submit] {
        margin-top: 10px;
        width: 15vh;
        height: 3vh;
        background-color: lightseagreen;
        border: 1px solid black;
        color: white;
        border-radius: 5px;
    }

    input[type=datetime-local] {
        width: 20vh;
        height: 30px;
    }

    select {
        width: 20vh;
        height: 30px;
    }
</style>

<body>
    <div class="container">
        <?php
        include('admin_navigation.php');
        ?>
        <div class="main">
            <?php
            include('admin_title.php');
            ?>
            <div class="table__header">
                <h1>Flight list</h1>
                <div class="input-group">
                    <input type="search" placeholder="Search Data...">
                    <img src="imgs/search.png" alt="">
                </div>
                <div>
                    <button class="add-btn" style=" background: #2ba4df; color: white; width: 10vh; height: 3vh;"><a href="add_flight.php" style="list-style: none; text-decoration: none; color: white;">Add Flight</a></button>
                </div>
            </div>


            <div class="table_body">
                <table>
                    <thead>
                        <tr>
                            <th> Id <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Airline <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Plane No. <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Departure <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Arrival <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Seats <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Booked <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Available <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Price <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $t = 1;
                        $airport = $conn->query("SELECT * FROM airport_list ");
                        while ($row = $airport->fetch_assoc()) {
                            $aname[$row['airport_id']] = ucwords($row['airport_name'] . ', ' . $row['location']);
                        }
                        $qry = $conn->query("SELECT f.*,a.airlines FROM flight_list f inner join airlines_list a on f.airline_id = a.airline_id  order by airline_id");
                        while ($row = $qry->fetch_assoc()) :
                            $booked = $conn->query("SELECT * FROM booked_flight where flight_id = " . $row['airline_id'])->num_rows;

                        ?>
                            <tr>
                                <td><?php echo $t++ ?></td>
                                <td><?php echo $row['airlines'] ?></td>
                                <td><?php echo $row['plane_no'] ?></td>
                                <td><?php echo $aname[$row['departure_airport_id']]  ?> : <?php echo date('M d,Y h:i A', strtotime($row['departure_datetime'])) ?></td>
                                <td><?php echo $aname[$row['arrival_airport_id']] ?> : <?php echo date('M d,Y h:i A', strtotime($row['arrival_datetime']))  ?></td>
                                <td><?php echo $row['seats'] ?></td>
                                <td><?php echo $booked ?></td>
                                <td><?php echo $row['seats'] - $booked ?></td>
                                <td><?php echo number_format($row['price'], 2) ?></td>
                                <td>
                                    <a href="flight_list.php?edit=<?php echo $row['flight_id']; ?>" class="edit">edit</a>
                                    <a href="flight_list.php?delete=<?php echo $row['flight_id']; ?>" class="delete" onclick="return confirm('want to delete this');" class="delete">delete</a>
                                </td>
                            </tr>

                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>


            <section class="update-container">
                <?php
                if (isset($_GET['edit'])) {
                    $edit_id = $_GET['edit'];
                    $edit_query = mysqli_query($conn, "SELECT * FROM flight_list WHERE flight_id = '$edit_id'") or die('query failed');
                    if (mysqli_num_rows($edit_query) > 0) {
                        while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
                ?>
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="update_id" value="<?php echo $fetch_edit['flight_id']; ?>">


                                <label for="update_airline">Airline</label>
                                <select name="update_airline">
                                    <?php
                                    $id = $fetch_edit['airline_id'];
                                    $airline_match = $conn->query("SELECT * FROM airlines_list where airline_id = $id");
                                    $airline_unmatch = $conn->query("SELECT * FROM airlines_list where airline_id <> $id");
                                    while ($row = $airline_match->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['airline_id'] ?>"> <?php echo $row['airlines'] ?></option>
                                    <?php endwhile;
                                    while ($row = $airline_unmatch->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['airline_id'] ?>"> <?php echo $row['airlines'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <label for="update_plane">Plane no</label>
                                <input type="text" name="update_plane" value="<?php echo $fetch_edit['plane_no']; ?> " required>
                                <label for="update_departure_airport_id">Departure Location</label>
                                <select name="update_departure_airport_id">
                                    <?php
                                    $id = $fetch_edit['departure_airport_id'];
                                    $airport_match = $conn->query("SELECT * FROM airport_list where airport_id = $id");
                                    $airport_unmatch = $conn->query("SELECT * FROM airport_list where airport_id <> $id");
                                    while ($row = $airport_match->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['airport_id'] ?>"><?php echo $row['location'] . ", " . $row['airport_name'] ?></option>
                                    <?php endwhile;
                                    while ($row = $airport_unmatch->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['airport_id'] ?>"><?php echo $row['location'] . ", " . $row['airport_name'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <label for="update_arrival_airport_id">Arrival Location</label>
                                <select name="update_arrival_airport_id">
                                    <?php
                                    $id = $fetch_edit['arrival_airport_id'];
                                    $airport_match = $conn->query("SELECT * FROM airport_list where airport_id = $id");
                                    $airport_unmatch = $conn->query("SELECT * FROM airport_list where airport_id <> $id");
                                    while ($row = $airport_match->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['airport_id'] ?>"><?php echo $row['location'] . ", " . $row['airport_name'] ?></option>
                                    <?php endwhile;
                                    while ($row = $airport_unmatch->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['airport_id'] ?>"><?php echo $row['location'] . ", " . $row['airport_name'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <label for="update_departure_datetime">Departure Data/Time</label>
                                <input type="datetime-local" name="departure_datetime" value="<?php echo $fetch_edit['departure_datetime']; ?> ">

                                <label for="update_arrival_datetime">Arrival Data/Time</label>
                                <input type="datetime-local" name="arrival_datetime" value="<?php echo $fetch_edit['arrival_datetime']; ?> ">

                                <label for="update_seats">Seats</label>
                                <input name="update_seats" value="<?php echo $fetch_edit['seats']; ?> ">

                                <label for="update_price">Price</label>
                                <input name="update_price" value="<?php echo $fetch_edit['price']; ?> ">


                                <input type="submit" name="update_product" value="update" class="edit">
                                <input type="submit" name="cancel" value="cancel" class="option-btn btn" id="close-form">
                            </form>
                <?php
                        }
                    }
                    echo "<script>document.querySelector('.update-container').style.display='block'</script>";
                }
                ?>
            </section>
        </div>
    </div>
    <script>
        const search = document.querySelector('.input-group input'),
            table_rows = document.querySelectorAll('tbody tr'),
            table_headings = document.querySelectorAll('thead th');

        // 1. Searching for specific data of HTML table
        search.addEventListener('input', searchTable);

        function searchTable() {
            table_rows.forEach((row, i) => {
                let table_data = row.textContent.toLowerCase(),
                    search_data = search.value.toLowerCase();

                row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
                row.style.setProperty('--delay', i / 25 + 's');
            })

            document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
                visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
            });
        }

        // 2. Sorting | Ordering data of HTML table

        table_headings.forEach((head, i) => {
            let sort_asc = true;
            head.onclick = () => {
                table_headings.forEach(head => head.classList.remove('active'));
                head.classList.add('active');

                document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
                table_rows.forEach(row => {
                    row.querySelectorAll('td')[i].classList.add('active');
                })

                head.classList.toggle('asc', sort_asc);
                sort_asc = head.classList.contains('asc') ? false : true;

                sortTable(i, sort_asc);
            }
        })


        function sortTable(column, sort_asc) {
            [...table_rows].sort((a, b) => {
                    let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
                        second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

                    return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
                })
                .map(sorted_row => document.querySelector('tbody').appendChild(sorted_row));
        }

        // 3. Converting HTML table to PDF

        const pdf_btn = document.querySelector('#toPDF');
        const customers_table = document.querySelector('#customers_table');

        const toPDF = function(customers_table) {
            const html_code = `
    <link rel="stylesheet" href="style.css">
    <main class="table" >${customers_table.innerHTML}</main>
    `;

            const new_window = window.open();
            new_window.document.write(html_code);

            setTimeout(() => {
                new_window.print();
                new_window.close();
            }, 400);
        }

        pdf_btn.onclick = () => {
            toPDF(customers_table);
        }

        // 4. Converting HTML table to JSON

        const json_btn = document.querySelector('#toJSON');

        const toJSON = function(table) {
            let table_data = [],
                t_head = [],

                t_headings = table.querySelectorAll('th'),
                t_rows = table.querySelectorAll('tbody tr');

            for (let t_heading of t_headings) {
                let actual_head = t_heading.textContent.trim().split(' ');

                t_head.push(actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase());
            }

            t_rows.forEach(row => {
                const row_object = {},
                    t_cells = row.querySelectorAll('td');

                t_cells.forEach((t_cell, cell_index) => {
                    const img = t_cell.querySelector('img');
                    if (img) {
                        row_object['customer image'] = decodeURIComponent(img.src);
                    }
                    row_object[t_head[cell_index]] = t_cell.textContent.trim();
                })
                table_data.push(row_object);
            })

            return JSON.stringify(table_data, null, 4);
        }

        json_btn.onclick = () => {
            const json = toJSON(customers_table);
            downloadFile(json, 'json')
        }

        // 5. Converting HTML table to CSV File

        const csv_btn = document.querySelector('#toCSV');

        const toCSV = function(table) {
            // Code For SIMPLE TABLE
            // const t_rows = table.querySelectorAll('tr');
            // return [...t_rows].map(row => {
            //     const cells = row.querySelectorAll('th, td');
            //     return [...cells].map(cell => cell.textContent.trim()).join(',');
            // }).join('\n');

            const t_heads = table.querySelectorAll('th'),
                tbody_rows = table.querySelectorAll('tbody tr');

            const headings = [...t_heads].map(head => {
                let actual_head = head.textContent.trim().split(' ');
                return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
            }).join(',') + ',' + 'image name';

            const table_data = [...tbody_rows].map(row => {
                const cells = row.querySelectorAll('td'),
                    img = decodeURIComponent(row.querySelector('img').src),
                    data_without_img = [...cells].map(cell => cell.textContent.replace(/,/g, ".").trim()).join(',');

                return data_without_img + ',' + img;
            }).join('\n');

            return headings + '\n' + table_data;
        }

        csv_btn.onclick = () => {
            const csv = toCSV(customers_table);
            downloadFile(csv, 'csv', 'customer orders');
        }

        // 6. Converting HTML table to EXCEL File

        const excel_btn = document.querySelector('#toEXCEL');

        const toExcel = function(table) {
            // Code For SIMPLE TABLE
            // const t_rows = table.querySelectorAll('tr');
            // return [...t_rows].map(row => {
            //     const cells = row.querySelectorAll('th, td');
            //     return [...cells].map(cell => cell.textContent.trim()).join('\t');
            // }).join('\n');

            const t_heads = table.querySelectorAll('th'),
                tbody_rows = table.querySelectorAll('tbody tr');

            const headings = [...t_heads].map(head => {
                let actual_head = head.textContent.trim().split(' ');
                return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
            }).join('\t') + '\t' + 'image name';

            const table_data = [...tbody_rows].map(row => {
                const cells = row.querySelectorAll('td'),
                    img = decodeURIComponent(row.querySelector('img').src),
                    data_without_img = [...cells].map(cell => cell.textContent.trim()).join('\t');

                return data_without_img + '\t' + img;
            }).join('\n');

            return headings + '\n' + table_data;
        }

        excel_btn.onclick = () => {
            const excel = toExcel(customers_table);
            downloadFile(excel, 'excel');
        }

        const downloadFile = function(data, fileType, fileName = '') {
            const a = document.createElement('a');
            a.download = fileName;
            const mime_types = {
                'json': 'application/json',
                'csv': 'text/csv',
                'excel': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            }
            a.href = `
        data:${mime_types[fileType]};charset=utf-8,${encodeURIComponent(data)}
    `;
            document.body.appendChild(a);
            a.click();
            a.remove();
        }
    </script>
    <!-- =========== Scripts =========  -->
    <script src="js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
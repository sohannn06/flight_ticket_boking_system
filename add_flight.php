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

if (isset($_POST['submit-btn'])) {
    $filter_airline_id = filter_var($_POST['airline']);
    $airline_id = mysqli_real_escape_string($conn, $filter_airline_id);

    $filter_plane = filter_var($_POST['plane']);
    $plane = mysqli_real_escape_string($conn, $filter_plane);

    $filter_departure_airport_id = filter_var($_POST['departure_airport_id']);
    $departure_airport_id = mysqli_real_escape_string($conn, $filter_departure_airport_id);

    $filter_arrival_airport_id = filter_var($_POST['arrival_airport_id']);
    $arrival_airport_id = mysqli_real_escape_string($conn, $filter_arrival_airport_id);

    $filter_departure_datetime = filter_var($_POST['departure_datetime']);
    $departure_datetime = mysqli_real_escape_string($conn, $filter_departure_datetime);

    $filter_arrival_datetime = filter_var($_POST['arrival_datetime']);
    $arrival_datetime = mysqli_real_escape_string($conn, $filter_arrival_datetime);

    $filter_seats = filter_var($_POST['seats']);
    $seats = mysqli_real_escape_string($conn, $filter_seats);

    $filter_price = filter_var($_POST['price']);
    $price = mysqli_real_escape_string($conn, $filter_price);


    $sql = "INSERT INTO flight_list (airline_id, plane_no, departure_airport_id, arrival_airport_id, departure_datetime, arrival_datetime, seats, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Check for errors in statement preparation
    if (!$stmt) {
        die("Error in statement preparation: " . $conn->error);
    }

    // Bind the variables
    $stmt->bind_param("ssssssss", $airline_id, $plane, $departure_airport_id, $arrival_airport_id, $departure_datetime, $arrival_datetime, $seats, $price);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement and database connection
    $stmt->close();

    header('location:flight_list.php');
}

?>
<style>
    body {
        background-color: #99d6ff;
        display: grid;
        align-items: center;
        justify-items: center;
    }

    form {
        background-color: white;
        display: grid;
        width: 80vh;
        height: 80vh;
        justify-items: center;
        align-content: center;
    }

    label {
        padding-top: 10px;
        font-size: 3vh;
    }

    input[type=text], input[type=number] {
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
    input[type=datetime-local]{
        width: 20vh;
        height: 30px;
    }
    select{
        width: 20vh;
        height: 30px;
    }
</style>

<body>
    <form method="post">
        <h1>Add Flight</h1>
        <label for="airline">Airline</label>
        <select name="airline">
            <option value=""></option>
            <?php
            $airline = $conn->query("SELECT * FROM airlines_list order by airlines asc");
            while ($row = $airline->fetch_assoc()) :
            ?>
                <option value="<?php echo $row['airline_id'] ?>"><?php echo $row['airlines'] ?></option>
            <?php endwhile; ?>
        </select>
        <label for="plane">Plane no</label>
        <input type="text" name="plane" placeholder="enter your plane no." required>
        <label for="departure_airport_id">Departure Location</label>
        <select name="departure_airport_id">
            <option value=""></option>
            <?php
            $airport = $conn->query("SELECT * FROM airport_list order by airport_name asc");
            while ($row = $airport->fetch_assoc()) :
            ?>
                <option value="<?php echo $row['airport_id'] ?>"><?php echo $row['location'] . ", " . $row['airport_name'] ?></option>
            <?php endwhile; ?>
        </select>
        <label for="arrival_airport_id">Arrival Location</label>
        <select name="arrival_airport_id">
            <option value=""></option>
            <?php
            $airport = $conn->query("SELECT * FROM airport_list order by airport_name asc");
            while ($row = $airport->fetch_assoc()) :
            ?>
                <option value="<?php echo $row['airport_id'] ?>"><?php echo $row['location'] . ", " . $row['airport_name'] ?></option>
            <?php endwhile; ?>
        </select>
        <label for="departure_datetime">Departure Data/Time</label>
        <input type="datetime-local" name="departure_datetime">

        <label for="arrival_datetime">Arrival Data/Time</label>
        <input type="datetime-local" name="arrival_datetime">

        <label for="seats">Seats</label>
        <input name="seats" type="number" step="any">

        <label for="price">Price</label>
        <input name="price" id="price" type="number" step="any">

        <input type="submit" name="submit-btn" value="Add" class="btn">
    </form>
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
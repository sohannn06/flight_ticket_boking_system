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

    mysqli_query($conn, "DELETE FROM `airlines_list` WHERE airline_id = '$delete_id'") or die('query failed');

    header('location:airline_list.php');
}
//update product
if(isset($_POST['update_product'])) {
    $update_id = $_POST['update_id'];
    $update_name = $_POST['update_name'];

    $update_query = mysqli_query($conn, "UPDATE `airlines_list` SET `airline_id`='$update_id',`airlines`='$update_name' WHERE airline_id='$update_id'") or die('query failed');
    if($update_query) {
        header('location:airline_list.php');
    }
}

if(isset($_POST['cancel'])) {
    header('location:airline_list.php');
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
            gap: 20px;
            box-shadow: 0px 0px 0px 6px rgb(255 255 255/40%);
            width: 50%;
            background: #fff;
            padding: 1rem;
            margin: 2rem auto;
            text-align: center;
            height: 300px;
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
        .update-container form label{
            padding-top: 10px;
            font-size: 3vh;
        }
        input[type=text]{
            width: 30vh;
            height: 30px;
        }
        input[type=submit]{
            margin-top: 10px;
            width: 15vh;
            height: 3vh;
            background-color: lightseagreen;
            border: 1px solid black;
            color: white;
            border-radius: 5px;
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
                <h1>Airline's</h1>
                <div class="input-group">
                    <input type="search" placeholder="Search Data...">
                    <img src="imgs/search.png" alt="">
                </div>
                <div>
                    <button class="add-btn" style=" background: #2ba4df; color: white; width: 10vh; height: 3vh;"><a href="add_airline.php" style="list-style: none; text-decoration: none; color: white;">Add Airline</a></button>
                </div>
            </div>


            <div class="table_body">
                <table>
                    <thead>
                        <tr>
                            <th> Id <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Airline Name <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $select_airline = mysqli_query($conn, "SELECT * FROM airlines_list") or die('query failed');
                            if (mysqli_num_rows($select_airline) > 0) {
                                while ($fetch_airline = mysqli_fetch_assoc($select_airline)) {
                        ?>
                        <tr>
                            <td> <?php echo $fetch_airline['airline_id']; ?> </td>
                            <td> <?php echo $fetch_airline['airlines']; ?> </td>
                            <td>
                            <!-- <button class="edit-btn" style=" background: #2ba4df; color: white; width: 5vh; height: 3vh;"><a href="#" style="list-style: none; text-decoration: none; color: white;">Edit</a></button>
                            <button class="delete-btn" style=" background: red; color: white; width: 5vh; height: 3vh;"><a href="#" style="list-style: none; text-decoration: none; color: white;">Delete</a></button> -->

                            <a href="airline_list.php?edit=<?php echo $fetch_airline['airline_id']; ?>" class="edit">edit</a>
                            <a href="airline_list.php?delete=<?php echo $fetch_airline['airline_id']; ?>" class="delete" onclick="return confirm('want to delete this');" class="delete">delete</a>
                            </td>
                        </tr>
                        <?php
                }
            } else {
                echo '<p class="empty">no airline added yet!</p>';
            }
            ?>
                    </tbody>
                </table>
            </div>


            <section class="update-container">
        <?php
        if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM airlines_list WHERE airline_id = '$edit_id'") or die('query failed');
            if (mysqli_num_rows($edit_query) > 0) {
                while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
        ?>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="update_id" value="<?php echo $fetch_edit['airline_id']; ?>">
                        <label for="update_name">Airline Name</label>
                        <input type="text" name="update_name" value="<?php echo $fetch_edit['airlines']; ?>">
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
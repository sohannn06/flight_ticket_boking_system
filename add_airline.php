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

if(isset($_POST['submit-btn'])) {
    $filter_name = filter_var($_POST['name']);
    $name = mysqli_real_escape_string($conn, $filter_name);


    $query = "SELECT * FROM airlines_list WHERE airlines = '$name'";

    $select_user = mysqli_query($conn, $query) or die('query failed');

    if(mysqli_num_rows($select_user)>0) {
        $message[] = 'airline already exist';
    }
    else {
        mysqli_query($conn, "INSERT INTO airlines_list (airlines) VALUES ('$name')") or die('query_failed');
        $message[] = 'airline added successfully';
        header('location:airline_list.php');
    }
}

?>
<style>
    body{
        background-color: #99d6ff;
        display: grid;
        align-items: center;
        justify-items: center;
    }
    form{
        background-color: white;
        display: grid;
        width: 80vh;
        height: 50vh;
        justify-items: center;
        align-content: center;
    }
    label{
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
    <form method="post">
        <h1>Add Airline</h1>
        <label for="name">Airline name</label>
        <input type="text" name="name" placeholder="enter your airline name" required>
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
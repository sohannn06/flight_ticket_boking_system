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
            <div class="table__header">
                <h1>User's</h1>
                <div class="input-group">
                    <input type="search" placeholder="Search Data...">
                    <img src="imgs/search.png" alt="">
                </div>
                <div class="export__file">
                    <label for="export-file" class="export__file-btn" title="Export File"></label>
                    <input type="checkbox" id="export-file">
                    <div class="export__file-options">
                        <label>Export As &nbsp; &#10140;</label>
                        <label for="export-file" id="toPDF">PDF <img src="images/pdf.png" alt=""></label>
                        <label for="export-file" id="toJSON">JSON <img src="images/json.png" alt=""></label>
                        <label for="export-file" id="toCSV">CSV <img src="images/csv.png" alt=""></label>
                        <label for="export-file" id="toEXCEL">EXCEL <img src="images/excel.png" alt=""></label>
                    </div>
                </div>
            </div>


            <div class="table_body">
                <table>
                    <thead>
                        <tr>
                            <th> Id <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Name <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Address <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Contact <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Email <span class="icon-arrow">&UpArrow;</span></th>
                            <th> Department <span class="icon-arrow">&UpArrow;</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $select_users = mysqli_query($conn, "SELECT user_id, name, address, contact, email, department_name FROM users, department WHERE users.department_id = department.department_id") or die('query failed');
                            if (mysqli_num_rows($select_users) > 0) {
                                while ($fetch_users = mysqli_fetch_assoc($select_users)) {
                        ?>
                        <tr>
                            <td> <?php echo $fetch_users['user_id']; ?> </td>
                            <td> <?php echo $fetch_users['name']; ?></td>
                            <td> <?php echo $fetch_users['address']; ?> </td>
                            <td> <?php echo $fetch_users['contact']; ?> </td>
                            <td> <?php echo $fetch_users['email']; ?> </td>
                            <td> <?php echo $fetch_users['department_name']; ?> </td>
                        </tr>
                        <?php
                }
            } else {
                echo '<p class="empty">no users added yet!</p>';
            }
            ?>
                        <!-- <tr>
                            <td> 2 </td>
                            <td><img src="images/Jeet Saru.jpg" alt=""> Jeet Saru </td>
                            <td> Kathmandu </td>
                            <td> 27 Aug, 2023 </td>
                            <td>
                                <p class="status cancelled">Cancelled</p>
                            </td>
                            <td> <strong>$5350.50</strong> </td>
                        </tr>
                        <tr>
                            <td> 3</td>
                            <td><img src="images/Sonal Gharti.jpg" alt=""> Sonal Gharti </td>
                            <td> Tokyo </td>
                            <td> 14 Mar, 2023 </td>
                            <td>
                                <p class="status shipped">Shipped</p>
                            </td>
                            <td> <strong>$210.40</strong> </td>
                        </tr>
                        <tr>
                            <td> 4</td>
                            <td><img src="images/Alson GC.jpg" alt=""> Alson GC </td>
                            <td> New Delhi </td>
                            <td> 25 May, 2023 </td>
                            <td>
                                <p class="status delivered">Delivered</p>
                            </td>
                            <td> <strong>$149.70</strong> </td>
                        </tr>
                        <tr>
                            <td> 5</td>
                            <td><img src="images/Sarita Limbu.jpg" alt=""> Sarita Limbu </td>
                            <td> Paris </td>
                            <td> 23 Apr, 2023 </td>
                            <td>
                                <p class="status pending">Pending</p>
                            </td>
                            <td> <strong>$399.99</strong> </td>
                        </tr>
                        <tr>
                            <td> 6</td>
                            <td><img src="images/Alex Gonley.jpg" alt=""> Alex Gonley </td>
                            <td> London </td>
                            <td> 23 Apr, 2023 </td>
                            <td>
                                <p class="status cancelled">Cancelled</p>
                            </td>
                            <td> <strong>$399.99</strong> </td>
                        </tr>
                        <tr>
                            <td> 7</td>
                            <td><img src="images/Alson GC.jpg" alt=""> Jeet Saru </td>
                            <td> New York </td>
                            <td> 20 May, 2023 </td>
                            <td>
                                <p class="status delivered">Delivered</p>
                            </td>
                            <td> <strong>$399.99</strong> </td>
                        </tr>
                        <tr>
                            <td> 8</td>
                            <td><img src="images/Sarita Limbu.jpg" alt=""> Aayat Ali Khan </td>
                            <td> Islamabad </td>
                            <td> 30 Feb, 2023 </td>
                            <td>
                                <p class="status pending">Pending</p>
                            </td>
                            <td> <strong>$149.70</strong> </td>
                        </tr>
                        <tr>
                            <td> 9</td>
                            <td><img src="images/Alex Gonley.jpg" alt=""> Alson GC </td>
                            <td> Dhaka </td>
                            <td> 22 Dec, 2023 </td>
                            <td>
                                <p class="status cancelled">Cancelled</p>
                            </td>
                            <td> <strong>$249.99</strong> </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
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

const toPDF = function (customers_table) {
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

const toJSON = function (table) {
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

const toCSV = function (table) {
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

const toExcel = function (table) {
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

const downloadFile = function (data, fileType, fileName = '') {
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
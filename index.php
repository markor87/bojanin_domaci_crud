<?php
//error_reporting(E_ALL);ini_set('display_errors',1);
//const_dump($_POST);
require_once('php/classes/Studenti.php');

$student = new Student();

if (isset($_POST['create'])) {
    $student->create($_POST['ime'], $_POST['prezime'], $_POST['email'], $_POST['telefon']);
    header('Location: index.php');
}

if (isset($_POST['update'])) {

    $student->update($_POST['ime'], $_POST['prezime'], $_POST['email'], $_POST['telefon'], $_POST['id']);
    header('Location: index.php');
}

if (isset($_POST['delete'])) {
    $student->delete($_POST['id']);
    header('Location: index.php');
}

$studenti = $student->read();
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        /* Make the table the same width as the monitor */
        .table {
            width: 100%;
        }

        /* Make the navbar and fonts more modern */
        .navbar {
            font-family: 'Roboto', sans-serif;
            background-color: #333333;
        }

        .nav-link {
            color: #ffffff;
        }

        .nav-link:hover {
            color: #cccccc;
        }
    </style>

    <title>Fakultet</title>
</head>
<body>
<!-- Navigation menu -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Fakultet</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Studenti</a>
            </li>
        </ul>
        <!-- Search field in the menu -->
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="searchInput">
            <button class="btn btn-outline-success my-2 my-sm-0" type="button" id="search-btn">Search</button>
            <!-- User information with a sign out option -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    User Name
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="#">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Sign Out</a>
                </div>
            </div>
        </form>
    </div>
</nav>

<!-- Table with CRUD options -->
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <!-- Add button above the table -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Add
                </button>

                <!-- Counter that counts how many rows are in the table -->
                <div class="text-right mt-3">
                    <span>Rows:</span>
                    <span id="rowCount" class="badge badge-secondary">0</span>
                </div>
            </div>

            <!-- Table -->
            <table class="table table-striped table-bordered" id="studentiTable">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" data-sort="id">Id</th>
                    <th scope="col" data-sort="ime">Ime</th>
                    <th scope="col" data-sort="prezime">Prezime</th>
                    <th scope="col" data-sort="email">Email</th>
                    <th scope="col" data-sort="telefon">Telefon</th>
                    <th scope="col">Akcija</th>
                </tr>
                </thead>
                <tbody id="table-body">
                <!-- Table rows -->
                <?php foreach ($studenti as $student) : ?>
                    <tr>
                        <th scope="row">1</th>
                        <td data-column="id"><?= $student['id'] ?></td>
                        <td data-column="ime"><?= $student['ime'] ?></td>
                        <td data-column="prezime"><?= $student['prezime'] ?></td>
                        <td data-column="email"><?= $student['email'] ?></td>
                        <td data-column="telefon"><?= $student['telefon'] ?></td>
                        <td>
                            <!-- CRUD options -->
                            <!--                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#readModal">Read-->
                            <!--                            </button>-->
                            <button class="btn btn-primary btn-sm edit-btn" data-toggle="modal" data-target="#editModal"
                                    data-id="<?php echo $student['id']; ?>"
                                    data-ime="<?php echo $student['ime']; ?>"
                                    data-prezime="<?php echo $student['prezime']; ?>"
                                    data-email="<?php echo $student['email']; ?>"
                                    data-telefon="<?php echo $student['telefon']; ?>">Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-toggle="modal"
                                    data-target="#deleteModal" data-id="<?php echo $student['id']; ?>">Delete
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- Modals for the CRUD options -->

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new row -->
                <form method="post">
                    <div class="form-group">
                        <label for="ime">Ime</label>
                        <input type="text" class="form-control" id="ime" placeholder="Unesite ime" name="ime">
                    </div>
                    <div class="form-group">
                        <label for="prezime">Prezime</label>
                        <input type="text" class="form-control" id="prezime" placeholder="Unesite prezime"
                               name="prezime">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Unesite prezime"
                               name="email">
                    </div>
                    <div class="form-group">
                        <label for="telefon">Telefon</label>
                        <input type="text" class="form-control" id="telefon" placeholder="Unesite prezime"
                               name="telefon">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addStudentBtn" name="create">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing a row -->
                <form method="post">
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <label for="ime">ime</label>
                        <input type="text" class="form-control" id="ime" name="ime">
                    </div>
                    <div class="form-group">
                        <label for="prezime">prezime</label>
                        <input type="text" class="form-control" id="prezime" name="prezime">
                    </div>
                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="telefon">telefon</label>
                        <input type="text" class="form-control" id="telefon" name="telefon">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="update">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    Are you sure you want to delete this row?

                    <div class="modal-footer">
                        <input type="hidden" id="id" name="id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.16.6/dist/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
<script>
    // Select all the rows in the table
    const rows = document.querySelectorAll('table tbody tr');

    // Get the number of rows and update the rowCount element
    document.getElementById('rowCount').innerHTML = rows.length;
</script>

<script>
    $(document).on("click", ".edit-btn", function () {

        const id = $(this).data('id');
        const ime = $(this).data('ime');
        const prezime = $(this).data('prezime');
        const email = $(this).data('email');
        const telefon = $(this).data('telefon');
        $("#editModal #id").val(id);
        $("#editModal #ime").val(ime);
        $("#editModal #prezime").val(prezime);
        $("#editModal #email").val(email);
        $("#editModal #telefon").val(telefon);
    });

    $(document).on("click", ".delete-btn", function () {
        const id = $(this).data('id');
        $("#deleteModal #id").val(id);
    });
</script>

<script>
    function searchTable() {
        // Get the input and search button elements
        let input = document.getElementById("searchInput");
        let searchBtn = document.getElementById("search-btn");

        // Get the table rows
        let table = document.getElementById("table-body");
        let rows = table.getElementsByTagName("tr");

        // Convert the input value to lowercase and remove any leading or trailing spaces
        let searchValue = input.value.toLowerCase().trim();

        // Loop through the rows of the table and hide any rows that do not match the search term
        for (let i = 0; i < rows.length; i++) {
            let ime = rows[i].getElementsByTagName("td")[1].textContent.toLowerCase();
            let prezime = rows[i].getElementsByTagName("td")[2].textContent.toLowerCase();
            let email = rows[i].getElementsByTagName("td")[3].textContent.toLowerCase();
            let telefon = rows[i].getElementsByTagName("td")[4].textContent.toLowerCase();
            if (ime.includes(searchValue) || prezime.includes(searchValue) || email.includes(searchValue) || telefon.includes(searchValue)) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }

    let searchBtn = document.getElementById("search-btn");
    searchBtn.addEventListener("click", searchTable);

</script>

<script>

    $(document).ready(function () {
        $('th[data-sort]').on('click', function () {
            let column = $(this).data('sort');
            let table = $(this).closest('table');
            let tbody = table.find('tbody');
            let rows = tbody.find('tr').get();
            let ascending = $(this).hasClass('asc');
            rows.sort(function (a, b) {
                let aValue = $(a).find('td[data-column="' + column + '"]').text().toLowerCase();
                let bValue = $(b).find('td[data-column="' + column + '"]').text().toLowerCase();
                if (aValue < bValue) {
                    return ascending ? -1 : 1;
                }
                if (aValue > bValue) {
                    return ascending ? 1 : -1;
                }
                return 0;
            });
            tbody.empty();
            $.each(rows, function (index, row) {
                tbody.append(row);
            });
            $(this).toggleClass('asc', !ascending);
            $(this).toggleClass('desc', ascending);
        });
    });


</script>

</body>
</html>




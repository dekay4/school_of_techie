<?php
include("../includes/connection.php");
if ($_COOKIE['userId'] == '') {
    header('Location: http://schooloftechiestask.infinityfreeapp.com/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" sizes="192x192" href="https://schooloftechies.com/assets/img/sot/sot-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="https://schooloftechies.com/assets/img/sot/sot-icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<style>
    .error {
        color: red;
    }

    .div_img_container img {
        width: 200px;
        height: auto;
        margin-bottom: 20px;
        position: relative;
        left: 35px;
    }
</style>

<body>


    <div class="container-fluid">

        <!-- Button trigger modal -->
        <div style="display: flex;justify-content: space-between;flex-wrap: wrap;">

            <nav aria-label="breadcrumb" style="margin-top: 16px;font-size: 35px;">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <div class="div_img_container">
                            <img src="https://schooloftechies.com/assets/img/sot/sot%20logo%20tm-02.jpg">
                        </div>
                    </li>
                </ol>
            </nav>

            <div>
                <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="add()" style="height: 58px;">
                    Add Comment
                </button>
                <a href="../login/?logout=1">
                    <button type="button" class="btn btn-danger m-3" style="height: 58px;">
                        Logout
                    </button>
                </a>
            </div>
        </div>



        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>S.no</th>
                    <th>Username</th>
                    <th>Comment</th>
                    <th>Date Time</th>

                </tr>

            </thead>
            <tbody>




                <?php
                $sql = "SELECT * FROM comment";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $sNo = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sNo++;
                        $userIds = $row['user_id'];
                        $sqlUser = "SELECT * FROM register WHERE user_id='$userIds'";
                        $resultUser = mysqli_query($conn, $sqlUser);
                        $rowUser = mysqli_fetch_assoc($resultUser)

                ?>

                        <tr>


                            <td><?php echo $sNo; ?></td>
                            <td><?php echo $rowUser['user_name']; ?></td>
                            <td><?php echo $row['comment']; ?></td>

                            <td><?php echo date("d-M-Y h:i A", strtotime($row['dateTime'])); ?></td>



                        </tr>
                <?php
                    }
                }
                ?>




            </tbody>


        </table>
    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="title">Add Comment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">



                        <div class="mb-3">
                            <label for="comment_box" class="form-label">Comment</label>
                            <textarea class="form-control" id="comment_box" name="comment_box" rows="3"></textarea>
                        </div>




                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary" id="formBtn" onclick="addComent()">Add</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.3/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function add() {
            $("#title").html("Add Comment");
            $('#addForm')[0].reset();
            $("#api").val("add.php");

        }

        $(document).ready(function() {

            $('#addForm').validate({
                rules: {

                    comment_box: {
                        required: true,
                    }

                }

            });

        });




        function addComent() {

            if ($('#addForm').valid()) {


                Swal.fire({
                        title: "Add",
                        text: "Are you sure want to Add This Comment?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        closeOnClickOutside: false,
                        showCancelButton: true,

                    })
                    .then((value) => {
                        if (value.isConfirmed) {



                            // if ($('#addForm').valid()) {



                            var form = $("#addForm");

                            var formData = new FormData(form[0]);
                            this.disabled = true;
                            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                            $.ajax({
                                type: "POST",
                                url: "add.php",
                                data: formData,
                                dataType: "json",
                                contentType: false,
                                cache: false,
                                processData: false,

                                success: function(res) {
                                    if (res.status == 'success') {
                                        Swal.fire({
                                                title: "Success",
                                                text: res.msg,
                                                icon: "success",
                                                button: "OK",
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                closeOnClickOutside: false,
                                            })
                                            .then((value) => {
                                                window.window.location.reload();
                                            });
                                    } else if (res.status == 'failure') {

                                        Swal.fire({
                                                title: "Failure",
                                                text: res.msg,
                                                icon: "warning",
                                                button: "OK",
                                                allowOutsideClick: false,
                                                allowEscapeKey: false,
                                                closeOnClickOutside: false,
                                            })
                                            .then((value) => {

                                                document.getElementById("add_btn").disabled = false;
                                                document.getElementById("add_btn").innerHTML = 'Add';
                                            });

                                    }
                                },
                                error: function() {

                                    Swal.fire('Check Your Network!');
                                    document.getElementById("add_btn").disabled = false;
                                    document.getElementById("add_btn").innerHTML = 'Add';
                                }

                            });

                            //    }


                        }
                    });


            }


        }
    </script>

</body>

</html>
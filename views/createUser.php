<?php require_once "layouts/header.php"; ?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="../controllers/UserController.php?action=create" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label>Shops</label>
                                    <select class="select2" id="js-shops" name="shops[]" multiple="multiple" style="width: 100%;">
                                        <option value='0'>- Search Shops -</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <?php
                            if(isset($_SESSION['CreateUserError'])){
                                foreach ($_SESSION['CreateUserError'] as $error){
                                    echo "<div class='alert alert-danger text-center'><strong>{$error}</strong></div>";
                                }
                                unset($_SESSION['CreateUserError']);
                            }

                            ?>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<?php require_once "layouts/footer.php"; ?>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $("#js-shops").select2({
            ajax: {
                url: "../controllers/UserController.php?action=shopsDropdown",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        shops: params.term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    })
</script>

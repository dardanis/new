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
                            <h3 class="card-title">Create Service</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="../controllers/ServiceController.php?action=create" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Description</label>
                                    <input type="text" name="description" class="form-control" placeholder="Description">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Price</label>
                                    <input type="text" name="price" class="form-control" placeholder="Price">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <?php
                            if(isset($_SESSION['CreateServiceError'])){
                                foreach ($_SESSION['CreateServiceError'] as $error){
                                    echo "<div class='alert alert-danger text-center'><strong>{$error}</strong></div>";
                                }
                                unset($_SESSION['CreateServiceError']);
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

    })
</script>

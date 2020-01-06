<?php require_once "layouts/header.php"; ?>
<?php require_once "../models/ShopModel.php"; ?>

<?php
$shop = new ShopModel();
$show = $shop->show($_GET['id']);
?>

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
                            <h3 class="card-title">Update Shop</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="../controllers/ShopController.php?action=update" method="POST">
                            <input type="text" name="id" value="<?php echo $show['id']; ?>" hidden>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" name="name" value="<?php echo $show['name']; ?>"
                                           class="form-control" id="exampleInputEmail1" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="form-control select2" name="city_id" style="width: 100%;">
                                        <?php foreach ($shop->cityDropdown() as $city) {
                                            if ($city['id'] === $show['city_id']) {
                                                echo "<option selected='selected'  value='" . $city['id'] . "'>" . $city['text'] . "</option>";
                                            } else {
                                                echo "<option value='" . $city['id'] . "'>" . $city['text'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Users</label>
                                    <select class="select2" id="selectUser" name="users[]" multiple="multiple"
                                            style="width: 100%;">
                                        <?php
                                        $users = $shop->getShopUsersDropdown($show['id']);
                                        foreach ($users as $user) {
                                            echo "<option selected='selected'  value='" . $user['id'] . "'>" . $user['text'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            <?php
                            if (isset($_SESSION['UpdateShopError'])) {
                                foreach ($_SESSION['UpdateShopError'] as $error) {
                                    echo "<div class='alert alert-danger text-center'><strong>{$error}</strong></div>";
                                }
                                unset($_SESSION['UpdateShopError']);
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

        $("#selectUser").select2({
            ajax: {
                url: "../controllers/UserController.php?action=userDropdown",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        users: params.term
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

<?php require_once "layouts/header.php"; ?>
<?php require_once "../models/ShopModel.php"; ?>

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">
                        <a href="createShop.php" class="btn btn-sm">
                            Add Shop
                        </a>
                    </button>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Shops</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <?php
                                    $shops = new ShopModel();
                                    foreach ($shops->getAll() as $shop) {
                                ?>
                                <tbody>

                                <tr>
                                    <td><?php echo $shop['id'];?></td>
                                    <td><?php echo $shop['name'];?></td>
                                    <td><?php echo $shop['city_name'];?></td>
                                    <td class="text-center">
                                        <a href="updateShop.php?id=<?php echo $shop['id']; ?>"><img src="assets/img/edit.svg" width="30"></a>
                                        <a href="../controllers/ShopController.php?id=<?php echo $shop['id'];?>&action=delete" onclick="return confirm('Are you sure about this action?'); "><img src="assets/img/delete.svg" width="30"></a>
                                    </td>
                                </tr>

                                </tbody>
                               <?php } ?>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
<?php require_once "layouts/footer.php"; ?>
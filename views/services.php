<?php require_once "layouts/header.php"; ?>
<?php require_once "../models/ServiceModel.php"; ?>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">
                        <a href="createService.php" class="btn btn-sm">
                            Add Service
                        </a>
                    </button>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Users</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <?php
                                $services = new ServiceModel();
                                foreach ($services->getAll() as $service) {
                                    ?>
                                    <tbody>

                                    <tr>
                                        <td><?php echo $service['id'];?></td>
                                        <td><?php echo $service['description'];?></td>
                                        <td><?php echo $service['price'];?></td>
                                        <td><?php echo $service['active'] == 1 ? 'Enabled' : 'Disabled';?></td>
                                        <td class="text-center">
                                            <a href="updateService.php?id=<?php echo $service['id']; ?>"><img src="assets/img/edit.svg" width="30"></a>
                                            <a href="../controllers/ServiceController.php?id=<?php echo $service['id'];?>&action=delete" onclick="return confirm('Are you sure about this action?'); "><img src="assets/img/delete.svg" width="30"></a>
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
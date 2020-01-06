<?php require_once "layouts/header.php"; ?>
<?php require_once "../models/UserModel.php"; ?>

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">
                        <a href="createUser.php" class="btn btn-sm">
                            Add User
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
                                    <th>Name</th>
                                    <th>email</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <?php
                                $users = new UserModel();
                                foreach ($users->getAll() as $user) {
                                    ?>
                                    <tbody>

                                    <tr>
                                        <td><?php echo $user['id'];?></td>
                                        <td><?php echo $user['name'];?></td>
                                        <td><?php echo $user['email'];?></td>
                                        <td class="text-center">
                                            <a href="updateUser.php?id=<?php echo $user['id']; ?>"><img src="assets/img/edit.svg" width="30"></a>
                                            <a href="../controllers/UserController.php?id=<?php echo $user['id'];?>&action=delete" onclick="return confirm('Are you sure about this action?'); "><img src="assets/img/delete.svg" width="30"></a>
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
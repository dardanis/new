<?php require_once "layouts/header.php"; ?>
<?php require_once "../models/DashboardModel.php"; ?>

<?php
    $dashboard = new DashboardModel()
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <?php $topService = $dashboard->getTopSoldServices() ?>
                            <h3><?php echo $topService['top_sold'];?></h3>
                            <p><?php echo $topService['description'];?></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">Top Sold Services</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php require_once "layouts/footer.php"; ?>
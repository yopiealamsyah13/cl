<section class="content-header">
  <h1>HOME</h1>
</section>
<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php if($pending->row()->total>0){?><?php echo $pending->row()->total;?><?php }else{echo "0";}?></h3>

              <p>PENDING</p>
            </div>
            <div class="icon">
              <i class="ion ion-document"></i>
            </div>
            <a href="<?php echo site_url() ?>/request" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php if($closed->row()->total>0){?><?php echo $closed->row()->total;?><?php }else{echo "0";}?></h3>

              <p>CLOSED</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="<?php echo site_url() ?>/request/history" class="small-box-footer" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php if($total->row()->total>0){?><?php echo $total->row()->total;?><?php }else{echo "0";}?></h3>

              <p>TOTAL REQUEST</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-red">
              <h3>AREA</h3>
              <h5>Total Request</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php foreach($area_user->result() as $rowa){?>
                <li><a href="#"><?php echo $rowa->name_user.' (<b>'.$rowa->alias_company.'</b>) - '.$rowa->name_area; ?> <span class="pull-right badge bg-red"><?php echo $rowa->total;?></span></a></li>
              <?php } ?>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</section>
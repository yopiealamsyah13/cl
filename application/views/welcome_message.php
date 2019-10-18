<?php
$id_role = $this->session->userdata('id_role');
$request = $this->acl->get_user_permissions()->request;
$add_request = $this->acl->get_user_permissions()->add_request;
?>
<section class="content-header">
  <h1>HOME</h1>
  <ol class="breadcrumb">
      <form name="cari" action="<?php echo site_url() ?>/welcome" method="get">
      <div class="input-group input-group-sm">
          <select name="bulan" class="form-control" style="width: 200px">
            <option value="">- Month -</option>
            <?php foreach ($month->result() as $key) { ?>
            <option value="<?php echo $key->bulan?>"><?php echo date('F',strtotime($key->requested_date));?></option>
            <?php }?>
          </select>
          <select name="tahun" class="form-control" style="width: 200px">
            <option value="">- Year -</option>
            <?php foreach ($year->result() as $key) { ?>
            <option value="<?php echo $key->year?>"><?php echo $key->year?></option>
            <?php }?>
          </select>
          <div class="btn-group">
            <button class="btn btn-sm btn-primary" type="submit"><span class="fa fa-search"></span></button>
          </div>
      </div>
    </form>
    </ol>
</section>
<section class="content">
<?php
  if($request=='1'){
?>
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
            <a href="<?php echo site_url() ?>/request?bulan=<?php echo $pending->row()->bulan;?>&tahun=<?php echo $pending->row()->tahun;?>" class="small-box-footer">
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
            <a href="<?php echo site_url() ?>/request/history?bulan=<?php echo $closed->row()->bulan;?>&tahun=<?php echo $closed->row()->tahun;?>" class="small-box-footer" class="small-box-footer">
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
            <a href="<?php echo site_url() ?>/request?bulan=<?php echo $total->row()->bulan;?>&tahun=<?php echo $total->row()->tahun;?>" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <div class="row">
      <?php if($id_role!='10'){ ?>
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-red">
              <h3>AREA</h3>
              <h5>Active Request</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <?php foreach($area_user->result() as $rowa){?>
                <li><a href="<?php echo site_url();?>/request/history?area=<?php echo $rowa->id_area;?>&bulan=<?php echo $closed->row()->bulan;?>&tahun=<?php echo $closed->row()->tahun;?>"><?php echo '(<b>'.$rowa->alias_company.'</b>) - '.$rowa->name_area; ?> <span class="pull-right badge bg-red"><?php echo $rowa->total;?></span></a></li>
              <?php } ?>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
        <?php } ?>
        <?php if($add_request=='1'){?>
        <div class="col-sm-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">My Request Credit Limit</h3>
              
            </div>
              <div class="box-body chart-responsive">
                <?php 
                $data="";
                foreach($get_chart->result() as $row){
                  $month = date('M',strtotime($row->requested_date));
                  $data .= "{ month:'".$month."', request:".$row->total."}, ";
                }
                $data = substr($data, 0, -2);
                ?>

                <div class="chart" id="request" style="height: 345px;"></div>
              </div>
          </div>
        </div>
        
        <script>
          $(function () {
            //BAR CHART VISIT
            var bar = new Morris.Bar({
              element: 'request',
              resize: true,
              data: [<?php echo $data; ?>],
              barColors: ['#00a65a'],
              xkey: 'month',
              ykeys: ['request'],
              labels: ['Request'],
              hideHover: 'auto'
            });
          });
        </script>
        <?php } ?>

         
      <?php if($id_role!='10'){ ?>
        
        <div class="col-md-4">
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-red">
                  <!-- /.widget-user-image -->
                  <h3>New Customers</h3>
                  <h5>Active Request</h5>
                </div>
                <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                  <?php foreach ($new_area->result() as $value) {?>
                    <li>
                      <a data-toggle="modal" data-target="#myModal<?php echo $value->id_company.$value->id_area; ?>"><?php echo '(<b>'.$value->alias_company.'</b>) - '.$value->name_area;?>
                        <span class="pull-right badge bg-red"><?php foreach($count_new_customer as $val){if($val->id_area == $value->id_area){ echo $val->total;}} ?></span>
                      </a>
                    </li>
                  
                   <!-- Modal -->
                    <div id="myModal<?php echo $value->id_company.$value->id_area ?>" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">New <?php echo "(".$value->alias_company.") - ".$value->name_area; ?></h4>
                          </div>
                          <div class="modal-body">
                          <table class="table table-bordered table-striped table-responsive">
                            <thead>
                              <tr style="background-color: #3c8dbc; color: #fff;">
                                <th>No.</th>
                                <th>Name Customers</th>
                                <th>Company</th>
                                <th>Area</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php 
                                  foreach ($new_request as $baris) {
                                    if($baris->id_company == $value->id_company && $baris->id_area == $value->id_area){
                              ?>
                              <tr style="font-size:12px;">
                                <td><a href="<?php echo site_url() ?>/request/view_request/<?php echo $baris->id_request;?>/<?php echo $baris->id_customer;?>"><?php echo $baris->id_request; ?></a> </td>
                                <td><?php echo $baris->name_customer; ?></td>
                                <td><?php echo $baris->alias_company; ?></td>
                                <td><?php echo $baris->name_area; ?></td>
                                <td><span class="label bg-<?php if($baris->id_request_status=='1'){echo "gray";}elseif($baris->id_request_status=='2'){echo "red";}elseif($baris->id_request_status=='3'){echo "orange";}elseif($baris->id_request_status=='4'){echo "yellow";}elseif($baris->id_request_status=='5'){echo "green";}elseif($baris->id_request_status=='6'){echo "red";}elseif($baris->id_request_status=='7'){echo "black";}?>"><?php echo $baris->name_request_status; ?></span></td>
                              </tr>
                              <?php 
                                  } 
                                } 
                              ?>
                            </tbody>
                          </table>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- end modal -->
                  <?php } ?>
                  </ul>
                </div>
              </div>
            </div>

        <div class="col-md-4">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-red">
                <!-- /.widget-user-image -->
                <h3>Closed By</h3>
                <h5>User List</h5>
              </div>
              <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                <?php foreach ($user_close->result() as $value) {?>
                  <li><a href="#"><?php echo $value->name_user;?> <span class="pull-right badge bg-red"><?php echo $value->total;?></span></a></li>
                <?php } ?>
                </ul>
              </div>
            </div>
            <!-- /.widget-user -->
          </div>


      <?php } ?>
      </div>
      <!-- /.row -->
<?php } ?>
</section>
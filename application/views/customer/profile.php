
<?php
$baris = $profile->row();
$id_user = $this->session->userdata('id');
$id_role = $this->session->userdata('id_role');
?>


<section class="content-header">
  <h1>CUSTOMER INFORMATION</h1>
  <ol class="breadcrumb">
    <li></li>
  </ol>
</section>

<section class="content">
    
<div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center"><?php echo $baris->name_customer; ?></h3>

              <p class="text-muted text-center"><?php echo $baris->name_sector; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Sales</b> <a class="pull-right"> <?php echo $baris->name_user; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Type</b> <a class="pull-right"><?php echo $baris->name_customer_type; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Phone</b> <a class="pull-right"><?php echo $baris->phone_customer; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Fax</b> <a class="pull-right"><?php echo $baris->fax_customer; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Website</b> <a class="pull-right"><?php echo $baris->website_customer; ?></a>
                </li>
                <li class="list-group-item">
                  <b>NPWP</b> <a class="pull-right"><?php echo $baris->npwp_customer; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Total CL</b> <a class="pull-right">Rp. <?php $key = $credit->row(); echo number_format($key->total,0,",",".");?></a>
                </li>
              </ul>

              <span class="btn btn-<?php if($baris->status_existing=='1'){echo "success";}else{echo "primary";} ?> btn-block"><b><?php if($baris->status_existing=='1'){echo "EXISTING";}else{echo "PROSPECT";} ?></b></span>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="box box-primary">
            <div class="box-body box-profile">
              <i><p class="text-muted">Since<span class="pull-right"><?php echo date('d M Y', strtotime( $baris->create_date_customer)); ?></span></p></i>
              <i><p class="text-muted">Last Request<span class="pull-right"><?php  if(count($request->result())>0){echo date("d M Y",strtotime($request->row()->requested_date));}else{echo "no order found";} ?></span></p></i>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">CL Request</a></li>
              <li><a href="#outstandingar" data-toggle="tab">Outstanding AR</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
              <?php foreach ($activity->result() as $value) {?>
                <!-- Post -->
                <div class="post">
                        <span class="username">
                          Number : <a href="<?php echo site_url('request/view_request/'.$value->id_request.'/'.$value->id_customer);?>"><?php echo "[".$value->id_request."]" ?> <span class="label bg-<?php if($value->id_request_status=='1'){echo "blue";}elseif($value->id_request_status=='2'){echo "red";}elseif($value->id_request_status=='3'){echo "orange";}elseif($value->id_request_status=='4'){echo "yellow";}elseif($value->id_request_status=='5'){echo "green";}elseif($value->id_request_status=='6'){echo "red";}elseif($value->id_request_status=='7'){echo "black";}?>"><?php echo $value->name_request_status; ?></span></a>
                        </span>
                        <span class="pull-right"><i class="fa fa-calendar"></i> <?php echo date('d M Y',strtotime($value->requested_date));?></span>
                  <!-- /.user-block -->
                  <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                      <?php echo $value->requested_note;?>
                  </p>
                  <ul class="list-inline">
                    <li><strong><p>CL : Rp. <?php echo number_format($value->credit_limit,0,",","."); ?></p></strong></li>
                    <li class="pull-right"><strong>Max Outstanding Days : <?php echo $value->max_top; ?></strong></li>
                  </ul>
                </div>
                <!-- /.post -->
              <?php } ?>
              </div>
              <div class="tab-pane" id="outstandingar">
                <!-- masih dipikirin -->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</section>
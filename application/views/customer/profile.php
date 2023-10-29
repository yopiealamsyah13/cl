
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
              <h3 class="profile-username text-center"><?php echo $baris->companyname." ".$baris->firstname." ".$baris->middlename." ".$baris->lastname; ?></h3>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>ID</b> <a class="pull-right"> <?php echo $baris->id_netsuite; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Sales</b> <a class="pull-right"> <?php echo $baris->salesrepname; ?></a>
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
                <b>Total CL</b> <a class="pull-right">IDR <?php $key = $credit->row(); echo number_format($key->total,2,".",",");?></a>
                </li>
              </ul>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="box box-primary">
            <div class="box-body box-profile">
              <i><p class="text-muted">Last Request<span class="pull-right"><?php  if(count($request->result())>0){echo date("d M Y",strtotime($request->row()->requested_date));}else{echo "no order found";} ?></span></p></i>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">History Request</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
              <?php foreach ($activity->result() as $value) {?>
                <!-- Post -->
                <div class="post">
                        <span class="username">
                          Request No: <a href="<?php echo site_url('request/view_request/'.$value->id_request.'/'.$value->id_internal);?>"><?php echo "[".$value->id_request."]" ?> <span class="label bg-<?php if($value->id_request_status=='1'){echo "blue";}elseif($value->id_request_status=='2'){echo "red";}elseif($value->id_request_status=='3'){echo "orange";}elseif($value->id_request_status=='4'){echo "yellow";}elseif($value->id_request_status=='5'){echo "green";}elseif($value->id_request_status=='6'){echo "red";}elseif($value->id_request_status=='7'){echo "black";}?>"><?php echo $value->name_request_status; ?></span></a>
                        </span>
                        <span class="pull-right"><i class="fa fa-calendar"></i> <?php echo date('d M Y',strtotime($value->requested_date));?></span>
                  <!-- /.user-block -->
                  <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                      <?php echo $value->requested_note;?>
                  </p>
                  <ul class="list-inline">
                    <li><p>Credit Limit: <strong>IDR <?php echo number_format($value->credit_limit,2,".",","); ?></p></strong></li>
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

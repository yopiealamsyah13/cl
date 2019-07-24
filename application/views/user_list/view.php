<?php 
    $baris = $user->row();
?>
<section class="content-header">
  <h1>USER INFORMATION</h1>
</section>
<section class="content">
  <div class="row">
        <div class="col-md-5">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url(); ?>assets/photo/<?php echo $baris->photo;?>">

              <h3 class="profile-username text-center"><?php echo $baris->name_user;?></h3>

              <p class="text-muted text-center"><?php foreach($role->result() as $row){ if($baris->id_role==$row->id){ echo $row->name_role;}}?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Company</b> <a class="pull-right"><?php foreach($company->result() as $row){ if($baris->id_company==$row->id_company){ echo $row->name_company;}}?></a>
                </li>
                <li class="list-group-item">
                  <b>Area</b> <a class="pull-right"><?php foreach($area->result() as $row){ if($baris->id_area==$row->id_area){ echo $row->name_area;}}?></a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right"><?php echo $baris->email;?></a>
                </li>
                <li class="list-group-item">
                  <b>Mobile</b> <a class="pull-right"><?php echo $baris->mobile_phone;?></a>
                </li>
                <li class="list-group-item">
                  <b>Phone</b> <a class="pull-right"><?php echo $baris->phone;?></a>
                </li>
              </ul>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

</section>
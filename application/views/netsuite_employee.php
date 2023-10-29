<html>
<head>
<title>test netsuite</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class="active"><a href="<?php echo site_url();?>/netsuite" data-toggle="tab">Customer</a></li>
    <li><a href="<?php echo site_url();?>/netsuite/employee" data-toggle="tab">Employee</a></li>
    <li><a href="<?php echo site_url();?>/netsuite/activity" data-toggle="tab">Activity</a></li>
  </ul>
</div>
<div class="pull-left">
<h3>EMPLOYEE</h3>
</div>
<div class="pull-right">
<form action="<?php echo site_url() ?>/netsuite/employee" method="GET">
      <div class="input-group input-group-sm">     
        <input type="text" style="width: 260px" class="form-control" name="term" placeholder="input first name">
          <div class="btn-group">
            <button class="btn btn-sm btn-primary" type="submit">Search</button>
	    <button class="btn btn-sm btn-primary" href="<?php echo base_url();?>/netsuite/employee">Refresh</button>
          </div>
      </div>
    </form>
</div>
<?php 
    $per_page = abs($this->input->get('per_page'));
    $no = $per_page + 1;
    if(count($employee->result()) > 0) {
  ?>
   <table class="table table-bordered table-striped" style="font-size:13px;">
    <thead>
      <tr style="background-color: #3c8dbc; color: #fff;">
	<td>No</td>
	<td>id_employee</td>
	<td>internalid</td>
	<td>employeeid</td>
	<td>firstname</td>
	<td>middlename</td>
	<td>lastname</td>
	<td>subsidiaryid</td>
	<td>subsidiaryname</td>
	<td>sbuid</td>
	<td>sbuname</td>
	<td>phone</td>
        <td>jobtitle</td>
	<td>email</td>
	<td>nik</td>
	<td>supervisorid</td>
	<td>supervisorname</td>
      </tr>
    </thead>

    <tbody> 
    <?php
      foreach($employee->result() as $baris){
    ?>
      <tr>
	<td><?php echo $no; ?></td>
        <td><?php echo $baris->id_employee; ?></td>
	<td><?php echo $baris->internalid; ?></td>
	<td><?php echo $baris->employeeid; ?></td>
	<td><?php echo $baris->firstname; ?></td>
	<td><?php echo $baris->middlename; ?></td>
	<td><?php echo $baris->lastname; ?></td>
	<td><?php echo $baris->subsidiaryid; ?></td>
	<td><?php echo $baris->subsidiaryname; ?></td>
	<td><?php echo $baris->sbuid; ?></td>
	<td><?php echo $baris->sbuname; ?></td>
	<td><?php echo $baris->phone; ?></td>
	<td><?php echo $baris->jobtitle; ?></td>
	<td><?php echo $baris->email; ?></td>
	<td><?php echo $baris->nik; ?></td>
	<td><?php echo $baris->supervisorid; ?></td>
	<td><?php echo $baris->supervisorname; ?></td>
      </tr>
    <?php
      $no++;
      }
    ?>

      <tr>
        <td colspan="17">
          <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
        </td>
      </tr>
    </tbody> 
  </table>

  <?php
    } else {
  ?>
  
  <table class="table table-bordered table-striped" style="font-size:13px;"> 
    <thead> 
      <tr style="background-color: #3c8dbc; color: #fff;">
	<td>No</td>
	<td>id_employee</td>
	<td>internalid</td>
	<td>employeeid</td>
	<td>firstname</td>
	<td>middlename</td>
	<td>lastname</td>
	<td>subsidiaryid</td>
	<td>subsidiaryname</td>
	<td>sbuid</td>
	<td>sbuname</td>
	<td>phone</td>
        <td>jobtitle</td>
	<td>email</td>
	<td>nik</td>
	<td>supervisorid</td>
	<td>supervisorname</td>
      </tr>
    </thead> 
    
    <tbody> 
      <td colspan="17" align="center">No Data Available</td>    
    </tbody>
  </table>    
  <?php } ?>

</body>
</html>

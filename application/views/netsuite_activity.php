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
<h3>ACTIVITY</h3>
</div>
<div class="pull-right">
<form action="<?php echo site_url() ?>/netsuite/activity" method="GET">
      <div class="input-group input-group-sm">     
        <input type="text" style="width: 260px" class="form-control" name="term" placeholder="input title">
          <div class="btn-group">
            <button class="btn btn-sm btn-primary" type="submit">Search</button>
	    <button class="btn btn-sm btn-primary" href="<?php echo base_url();?>/netsuite/activity">Refresh</button>
          </div>
      </div>
    </form>
</div>
<?php 
    $per_page = abs($this->input->get('per_page'));
    $no = $per_page + 1;
    if(count($activity->result()) > 0) {
  ?>
   <table class="table table-bordered table-striped" style="font-size:13px;">
    <thead>
      <tr style="background-color: #3c8dbc; color: #fff;">
	<td>No</td>
	<td>id_request</td>
	<td>internalid</td>
	<td>type</td>
	<td>title</td>
<td>date_activity</td>
<td>time_activity</td>
<td>end_time_activity</td>
	<td>organizer</td>
	<td>attendee</td>
	<td>name_customer</td>
      </tr>
    </thead>

    <tbody> 
    <?php
      foreach($activity->result() as $baris){
    ?>
      <tr>
	<td><?php echo $no; ?></td>
        <td><?php echo $baris->id_request; ?></td>
	<td><?php echo $baris->internalid; ?></td>
	<td><?php echo $baris->type; ?></td>
	<td><?php echo $baris->title; ?></td>
<td><?php echo $baris->date_activity; ?></td>
<td><?php echo $baris->time_activity; ?></td>
<td><?php echo $baris->end_time_activity; ?></td>
	<td><?php echo $baris->organizer; ?></td>
	<td><?php echo $baris->attendee; ?></td>
	<td><?php echo $baris->name_customer; ?></td>
      </tr>
    <?php
      $no++;
      }
    ?>

      <tr>
        <td colspan="11">
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
	<td>id_request</td>
	<td>internalid</td>
	<td>type</td>
	<td>title</td>
<td>date_activity</td>
<td>time_activity</td>
<td>end_time_activity</td>
	<td>organizer</td>
	<td>name_customer</td>
      </tr>
    </thead> 
    
    <tbody> 
      <td colspan="11" align="center">No Data Available</td>    
    </tbody>
  </table>    
  <?php } ?>

</body>
</html>

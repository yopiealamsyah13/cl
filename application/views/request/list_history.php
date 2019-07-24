<?php
  $id_role = $this->session->userdata('id_role');
?>

<section class="content-header">
  <h1>HISTORY CREDIT LIMIT</h1>
</section>
<section class="content">

<div class="box box-primary">
  <?php 
    $per_page = abs($this->input->get('per_page'));
    $no = $per_page + 1;
    if(count($name->result()) > 0) {
  ?>
<div class="box-body table-responsive">
<div class="box-tools pull-right">
    <form name="cari" method="GET" action="<?php echo site_url('request/history'); ?>">
        <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="search" id="get_customer" class="form-control pull-right" placeholder="Search">
            <div class="input-group-btn">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
  </div>
  <br>
  <br>
  <table id="mytable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th width="150">State</th>
        <th width="100" align="center">No.</th>
        <th width="100">Request Date</th>
        <th width="100">Request by</th>
        <th width="150">Sales Name</th>
        <th>Customer Name</th>
        <th>Lead Time</th>
      </tr>
    </thead>

    <tbody> 
    <?php
      foreach($name->result() as $baris){
    ?>
      <tr>
        <td><span class="bg-<?php if($baris->id_request_status=='1'){echo "gray";}elseif($baris->id_request_status=='2'){echo "red";}elseif($baris->id_request_status=='3'){echo "orange";}elseif($baris->id_request_status=='4'){echo "yellow";}elseif($baris->id_request_status=='5'){echo "green";}elseif($baris->id_request_status=='6'){echo "red";}elseif($baris->id_request_status=='7'){echo "black";}?>"><?php foreach($status->result() as $rows){if($baris->id_request_status==$rows->id_request_status){ echo $rows->name_request_status;}}?></span></td>
        <td><a href="<?php echo site_url() ?>/request/view_request/<?php echo $baris->id_request;?>/<?php echo $baris->id_customer; ?>"><?php echo $baris->id_request;?></a></td>
        <td><?php echo date('d M Y g:i a',strtotime($baris->requested_date));?></td>
        <td><?php foreach($user->result() as $rowu){if($baris->id_user==$rowu->id){echo $rowu->name_user;}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->name_user;}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo strtoupper($rowc->name_customer);}}?></td>
        <td>
          <?php
            $now = new DateTime('now');
            $requested_date = new DateTime($baris->requested_date);
            $update_date = new DateTime($baris->update_date);

            if($update_date->diff($requested_date)->format('%a')>0)
            {
              echo $update_date->diff($requested_date)->format('%a days');
            }
            elseif($update_date->diff($requested_date)->format('%h')>0)
            {
              echo $update_date->diff($requested_date)->format('%h hours');
            }
            elseif($update_date->diff($requested_date)->format('%i')>0)
            {
              echo $update_date->diff($requested_date)->format('%i minutes');
            }
          ?>
        </td>
      </tr>
    <?php
      $no++;
      }
    ?>
    <tr>
        <td colspan="14">
          <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
        </td>
      </tr>
    </tbody> 
  </table>

  <?php
    } else {
  ?>
  
  <table class="table table-striped table-hover tablesorter" cellspacing="0"> 
    <thead> 
      <tr>
        <th width="150">State</th>
        <th width="100" align="center">No.</th>
        <th width="100">Request Date</th>
        <th width="100">Request by</th>
        <th width="150">Sales Name</th>
        <th>Customer Name</th>
        <th>Lead Time</th>
      </tr>
    </thead> 
    
    <tbody> 
      <td colspan="7" align="center">No Data Available</td>    
    </tbody>
  </table>    
  <?php } ?>

</div>
</div>
</section>
<script>
  $(function () {
    $('#mytable').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
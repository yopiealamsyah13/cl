<?php
  $id_role = $this->session->userdata('id_role');
  $id_area = $this->session->userdata('id_area');
?>

<section class="content-header">
  <h1>HISTORY CREDIT LIMIT</h1>
  <ol class="breadcrumb">
      <form name="cari" action="<?php echo site_url() ?>/request/history" method="GET">
      <div class="input-group input-group-sm">
        <?php if($id_role!='10' && $id_area != '17'){?>
          <select name="area" class="form-control" style="width: 200px">
            <option value="">- Select SBU -</option>
            <?php foreach ($area->result() as $vala) { ?>
            <option value="<?php echo $vala->id_area; ?>" <?php if(isset($_GET['area']) && $_GET['area'] == $vala->id_area) { echo "selected";} ?> ><?php echo $vala->name_company.' - '.$vala->name_area; ?></option>
            <?php } ?>
          </select>
        <?php } ?>
          
          <input type="text" class="form-control" name="startdate" id="datepicker" style="width: 150px" placeholder="Date From" autocomplete='off' readonly="readonly" style="cursor: pointer; background-color: white">
          <input type="text" class="form-control" name="enddate" id="datepicker2" style="width: 150px" placeholder="Date To" autocomplete='off' readonly="readonly" style="cursor: pointer; background-color: white">
          <input type="text" class="form-control" name="note" style="width: 250px" placeholder="Search Note">
          <div class="btn-group">
            <button class="btn btn-sm btn-primary" type="submit"><span class="fa fa-search"></span></button>
          </div>
          <div class="btn-group">
            <a href="<?php echo site_url() ?>/request/export_history_request" class="btn btn-sm btn-primary">Export</a>
          </div>  
      </div>
    </form>
    </ol>
</section>
<section class="content">

<div class="box box-primary">
  <?php 
    $per_page = abs($this->input->get('per_page'));
    $no = $per_page + 1;
    if(count($name->result()) > 0) {
  ?>
<div class="box-body">
  <table id="mytable" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr style="background-color: #3c8dbc; color: #fff;">
        <th width="33">State</th>
        <th width="33" align="center">No.</th>
        <th>Request Date</th>
        <?php if($id_role!='10'){ ?><th>Requested by</th><?php } ?>
        <th>SBU</th>
        <th width="90">Netsuite ID</th>
        <th>Customer Name</th>
        <th>Sales Rep</th>
        <th width="400">Note</th>
        <th width="80">Lead Time</th>
        <th width="80">Approver</th>
      </tr>
    </thead>
    <tbody> 
    <?php
      foreach($name->result() as $baris){
    ?>
      <tr>
        <td><span class="label bg-<?php if($baris->id_request_status=='5'){echo "green";}elseif($baris->id_request_status=='6'){echo "red";}elseif($baris->id_request_status=='7'){echo "black";}?>"><?php foreach($status->result() as $rows){if($baris->id_request_status==$rows->id_request_status){ echo $rows->name_request_status;}}?></span></td>
        <td><a href="<?php echo site_url() ?>/request/view_request/<?php echo $baris->id_request;?>/<?php echo $baris->id_internal; ?>"><?php echo $baris->id_request;?></a></td>
        <td><?php echo date('d M Y g:i a',strtotime($baris->requested_date));?></td>
        <?php if($id_role!='10'){ ?>
        <td><?php foreach($user->result() as $rowu){if($baris->id_user==$rowu->id){echo $rowu->name_user;}}?></td>
        <?php } ?>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_internal==$rowc->id_internal){echo $rowc->sbuname;}}?></td>
	      <td><?php foreach($customer->result() as $rowc){if($baris->id_internal==$rowc->id_internal){echo $rowc->id_netsuite;}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_internal==$rowc->id_internal){ echo $rowc->companyname." ".$rowc->firstname." ".$rowc->middlename." ".$rowc->lastname;}}?></td>
	      <td><?php foreach($customer->result() as $rowc){if($baris->id_internal==$rowc->id_internal){echo $rowc->empfirstname." ".$rowc->empmiddlename." ".$rowc->emplastname;}}?></td>
        <td><?php foreach($note->result() as $rown){if($baris->id_request==$rown->id_request){ echo $rown->note_comment;}}?></td>
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
        <td><?php foreach($user->result() as $rowu){if($baris->update_by==$rowu->id){echo $rowu->name_user;}}?></td>
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
</div>

  <?php
    } else {
  ?>
  <div class="box-body">
  <table id="mytable" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr style="background-color: #3c8dbc; color: #fff;">
        <th width="33">State</th>
        <th width="33" align="center">No.</th>
        <th>Request Date</th>
        <?php if($id_role!='10'){ ?><th>Requested by</th><?php } ?>
        <th>SBU</th>
        <th width="90">Netsuite ID</th>
        <th>Customer Name</th>
        <th>Sales Rep</th>
        <th width="400">Note</th>
        <th width="80">Lead Time</th>
        <th width="80">Approver</th>
      </tr>
    </thead> 
    <tbody> 
      <td colspan="11" align="center">No Data Available</td>    
    </tbody>
  </table>  
</div>  
  <?php } ?>

</div>
</section>
<script>
  $(document).ready(function(){
	//Date picker
    	$('#datepicker').datepicker({
      		autoclose: true,
		format: 'yyyy-mm-dd',
      		todayHighlight: true
    	})
    		$('#datepicker2').datepicker({
      		autoclose: true,
		format: 'yyyy-mm-dd',
      		todayHighlight: true
    	})

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

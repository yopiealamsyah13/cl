<?php
  $id_role = $this->session->userdata('id_role');
  $add_request = $this->acl->get_user_permissions()->add_request;
?>
 
<section class="content-header">
  <h1>CREDIT LIMIT REQUEST</h1>
    <ol class="breadcrumb">
      <form name="cari" action="<?php echo site_url() ?>/request" method="GET">
      <div class="input-group input-group-sm">
        <?php if($id_role!='10' && $id_role!='12'){?>
          <select name="area" class="form-control" style="width: 200px">
            <option value="">- Select SBU -</option>
            <?php foreach ($area->result() as $vala) { ?>
            <option value="<?php echo $vala->id_area; ?>" <?php if (isset($_GET['area']) && $_GET['area'] == $vala->id_area) { echo "selected";} ?> ><?php echo $vala->name_company.' - '.$vala->name_area; ?></option>
            <?php } ?>
          </select>
        <?php } ?>
          
	        <input type="text" class="form-control" name="startdate" id="datepicker" style="width: 150px" placeholder="Date From" autocomplete='off' readonly="readonly" style="cursor: pointer; background-color: white">
	        <input type="text" class="form-control" name="enddate" id="datepicker2" style="width: 150px" placeholder="Date To" autocomplete='off' readonly="readonly" style="cursor: pointer; background-color: white">
          <div class="btn-group">
            <?php if($id_role!='10'){?>
            <button class="btn btn-sm btn-primary" type="submit"><span class="fa fa-search"></span></button>
            <?php }?>
            <?php if($add_request=='1'){ ?>
            <a class="btn btn-primary btn-sm" href="<?php echo site_url() ?>/request/add_request"><i class="fa fa-plus"></i> Add</a>
            <?php } ?>
          </div>
      </div>
    </form>
    </ol>
</section>
<section class="content">
 
<div class="box box-primary">
<div class="box-body table-responsive">
  <?php 
    $per_page = abs($this->input->get('per_page'));
    $no = $per_page + 1;
    if(count($name->result()) > 0) {
  ?>
  <table id="mytable" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr style="background-color: #3c8dbc; color: #fff;">
        <th width="100">State</th>
        <th width="70">No.</th>
        <th>Request Date</th>
        <?php if($id_role!='10'){ ?><th>Requested by</th><?php } ?>
        <th>SBU</th>
        <th width="90">Netsuite ID</th>
        <th>Customer Name</th>
        <th>Sales Rep</th>
      </tr>
    </thead>
 
    <tbody> 
    <?php
      foreach($name->result() as $baris){
    ?>
      <tr>
        <td><span class="label bg-<?php if($baris->id_request_status=='1'){echo "gray";}elseif($baris->id_request_status=='2'){echo "red";}elseif($baris->id_request_status=='3'){echo "orange";}elseif($baris->id_request_status=='4'){echo "yellow";}elseif($baris->id_request_status=='5'){echo "green";}elseif($baris->id_request_status=='6'){echo "red";}elseif($baris->id_request_status=='7'){echo "black";}elseif($baris->id_request_status=='8'){echo "blue";}?>"><?php foreach($status->result() as $rows){if($baris->id_request_status==$rows->id_request_status){ echo $rows->name_request_status;}}?></span></td>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?>
          <a href="<?php echo site_url() ?>/request/view_request/<?php echo $baris->id_request;?>/<?php echo $baris->id_internal;?>" class="read-list" data-req="<?php echo $baris->id_request;?>" data-value="<?php foreach ($notif as $rown){ if($rown->notification_reference_id == $baris->id_request){echo $rown->notification_id;}} ?>">
            <?php echo $baris->id_request;?>
          </a><?php if($baris->id_request_status=='7'){echo "</strike>";}?>
        </td>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><?php echo date('d M Y g:i a',strtotime($baris->requested_date));?><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>
        <?php if($id_role!='10'){ ?>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><?php foreach($user->result() as $rowu){if($baris->id_user==$rowu->id){echo $rowu->name_user;}}?><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>
        <?php } ?>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><?php foreach($customer->result() as $rowc){if($baris->id_internal==$rowc->id_internal){echo $rowc->sbuname;}}?><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>
	      <td><?php foreach($customer->result() as $rowc){if($baris->id_internal==$rowc->id_internal){echo $rowc->id_netsuite;}}?></td>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><?php foreach($customer->result() as $rowc){if($baris->id_internal==$rowc->id_internal){ echo $rowc->companyname." ".$rowc->firstname." ".$rowc->middlename." ".$rowc->lastname;}}?><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>
	      <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><?php foreach($customer->result() as $rowc){if($baris->id_internal==$rowc->id_internal){echo $rowc->empfirstname." ".$rowc->empmiddlename." ".$rowc->emplastname;}}?><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>

      </tr>
    <?php
      $no++;
      }
    ?>
      <tr>
        <td colspan="7">
          <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
        </td>
      </tr>
    </tbody> 
  </table>
 
  <?php
    } else {
  ?>
  
  <table id="mytable" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead> 
      <tr style="background-color: #3c8dbc; color: #fff;">
        <th width="150">State</th>
        <th width="70">No.</th>
        <th width="100">Request Date</th>
        <th width="120">Requested by</th>
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
<script type="text/javascript">
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

    $('.read-list').click(function(){
        var id_user = parseInt("<?php echo $this->session->userdata('id');?>");
        var date = new Date();
        var notification_id = $(this).data('value');
        var id_request = $(this).data('req');
        $.ajax({
            method:"POST",
            dataType : "json",
            url : "<?php echo site_url('request/insert_read/')?>/"+notification_id+"/"+id_request,
            data :{id_notification:notification_id,id_user:id_user,id_request:id_request,date:date},
            success:function(data){
                location.href(true);
            }
        });
    });
 
});
</script>

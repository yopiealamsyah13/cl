<?php
  $id_role = $this->session->userdata('id_role');
  $add_request = $this->acl->get_user_permissions()->add_request;
?>

<section class="content-header">
<h1>CREDIT LIMIT REQUEST</h1>
    <ol class="breadcrumb">
      <form name="cari" action="<?php echo site_url() ?>/request" method="GET">
      <div class="input-group input-group-sm">
        <?php if($id_role!='10'){?>
          <select name="status" class="form-control" style="width: 200px">
            <option value="">- Select State -</option>
            <?php foreach ($status->result() as $value) { ?>
            <option value="<?php echo $value->id_request_status; ?>"><?php echo $value->name_request_status; ?></option>
            <?php } ?>
          </select>
          <select name="area" class="form-control" style="width: 200px">
            <option value="">- Select SBU -</option>
            <?php foreach ($area->result() as $vala) { ?>
            <option value="<?php echo $vala->id_area; ?>"><?php echo $vala->name_company.' - '.$vala->name_area; ?></option>
            <?php } ?>
          </select>
        <?php } ?>
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

<div class="box box-primary table-responsive">
  <?php 
    $per_page = abs($this->input->get('per_page'));
    $no = $per_page + 1;
    if(count($name->result()) > 0) {
  ?>
<div class="box-body">
  <table id="mytable" class="table table-bordered table-striped table-responsive">
    <thead>
      <tr  style="background-color: #3c8dbc; color: #fff;">
        <th width="150">State</th>
        <th width="70">No.</th>
        <th width="100">Request Date</th>
        <th width="120">Requested by</th>
        <th>Entity</th>
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
        <td><span class="label bg-<?php if($baris->id_request_status=='1'){echo "gray";}elseif($baris->id_request_status=='2'){echo "red";}elseif($baris->id_request_status=='3'){echo "orange";}elseif($baris->id_request_status=='4'){echo "yellow";}elseif($baris->id_request_status=='5'){echo "green";}elseif($baris->id_request_status=='6'){echo "red";}elseif($baris->id_request_status=='7'){echo "black";}?>"><?php foreach($status->result() as $rows){if($baris->id_request_status==$rows->id_request_status){ echo $rows->name_request_status;}}?></span></td>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><a href="<?php echo site_url() ?>/request/view_request/<?php echo $baris->id_request;?>/<?php echo $baris->id_customer; ?>"><?php echo $baris->id_request;?></a><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><?php echo date('d M Y g:i a',strtotime($baris->requested_date));?><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><?php foreach($user->result() as $rowu){if($baris->id_user==$rowu->id){echo $rowu->name_user;}}?><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->alias_company;}}?><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->name_user;}}?><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>
        <td><?php if($baris->id_request_status=='7'){echo "<strike>";}?><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo strtoupper($rowc->name_customer);}}?><?php if($baris->id_request_status=='7'){echo "</strike>";}?></td>
        <td>
          <?php if($baris->id_request_status=='7'){echo "<strike>";}?>
          <?php
            $requested_date = strtotime($baris->requested_date);
            $update_date = strtotime($baris->update_date);
            $lead = $update_date-$requested_date;
            $hours = floor($lead/(60*60));
            //$minutes = $lead-$hours*(60*60);
            //$day = floor($lead/(60*60*24));
            if($baris->id_request_status=='7')
            {
              echo $hours." hours";
            }
          ?>
          <?php if($baris->id_request_status=='7'){echo "</strike>";}?>
        </td>
      </tr>
    <?php
      $no++;
      }
    ?>
    </tbody> 
  </table>
  <div class="box-footer clearfix">
      <ul class="pagination pagination-sm no-margin pull-right">
          <li>
              <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
          </li>
      </ul>
  </div>
  <?php
    } else {
  ?>
  <table class="table table-bordered table-striped"> 
    <thead> 
      <tr>
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
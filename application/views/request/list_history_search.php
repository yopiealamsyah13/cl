<?php
  $id_role = $this->session->userdata('id_role');
?>
<section class="content-header">
  <h1>HISTORY CREDIT LIMIT</h1>
  <ol class="breadcrumb">
      <form name="cari" action="<?php echo site_url() ?>/request/search_history" method="GET">
      <div class="input-group input-group-sm">
        <?php if($id_role!='10'){?>
          <select name="area" class="form-control" style="width: 200px">
            <option value="">- Select SBU -</option>
            <?php foreach ($area->result() as $vala) { ?>
            <option value="<?php echo $vala->id_area; ?>"><?php echo $vala->name_company.' - '.$vala->name_area; ?></option>
            <?php } ?>
          </select>
        <?php } ?>
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
          <input type="text" name="cari" class="form-control" style="width: 200px" placeholder="Search Note...">
          <div class="btn-group">
            <button class="btn btn-sm btn-primary" type="submit"><span class="fa fa-search"></span></button>
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
<div class="box-body table-responsive">
  <table id="mytable" class="table table-bordered table-striped">
    <thead>
      <tr  style="background-color: #3c8dbc; color: #fff;">
        <th width="150">State</th>
        <th width="100" align="center">No.</th>
        <th width="100">Request Date</th>
        <?php if($id_role!='10'){ ?>
        <th width="100">Request by</th>
        <?php } ?>
        <th>Entity</th>
        <th width="150">Sales Name</th>
        <th>Customer Name</th>
        <th>Note</th>
        <th>Lead Time</th>
        <th>Updated By</th>
      </tr>
    </thead>

    <tbody> 
    <?php
      foreach($name->result() as $baris){
    ?>
      <tr>
        <td><span class="label bg-<?php if($baris->id_request_status=='1'){echo "gray";}elseif($baris->id_request_status=='2'){echo "red";}elseif($baris->id_request_status=='3'){echo "orange";}elseif($baris->id_request_status=='4'){echo "yellow";}elseif($baris->id_request_status=='5'){echo "green";}elseif($baris->id_request_status=='6'){echo "red";}elseif($baris->id_request_status=='7'){echo "black";}?>"><?php foreach($status->result() as $rows){if($baris->id_request_status==$rows->id_request_status){ echo $rows->name_request_status;}}?></span></td>
        <td><a href="<?php echo site_url() ?>/request/view_request/<?php echo $baris->id_request;?>/<?php echo $baris->id_customer; ?>"><?php echo $baris->id_request;?></a></td>
        <td><?php echo date('d M Y g:i a',strtotime($baris->requested_date));?></td>
        <?php if($id_role!='10'){ ?>
        <td><?php foreach($user->result() as $rowu){if($baris->id_user==$rowu->id){echo $rowu->name_user;}}?></td>
        <?php } ?>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->alias_company;}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->name_user;}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){if($rowc->name_entity!='Pte Ltd' and $rowc->name_entity!='Ltd' and $rowc->name_entity!='GmbH & Co. KG' and $rowc->name_entity!='Other' and $rowc->name_entity!='Perseorangan'){ echo $rowc->name_entity;}?> <?php echo strtoupper($rowc->name_customer);?> <?php if($rowc->name_entity=='Pte Ltd' or $rowc->name_entity=='Ltd' or $rowc->name_entity=='GmbH & Co. KG'){ echo strtoupper($rowc->name_entity);}}}?> <?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){if($rowc->status_existing=='1'){?><i class="fa fa-check text-success"></i><?php }}}?></td>
        <td><?php foreach($note->result() as $rown){if($baris->id_request==$rown->id_request){echo $rown->note_comment;}}?></td>
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
  <table class="table table-striped table-hover tablesorter" cellspacing="0"> 
    <thead> 
      <tr>
        <th width="150">State</th>
        <th width="100" align="center">No.</th>
        <th width="100">Request Date</th>
        <?php if($id_role!='10'){ ?><th width="100">Request by</th><?php } ?>
        <th width="150">Sales Name</th>
        <th>Customer Name</th>
        <th>Note</th>
        <th width="80">Lead Time</th>
        <th width="80">Updated by</th>
      </tr>
    </thead> 
    <tbody> 
      <td colspan="8" align="center">No Data Available</td>    
    </tbody>
  </table>    
  <?php } ?>
</div>
</div>
</section>
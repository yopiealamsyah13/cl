<?php
  $id_role = $this->session->userdata('id_role');
?>

<section class="content-header">
  <h1>CUSTOMER</h1>
  <ol class="breadcrumb">
  </ol>
</section>
<section class="content">

<div class="box box-primary">
<div class="box-body">
  <table id="mytable" class="table table-bordered table-striped">
    <thead>
      <tr style="background-color: #3c8dbc; color: #fff;">
        <td>No.</td>
        <td>ID CRRM</td>
        <td>ID Netsuite</td>
        <td>ID Internal</td>
        <td>Customer</td>
      </tr>
    </thead>
    <tbody id="tableData">
    <?php if(!empty($customer->data)){ ?>
    <?php $no=1; foreach($customer->data as $rowc){?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td><?php echo $rowc->id_customer; ?></td>
      <td><?php echo $rowc->id_netsuite; ?></td>
      <td><?php echo $rowc->id_internal; ?></td>
      <td><?php echo $rowc->name_customer; ?></td>
    </tr>
    <?php }?>
    <?php }else{?><tr>
      <td colspan="5"><?php echo $this->session->flashdata('status'); ?></td>
    </tr>
    <?php }?>
    </tbody> 
  </table>
</div>
</div>
</section>
<script>
$(document).ready(function(){
  $("#mytable").DataTable();
});
</script>
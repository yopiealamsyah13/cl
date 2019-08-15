<?php
  $id_role = $this->session->userdata('id_role');
?>

<section class="content-header">
  <h1>CUSTOMER</h1>
  <ol class="breadcrumb">
    <form name="cari" action="<?php echo site_url() ?>/customer" method="GET">
      <div class="input-group input-group-sm">     
        <input type="text" style="width: 260px" class="form-control" name="term" id="get_customer" placeholder="Search">
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
<div class="box-body">
  <table id="mytable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th width="33">No.</th>
        <th width="300">Customer</th>
        <th width="150">Sales</th>
        <th width="150">Credit Limit</th>
        <th width="100">TOP</th>
        <th width="33">#</th>
      </tr>
    </thead>

    <tbody> 
    <?php
      foreach($name->result() as $baris){
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><a href="<?php echo site_url('customer/customer_profile/'.$baris->id_customer); ?>"><?php echo strtoupper($baris->name_customer);?></a></td>
        <td><?php echo $baris->name_user;?></td>
        <td><?php echo number_format($baris->credit_limit,0,',','.');?></td>
        <td><?php echo $baris->outstanding_over;?></td>
        <td>
          <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#edit<?php echo $baris->id_customer;?>"><span class="fa fa-pencil"></span></a>

<!-- Edit Customer -->
<div class="modal fade" id="edit<?php echo $baris->id_customer;?>" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Edit Customer</h3>
      </div>
      <div class="modal-body form">
      <form name="form-validate" id="edit" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/customer/edit_customer/<?php echo $baris->id_customer;?>">
          <div class="form-body">
            <div class="form-group form-group-sm">
              <label class="control-label col-sm-4">Credit Limit</label>
              <div class="col-sm-6">
                <input data-a-dec="," data-a-sep="." name="credit_limit" placeholder="Input Credit Limit" class="credit_limit form-control" value="<?php echo $baris->credit_limit;?>" required>
              </div>
            </div>

            <div class="form-group form-group-sm">
              <label class="control-label col-sm-4">TOP</label>
              <div class="col-sm-6">
                <input name="outstanding_over" placeholder="Input Outstanding Over" class="form-control" value="<?php echo $baris->outstanding_over;?>" required>
              </div>
            </div>

          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('.credit_limit').autoNumeric();
</script>

<script type="text/javascript">
$(document).ready(function() {
  $('#edit').validate(
  {
    rules: {
      credit_limit: {
        required: true
      },
      outstanding_over: {
        required: true
      }
    },
    messages: {
      credit_limit: "input credit_limit",
      outstanding_over: "input outstanding over"
    }
  });
});
</script>
<!-- end of edit customer -->

        </td>
      </tr>
    <?php
      $no++;
      }
    ?>

      <tr>
        <td colspan="6">
          <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
        </td>
      </tr>
    </tbody> 
  </table>

  <?php
    } else {
  ?>
  
  <table class="table table-bordered table-striped"> 
    <thead> 
      <tr>
        <th width="33">No.</th>
        <th width="300">Customer</th>
        <th width="150">Sales</th>
        <th width="150">Credit Limit</th>
        <th width="100">Outstanding Over</th>
        <th width="33">#</th>
      </tr>
    </thead> 
    
    <tbody> 
      <td colspan="6" align="center">No Data Available</td>    
    </tbody>
  </table>    
  <?php } ?>

</div>
</div>
</section>
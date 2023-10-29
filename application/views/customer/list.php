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
  <table id="mytable" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr style="background-color: #3c8dbc; color: #fff;">
        <th width="33">No.</th>
	<th width="90">Netsuite ID</th> 
        <th>Customer Name</th>
        <th>Sales Rep</th>
        <th>Master Credit Limit</th>
        <th>Master Terms</th>
        <th>Credit Limit</th>
        <th>Balance</th>
        <th>Over Under</th>
        <th width="33">#</th>
      </tr>
    </thead>

    <tbody> 
    <?php
      foreach($name->result() as $baris){
        $credit_limit=0;
        $total=0;
    ?>
      <tr>
        <td><?php echo $no; ?></td>
	<td><?php echo $baris->id_netsuite;?></td>
        <td><a href="<?php echo site_url();?>/customer/customer_profile/<?php echo $baris->id_internal; ?>"><?php echo $baris->companyname;?><?php echo $baris->firstname;?> <?php echo $baris->middlename;?> <?php echo $baris->lastname;?></td>
        <td><?php echo $baris->salesrepname;?></td>
        <td><?php echo number_format($baris->master_credit_limit,2,'.',',');?></td>
        <td><?php echo $baris->outstanding_over;?></td>
        <td><?php foreach($data->result() as $row){if($baris->id_internal==$row->id_internal){ $credit_limit = $row->credit_limit; echo number_format($credit_limit,2,'.',',');}} ?></td>
        <td><?php echo number_format($baris->balance,2,'.',',');?></td>
        <td>
          <?php
            $selisih = $credit_limit-$baris->balance;
            if ($selisih < 0)
            {
              $print_number = "<span style='color:red;'>(".str_replace('-', '', number_format ($selisih, 2, ".", ",")) . ")</span>"; 
            }else{ 
              $print_number = number_format ($selisih, 2, ".", ",") ; 
            }
            if($print_number!='0')
            {
              echo $print_number;
            }
          ?>
        </td>
        <td>
          <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#edit<?php echo $baris->id_internal;?>"><span class="fa fa-pencil"></span></a>

<!-- Edit Customer -->
<div class="modal fade" id="edit<?php echo $baris->id_internal;?>" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Edit Customer</h3>
      </div>
      <div class="modal-body form">
      <form name="form-validate" id="edit" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/customer/edit_customer/<?php echo $baris->id_internal;?>">
          <div class="form-body">
            <div class="form-group form-group-sm">
              <label class="control-label col-sm-4">Master Credit Limit</label>
              <div class="col-sm-6">
                <input data-a-dec="." data-a-sep="," name="master_credit_limit" placeholder="Input Master Credit Limit" class="master_credit_limit form-control" value="<?php echo $baris->master_credit_limit;?>" required>
              </div>
            </div>

            <div class="form-group form-group-sm">
              <label class="control-label col-sm-4">Master Terms</label>
              <div class="col-sm-6">
                <input name="outstanding_over" placeholder="Input Master Term" class="form-control" value="<?php echo $baris->outstanding_over;?>" required>
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
  $('.master_credit_limit').autoNumeric();
</script>

<script type="text/javascript">
$(document).ready(function() {
  $('#edit').validate(
  {
    rules: {
      master_credit_limit: {
        required: true
      },
      outstanding_over: {
        required: true
      }
    },
    messages: {
      master_credit_limit: "input master credit limit",
      outstanding_over: "input master terms"
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
        <td colspan="10">
          <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
        </td>
      </tr>
    </tbody> 
  </table>

  <?php
    } else {
  ?>
  <div class="box-body">
  <table id="mytable" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead> 
      <tr style="background-color: #3c8dbc; color: #fff;">
        <th width="33">No.</th>
	      <th width="90">Netsuite ID</th> 
        <th>Customer Name</th>
        <th>Sales Rep</th>
        <th>Master Credit Limit</th>
        <th>Master Terms</th>
        <th>Credit Limit</th>
        <th>Balance</th>
        <th>Over Under</th>
        <th width="33">#</th>
      </tr>
    </thead> 
    
    <tbody> 
      <td colspan="10" align="center">No Data Available</td>    
    </tbody>
  </table>
</div>    
  <?php } ?>

</div>
</div>
</section>

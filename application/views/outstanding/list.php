<?php
  $id_role = $this->session->userdata('id_role');
?>

<style type="text/css">
  #scrolltable {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<section class="content-header">
  <h1>OUTSTANDING AR</h1>
    <ol class="breadcrumb">
      <form name="cari" action="<?php echo site_url() ?>/outstanding" method="GET">
      <div class="input-group input-group-sm">
          <select name="cust" class="form-control select2" style="width: 300px">
            <option value="">- Select -</option>
            <?php foreach ($customer->result() as $valc) { ?>
            <option value="<?php echo $valc->id_customer; ?>"><?php if($valc->name_entity!='Pte Ltd' and $valc->name_entity!='Ltd' and $valc->name_entity!='GmbH & Co. KG' and $valc->name_entity!='Other' and $valc->name_entity!='Perseorangan'){ echo $valc->name_entity;}?> <?php echo strtoupper($valc->name_customer);?> <?php if($valc->name_entity=='Pte Ltd' or $valc->name_entity=='Ltd' or $valc->name_entity=='GmbH & Co. KG'){ echo strtoupper($valc->name_entity);}?> - <?php echo $valc->name_user; ?></option>
            <?php } ?>
          </select>
          <div class="btn-group">
            <button class="btn btn-sm btn-primary" type="submit"><span class="fa fa-search"></span></button>
            <?php if($id_role=='11'){ ?>
              <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add</a>
            <?php } ?>
          </div>
      </div>
    </form>
    </ol>

    <ol class="breadcrumb">
      <?php if($id_role=='11'){ ?>
        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Add</a>
      <?php } ?>
    </ol>
</section>
<section class="content">

<div class="box box-primary">
<div class="box-body">
  <?php 
    $per_page = abs($this->input->get('per_page'));
    $no = $per_page + 1;
    if(count($name->result()) > 0) {
  ?>
  <div id="scrolltable">
  <table id="mytable" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr style="background-color: #3c8dbc; color: #fff;">
        <td>#</td>
        <td>Inv. No.</td>
        <td>Customer Name</td>
        <td>Inv. Date</td>
        <td>Receive Date</td>
        <td>TOP</td>
        <td>Due Date</td>
        <td>Inv. Amount</td>
        <td>Outstanding Amount</td>
        <td>Age</td>
        <td>Credit Limit</td>
        <td>Sales</td>
        <td>Area</td>
        <td>SBU</td>
        <td>PO</td>
        <td>Remark</td>
        <td>Current</td>
        <td>1-30</td>
        <td>31-60</td>
        <td>61-90</td>
        <td>91-120</td>
        <td>121-150</td>
        <td>151-180</td>
        <td>181-240</td>
        <td>241-360</td>
        <td>>360</td>
      </tr>
    </thead>

    <tbody> 
    <?php
      foreach($name->result() as $baris){
    ?>
      <tr>
        <td><a class="btn btn-success btn-xs" data-toggle="modal" data-target="#change<?php echo $baris->id_outstanding;?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#submit<?php echo $baris->id_outstanding;?>"><i class="fa fa-exchange"></i></a></td>

<!-- Modal edit outstanding-->
    <div class="modal fade" id="change<?php echo $baris->id_outstanding;?>" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form name="form-validate" id="edit" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/outstanding/edit_outstanding/<?php echo $baris->id_outstanding;?>">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="ModalLabel">EDIT OUTSTANDING AR - <?php echo $baris->invoice_no; ?></h4>
                </div>
              <div class="modal-body">
                <div class="form-group form-group-sm">
                  <label for="id_customer" class="control-label">Customer</label>
                  <div>
                    <select class="form-control select4" name="id_customer" style="width: 100%;" required>
                      <option value="">-- Select --</option>
                      <?php foreach ($customer->result() as $rowc) {
                        if($baris->id_customer==$rowc->id_customer){
                        ?>
                      <option value="<?php echo $rowc->id_customer; ?>" selected><?php if($rowc->name_entity!='Pte Ltd' and $rowc->name_entity!='Ltd' and $rowc->name_entity!='GmbH & Co. KG' and $rowc->name_entity!='Other' and $rowc->name_entity!='Perseorangan'){ echo $rowc->name_entity;}?> <?php echo strtoupper($rowc->name_customer);?> <?php if($rowc->name_entity=='Pte Ltd' or $rowc->name_entity=='Ltd' or $rowc->name_entity=='GmbH & Co. KG'){ echo strtoupper($rowc->name_entity);}?> - <?php echo $rowc->name_user; ?></option>
                    <?php } else{?>
                      <option value="<?php echo $rowc->id_customer; ?>"><?php if($rowc->name_entity!='Pte Ltd' and $rowc->name_entity!='Ltd' and $rowc->name_entity!='GmbH & Co. KG' and $rowc->name_entity!='Other' and $rowc->name_entity!='Perseorangan'){ echo $rowc->name_entity;}?> <?php echo strtoupper($rowc->name_customer);?> <?php if($rowc->name_entity=='Pte Ltd' or $rowc->name_entity=='Ltd' or $rowc->name_entity=='GmbH & Co. KG'){ echo strtoupper($rowc->name_entity);}?> - <?php echo $rowc->name_user; ?></option>
                      <?php }} ?>
                    </select>
                  </div>   
                </div>

                <div class="form-group form-group-sm">
                  <label for="po_number" class="control-label">PO No.</label>
                      <input type="text" class="form-control" name="po_number" placeholder="Input PO Number" value="<?php echo $baris->po_number;?>" autocomplete="off">
                </div>

                <div class="form-group form-group-sm">
                  <label for="invoice_no" class="control-label">Invoice No.</label>
                      <input type="text" class="form-control" name="invoice_no" placeholder="Input Invoice Number" value="<?php echo $baris->invoice_no;?>" autocomplete="off" required>
                </div>

                <div class="form-group form-group-sm">
                  <label for="invoice_date" class="control-label">Invoice Date</label>
                      <input id="datepicker1<?php echo $baris->id_outstanding;?>" type="text" name="invoice_date" class="form-control" placeholder="Select Invoice Date" value="<?php echo $baris->invoice_date;?>" required autocomplete='off'>
                </div>

                <div class="form-group form-group-sm">
                  <label for="receive_date" class="control-label">Receive Date</label>
                      <input id="datepicker2<?php echo $baris->id_outstanding;?>" type="text" name="receive_date" class="form-control" placeholder="Select Receive Date" value="<?php echo $baris->receive_date;?>" autocomplete='off'>  
                </div>

                <div class="form-group form-group-sm">
                  <label for="invoice_amount" class="control-label">Invoice Amount</label>
                      <input data-a-dec="," data-a-sep="." type="text" class="invoice_amount form-control" name="invoice_amount" placeholder="Input Amount" value="<?php echo $baris->invoice_amount;?>" autocomplete="off" required>
                </div>

                <div class="form-group form-group-sm">
                  <label for="remark" class="control-label">Remark</label>
                      <input type="text" class="form-control" name="remark" placeholder="Input Remark" value="<?php echo $baris->remark;?>" autocomplete="off">
                </div>
              </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="savestate">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
            </form>
          </div>
        </div>
    </div>

<script type="text/javascript">
  $('.invoice_amount').autoNumeric();
  $(document).ready(function() {
    $('#edit').validate({
      rules: {
        id_customer: {
          required: true
        },
        invoice_no: {
          required: true
        },
        invoice_date: {
          required: true
        },
        invoice_amount: {
          required: true
        }
      },
      messages: {
        id_customer: "select customer",
        invoice_no: "input invoice no",
        invoice_date: "select invoice date",
        invoice_amount: "input invoice amount"
      },
      submitHandler : function(form){
        $("#savestate").prop('disabled',true);
        $("#savestate").text('in progress');
        form.submit();
      }
    });
  });
  $(function () {
    //Initialize Select2 Elements
    $('.select4').select2()
  })
</script>

<script>
$(function() {
  $("#datepicker1<?php echo $baris->id_outstanding;?>").datepicker(
  {
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    orientation: 'bottom'
  });
  $("#datepicker2<?php echo $baris->id_outstanding;?>").datepicker(
  {
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    orientation: 'bottom'
  });
});
</script>
<!-- end modal edit outstanding -->

<!-- Modal add payment-->
    <div class="modal fade" id="submit<?php echo $baris->id_outstanding;?>" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form name="form-validate" id="submitpayment" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/outstanding/input_payment/<?php echo $baris->id_outstanding;?>">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="ModalLabel">INPUT PAYMENT - <?php echo $baris->invoice_no; ?></h4>
                </div>
              <div class="modal-body">

                <div class="form-group form-group-sm">
                  <label for="payment_amount" class="control-label">Payment Amount <?php echo $baris->id_outstanding;?></label>
                      <input data-a-dec="," data-a-sep="." type="text" class="payment_amount form-control" name="payment_amount" placeholder="Input Payment" value="<?php echo $baris->outstanding_amount;?>" autocomplete="off" required="">
                </div>

                <div class="form-group form-group-sm">
                  <label for="payment_date" class="control-label">Payment Date</label>
                      <input id="datepicker5<?php echo $baris->id_outstanding;?>" type="text" name="payment_date" class="payment_amount form-control" placeholder="Select Payment Date" autocomplete='off' required="">  
                </div>

                <div class="form-group form-group-sm">
                  <label for="remark" class="control-label">Remark</label>
                      <input type="text" class="form-control" name="remark" placeholder="Input Remark" autocomplete="off">
                </div>
              </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="savestate">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
            </form>
          </div>
        </div>
    </div>

<script type="text/javascript">
  $('.payment_amount').autoNumeric();
  $(document).ready(function() {
    $('#submitpayment').validate({
      rules: {
        payment_amount: {
          required: true
        },
        payment_date: {
          required: true
        }
      },
      messages: {
        payment_amount: "input payment amount",
        payment_date: "select payment date"
      },
      submitHandler : function(form){
        $("#savestate").prop('disabled',true);
        $("#savestate").text('in progress');
        form.submit();
      }
    });
  });
</script>

<script>
$(function() {
  $("#datepicker5<?php echo $baris->id_outstanding;?>").datepicker(
  {
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    orientation: 'bottom'
  });
});
</script>
<!-- end modal add payment -->

        <td><?php echo $baris->invoice_no;?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){if($rowc->name_entity!='Pte Ltd' and $rowc->name_entity!='Ltd' and $rowc->name_entity!='GmbH & Co. KG' and $rowc->name_entity!='Other' and $rowc->name_entity!='Perseorangan'){ echo $rowc->name_entity;}?> <?php echo strtoupper($rowc->name_customer);?> <?php if($rowc->name_entity=='Pte Ltd' or $rowc->name_entity=='Ltd' or $rowc->name_entity=='GmbH & Co. KG'){ echo strtoupper($rowc->name_entity);}}}?></td>
        <td><?php echo date('d/m/Y',strtotime($baris->invoice_date));?></td>
        <td><?php if($baris->receive_date==''){}else{echo date('d/m/Y',strtotime($baris->receive_date));}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->outstanding_over;}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){if($baris->receive_date!=''){$age = date('Y-m-d',strtotime('+'.$rowc->outstanding_over.' days',strtotime($baris->receive_date)));}else{$age = date('Y-m-d',strtotime('+'.$rowc->outstanding_over.' days',strtotime($baris->invoice_date)));} echo date('d/m/Y',strtotime($age));}}?></td>
        <td><?php echo number_format($baris->invoice_amount,0,',','.');?></td>
        <td><?php echo number_format($baris->outstanding_amount,0,',','.');?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); echo $diff->format('%R%a');?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo number_format($rowc->credit_limit,0,',','.');}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->name_user;}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->name_area;}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->alias_company;}}?></td>
        <td><?php echo $baris->po_number;?></td>
        <td><?php echo $baris->remark;?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); if($diff->format('%R%a')<1){echo number_format($baris->outstanding_amount,0,',','.');}?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); if($diff->format('%R%a')>0 and $diff->format('%R%a')<31){echo number_format($baris->outstanding_amount,0,',','.');}?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); if($diff->format('%R%a')>30 and $diff->format('%R%a')<61){echo number_format($baris->outstanding_amount,0,',','.');}?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); if($diff->format('%R%a')>60 and $diff->format('%R%a')<91){echo number_format($baris->outstanding_amount,0,',','.');}?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); if($diff->format('%R%a')>90 and $diff->format('%R%a')<121){echo number_format($baris->outstanding_amount,0,',','.');}?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); if($diff->format('%R%a')>120 and $diff->format('%R%a')<151){echo number_format($baris->outstanding_amount,0,',','.');}?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); if($diff->format('%R%a')>150 and $diff->format('%R%a')<181){echo number_format($baris->outstanding_amount,0,',','.');}?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); if($diff->format('%R%a')>180 and $diff->format('%R%a')<241){echo number_format($baris->outstanding_amount,0,',','.');}?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); if($diff->format('%R%a')>240 and $diff->format('%R%a')<361){echo number_format($baris->outstanding_amount,0,',','.');}?></td>
        <td><?php date_default_timezone_set('Asia/Jakarta'); $today = new DateTime('now'); $day = new DateTime($age); $diff = $day->diff($today); if($diff->format('%R%a')>360){echo number_format($baris->outstanding_amount,0,',','.');}?></td>
      </tr>
    <?php
      $no++;
      }
    ?>

      <tr>
        <td colspan="25">
          <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
        </td>
      </tr>
    </tbody> 
  </table>
</div>

  <?php
    } else {
  ?>
  <div id="scrolltable">
  <table id="mytable" class="table table-bordered table-striped" style="font-size: 12px;">
    <thead> 
      <tr style="background-color: #3c8dbc; color: #fff;">
        <td>Inv. No.</td>
        <td>Customer Name</td>
        <td>Inv. Date</td>
        <td>Receive Date</td>
        <td>TOP</td>
        <td>Due Date</td>
        <td>Inv. Amount</td>
        <td>Outstanding Amount</td>
        <td>Age</td>
        <td>Credit Limit</td>
        <td>Sales</td>
        <td>Area</td>
        <td>SBU</td>
        <td>PO</td>
        <td>Remark</td>
        <td>1-30</td>
        <td>31-60</td>
        <td>61-90</td>
        <td>91-120</td>
        <td>121-150</td>
        <td>151-180</td>
        <td>181-240</td>
        <td>241-360</td>
        <td>>360</td>
      </tr>
    </thead> 
    
    <tbody> 
      <td colspan="25">No Data Available</td>    
    </tbody>
  </table>
  </div>    
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

<!-- Modal add outstanding-->
    <div class="modal fade" id="add" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form name="form-validate" id="addf" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/outstanding/add_outstanding">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <h4 class="modal-title" id="ModalLabel">ADD OUTSTANDING AR</h4>
                </div>
              <div class="modal-body">
                <div class="form-group form-group-sm">
                  <label for="id_customer" class="control-label col-sm-3">Customer</label>
                  <div class="col-sm-8">
                    <select class="form-control select3" name="id_customer" style="width: 100%;" required>
                      <option value="">-- Select --</option>
                      <?php foreach ($customer->result() as $rowc) {?>
                      <option value="<?php echo $rowc->id_customer; ?>"><?php if($rowc->name_entity!='Pte Ltd' and $rowc->name_entity!='Ltd' and $rowc->name_entity!='GmbH & Co. KG' and $rowc->name_entity!='Other' and $rowc->name_entity!='Perseorangan'){ echo $rowc->name_entity;}?> <?php echo strtoupper($rowc->name_customer);?> <?php if($rowc->name_entity=='Pte Ltd' or $rowc->name_entity=='Ltd' or $rowc->name_entity=='GmbH & Co. KG'){ echo strtoupper($rowc->name_entity);}?> - <?php echo $rowc->name_user; ?></option>
                      <?php } ?>
                    </select>
                  </div>   
                </div>

                <div class="form-group form-group-sm">
                  <label for="po_number" class="control-label col-sm-3">PO No.</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="po_number" placeholder="Input PO Number" autocomplete="off">
                    </div>
                </div>

                <div class="form-group form-group-sm">
                  <label for="invoice_no" class="control-label col-sm-3">Invoice No.</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="invoice_no" placeholder="Input Invoice Number" autocomplete="off" required>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                  <label for="invoice_date" class="control-label col-sm-3">Invoice Date</label>
                    <div class="col-sm-8">
                      <input id="datepicker3" type="text" name="invoice_date" class="form-control" placeholder="Select Invoice Date" required autocomplete='off'>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                  <label for="receive_date" class="control-label col-sm-3">Receive Date</label>
                    <div class="col-sm-8">
                      <input id="datepicker4" type="text" name="receive_date" class="form-control" placeholder="Select Receive Date" autocomplete='off'>  
                    </div>
                </div>

                <script>
                  $(function() {
                    $("#datepicker3").datepicker(
                    {
                      format: 'yyyy-mm-dd',
                      autoclose: true,
                      todayHighlight: true,
                      orientation: 'bottom'
                    });
                    $("#datepicker4").datepicker(
                    {
                      format: 'yyyy-mm-dd',
                      autoclose: true,
                      todayHighlight: true,
                      orientation: 'bottom'
                    });
                  });
                  </script>

                <div class="form-group form-group-sm">
                  <label for="invoice_amount" class="control-label col-sm-3">Invoice Amount</label>
                    <div class="col-sm-8">
                      <input data-a-dec="," data-a-sep="." type="text" class="invoice_amount form-control" name="invoice_amount" placeholder="Input Amount" autocomplete="off" required>
                    </div>
                </div>

                <div class="form-group form-group-sm">
                  <label for="remark" class="control-label col-sm-3">Remark</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="remark" placeholder="Input Remark" autocomplete="off">
                    </div>
                </div>

                <script type="text/javascript">
                  $('.invoice_amount').autoNumeric();
                  $(document).ready(function() {
                    $('#addf').validate({
                      rules: {
                        id_customer: {
                          required: true
                        },
                        invoice_no: {
                          required: true
                        },
                        invoice_date: {
                          required: true
                        },
                        invoice_amount: {
                          required: true
                        }
                      },
                      messages: {
                        id_customer: "select customer",
                        invoice_no: "input invoice no",
                        invoice_date: "select invoice date",
                        invoice_amount: "input invoice amount"
                      },
                      submitHandler : function(form){
                        $("#savestate").prop('disabled',true);
                        $("#savestate").text('in progress');
                        form.submit();
                      }
                    });
                  });
                  $(function () {
                    //Initialize Select2 Elements
                    $('.select3').select2()
                  });
                </script>
              </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="savestate">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
            </form>
          </div>
        </div>
    </div>

<!-- end modal add outstanding -->
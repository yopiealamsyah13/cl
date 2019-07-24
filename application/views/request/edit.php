<script>
    tinymce.init({selector:'textarea', menubar:false, statusbar:false, toolbar:false});
</script>

<?php 
  $baris = $data->row();
  $id_role = $this->session->userdata('id_role');
?>

<section class="content-header">
  <h1>EDIT REQUEST <?php echo '- [id: '.$baris->id_request.']'; ?></h1>
</section>
<section class="content">
<div class="box box-primary">
        <form name="form-validate" id="engine" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo site_url(); ?>/request/edit_request/<?php echo $baris->id_request;?>/<?php echo $baris->id_customer;?>">
        <div class="box-body">

          <div class="form-group form-group-sm">
            <label for="id_customer" class="col-sm-2 control-label">Customer :</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo $customer->row()->name_customer;?>" disabled>
              </div>
          </div>

          <?php if($id_role!='10'){?>
          <div class="form-group form-group-sm">
            <label for="credit_limit" class="col-sm-2 control-label">Credit Limit :</label>
              <div class="col-sm-4">
                <input data-a-dec="," data-a-sep="." type="text" class="credit_limit form-control" name="credit_limit" value="<?php echo $baris->credit_limit;?>" placeholder="Input Credit Limit">
              </div>
          </div>

          <div class="form-group form-group-sm">
            <label for="max_top" class="col-sm-2 control-label">Max Outstanding Days :</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="max_top" value="<?php echo $baris->max_top;?>" placeholder="Input TOP">
              </div>
          </div>
          <?php }else{?>
            <input type="hidden" name="credit_limit" value="<?php echo $baris->credit_limit;?>">
            <input type="hidden" name="max_top" value="<?php echo $baris->max_top;?>">
          <?php }?>

          <?php if($id_role=='10' or $id_role=='1'){?>
          <div class="form-group form-group-sm">
            <label for="top" class="col-sm-2 control-label">TOP :</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="top" value="<?php echo $baris->top;?>" placeholder="Input TOP">
              </div>
          </div>

          <div class="form-group form-group-sm">
            <label for="po_amount" class="col-sm-2 control-label">PO Amount :</label>
              <div class="col-sm-4">
                <input data-a-dec="," data-a-sep="." type="text" class="po_amount form-control" name="po_amount" value="<?php echo $baris->po_amount;?>" placeholder="Input Amount">
              </div>
          </div>

          <div class="form-group">
            <label for="requested_note" class="col-sm-2 control-label">Note :</label>
              <div class="col-sm-4">
                <textarea rows="5" class="form-control" name="requested_note"><?php echo $baris->requested_note;?></textarea>
              </div>
          </div>
          <?php }else{?>
            <input type="hidden" name="top" value="<?php echo $baris->top;?>">
            <input type="hidden" name="po_amount" value="<?php echo $baris->po_amount;?>">
            <input type="hidden" name="requested_note" value="<?php echo $baris->requested_note;?>">
          <?php }?>

        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-xs btn-primary">Submit</button>
          <button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo site_url() ?>/request/view_request/<?php echo $baris->id_request;?>/<?php echo $baris->id_customer;?>'; return false;">Cancel</button>
        </div>
        </form>
    </div>
</div>
</section>

<script type="text/javascript">
  $('.credit_limit').autoNumeric();
  $('.po_amount').autoNumeric();
</script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>
<section class="content-header">
  <h1>ADD REQUEST</h1>
</section>
<section class="content">
  <div class="box box-primary">
        <form name="form-validate" id="addreq" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo site_url(); ?>/request/add_request">
        <div class="box-body">

        <div class="col-md-6">
          <div class="form-group form-group-sm">
            <label for="credit_limit" class="col-sm-2 control-label">Status :</label>
              <div class="col-sm-10">
                <div class="radio">
                  <label>
                    <input type="radio" name="status_customer" checked id="yes-top">
                      New
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="status_customer" id="no-top">
                      Existing
                  </label>
                </div>
              </div>
          </div>

          <div class="form-group form-group-sm">
            <label for="id_customer" class="col-sm-2 control-label">Customer :</label>
            <div class="col-sm-10">
              <select class="form-control select2" name="id_customer" style="width: 100%;">
                <option value="">-- Select --</option>
                <?php foreach ($customer->result() as $rowc) {?>
                <option value="<?php echo $rowc->id_customer; ?>"><?php echo strtoupper($rowc->name_customer); ?> - <?php echo $rowc->name_user;?></option>
                <?php } ?>
              </select>
            </div>   
          </div>
          <span class="help-block"><?php echo form_error('id_customer');?></span>

          <div id="top" class="form-group form-group-sm">
            <label for="top" class="col-sm-2 control-label">TOP :</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="top" placeholder="Input TOP" autocomplete="off">
              </div>
          </div>
          <span class="help-block"><?php echo form_error('top');?></span>

          <div class="form-group form-group-sm">
            <label for="po_amount" class="col-sm-2 control-label">PO Amount :</label>
              <div class="col-sm-10">
                <input data-a-dec="," data-a-sep="." type="text" class="po_amount form-control" name="po_amount" placeholder="Input Amount" autocomplete="off">
              </div>
          </div>
          <span class="help-block"><?php echo form_error('po_amount');?></span>

          <div class="form-group">
            <label for="requested_note" class="col-sm-2 control-label">Note :</label>
              <div class="col-sm-10">
                <textarea rows="5" class="form-control" name="requested_note"></textarea>
              </div>
          </div>
          <span class="help-block"><?php echo form_error('requested_note');?></span>
        </div>

        <div class="col-md-6">
          <div class="form-group form-group-sm">
            <label for="file" class="col-sm-2 control-label">File :</label>
              <div class="col-sm-10">
                <div>
                  <input type="file" class="files form-control" name="files[]" multiple>
                </div>
              </div>
          </div>
        </div>

        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-xs btn-primary" id="save">Submit</button>
          <button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo site_url() ?>/request'; return false;">Cancel</button>
        </div>
        </form>
  </div>
</section>

<script type="text/javascript">

  $('#no-top').click(function(){
    $('#top').hide();
    $('input[name=top]').val('');
  });
  
  $('#yes-top').click(function(){
    $('#top').show()
  });

  $('.po_amount').autoNumeric();
</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>

<script>
$(document).ready(function() {
  $(".files").fileinput({
      theme: "fa",
      hideThumbnailContent: false, //memunculkan thumbnail file
      allowedFileExtensions: ['jpg','png','jpeg','pdf','xls','xlsx'], //file extensi yang di izinkan
      initialPreviewAsData: true, //
      browseClass: "btn btn-success btn-block", //css class padd button browse
        showCaption: false, //menghilangkan caption
        showRemove: false, //menghilangkan button hapus
    showUpload: false, // menghilangkan button upload
        fileActionSettings: {
      showRemove: true, //memunculkan button hapus pada thumbnail
      showUpload: false // menghilangkan button upload pada thumbnail
    },
      
      maxFileCount : 5, //maksimum jumlah file upload
        uploadUrl: "<?php echo base_url('myfile'); ?>", // url folder tempat penyimpanan file
  });
});
</script>
<?php
$baris = $data->row();
$id_user = $this->session->userdata('id');
$id_role = $this->session->userdata('id_role');
?>

<!--<script>
    tinymce.init({selector:'textarea', menubar:false, statusbar:false, toolbar:false});
</script>-->

<style type="text/css">
  ul.dropdown-menu-kanan{
    left: -138%;
    position: absolute;
  }

  .dropdown{
    position:relative;
    display: inline-block;
  }
</style>

<section class="content-header">
<h1><b><?php echo strtoupper($customer->row()->id_netsuite);?></b> <?php echo $customer->row()->companyname." ".$customer->row()->firstname." ".$customer->row()->middlename." ".$customer->row()->lastname;?></h1>
</section>
<section class="content">
<div class="row">
  <div class="col-sm-9">
    <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-body">
          <div class="pull-right">
            <a data-toggle="modal" href="#approvemodal" id="approve" type="button" class="btn btn-primary btn-sm <?php if($baris->id_request_status=='6' or $baris->id_request_status=='5' or $baris->id_request_status=='7'){echo "hidden";}?>">Approve</a>
            <div class="btn-group">
              <a type="button" class="btn btn-primary btn-sm" <?php if($baris->id_request_status!='3' and $baris->id_request_status!='5' and $baris->id_request_status!='7'){?>href="<?php echo site_url(); ?>/request/edit_request/<?php echo $baris->id_request; ?>/<?php echo $baris->id_internal;?>"<?php }?> <?php if($baris->id_request_status=='3' or $baris->id_request_status=='5' or $baris->id_request_status=='7'){echo "disabled";}?>>Edit</a>
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-kanan" role="menu">
                  <?php if($id_role!='10' && $id_role!='12'){ ?>
                  <li><a data-toggle="modal" href="#change<?php echo $baris->id_request;?>"><i class="fa fa-exchange"></i>Change State</a></li>
                <?php }?>
                  <?php if($baris->id_request_status!='7'){?>
                  <li><a data-toggle="modal" href="#attach<?php echo $baris->id_request;?>"><i class="fa fa-file-o"></i>Attach File</a></li>
                  <li><a href="<?php echo site_url(); ?>/request/delete_request/<?php echo $baris->id_request; ?>/<?php echo $baris->id_internal; ?>" onClick='return confirm("Are you sure?")'><i class="fa fa-trash"></i>Delete</a></li>
                  <?php }?>
                </ul>
            </div>
          </div>
          <b><i>Description</i></b>
          <p><?php echo $baris->requested_note;?></p>
          <br>
          <p><b><i>Request & CL Information</i></b></p>
          <table class="table table-bordered" style="background-color: #e5e5e5">
            <tr>
              <td align="center" width="33%"><b>PO Amount</b><br>IDR <?php echo number_format($baris->po_amount,2,'.',',');?></td>
              <td align="center" width="33%"><b>Credit Limit</b><br>IDR <?php echo number_format($baris->credit_limit,2,'.',',');?></td>
              <td align="center" width="33%"><b>Terms</b><br><?php echo $baris->term_description;?></td>
            </tr>
          </table>
          <br>
          <table class="table table-bordered" style="background-color: #e5e5e5">
            <tr>
              <td align="center" width="50%"><b>Master Credit Limit</b><br>IDR <?php echo number_format($customer->row()->master_credit_limit,2,'.',',');?></td>
              <td align="center" width="50%"><b>Master Terms</b><br>Net <?php echo $customer->row()->outstanding_over;?></td>
            </tr>
          </table>
          <br>
          <p><b><i>AR Information</i></b></p>
          <table class="table table-bordered" style="background-color: #e5e5e5">
            <tr>
              <td align="center" width="50%"><b>Balance</b><br>IDR <?php echo number_format($customer->row()->balance,2,'.',',');?></td>
              <td align="center" width="50%"><b>Overdue Balance</b><br>IDR <?php echo number_format($customer->row()->overdue_balance,2,'.',',');?></td>
            </tr>
          </table>
          <br>
          <p><b><i>Attachment</i></b></p>
          <?php 
            if(count($file->result()) > 0) {
          ?>
          <?php
            foreach($file->result() as $rowf){
          ?>
          <p>
            <a href="<?php echo base_url();?>myfile/<?php echo $rowf->file_name; ?>" target="_blank"><i class="fa fa-paperclip"></i> <?php echo $rowf->file_name;?> <i><?php if($rowf->status_confidential=='1'){echo " <i class='fa fa-lock'></i>";} ?></i></a>
            <?php if($baris->id_request_status!='7'){ ?>
            <span class="text-muted pull-right"><a href="<?php echo site_url(); ?>/request/delete_attachment/<?php echo $baris->id_request; ?>/<?php echo $rowf->id_request_file; ?>/<?php echo $rowf->file_name; ?>/<?php echo $baris->id_internal; ?>" onClick='return confirm("Are you sure?")'><i class="fa fa-trash"></i></a></span>
            <?php } ?>
          </p>
          <?php }?>
          <?php } else {echo "No Attachment";} ?>
        </div>
      </div>
    </div>
    
    <div class="col-sm-12">
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <h4><b>COMMENT</b></h4>
              </div>
              <!-- /.user-block -->
            </div>
            <!-- /.box-header -->

            <div class="box-footer box-comments">
              <?php 
                if(count($comment->result()) > 0) {
              ?>
              <?php foreach($comment->result() as $rowc){ ?>
              <div class="box-comment">
                <!-- User image -->
                <img class="img-circle img-sm" src="<?php echo base_url(); ?>assets/photo/<?php foreach($user->result() as $rowu){if($rowc->id_user==$rowu->id){echo $rowu->photo;}}?>">
                <div class="comment-text">
                      <span class="username">
                        <?php foreach($user->result() as $rowu){if($rowc->id_user==$rowu->id){echo $rowu->name_user;}}?>
                        <span class="text-muted pull-right">
                          <?php 
                            date_default_timezone_set('Asia/Jakarta');
                            $now = new DateTime('now');  //mengambil tanggal sekarang
                            $datec = new DateTime($rowc->date_comment); //mengambil tanggal data di input
                            $diff = $now->diff($datec);
                           
                                if($diff->format('%a')>2){ //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 2 dengan format hari
                                  echo date('d M y',strtotime($rowc->date_comment))." at ".date('H:i',strtotime($rowc->date_comment));
                                }elseif($diff->format('%a')>=1){ //jika perbedaan antara tanggal data diinput dan dibutuhkan tidak lebih dari 1 hari yang lalu
                                  echo 'yesterday at '.date('H:i',strtotime($rowc->date_comment));
                                }elseif($diff->format('%h')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format jam
                                  echo $diff->format('%h hrs ago');
                                }elseif($diff->format('%i')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format menit
                                  echo $diff->format('%i mins ago');
                                }elseif($diff->format('%s')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format menit
                                  echo $diff->format('%s secs ago');
                                }
                          ?>
                          <?php if($baris->id_request_status!='7'){ ?>
                          <?php if($rowc->id_user==$id_user){?><a href="<?php echo site_url(); ?>/request/delete_comment/<?php echo $baris->id_request; ?>/<?php echo $rowc->id_comment; ?>/<?php echo $baris->id_internal; ?>" onClick='return confirm("Are you sure?")'><i class="fa fa-trash"></i></a><?php }}?></span>
                      </span><!-- /.username -->
                  <?php if($rowc->status_confidential=='1'){?><i class="fa fa-lock"></i><?php } ?> <?php echo $rowc->note_comment; ?>
                </div>
                <!-- /.comment-text -->
              </div>
              <!-- /.box-comment -->
              <?php } ?>
              <?php } else {?>
                No Comment
              <?php } ?>

            </div>
            <?php if($baris->id_request_status!='7'){ ?>
            <!-- /.box-footer -->
            <div class="box-footer">
              <form name="form-validate" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo site_url(); ?>/request/add_comment/<?php echo $baris->id_request; ?>/<?php echo $baris->id_internal; ?>/<?php echo $baris->id_request_status; ?>">
                <img class="img-responsive img-circle img-sm" src="<?php echo base_url(); ?>assets/photo/<?php echo $this->acl->get_user()->photo;?>">
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                  <div class="input-group input-group-sm">
                    <input type="text" class="form-control input-sm" name="note_comment" placeholder="Write your comment here" autocomplete="off">
                    <input type="hidden" name="status_confidential" value="0">
                    <?php if($id_role!='10'){?>
                    <span class="input-group-addon">
                      <input type="checkbox" name="status_confidential" value="1"> Confidential
                    </span>
                    <?php } ?>
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary btn-flat">Send</button>
                    </span>
              </div>
                </div>
              </form>
            </div>
            <!-- /.box-footer -->
            <?php } ?>
          </div>
          <!-- /.box -->
        </div>
  </div>

  <div class="col-sm-3">
    <div class="box box-primary">
      <div class="box-body">
        <p><b>State</b><br><span class="label bg-<?php if($baris->id_request_status=='1'){echo "gray";}elseif($baris->id_request_status=='2'){echo "red";}elseif($baris->id_request_status=='3'){echo "orange";}elseif($baris->id_request_status=='4'){echo "yellow";}elseif($baris->id_request_status=='5'){echo "green";}elseif($baris->id_request_status=='6'){echo "red";}elseif($baris->id_request_status=='7'){echo "black";}elseif($baris->id_request_status=='8'){echo "blue";}?>"><?php foreach($status->result() as $rows){if($baris->id_request_status==$rows->id_request_status){ echo $rows->name_request_status;}}?></span></p>
        <p><b>Created</b><br><?php echo date('d/m/Y g:i a',strtotime($baris->requested_date));?></p>
        <p><b>Last Update</b><br><?php if($baris->update_date!=0){ echo date('d/m/Y g:i a',strtotime($baris->update_date));}else{echo "-";}?></p>
        <p><b>Requested by</b><br><?php foreach($user->result() as $rowu){if($baris->id_user==$rowu->id){echo $rowu->name_user;}}?></p>
        <p><b>Sales</b><br><?php echo $customer->row()->salesrepname;?></p>
	<p><b>ID Request</b><br><?php echo $baris->id_request;?></p>
      </div>
    </div>
  </div>
</div>
<div class="row">

        <div class="col-sm-9">
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <h4><b>HISTORY</b></h4>
              </div>
              <!-- /.user-block -->
            </div>
            <!-- /.box-header -->

            <div class="box-footer box-comments">
              
              <div class="box-comment">
                    <!-- row -->
                    <div class="row">
                      <div class="col-md-12">
                        <!-- The time line -->
                        <ul class="timeline">
                          <!-- timeline item -->
                          <?php 
                            if(count($timeline->result()) > 0) {
                          ?>
                          <?php foreach($timeline->result() as $rowt){ ?>
                          <li>
                            <i class="fa fa-user bg-green"></i>
                            <div class="timeline-item">
                              <span class="time"><i class="fa fa-clock-o"></i>
                                <?php 
                                  date_default_timezone_set('Asia/Jakarta');
                                  $now = new DateTime('now');  //mengambil tanggal sekarang
                                  $dates = new DateTime($rowt->date_timeline); //mengambil tanggal data di input
                                  $diff = $now->diff($dates);
                                 
                                      if($diff->format('%a')>2){ //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 2 dengan format hari
                                        echo date('d M y',strtotime($rowt->date_timeline))." at ".date('H:i',strtotime($rowt->date_timeline));
                                      }elseif($diff->format('%a')>=1){ //jika perbedaan antara tanggal data diinput dan dibutuhkan tidak lebih dari 1 hari yang lalu
                                        echo 'yesterday at '.date('H:i',strtotime($rowt->date_timeline));
                                      }elseif($diff->format('%h')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format jam
                                        echo $diff->format('%h hrs ago');
                                      }elseif($diff->format('%i')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format menit
                                        echo $diff->format('%i mins ago');
                                      }elseif($diff->format('%s')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format menit
                                        echo $diff->format('%s secs ago');
                                      }
                                ?>
                              </span>
                                <h5 class="timeline-header no-border"><b><?php echo $rowt->name_user;?></b> <?php if($rowt->id_request_status=='1'){echo "create <b>".$rowt->name_request_status."</b> request";}else{echo "change state to <b>".$rowt->name_request_status."</b>";} ?></h5>
                            </div>
                          </li>
                          <?php } ?>
                          <?php } else {?>
                            <li>No Information</li>
                          <?php } ?>
                          <!-- END timeline item -->
                        </ul>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
              </div>
              <!-- /.box-comment -->
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>

</section>

<!-- Modal upload attachment-->
    <div class="modal fade" id="attach<?php echo $baris->id_request;?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="ModalLabel">Attach File</h4>
                </div>
            <form name="form-validate" id="close" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/request/add_attachment/<?php echo $baris->id_request;?>/<?php echo $baris->id_internal; ?>">

            <div class="modal-body">
              <div class="form-group form-group-sm">
                <label for="file_upload" class="col-sm-3 control-label">Select File :</label>
                  <div class="col-sm-6">
                    <input type="file" class="form-control" name="file_upload">
                  </div>
              </div>
              
              <div class="form-group form-group-sm">
                <label for="status_confidential" class="col-sm-3 control-label"></label>
                  <div class="col-sm-6">
                    <input type="hidden" name="status_confidential" value="0">
                    <input type="checkbox" name="status_confidential" value="1"> Confidential
                  </div>
              </div>

              <?php    
                if (isset($error)):
                echo $error;
                endif;
              ?>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
            </form>
          </div>
        </div>
    </div>

<script type="text/javascript">
$(document).ready(function() {
  $('#close').validate(
  {
    rules: {
      file_upload: {
        required: true
      }
    },
    messages: {
      file_upload: "select file"
    }
  });
});
</script>
<!-- end modal upload attachment -->

<!-- Modal change state-->
    <div class="modal fade" id="change<?php echo $baris->id_request;?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true"  data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="ModalLabel">CHANGE STATE</h4>
                </div>
            <form name="form-validate"  id="changestate" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/request/change_state/<?php echo $baris->id_request;?>/<?php echo $baris->id_internal;?>">
                <div class="modal-body">
                  <div class="form-group form-group-sm">
                    <label for="id_request_status" class="col-sm-3 control-label">State :</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="id_request_status" required>
                        <?php foreach ($status_closed->result() as $rows) {
                          if($baris->id_request_status==$rows->id_request_status){
                        ?>
                        <option value="<?php echo $rows->id_request_status; ?>" selected><?php echo $rows->name_request_status; ?></option>
                      <?php } else {?>
                        <option value="<?php echo $rows->id_request_status; ?>"><?php echo $rows->name_request_status; ?></option>
                        <?php }} ?>
                      </select>
                    </div>   
                  </div>
                  <input type="hidden" name="id_internal" value="<?php echo $baris->id_internal;?>">
                  <input type="hidden" name="creditlimit" value="<?php echo $baris->credit_limit;?>">
                  <div class="form-group form-group-sm">
                    <label for="note_comment" class="col-sm-3 control-label">Note :</label>
                      <div class="col-sm-8">
                        <textarea rows="5" class="form-control" name="note_comment" required></textarea>
                      </div>
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
<!-- end modal change state -->

<!-- Modal Approve-->
<div class="modal fade" id="approvemodal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true"  data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="ModalLabel">APPROVE</h4>
                </div>
            <form name="form-validate" id="approveform" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/request/approve/<?php echo $baris->id_request;?>/<?php echo $baris->id_internal;?>">
                <div class="modal-body">
                  <input type="hidden" name="id_internal" value="<?php echo $baris->id_internal;?>">
                  <input type="hidden" name="creditlimit" value="<?php echo $baris->credit_limit;?>">
                  <div class="form-group form-group-sm">
                    <label for="note_comment" class="col-sm-3 control-label">Note :</label>
                      <div class="col-sm-8">
                        <textarea rows="5" class="form-control" name="note_comment" required></textarea>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="savesapprove">Save</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
          </div>
        </div>
    </div>
<!-- end modal approve -->
<?php if ($this->session->flashdata('success')){ ?>
<script>
  swal("Success", "Update CL to NETSUITE success!", "success");
</script>
<?php } ?>
<?php if($this->session->flashdata('failed')){ ?>
<script>
  swal("Error", "Error update CL to NETSUITE !", "error");
</script>
<?php } ?>

<script type="text/javascript">
  $(document).ready(function() {
    $('#changestate').validate({
      rules: {
        id_request_status: {
          required: true
        },
        note_comment: {
          required: true
        }
      },
      messages: {
        id_request_status: "select state",
        note_comment: "input note"
      },
      submitHandler : function(form){
        $("#savestate").prop('disabled',true);
        $("#savestate").text('in progress');
        form.submit();
      }
    });
  });

  
  $(document).ready(function() {

  $('#approveform').validate({
      rules: {
        note_comment: {
          required: true
        }
      },
      messages: {
        note_comment: "input note"
      },
      submitHandler : function(form){
        $("#savesapprove").prop('disabled',true);
        $("#savesapprove").text('in progress');
        form.submit();
      }
    });
  });
</script>
<!-- end modal change state -->

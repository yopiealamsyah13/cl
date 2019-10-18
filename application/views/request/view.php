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

  .scroll-comment{
    max-height:320px;
    overflow-y:auto;
    display:flex;
    flex-direction:column-reverse;
  }
</style>

<section class="content-header">
<h1>[<?php echo $baris->id_request;?>] <?php if($customer->row()->name_entity!='Pte Ltd' and $customer->row()->name_entity!='Ltd' and $customer->row()->name_entity!='GmbH & Co. KG' and $customer->row()->name_entity!='Other' and $customer->row()->name_entity!='Perseorangan'){ echo $customer->row()->name_entity;}?> <?php echo strtoupper($customer->row()->name_customer);?> <?php if($customer->row()->name_entity=='Pte Ltd' or $customer->row()->name_entity=='Ltd' or $customer->row()->name_entity=='GmbH & Co. KG'){ echo strtoupper($customer->row()->name_entity);}?> <?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){if($rowc->status_existing=='1'){?><i class="fa fa-check text-success"></i><?php }}}?></h1>
</section>
<section class="content">
<div class="row">
  <div class="col-sm-9">
    <div class="box box-primary">
      <div class="box-body">
        <div class="pull-right">
          <div class="btn-group">
            <a type="button" class="btn btn-primary btn-sm" <?php if($baris->id_request_status!='3' and $baris->id_request_status!='5' and $baris->id_request_status!='7'){?>href="<?php echo site_url(); ?>/request/edit_request/<?php echo $baris->id_request; ?>/<?php echo $baris->id_customer;?>"<?php }?> <?php if($baris->id_request_status=='3' or $baris->id_request_status=='5' or $baris->id_request_status=='7'){echo "disabled";}?>>Edit</a>
              <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-kanan" role="menu">
                <?php if($id_role!='10'){ ?>
                <li><a data-toggle="modal" href="#change<?php echo $baris->id_request;?>"><i class="fa fa-exchange"></i>Change State</a></li>
              <?php }?>
                <?php if($baris->id_request_status!='7'){?>
                <li><a data-toggle="modal" href="#attach<?php echo $baris->id_request;?>"><i class="fa fa-file-o"></i>Attach File</a></li>
                <li><a href="<?php echo site_url(); ?>/request/delete_request/<?php echo $baris->id_request; ?>/<?php echo $baris->id_customer; ?>" onClick='return confirm("Are you sure?")'><i class="fa fa-trash"></i>Delete</a></li>
                <?php }?>
              </ul>
          </div>
        </div>
        <b><i>Description</i></b>
        <p><?php echo $baris->requested_note;?></p>
        <br>
        <p><b><i>Request</i></b></p>
        <table class="table table-bordered" style="background-color: #e5e5e5">
          <tr>
            <td align="center" width="25%"><b>PO Amount</b><br>IDR <?php echo number_format($baris->po_amount,0,',','.');?></td>
            <td align="center" width="25%"><b>TOP</b><br><?php echo $baris->top;?> Days</td>
            <td align="center" width="25%"><b>Credit Limit</b><br>IDR <?php echo number_format($baris->credit_limit,0,',','.');?></td>
            <td align="center" width="25%"><b>Max Outstanding Days</b><br><?php echo $baris->max_top;?> Days</td>
          </tr>
        </table>
        <br>
        <table class="table table-bordered" style="background-color: #e5e5e5">
          <tr>
            <td align="center" width="50%"><b>Master Credit Limit</b><br>IDR <?php echo number_format($customer->row()->credit_limit,0,',','.');?></td>
            <td align="center" width="50%"><b>Master TOP</b><br><?php echo $customer->row()->outstanding_over;?> Days</td>
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
          <a href="<?php echo base_url();?>myfile/<?php echo $rowf->file_name; ?>" target="_blank"><i class="fa fa-paperclip"></i> <?php echo $rowf->file_name;?> <i><?php if($rowf->status_confidential=='1'){echo "[confidential]";} ?></i></a>
          <?php if($baris->id_request_status != '7'){?>
          <span class="text-muted pull-right"><a href="<?php echo site_url(); ?>/request/delete_attachment/<?php echo $baris->id_request; ?>/<?php echo $rowf->id_request_file; ?>/<?php echo $rowf->file_name; ?>/<?php echo $baris->id_customer; ?>" onClick='return confirm("Are you sure?")'><i class="fa fa-trash"></i></a></span>
          <?php } ?>
        </p>
        <?php }?>
        <?php } else {echo "No Attachment";} ?>
      </div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="box box-primary">
      <div class="box-body">
        <p><b>State</b><br><span class="label bg-<?php if($baris->id_request_status=='1'){echo "gray";}elseif($baris->id_request_status=='2'){echo "red";}elseif($baris->id_request_status=='3'){echo "orange";}elseif($baris->id_request_status=='4'){echo "yellow";}elseif($baris->id_request_status=='5'){echo "green";}elseif($baris->id_request_status=='6'){echo "red";}elseif($baris->id_request_status=='7'){echo "black";}?>"><?php foreach($status->result() as $rows){if($baris->id_request_status==$rows->id_request_status){ echo $rows->name_request_status;}}?></span></p>
        <p><b>Created</b><br><?php echo date('d/m/Y g:i a',strtotime($baris->requested_date));?></p>
        <p><b>Last Update</b><br><?php if($baris->update_date!=0){ echo date('d/m/Y g:i a',strtotime($baris->update_date));}else{echo "-";}?></p>
        <p><b>Requested by</b><br><?php foreach($user->result() as $rowu){if($baris->id_user==$rowu->id){echo $rowu->name_user;}}?></p>
        <p><b>Sales / Phone</b><br><?php echo $customer->row()->name_user;?> / <a href="tel:<?php echo $customer->row()->mobile_phone;?>"><?php echo $customer->row()->mobile_phone;?></a></p>
        <p><b>Sales Code</b><br><?php echo $customer->row()->project_code;?></p>
      </div>
    </div>
  </div>
</div>
<div class="row">
        <div class="col-sm-6">
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <h4><b>COMMENT</b></h4>
              </div>
              <!-- /.user-block -->
            </div>
            <!-- /.box-header -->
            <div class="scroll-comment">
            <!-- <div class="box-footer box-comments" id="comment"></div> -->
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
                          <?php if($rowc->id_user==$id_user){?><a href="<?php echo site_url(); ?>/request/delete_comment/<?php echo $baris->id_request; ?>/<?php echo $rowc->id_comment; ?>/<?php echo $baris->id_customer; ?>" onClick='return confirm("Are you sure?")'><i class="fa fa-trash"></i></a><?php }}?></span>
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
            </div>
            <!-- /.box-footer -->
            <?php if($baris->id_request_status!='7'){ ?>
            <!-- /.box-footer -->
            <div class="box-footer">
              <form name="form-validate" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo site_url(); ?>/request/add_comment/<?php echo $baris->id_request; ?>/<?php echo $baris->id_customer; ?>/<?php echo $baris->id_request_status; ?>">
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

          <!-- ajax for comment -->
          <script>
          $(document).ready(function(){
            tampil_comment();

            function tampil_comment()
            {
              var id = '<?php echo $this->uri->segment(3); ?>';
              var idu =  '<?php echo $this->session->userdata("id");?>';
              var ids = '<?php echo $data->row()->id_request_status;?>';
              var now = new Date();
              //setInterval(function(){
                $.ajax({
                type: 'ajax',
                url:'<?php echo site_url("request/get_comm/");?>/'+id,
                async:false,
                dataType:'json',
                success:function(data){
                  var html ='';
                  var now = new Date();
                  for(i=0;i<data.length;i++){
                    var date = new Date(data[i].date_comment),
                        diff_min = Math.floor((now.getTime() - date.getTime())/60000),
                        diff_hrs = Math.floor(diff_min/60);
                    html += '<div class="box-comment">'+
                              '<img class="img-circle img-sm" src="'+'<?php echo base_url("assets/photo/");?>/'+data[i].photo+'">'+
                                '<div class="comment-text">'+
                                  '<span class="username">'+
                                  data[i].name_user+
                                  '<span class="text-muted pull-right"><i>';
                                  if(diff_min <= 60){
                                    html += diff_min+' Mins Ago </i></span>';
                                  }else if(diff_hrs < 24){
                                    html += diff_hrs+' Hrs Ago </i></span>';
                                  }else{
                                    html += data[i].date_comment+'</i></span>';
                                  }
                                html += '</span>'+
                                data[i].note_comment+
                                '<span class="text-muted pull-right">';
                                if(ids != '7'){
                                  if(idu == data[i].id_user){
                                    html += '<a href="javascript:;" class="delete_comment" data="'+data[i].id_comment+'"><i class="fa fa-trash"></i></a></span>';
                                  }
                                }
                                html +='</span>'+
                                '</div>'+
                            '</div>';
                  }
                  $('#comment').html(html);
                }
              });
              //},1000);
            }

            //delete comment
            $('#comment').on('click','.delete_comment',function(){
              var idc = $(this).attr('data');
              if(confirm('Yakin ingin Hapus ?')){
                $.ajax({
                  type:'POST',
                  url:'<?php echo site_url("request/delete_comm_ajax");?>/'+idc,
                  dataType:'json',
                  data:{idc:idc},
                  success:function(data){
                    tampil_comment();
                  },
                  error:function(jqXHR, textStatus, errorThrown){
                    alert('Gagal dihapus !');
                  }
                });
                return false;
              }
            });

            //insert comment
            $('#sav_comment').on('click',function(){
                var idr = '<?php echo $baris->id_request; ?>';
                var idc = '<?php echo $baris->id_customer; ?>';
                var note_comment = $('#note_comment').val();
                var status_confidential = $('#status_confidential').val();
                $.ajax({
                  type:'POST',
                  url:'<?php echo site_url("request/add_comment")?>/'+idr+'/'+idc,
                  dataType:'JSON',
                  data:{note_comment:note_comment,status_confidential:status_confidential},
                  success:function(data){
                    tampil_comment();
                  },
                  error:function(jqXHR, textStatus, errorThrown){
                    alert('Gagal Input Comment');
                  }
                });
            });
          });
          </script>
          <!-- end ajax for comment -->
        </div>

        <div class="col-sm-6">
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
                              <span class="time"><i class="fa fa-clock-o"></i> <?php echo date('d/m/Y g:i a',strtotime($rowt->date_timeline));?></span>
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
             <form name="form-validate" id="close" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/request/add_attachment/<?php echo $baris->id_request;?>/<?php echo $baris->id_customer; ?>">
            <div class="modal-body">
              <div class="form-group">
                <label for="file_upload" class="col-sm-3 control-label">Select File :</label>
                  <div class="col-sm-6">
                    <input type="file" class="form-control" name="file_upload">
                    <p>* Hanya file berupa .pdf/.xls/.xlsx / .jpg </p>
                  </div>
              </div>
              
              <div class="form-group">
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
    <div class="modal fade" id="change<?php echo $baris->id_request;?>" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="ModalLabel">CHANGE STATE</h4>
                </div>
            <form name="form-validate" id="changestate" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/request/change_state/<?php echo $baris->id_request;?>/<?php echo $baris->id_customer;?>">

            <div class="form-group">
              <label for="id_request_status" class="col-sm-3 control-label">State :</label>
              <div class="col-sm-8">
                <select class="form-control" name="id_request_status" required>
                  <?php foreach ($status->result() as $rows) {
                    if($baris->id_request_status==$rows->id_request_status){
                  ?>
                  <option value="<?php echo $rows->id_request_status; ?>" selected><?php echo $rows->name_request_status; ?></option>
                <?php } else {?>
                  <option value="<?php echo $rows->id_request_status; ?>"><?php echo $rows->name_request_status; ?></option>
                  <?php }} ?>
                </select>
              </div>   
            </div>

            <div class="form-group">
              <label for="note_comment" class="col-sm-3 control-label">Note :</label>
                <div class="col-sm-8">
                  <textarea rows="5" class="form-control" name="note_comment" required></textarea>
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
</script>
<!-- end modal change state -->
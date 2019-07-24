<section class="content-header">
  <h1>NOTIFICATIONS</h1>
</section>
<section class="content">
        <!-- Box Comment -->
          <div class="box box-widget">

            <div class="box-footer box-comments">
              <?php 
                $per_page = abs($this->input->get('per_page'));
                $no = $per_page + 1;
                if(count($notification->result()) > 0) {
              ?>
              <?php foreach($notification->result() as $rowc){ ?>
              <div class="box-comment" <?php
                foreach($unread->result() as $key){
                 if($key->notification_id == $rowc->notification_id){ ?>style="background: #c5c5c5;"<?php }} ?>>
                <a href="" class="read" data-value="<?php echo $rowc->notification_id;?>" data-path="<?php echo $rowc->notification_link;?>">
                <!-- User image -->
                <img class="img-circle img-sm" src="<?php echo base_url(); ?>assets/photo/<?php echo $rowc->photo;?>">
                <div class="comment-text">
                  <span class="username">
                    <i><?php echo $rowc->notification_label;?></i>
                  </span><!-- /.username -->
                  <i><small>
                    <?php 
                      date_default_timezone_set('Asia/Jakarta');
                      $now = new DateTime('now');  //mengambil tanggal sekarang
                      $datec = new DateTime($rowc->notification_datetime); //mengambil tanggal data di input
                      $diff = $now->diff($datec);
                           
                      if($diff->format('%a')>2){ //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 2 dengan format hari
                        echo date('d M y',strtotime($rowc->notification_datetime))." at ".date('H:i',strtotime($rowc->notification_datetime));
                      }elseif($diff->format('%a')>=1){ //jika perbedaan antara tanggal data diinput dan dibutuhkan tidak lebih dari 1 hari yang lalu
                        echo 'yesterday at '.date('H:i',strtotime($rowc->notification_datetime));
                      }elseif($diff->format('%h')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format jam
                        echo $diff->format('%h hrs ago');
                      }elseif($diff->format('%i')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format menit
                        echo $diff->format('%i mins ago');
                      }elseif($diff->format('%s')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format menit
                        echo $diff->format('%s secs ago');
                      }
                    ?>
                  </small></i>
                </div>
                <!-- /.comment-text -->
                </a>
              </div>
              <!-- /.box-comment -->
              <?php } ?>
                  <ul class="pagination pagination-sm no-margin pull-right">
                      <li>
                          <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
                      </li>
                  </ul>
              <?php } else {?>
                No Comment
              <?php } ?>

            </div>
          </div>
          <!-- /.box -->
</section>

<script type="text/javascript">
$(document).ready(function(){
    $('.read').click(function(){
        var id_user = parseInt("<?php echo $this->session->userdata('id');?>");
        var date = new Date();
        var notification_id = $(this).data('value');
        var url = $(this).data('path');
        $.ajax({
            method:"POST",
            dataType : "json",
            url : "<?php echo site_url('request/insert_read/')?>/"+notification_id,
            data :{id_notification:notification_id,id_user:id_user,date:date},
            success:function(data){
                window.location.replace(url);
            },
            error:function(jqXHR,textStatus,errorThrown)
            {
                alert('error post data from ajax');
            }
        });
    });
});
</script>
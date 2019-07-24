<?php
foreach ($data as $row) {
    ?>
     <li <?php 
     foreach($unread->result() as $key){
     if($key->notification_id == $row->notification_id){ ?>style="background: #c5c5c5;"<?php }} ?>>
        <a class="read" href="" data-value="<?php echo $row->notification_id;?>" data-path="<?php echo $row->notification_link;?>">
            <img class="img-circle img-sm" src="<?php echo base_url(); ?>assets/photo/<?php echo $row->photo;?>"> 
            <i><?php echo $row->notification_label;?></i><br>
            <i><small>
            <?php 
            date_default_timezone_set('Asia/Jakarta');
            $now = new DateTime('now');  //mengambil tanggal sekarang
            $date = new DateTime($row->notification_datetime); //mengambil tanggal data di input
            $diff = $now->diff($date);
                
            if($diff->format('%a')>2){ //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 2 dengan format hari
                echo date('d M y',strtotime($row->notification_datetime))." at ".date('H:i',strtotime($row->notification_datetime));
            }elseif($diff->format('%a')>=1){ //jika perbedaan antara tanggal data diinput dan dibutuhkan tidak lebih dari 1 hari yang lalu
                echo 'yesterday at '.date('H:i',strtotime($row->notification_datetime));
            }elseif($diff->format('%h')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format jam
                echo $diff->format('%h hrs ago');
            }elseif($diff->format('%i')>0) { //jika perbedaan antara tanggal data diinput dan dibutuhkan lebih dari 0 dengan format menit
                echo $diff->format('%i mins ago');
            }
            ?>
            </small></i>
        </a>
        </li>
<?php } ?>
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
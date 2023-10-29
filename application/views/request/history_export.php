<?php
  $id_role = $this->session->userdata('id_role');
  $id_area = $this->session->userdata('id_area');

    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=CL_history_report.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
?>

  <table id="mytable" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>State</th>
        <th>No.</th>
        <th >Request Date</th>
        <?php if($id_role!='10'){ ?>
        <th>Request by</th>
        <?php } ?>
        <th>Entity</th>
        <th>Sales Name</th>
        <th>Customer Name</th>
        <th>Note</th>
        <th>Lead Time</th>
      </tr>
    </thead>

    <tbody> 
    <?php
      foreach($report->result() as $baris){
    ?>
      <tr>
        <td><?php foreach($status->result() as $rows){if($baris->id_request_status==$rows->id_request_status){ echo $rows->name_request_status;}}?></td>
        <td><?php echo $baris->id_request;?></td>
        <td><?php echo date('d M Y g:i a',strtotime($baris->requested_date));?></td>
        <?php if($id_role!='10'){ ?>
        <td><?php foreach($user->result() as $rowu){if($baris->id_user==$rowu->id){echo $rowu->name_user;}}?></td>
        <?php } ?>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->alias_company;}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){echo $rowc->name_user;}}?></td>
        <td><?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){if($rowc->name_entity!='Pte Ltd' and $rowc->name_entity!='Ltd' and $rowc->name_entity!='GmbH & Co. KG' and $rowc->name_entity!='Other' and $rowc->name_entity!='Perseorangan'){ echo $rowc->name_entity;}?> <?php echo strtoupper($rowc->name_customer);?> <?php if($rowc->name_entity=='Pte Ltd' or $rowc->name_entity=='Ltd' or $rowc->name_entity=='GmbH & Co. KG'){ echo strtoupper($rowc->name_entity);}}}?> <?php foreach($customer->result() as $rowc){if($baris->id_customer==$rowc->id_customer){if($rowc->status_existing=='1'){?><i class="fa fa-check text-success"></i><?php }}}?></td>
        <td><?php foreach($note->result() as $rown){if($baris->id_request==$rown->id_request){ echo $rown->note_comment;}}?></td>
        <td>
          <?php
            $now = new DateTime('now');
            $requested_date = new DateTime($baris->requested_date);
            $update_date = new DateTime($baris->update_date);

            if($update_date->diff($requested_date)->format('%a')>0)
            {
              echo $update_date->diff($requested_date)->format('%a days');
            }
            elseif($update_date->diff($requested_date)->format('%h')>0)
            {
              echo $update_date->diff($requested_date)->format('%h hours');
            }
            elseif($update_date->diff($requested_date)->format('%i')>0)
            {
              echo $update_date->diff($requested_date)->format('%i minutes');
            }
          ?>
        </td>
        </tr>
    <?php
      }
    ?>
    </tbody> 
  </table>
  
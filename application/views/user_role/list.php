<section class="content-header">
  <h1>ROLE LIST</h1>
</section>
<section class="content">
<div class="box box-primary">

<table id="myTable" class="table table-striped table-hover tablesorter" cellspacing="0"> 
<?php 
  $per_page = abs($this->input->get('per_page'));
  $no = $per_page + 1;
  
  if(count($role->result()) > 0)
  {
    ?> 
    <thead> 
      <form name="cari" action="<?php echo site_url() ?>/user_role" method="GET">
        <tr>
          <th width="33"><div align="center">#</div></th> 
          <th><input type="text" class="form-control" name="role" placeholder="Enter User Role Name"></th> 
          <th width="160" colspan="3">
            <div class="btn-group">
              <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span></button>
              <a href="<?php echo site_url() ?>/user_role" class="btn btn-success"><span class="glyphicon glyphicon-refresh"></a>
              <a href="<?php echo site_url() ?>/user_role/add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></a>
            </div>
          </th> 
          
        </tr>
      </form> 
    </thead>
    
    <thead> 
      <tr>
        <th width="33"><div align="center">No</div></th> 
        <th><div align="left">Role Name </div></th>
        <th></th>
        <th></th>
        <th><div align="center">Action</div></th> 
      </tr>
    </thead> 
    
    <tbody> 
      <?php
      foreach($role->result() as $baris)
      {
        ?>
        <tr>
          <td><?php echo $no; ?></td>           
          <td><?php echo $baris->name_role;?></td>
          <td></td>
          <td></td>
          <td width="70" align="center">
          <a href="<?php echo site_url() ?>/user_role/update/<?php echo $baris->id;?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
          <a href="<?php echo site_url() ?>/user_role/delete/<?php echo $baris->id;?>" class="btn btn-danger btn-xs" onClick='return confirm("Anda yakin ingin menghapus data ini?")'><span class="glyphicon glyphicon-trash"></span></a>
          </td>
        </tr> 
        
        <?php
          $no++;
          }
        ?>
    </tbody> 
    
    <tfoot>
      <tr>
        <td colspan="5"><div class="pagination"><?php echo $this->pagination->create_links(); ?></div></td>
        <?php
  }
  else 
  {
    ?>
    <table id="myTable" class="table table-striped table-hover tablesorter" cellspacing="0"> 
    <thead> 
      <form name="cari" action="<?php echo site_url() ?>/user_role" method="GET">
        <tr>
          <th width="33"><div align="center">#</div></th>
          <th><input type="text" class="form-control" name="role" placeholder="Enter User Role Name"></th> 
          <th width="160" colspan="2">
            <div class="btn-group">
              <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span></button>
              <a href="<?php echo site_url() ?>/user_role" class="btn btn-success"><span class="glyphicon glyphicon-refresh"></a>
              <a href="<?php echo site_url() ?>/user_role/add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></a>
            </div>
          </th> 
        </tr>
      </form> 
    </thead>
    
    <thead> 
      <tr>
        <th width="33"><div align="center">No</div></th> 
        <th><div align="left">Role Name </div></th> 
        <th><div align="center">Action</div></th> 
      </tr>
    </thead> 
    
    <tbody> 
      <td colspan="6">Data Tidak Tersedia</td>    
    </tbody>
    </table>    
    <?php
      }
    ?>
      </tr>
    </tfoot>
</table>
</div>      
</section> 
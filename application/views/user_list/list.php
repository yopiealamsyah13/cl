<section class="content-header">
  <h1>USER LIST</h1>
</section>
<section class="content">
<div class="box box-primary">
    <div class="box-body">
    <table id="myTable" class="table table-striped table-hover tablesorter" cellspacing="0"> 
                      <?php 
                      $per_page = abs($this->input->get('per_page'));
                      $no = $per_page + 1;
                      if(count($name->result()) > 0) {
                      ?> 
                      <thead> 
                      <form name="cari" action="<?php echo site_url() ?>/user_list" method="GET">
                          <tr>
                              <th width="33"><div align="center">#</div></th> 
                              <th><input type="text" class="form-control" name="name" placeholder="Enter User Name"></th> 
                              <th>
                                  <select name="company" class="form-control">
                                  <option value="">Pilih Company</option>
                                  <?php foreach ($company->result() as $valtype) { ?>
                                  <option value="<?php echo $valtype->name_company; ?>"><?php echo $valtype->name_company; ?></option>
                                  <?php } ?>
                                  </select>
                              </th>     
            
                              <th width="160" colspan="4">
                                  <div class="btn-group">
                                      <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                      <a href="<?php echo site_url() ?>/user_list" class="btn btn-success"><span class="glyphicon glyphicon-refresh"></a>
                                      <a href="<?php echo site_url() ?>/user_list/add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></a>
                                  </div>
                              </th> 
                          </tr>
                      </form> 
                      </thead>

                      <thead> 
                          <tr>
                            <th width="33"><div align="center">No</div></th> 
                            <th><div align="left">User Name </div></th>
                            <th><div align="left">Company </div></th>
                            <th><div align="left">Area </div></th>
                            <th><div align="left">User Role </div></th>
                            <th><div align="center">Action</div></th> 
                          </tr>
                      </thead>

                      <tbody> 
                          <?php
                          foreach($name->result() as $baris){
                          ?>
                          <tr>
                            <td><?php echo $no; ?></td>           
                            <td><?php echo $baris->name_user;?></td>
                            <td><?php echo $baris->name_company;?></td>
                            <td><?php echo $baris->name_area;?></td>
                            <td><?php echo $baris->name_role;?></td>
            
                            <td width="100" align="center">
                            <a href="<?php echo site_url() ?>/user_list/view/<?php echo $baris->user_id;?>" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                            <a href="<?php echo site_url() ?>/user_list/update/<?php echo $baris->user_id;?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
                            <a href="<?php echo site_url() ?>/user_list/delete/<?php echo $baris->user_id;?>" class="btn btn-danger btn-xs" onClick='return confirm("Anda yakin ingin menghapus data ini?")'><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                          </tr>
                          <?php
                          $no++;
                          }
                          ?>
                      </tbody> 
                      <tfoot>
                          <tr>
                              <td colspan="7">
                              <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
                              </td>
                              <?php
                              } else {
                              ?>
                              <table id="myTable" class="table table-striped table-hover tablesorter" cellspacing="0"> 
                              <thead> 
                              <form name="cari" action="<?php echo site_url() ?>/user_list" method="GET">
                                  <tr>
                                      <th width="33"><div align="center">#</div></th> 
                                      <th><input type="text" class="form-control" name="name" placeholder="Enter User Name"></th> 
                                      <th>
                                          <select name="company" class="form-control">
                                          <option value="">Pilih Company</option>
                                          <?php foreach ($company->result() as $valtype) { ?>
                                          <option value="<?php echo $valtype->name_company; ?>"><?php echo $valtype->name_company; ?></option>
                                          <?php } ?>
                                          </select>
                                      </th>     
            
                                      <th width="160" colspan="2">
                                          <div class="btn-group">
                                            <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                            <a href="<?php echo site_url() ?>/user_list" class="btn btn-success"><span class="glyphicon glyphicon-refresh"></a>
                                            <a href="<?php echo site_url() ?>/user_list/add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></a>
                                         </div>
                                      </th> 
                              </tr>
                              </form> 
                              </thead>
                              <thead> 
                                  <tr>
                                      <th width="33"><div align="center">No</div></th> 
                                      <th><div align="left">User Name </div></th> 
                                      <th><div align="left">Company </div></th>
                                      <th><div align="left">Area </div></th>
                                      <th><div align="left">User Role </div></th>  
                                      <th><div align="center">Action</div></th> 
                                  </tr>
                              </thead> 
                              <tbody> 
                              <td colspan="6">
                                Data Tidak Tersedia
                              </td>    
                              </tbody>
                              </table>    
                              <?php
                              }
                              ?>
                           </tr>
                      </tfoot>
    </table>
  </div>
</div>
</section> 
        
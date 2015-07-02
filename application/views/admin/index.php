<div class="row">
  <div class="span3">
    <h3><a href="<?php echo site_url('admin/user');?>">User</a></h3>
    <table class="table table-bordered">
      <tr>
        <td width="50%">Total</td>
        <td><?php echo $user_num;?></td>
      </tr>
    </table>
  </div>
  
  <div class="span3">
    <h3><a href="<?php echo site_url('admin/Item');?>">Item</a></h3>
    <table class="table table-bordered">
      <tr>
        <td width="50%">Total</td>
        <td><?php echo $item_num;?></td>
      </tr>
      <tr>
        <td width="50%">sharing</td>
        <td><?php echo $item_num_status[1];?></td>
      </tr>
      <tr>
        <td width="50%">unshare</td>
        <td><?php echo $item_num_status[2];?></td>
      </tr>
      <tr>
        <td width="50%">deleted</td>
        <td><?php echo $item_num_status[3];?></td>
      </tr>
      <tr>
        <td width="50%">borrowed</td>
        <td><?php echo $item_num_status[4];?></td>
      </tr>
    </table>
  </div>

  <div class="span3">
    <h3><a href="<?php echo site_url('admin/Trade');?>">Trade</a></h3>
    <table class="table table-bordered">
      <tr>
        <td width="50%">Total</td>
        <td><?php echo $trade_num;?></td>
      </tr>
      <tr>
        <td width="50%">initial</td>
        <td><?php echo $trade_num_status[1];?></td>
      </tr>
      <tr>
        <td width="50%">accepted</td>
        <td><?php echo $trade_num_status[2];?></td>
      </tr>
      <tr>
        <td width="50%">denied</td>
        <td><?php echo $trade_num_status[3];?></td>
      </tr>
      <tr>
        <td width="50%">canceled</td>
        <td><?php echo $trade_num_status[4];?></td>
      </tr>
      <tr>
        <td width="50%">returned</td>
        <td><?php echo $trade_num_status[5];?></td>
      </tr>
      <tr>
        <td width="50%">lost</td>
        <td><?php echo $trade_num_status[6];?></td>
      </tr>
    </table>
  </div>
</div>
<div class="row">
  <div class="span9">
    <h3>Trade List</h3>
        <form action="" method="GET" class="form-inline">
        <input type="text" class="form-control" name="item_title" placeholder="Item" value="<?php echo $search_data['item_title'];?>">
        <input type="text" class="form-control" name="owner_name" placeholder="owner" value="<?php echo $search_data['owner_name'];?>">
        <input type="text" class="form-control" name="borrower_name" placeholder="Borrower" value="<?php echo $search_data['borrower_name'];?>">
        <br>
        <br>
        <input type="text" id="datetimepicker1" class="form-control" name="start_time" placeholder="Create_time start" value="<?php echo $search_data['start_time'];?>">
        <input type="text" id="datetimepicker2" class="form-control" name="end_time" placeholder="Create_time end" value="<?php echo $search_data['end_time'];?>">
        
        <button class="btn btn-success" type="submit" >Search</button>
        <a class="btn btn-primary" href="<?php echo site_url('admin/' . $self );?>"/>Reset</a>
        <a class="btn btn-primary" href="<?php echo site_url('admin');?>"/>Return</a>
      </form>
    <table class="table table-bordered">
      <tr>
        <th>ID</th>
        <th>Item</th>
        <th>owner</th>
        <th>Borrower</th>
        <th>Status</th>
        <th>CreateTime</th>
      </tr>
      <?php
      foreach ($trades as $key => $trade) {
        echo "<tr>";
        echo "<td>" . $trade['trade_id'] . "</td>";
        echo "<td>" . $trade['item_title'] . "</td>";
        echo "<td>" . $trade['owner_name'] . "</td>";
        echo "<td>" . $trade['borrower_name'] . "</td>";
        echo "<td>" . getTradeStatusName($trade['trade_status']) . "</td>";
        echo "<td>" . $trade['create_time'] . "</td>";
        echo "</tr>";
      }
      ?>
    </table>

    <div class="pagination">
      <ul>
      <?php foreach ($link_array as $key => $value) {echo $value;}?>
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript" src="/public/js/jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="/public/css/jquery.datetimepicker.css">
<script>
  $('#datetimepicker1').datetimepicker();
  $('#datetimepicker2').datetimepicker();

  $(document).ready(function(){
    $("#resetTime").click(function(){
      $('#datetimepicker1').val("");
      $('#datetimepicker2').val("");
    });
  });
</script>

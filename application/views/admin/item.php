<div class="row">
  <div class="span9">
    <h3>Item List</h3>
        <form action="" method="GET" class="form-inline">
        <input type="text" class="form-control" name="keyword" placeholder="keyword" value="<?php if(isset($search_data['keyword'])){echo $search_data['keyword'];}?>">
        <input type="text" class="form-control" name="username" placeholder="owner name" value="<?php if(isset($search_data['username'])){echo $search_data['username'];}?>">

        <button class="btn btn-success" type="submit" >Search</button>
        <a class="btn btn-primary" href="<?php echo site_url('admin/' . $self );?>"/>Reset</a>
        <a class="btn btn-primary" href="<?php echo site_url('admin');?>"/>Return</a>
        <br><br>
        <input type="text" id="datetimepicker1" class="form-control" name="start_time" placeholder="Create_time start" value="<?php echo $search_data['start_time'];?>">
          <input type="text" id="datetimepicker2" class="form-control" name="end_time" placeholder="Create_time end" value="<?php echo $search_data['end_time'];?>">
      </form>
    <table class="table table-bordered">
      <tr>
        <th>ID</th>
        <th>title</th>
        <th>owner</th>
        <th>publisher</th>
        <th>status</th>
        <th>create time</th>
      </tr>
      <?php
      
      foreach ($items as $key => $item) {

        echo "<tr>";
        echo "<td>" . $item['item_id'] . "</td>";
        echo "<td>" . $item['title'] . "</td>";
        echo "<td>" . $item['username'] . "</td>";
        echo "<td>" . $item['publisher_name'] . "</td>";
        echo "<td>" . getItemStatusName($item['item_status']) . "</td>";
        echo "<td>" . $item['create_time'] . "</td>";
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

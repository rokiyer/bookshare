<div class="row">
  <div class="span9">
    <div class="alert alert-error hide" id="msg-box"></div>
    <ul class="thumbnails">
      <?php 
      foreach ($trades as $key => $trade) { ?>
      <li class="span9">
        <div class="thumbnail">
          <div class="row">
            <a href="" class="span2">
              <img class="book_image" src="<?php echo $trade['image_url'];?>" >
            </a>
            <div class="span6">
              <?php
              $title_anchor = anchor_popup(site_url('item/detail/'.$trade['item_id']) , $trade['item_title'] );
              $owner_anchor = anchor_popup(site_url('#') , $trade['owner_name'] );
              ?>
              <!-- title -->
              <h4><?php echo $title_anchor;?></h4>
              <p><?php echo $owner_anchor;?> : <span><?php echo $trade['item_description'];?></span></p>
              <p><?php echo $trade['create_time'];?> : You sent <?php echo $owner_anchor;?> a request for this book . </p>
              
              <?php if($trade['trade_status'] == 1){ //accept or deny?>
                <p>The owner has not responsed yet , you can cancel the request .</p>
                <p>
                <button class="btn btn-danger trade_op" trade_op="cancel" trade_id="<?php echo $trade['trade_id'];?>" type="button">Cancel</button>
                </p>
              <?php }else if($trade['trade_status'] == 2){?>
                <p>The owner has agreed to lend you the book.</p>
                <p>You can contact the owner using infomation below :</p>
                <div class="alert alert-info">
                  <p>Cellphone : <?php echo $trade['owner_cellphone'];?></p>
                  <p>Email : <?php echo $trade['owner_email'];?></p>
                </div>
              <?php }else if($trade['trade_status'] == 3){?>
                <p>The owner has denied your request for this book.</p>
                <p>Sorry for that .</p>
              <?php }else if($trade['trade_status'] == 4){?>
                <p>You have canceled the request for this book.</p>
              <?php }else if($trade['trade_status'] == 5){?>
                <p>The owner has confirm the book has been returned .</p>
                <p>Thanks for using our system.</p>
              <?php }else if($trade['trade_status'] == 6){?>
                <p>The owner has confirm the book has been lost .</p>
                <p>Sorry for that .</p>
              <?php }else{?>
                <p>Sytem error.</p>
              <?php }?>


            </div>
            <div class="span1">

            </div>
          </div>
        </div>
      </li>
      <?php }?>
    </ul>
    <div class="pagination">
      <ul>
      <?php foreach ($link_array as $key => $value) {echo $value;}?>
      </ul>
    </div>
    
  </div>
</div>

<script type="text/javascript">
  var post_url = "<?php echo site_url('api/updateTrade');?>";
  updateTrade(post_url);
</script>

 <style type="text/css">
      .book_image {
        margin-left: 5px;
        margin-top: 5px;
        margin-bottom: 5px;

        width: 100px; 
        height: 130px;
      }
      .share_status{
        margin-left: 25px;
      }
</style>
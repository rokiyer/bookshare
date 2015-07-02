<div class="row">
  <div class="span9">
    <div class="alert alert-error hide" id="msg-box"></div>
    <?php if(empty($trades)){ ?>
    <div class="alert alert-info" id="msg-box">None of your books has been borrowed yet.</div>
    <?php } ?>
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
              $borrower_anchor = anchor_popup(site_url('#') , $trade['borrower_name'] );
              ?>
              <!-- title -->
              <h4><?php echo $title_anchor;?></h4>
              <!-- book owner infomation  -->
              <p>My description :  <span><?php echo $trade['item_description'];?></span></p>
              <!-- trade_record -->
              <div id="trade_record">
              <?php 
              foreach ($trade['trade_record'] as $key => $record) {?>
                 <p><?php echo $record['create_time'];?> : 
                  <?php if($record['op'] == 1){
                    echo $borrower_anchor .' sent you a request for this book .';
                   }else if($record['op'] == 2){ 
                    echo 'You accepted the request .';
                   }else if($record['op'] == 3){ 
                    echo 'You denied the request .'; 
                   }else if($record['op'] == 4){ 
                    echo 'The borrower cancelled the request .'; 
                   }else if($record['op'] == 5){ 
                    echo 'You confirm the book is returned .';
                   }else if($record['op'] == 6){ 
                    echo 'You confirm the book is lost .';
                   } ?>
                 </p>
              <?php } ?>
              </div>
              <!-- change book -->
              
              <?php if($trade['trade_status'] == 1){ //accept or deny?>
                <p>
                <button class="btn btn-success trade_op" trade_op="accept" trade_id="<?php echo $trade['trade_id'];?>" type="button">Accept</button>
                <button class="btn btn-danger trade_op" trade_op="deny" trade_id="<?php echo $trade['trade_id'];?>" type="button">Deny</button>
                </p>
              <?php }else if($trade['trade_status'] == 2){?>
                <p>You have accepted <?php echo $borrower_anchor;?>'s request.</p>
                <p>His/Her contact infomation is shown below : </p>
                <div class="alert alert-info">
                  <p>Cellphone : <?php echo $trade['borrower_cellphone'];?></p>
                  <p>Email : <?php echo $trade['borrower_email'];?></p>
                </div>
                <p>
                <button class="btn btn-primary trade_op" trade_op="return" trade_id="<?php echo $trade['trade_id'];?>" type="button">Book is returned</button>
                <button class="btn btn-danger trade_op" trade_op="lost" trade_id="<?php echo $trade['trade_id'];?>" type="button">Book is lost</button>
                </p>
              <?php }else if($trade['trade_status'] == 3){?>
                <p>You have denied <?php echo $borrower_anchor;?>'s request.</p>
              <?php }else if($trade['trade_status'] == 4){?>
                <p>Borrower have canceled the request for this book.</p>
              <?php }else if($trade['trade_status'] == 5){?>
                <p>You have confirm the book has been returned.</p>
                <p>Thanks for using our system.</p>
              <?php }else if($trade['trade_status'] == 6){?>
                <p>You have confirm the book has been lost.</p>
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
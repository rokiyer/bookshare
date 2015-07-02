<div class="row">
   <div class="span8 alert alert-error hide" id="msg-box"></div>
   <div class="span6">
    <ul class="nav nav-pills">
      <li><a href="<?php echo site_url($link_time);?>"><?php if($search_data['order_time']){echo 'Oldest';}else{echo 'Newest';}?></a></li>
      <li><a href="<?php echo site_url($link_name);?>"><?php if($search_data['order_name']){echo 'Z-A';}else{echo 'A-Z';}?></a></li>
    </ul>
   </div>

   <div class="span3">
    <div class="input-append">
      <form>
      <input class="span2" type="text" name="keyword" value="<?php echo $search_data['keyword'];?>">
      <button class="btn" name="submit" type="submit" >Search</button>
      </form>
    </div>
   </div>

  <div class="span9">
    <ul class="thumbnails">
      <?php 
      foreach ($items as $key => $item) { ?>
      <li class="span9">
        <div class="thumbnail">
          <div class="row">
            <a href="<?php echo $item['douban_url'];?>" class="span2">
              <img class="book_image" src="<?php echo $item['image_url'];?>" >
              <?php if($item['item_status'] == 1) { ?>
              <span class="label label-success share_status">Sharing</span>
              <?php }else if($item['item_status'] == 2){ ?>
              <span class="label label-warning share_status">Unsharing</span>
              <?php }else if($item['item_status'] == 4){ ?>
              <span class="label label-warning share_status">Shared</span>
              <?php } ?>
            </a>
            <div class="span5">
              <?php
              $title_anchor = anchor_popup(site_url('share/detail/'.$item['item_id']) , $item['title'] );
              $authors_anchor = array();
              foreach ($item['authors'] as $key => $author) {
                $author_anchor = anchor_popup(site_url('share/author?author_id=' . $author['author_id']) , $author['name']);
                array_push($authors_anchor, $author_anchor);
              }
              $translators_anchor = array();
              foreach ($item['translators'] as $key => $translator) {
                $translator_anchor = anchor_popup(site_url('share/author?author_id=' . $translator['translator_id']) , $translator['name']);
                array_push($translators_anchor, $translator_anchor);
              }
              $publisher_anchor = anchor_popup(site_url('share/publisher?publisher_id='.$item['publisher_id'] ) , $item['publisher_name'] );
              $user_anchor = anchor_popup(site_url('share/user?user_id='.$item['user_id']) , $item['username'] );
              
              ?>

              <!-- title -->
              <h4><?php echo $title_anchor;?></h4>
              <!-- author and translator -->
              <p>
              <?php
              foreach ($authors_anchor as $key => $author_anchor) {
                echo "<span>" . $author_anchor . "</span>";
                if($key != count($authors_anchor) - 1 )
                   echo " | ";
              }
              ?>
              <?php 
              if(!empty($translators_anchor)) echo " | ";
              foreach ($translators_anchor as $key => $translator_anchor) {
                echo "<span>*" . $translator_anchor .  "</span>";
                if($key != count($translators_anchor) - 1 )
                   echo " | ";
              }
              ?>
              </p>
              <!-- publihser -->
              <p><span><?php echo $publisher_anchor;?></span> <span><?php echo $item['pubdate'];?></span></p>
              <!-- book owner infomation  -->
              <p><span><?php echo $item['description'];?></span></p>
              <!-- change book -->
              <p>
                <?php if($item['item_status'] != 4){ //shared book can not edit?>
                  <a class="btn btn-primary" href="<?php echo site_url('space/item_edit/'.$item['item_id']);?>">Edit My Comment</a>

                  <?php if($item['item_status'] == 1) { ?>
                  <button class="btn btn-warning unshare item_status" item_id="<?php echo $item['item_id'];?>" type="button">Unshare Book</button>
                  <?php }else if($item['item_status'] == 2){ ?>
                  <button class="btn btn-success share item_status" item_id="<?php echo $item['item_id'];?>" type="button">Share Book</button>
                  <?php } ?>
                  <button class="btn btn-danger delete item_status" item_id="<?php echo $item['item_id'];?>" type="button">Delete Book</button>
                <?php }?>
              </p>
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
  var post_url = "<?php echo site_url('api/updateItem');?>";
  updateItemStatus(post_url);
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
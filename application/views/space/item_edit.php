<div class="row">
  <div class="span6">
    <div class="alert alert-error hide" id="msg-box"></div>
    
    <ul class="thumbnails">
      <li class="span9">
        <div class="thumbnail">
          <div class="row">
            <a href="" class="span2">
            <img class="book_image" src="<?php echo $item['image_url'];?>" >
            <span class="label label-success share_status">Sharing</span>
            </a>
            <span id="item_id" item_id="<?php echo $item['item_id'];?>"></span>
            <div class="span5">
              <?php
              $title_anchor = anchor_popup(site_url('share/detail/'.$item['item_id']) , $item['title'] );
              $authors_anchor = array();
              foreach ($item['authors'] as $key => $author) {
                $author_anchor = anchor_popup(site_url('share/author?author_id='.$author['author_id']) , $author['name']);
                array_push($authors_anchor, $author_anchor);
              }
              $translators_anchor = array();
              foreach ($item['translators'] as $key => $translator) {
                $translator_anchor = anchor_popup(site_url('share/author?author_id='.$translator['translator_id']) , $translator['name']);
                array_push($translators_anchor, $translator_anchor);
              }
              if($item['publisher_name'] == NULL )
                $item['publisher_name'] = "Unknown";
              $publisher_anchor = anchor_popup( site_url('share/publisher?publisher_id='.$item['publisher_id']) , $item['publisher_name'] );
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
                   echo " , ";
              }
              ?>
              <?php 
              if(!empty($translators_anchor)) echo " , ";
              foreach ($translators_anchor as $key => $translator_anchor) {
                echo "<span>*" . $translator_anchor .  "</span>";
                if($key != count($translators_anchor) - 1 )
                   echo " , ";
              }
              ?>
              </p>
              <!-- publihser -->
              <p><span><?php echo $publisher_anchor;?></span> | <span><?php echo $item['pubdate'];?></span></p>
              <!-- book owner infomation  -->
              <p><textarea id="description" rows="3" class="span5"><?php echo $item['description'];?></textarea></p>
              <!-- change book -->
              <p>
                <button class="btn btn-primary" type="button" name="submit" id="submit" value="1">Save Change</button>
                <a class="btn" href="<?php echo site_url('space/items');?>">Back to My Books List</a>
              </p>
            </div>
            <!-- end of span5  -->
          </div>
          <!-- end of row -->
        </div>
      </li>
    </ul>
  </div>
</div>

<script type="text/javascript">
  var post_url = "<?php echo site_url('api/updateItem');?>";
  
  updateItemDescription(post_url);
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
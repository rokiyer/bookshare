<div class="row">
   <div class="span9">
    <div class="alert alert-info">
      <?php if($page == 'user'){ ?>
        The books in this page are owned by <b><?php echo anchor('share/user/' . $user['id'] , $user['username']);?></b> 
      , you can borrow multiple books from him/her.
      <?php }else if($page == 'author'){ ?>
        The books in this page are wrote by <b><?php echo anchor('share/author?author_id=' . $author['id'] , $author['name']);?></b> 
      <?php }else if($page == 'publisher'){ ?>
        The books in this page are published by <b><?php echo anchor('share/publisher?publisher_id=' . $publisher['id'] , $publisher['name']);?></b> 
      <?php } ?>
    </div>
   </div>

  <hr>

  <div class="span9">
  	<ul class="thumbnails">
      <?php 
      foreach ($items as $key => $item) { ?>
      <li class="span9">
        <div class="thumbnail">
          <div class="row">
            <a href="<?php echo $item['douban_url']; ?>" class="span2">
            <img class="book_image" src="<?php echo $item['image_url'];?>" >
            </a>
            <div class="span6">
              <?php
              $title_anchor = anchor_popup(site_url('share/detail/'.$item['item_id']) , $item['title'] );
              $authors_anchor = array();
              foreach ($item['authors'] as $key => $author) {
                $author_anchor = anchor_popup( site_url('share/author?author_id=' . $author['author_id']) , $author['name'] );
                array_push($authors_anchor, $author_anchor);
              }
              $translators_anchor = array();
              foreach ($item['translators'] as $key => $translator) {
                $translator_anchor = anchor_popup(site_url( 'share/author?author_id=' . $translator['translator_id'] ), $translator['name'] );
                array_push($translators_anchor, $translator_anchor);
              }
              $publisher_anchor = anchor_popup(site_url('share/publisher?publisher_id=' . $item['publisher_id'] ), $item['publisher_name'] );
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
                echo "<span>" . $translator_anchor .  "(Translate)</span>";
                if($key != count($translators_anchor) - 1 )
                   echo " | ";
              }
              ?>
              </p>
              <!-- publihser -->
              <p><span><?php echo $publisher_anchor;?></span> | <span><?php echo $item['pubdate'];?></span></p>
              <!-- book owner infomation  -->
              <p><span><?php echo $user_anchor;?></span> : <span><?php echo $item['description'];?></span></p>
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
  
</script>

 <style type="text/css">
      .book_image {
        margin-left: 5px;
        margin-top: 5px;
        margin-bottom: 5px;

        width: 100px; 
        height: 130px;
      }
</style>
<div class="row">
  <div class="span9">
  	<ul class="thumbnails">
      <?php 
      foreach ($items as $key => $item) { ?>
      <li class="span9">
        <div class="thumbnail">
          <div class="row">
            <a href="" class="span2">
            <img  class="book_image" src="<?php echo $item['image_url'];?>" >
            </a>
            <div class="span5">
              <h4>
                <?php 
                echo anchor_popup(site_url('item/detail/'.$item['item_id']) , $item['title'] );
                ?>
              </h4>
              <p><?php echo $item['description'];?></p>
            </div>
          </div>
        </div>
      </li>
      <?php }?>
      
    </ul>
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
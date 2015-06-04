<div class="row">
  <div class="span4">
    <div class="alert alert-error hide" id="msg-box"></div>
  	<div class="hide" id="another_one"><br><a class="btn btn-primary btn-small" href="<?php echo site_url('space/share');?>">Share Another One</a></div>
    <form class="form" method='post' action="">
	    <label>Descript your book below and share it !</label>
	    <textarea class="span4" name="description" id="description" rows="4"></textarea>
	    <button class="btn btn-primary" id="submit" name="submit" type="submit" value="1">Share It</button>
	    <hr>
	    <span class="help-block">If the your book does not match the infomation shown on the right . 
	    	Please check whether your ISBN is correct and try again .</span>
	    <a class="btn btn-info" href="<?php echo site_url('space/share');?>">Enter ISBN</a>
    </form>
  </div>
  <div class="span5">
  	<span class="hide" id="book_id" book_id="<?=$id?>"></span>
  	<table class="table table-striped">
	    <tr>
	      <td>Title</td>
	      <td><?=$title?></td>
	    </tr>
	    <tr>
	      <td>Author</td>
	      <td>
	      <?php 
	      	foreach ($authors as $key => $author) {
	      		$author_id = $author["author_id"];
	      		echo anchor_popup(site_url("books/author/$author_id") , $author["author_name"]);
	      		echo "<br>";
	      	}
	      ?>
	  	  </td>
	    </tr>
	    <tr>
	      <td>ISBN</td>
	      <td><?=$isbn13?></td>
	    </tr>
	    <tr>
	      <td>Publisher</td>
	      <td>
	      	<?php 
	      		$publisher_id = $publisher_id;
	      		echo anchor_popup(site_url("books/author/$publisher_id") , $publisher_name);
	      	?>
	      </td>
	    </tr>
	    <?php if (!empty($translators)) { ?>
	    <tr>
	      <td>Translators</td>
	      <td>
	      	<?php 
	      	foreach ($translators as $key => $author) {
	      		$translator_id = $author["translator_id"];
	      		echo anchor_popup(site_url("books/author/$translator_id") , $author["translator_name"]);
	      		echo "<br>";
	      	}
	       ?>
	      </td>
	    </tr>
	    <?php }?>
	    <?php if (!empty($pages)) { ?>
	    <tr>
	      <td>Pages</td>
	      <td><?=$pages?></td>
	    </tr>
	    <tr>
	      <td>Binding</td>
	      <td><?=$binding?></td>
	    </tr>
	    <?php }?>
	    <?php if (!empty($pubdate)) { ?>
	    <tr>
	      <td>Publish Date</td>
	      <td><?=$pubdate?></td>
	    </tr>
	    <?php }?>
	</table>

  	<img src="<?=$image_url;?>" class="img-polaroid">

  </div>
</div>


<script type="text/javascript">
	var post_url = "<?php echo site_url('api/shareBook');?>";
  	shareBook(post_url);
</script>
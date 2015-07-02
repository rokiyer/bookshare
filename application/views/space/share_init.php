<div class="row">
 <div class="span3">
  	
  </div>
  <div class="span3">
    <div class="alert alert-error <?php if($msg != 2) echo 'hide';?>" id="msg-box"><?php if($msg == 2) echo 'Can not find the ISBN';?></div>
	<form class="form" method='get' action="">
	    <label>Your Book's ISBN</label>
	    <span class="help-block">Usually in the back of the book</span>
	    <input type="text" id="isbn" name="isbn" placeholder="ISBN" value="<?php if(isset($isbn)){echo $isbn;}?>">
	    <button class="btn btn-primary btn-block" id="submit" name="submit" type="submit" value="1">Find Book</button>
	</form>
  </div>
  <div class="span3">
  	
  </div>
</div>

<script type="text/javascript">
  
</script>
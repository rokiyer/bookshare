<div class="row">
  <div class="span4">
    <div class="alert alert-error hide" id="msg-box"></div>
      <form class="form" method='post' action="">
	      <label>Your Book's ISBN</label>
	      <span class="help-block">Usually in the back of the book</span>
	      <input type="text" id="isbn" name="isbn" placeholder="ISBN">
	      <button class="btn btn-primary" id="submit" name="submit" type="submit" value="1">Find Book</button>
      </form>
  </div>
  <div class="span5">
  	<table class="table table-striped">
	    <tr>
	      <td>Title</td>
	      <td><?=$title?></td>
	    </tr>
	    <tr>
	      <td>Author</td>
	      <td><?=$authors?></td>
	    </tr>
	    <tr>
	      <td>Translators</td>
	      <td><?=$translators?></td>
	    </tr>
	    <tr>
	      <td>Publisher</td>
	      <td><?=$publisher?></td>
	    </tr>
	    <tr>
	      <td>Pages</td>
	      <td><?=$pages?></td>
	    </tr>
	    <tr>
	      <td>Binding</td>
	      <td><?=$binding?></td>
	    </tr>
	    <tr>
	      <td>Publish Date</td>
	      <td><?=$pubdate?></td>
	    </tr>
	</table>
  </div>
</div>


<script type="text/javascript">
  
</script>
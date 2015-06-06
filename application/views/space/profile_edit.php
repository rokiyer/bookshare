<div class="row">
  <div class="span6">
    <div class="alert alert-error hide" id="msg-box"></div>

    <form class="form-horizontal" method='post' action="">

      <div class="control-group">
        <label class="control-label" for="username">User name</label>
        <div class="controls">
          <input type="text" id="username" name="username" value="<?php if(isset($username)) echo $username;?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="cellphone">Cellphone</label>
        <div class="controls">
          <input type="cellphone" id="cellphone" name="cellphone" value="<?php if(isset($cellphone)) echo $cellphone;?>">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="email">Email</label>
        <div class="controls">
          <input type="email" id="email" name="email" value="<?php if(isset($email)) echo $email;?>" >
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button class="btn btn-primary" id="submit" name="submit" type="submit" value="1">Submit</button>
          <a class="btn btn-default" href="<?php echo site_url('space/profile');?>">Back to profile</a>
        </div>
      </div>
    </form>

  </div>
</div>

<script type="text/javascript">
  var post_url = "<?php echo site_url('api/updateProfile');?>";
  updateProfile(post_url);
</script>
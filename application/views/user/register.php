<div class="row">
  <div class="span6">
    <div class="alert alert-error hide" id="msg-box"></div>

    <form class="form-horizontal" method='post' action="">

      <div class="control-group">
        <label class="control-label" for="cellphone">Cellphone</label>
        <div class="controls">
          <input type="text" id="cellphone" name="cellphone" placeholder="Cellphone">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="password">Password</label>
        <div class="controls">
          <input type="password" id="password" name="password" placeholder="Login password">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="confirm">Confirm</label>
        <div class="controls">
          <input type="password" id="confirm" name="confirm" placeholder="Confirm password">
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <button class="btn btn-primary" name="submit" type="submit" id="submit" value="1">Register</button>
          <a class="btn" href="<?php echo site_url('user/login');?>" >Login</a>
        </div>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  var post_url = "<?php echo site_url('api/userRegister');?>";
  var target_url = "<?php echo site_url('space/profile');?>";

  userRegister(post_url , target_url);
</script>
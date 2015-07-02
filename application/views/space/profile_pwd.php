<div class="row">
  <div class="span6">
    <?php if($result == 1){?>
    <div class="alert alert-error" id="msg-box">Some fields are still empty.</div>
    <?php }else if($result == 2){ ?>
    <div class="alert alert-error" id="msg-box">New passwords don't match.</div>
    <?php }else if($result == 3){ ?>
    <div class="alert alert-error" id="msg-box">New password can not be the same as the current one.</div>
    <?php }else if($result == 4){ ?>
    <div class="alert alert-error" id="msg-box">Current password is not correct.</div>
    <?php }else if($result == 5){ ?>
    <div class="alert alert-success" id="msg-box">Change password successfully.</div>
    <?php } ?>


    <form class="form-horizontal" method='post' action="">

      <div class="control-group">
        <label class="control-label" for="cpwd">Current password</label>
        <div class="controls">
          <input type="password" id="cpwd" name="cpwd" value="">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="npwd1">New password</label>
        <div class="controls">
          <input type="password" id="npwd1" name="npwd1" value="">
        </div>
      </div>

      <div class="control-group">
        <label class="control-label" for="npwd2">Current password</label>
        <div class="controls">
          <input type="password" id="npwd2" name="npwd2" value="">
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

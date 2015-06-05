<ul class="nav nav-tabs">
  <li <?php if(isActive("profile")){ echo 'class="active"';}?> ><a href="<?php echo site_url("space/profile");?> ">Profile</a></li>
  <li <?php if(isActive("share")){ echo 'class="active"';}?> ><a href="<?php echo site_url("space/share");?> ">Share</a></li>
  <li <?php if(isActive("book")){ echo 'class="active"';}?> ><a href="<?php echo site_url("space/book");?> ">My Books</a></li>
</ul>

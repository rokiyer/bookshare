<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Book Share</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="/public/js/jquery.min.js"></script>
    <link href="/public/css/bootstrap.min.css" rel="stylesheet">
    <script src="/public/js/bootstrap.min.js"></script>
    <script src="/public/js/api.js"></script>

    <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 40px;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
    </style>
  </head>

  <body>
    <div class="container-narrow">
      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <?php
          $active_class = 0;
          switch ($this->uri->segment(1)) {
            case 'books':
              $active_class = 1;
              break;
            case 'space':
              $active_class = 2;
              break;
            default:
              $active_class = 0;
              break;
          }
          ?>
          <li <?php if($active_class == 0) echo "class='active'";?> ><a href="<?php echo site_url();?>">Home</a></li>
          <li <?php if($active_class == 1) echo "class='active'";?> ><a href="<?php echo site_url('books/display');?>">Books</a></li>
          <li <?php if($active_class == 2) echo "class='active'";?> ><a href="<?php echo site_url('space/upload');?>">Share</a></li>
        </ul>
        <h3 class="muted"><a href="<?php echo site_url();?>">Book Share</a></h3>
      </div>

      <hr>



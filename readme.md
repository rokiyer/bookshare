#BookShare
Another website for students in campus to share his/her books.

##Model 
####个人图书 
* upload image
* 上传图书
* 可以给图书添加描述、标签
* 可以设置图书状态：是否借阅
* 可以删除图书
* 可以添加、删除图书实物图片

####系统图书管理
* book author publisher
* 添加、删除图书
* 修改图书信息：书名、ISBN、作者、出版社

####分享系统
* share
* 可以借阅其他用户分享的图书
* 可以设置借阅时间
* 可以取消
* 分享图书的用户可以确认是否借阅

####用户信息
* user
* 用户可以注册、登陆、注销
* 用户需要设置基本信息
* 用户可以修改基本信息


##Page
####用户系统 user
* 注册页面 register
* 登陆页面 login

####用户空间 space
* 基本信息 basic
* 图书列表 list
* 上传图书 upload
* 修改图书 modify



####图书分享 share
* 图书列表 list
* 单个图书 detail
* 用户主页 user


####系统图书 book
* 图书列表 list
* 单个图书 detail
* 上传图书 upload
* 修改图书 modify


##API
####用户 user
* create
* update
* delete
* login
* logout

####个人图书 upload
* create
* update
* delete
* share
* hide


####系统图书 book
* create
* update
* delete

####分享系统 share
* order
* cancel
* accept
* deny
* back
* lost



##Database Structure

####user
<pre>
CREATE TABLE `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `password` char(40) NOT NULL,
  `cellphone` char(11)  NOT NULL,
  `email` varchar(64)  NOT NULL,
  `student_number` char(11) NULL,
  `grade` varchar(16) NULL,
  `academy` varchar(64) NULL,
  `major` varchar(64) NULL,
  `credit` int(11) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
</pre>


####upload
<pre>
CREATE TABLE `upload` (
  `upload_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` varchar(32) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`upload_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
</pre>



####book
<pre>
CREATE TABLE `book` (
  `book_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isbn` varchar(32) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
</pre>


####share
<pre>
CREATE TABLE `share` (
  `share_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `upload_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`share_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
</pre>

####author
<pre>
CREATE TABLE `author` (
  `author_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
</pre>

####book_author
<pre>
CREATE TABLE `book_author` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
</pre>

####image
<pre>
CREATE TABLE `image` (
  `image_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
</pre>

####upload_image
<pre>
CREATE TABLE `upload_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `upload_id` int(10) unsigned NOT NULL,
  `image_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
</pre>


####book_publisher
<pre>
CREATE TABLE `book_publisher` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL,
  `publisher_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
</pre>


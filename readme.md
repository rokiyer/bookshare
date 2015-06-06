#BookShare
Another website for students in campus to share his/her books.
demo : bookshare.rokiy.com

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



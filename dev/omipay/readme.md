
## 开发环境： xampp集成软件包

 ----
## 配置, demo配置完成才能使用
> 配置说明
1. 在lib/OmiPayConfig.php 进行 merchant_no、merchant_key、notify_url、DOMAIN_TYPE(接口节点)等相应的配置

----
## php 支持curl 
1. 如果出现curl错误，请查看other文件夹下面的curl状态码
2. 如果报错curl 60 那么请参考https://jingyan.baidu.com/article/e75057f2f24bfeebc81a8958.html  （cacert.pem文件在other里面有）
3. other 有omipay web api 接入文档


## 信用卡支付PHP服务端
1. 参考例子在example/checkout.php文件
# sorry-php
用php写的在线gif制作~

致敬————[@xtyxtyx](https://github.com/xtyxtyx/sorry/blob/master/README.md)

最近折腾点wordpress，简单学习了php，同为虎扑jr，看到众jr各显神通写了python版本、java版本、安卓版本等，就顺手撸了个php版本，挂自己小服务器上（最近在备案）。水平拙劣，欢迎批评指正~

## 组织结构

```
|--templates    ##模版，mp4视频和ass字幕文件
|--wangjingze   ##页面
|--sorry        ##页面
|--js           ##javascript
|--image        ##图片
|--make.php     ##核心业务逻辑

```

## 部署
**环境**： apache2 |  ffmpeg 
**安装**： 拷贝根目录到apache2默认服务器根目录即可。

## Todo

- [ ] cookie控制生成间隔
- [ ] 设置gif大小，多档画质

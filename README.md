# Snoopy
PHP采集器

Snoopy是一个php类，用来模拟浏览器的功能，可以获取网页内容，发送表单。
Snoopy正确运行需要你的服务器的PHP版本在4.0以上，并且支持PCRE（Perl Compatible Regular Expressions），基本的LAMP服务都支持。

一、Snoopy的一些特点:

1.抓取网页的内容 fetch
2.抓取网页的文本内容 (去除HTML标签) fetchtext
3.抓取网页的链接，表单 fetchlinks fetchform
4.支持代理主机
5.支持基本的用户名/密码验证
6.支持设置user_agent, referer(来路), cookies和header content(头文件)
7.支持浏览器重定向，并能控制重定向深度
8.能把网页中的链接扩展成高质量的url(默认)
9.提交数据并且获取返回值
10.支持跟踪HTML框架
11.支持重定向的时候传递cookies，要求php4以上就可以了，由于本身是php一个类，无需扩支持，服务器不支持curl时候的最好选择。

二、类方法:

fetch($URI)
这是为了抓取网页的内容而使用的方法。$URI参数是被抓取网页的URL地址。抓取的结果被存储在 $this->results 中。如果你正在抓取的是一个框架，Snoopy将会将每个框架追踪后存入数组中，然后存入 $this->results。

fetchtext($URI)
本方法类似于fetch()，唯一不同的就是本方法会去除HTML标签和其他的无关数据，只返回网页中的文字内容。

fetchform($URI)
本方法类似于fetch()，唯一不同的就是本方法会去除HTML标签和其他的无关数据，只返回网页中表单内容(form)。

fetchlinks($URI)
本方法类似于fetch()，唯一不同的就是本方法会去除HTML标签和其他的无关数据，只返回网页中链接(link)。
默认情况下，相对链接将自动补全，转换成完整的URL。

submit($URI,$formvars)
本方法向$URL指定的链接地址发送确认表单。$formvars是一个存储表单参数的数组。

submittext($URI,$formvars)
本方法类似于submit()，唯一不同的就是本方法会去除HTML标签和其他的无关数据，只返回登陆后网页中的文字内容。

submitlinks($URI)
本方法类似于submit()，唯一不同的就是本方法会去除HTML标签和其他的无关数据，只返回网页中链接(link)。
默认情况下，相对链接将自动补全，转换成完整的URL。

三、类属性: (缺省值在括号里)

$host 连接的主机
$port 连接的端口
$proxy_host 使用的代理主机，如果有的话
$proxy_port 使用的代理主机端口，如果有的话
$agent 用户代理伪装 (Snoopy v0.1)
$referer 来路信息，如果有的话
$cookies cookies， 如果有的话
$rawheaders 其他的头信息, 如果有的话
$maxredirs 最大重定向次数， 0=不允许 (5)
$offsiteok whether or not to allow redirects off-site. (true)
$expandlinks 是否将链接都补全为完整地址 (true)
$user 认证用户名, 如果有的话
$pass 认证用户名, 如果有的话
$accept http 接受类型 (image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*)
$error 哪里报错, 如果有的话
$response_code 从服务器返回的响应代码
$headers 从服务器返回的头信息
$maxlength 最长返回数据长度
$read_timeout 读取操作超时 (requires PHP 4 Beta 4+)
设置为0为没有超时
$timed_out 如果一次读取操作超时了，本属性返回 true (requires PHP 4 Beta 4+)
$maxframes 允许追踪的框架最大数量
$status 抓取的http的状态
$temp_dir 网页服务器能够写入的临时文件目录 (/tmp)
$curl_path cURL binary 的目录, 如果没有cURL binary就设置为 false

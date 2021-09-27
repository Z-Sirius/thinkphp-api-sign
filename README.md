# thinkphp-api-sign
Thinkphp api sign

### 初始化
```shell
composer require zsirius/thinkphp-api-sign
```


### 签名
1、在`url`中添加以下参数：

- `appid`: 前后端约定好的应用ID。
- `timestamp`: 当前的时间戳。
- `nonce`: 12位随机数。
- `body`: 如果是`POST`请求，则需要添加此参数，数值为请求的`body`的 `md5` 哈希值，如果请求的`content-type=form-data`，则不需要添加 body 参数。

2、排序

将`url`的参数按照键名排序，排序的字符串获取其`sha1`哈希值，连接`appsecret`值，进行`md5`加密，赋予`sign`，并将其添加到参数中。

### 验证
验证不通过，抛出异常`zsirius\signature\exception\SignException`，需自定义接收。


### 前端
#### 例子

通用方法：
```js
function md5(str) {
    return crypto.createHash('md5').update(str).digest('hex');
}
function sha1(str) {
    return crypto.createHash('sha1').update(str).digest('hex');
}
function nonce(length) {
  return Math.random().toString(36).substr(2, length);
}
function sign(obj, signKey) {
  var arr = []
  var keys = []
  for (var i in obj) {
    if (typeof obj[i] !== 'object' && i !== 'signature') {
      keys.push(i)
    }
  }
  keys.sort()
  for (var i in keys) {
    arr[keys[i]] = obj[keys[i]]
  }
  var sign = md5(sha1(qs.stringify(arr)) + signKey) 
  return sign
}
```

#### GET 请求
```js
var params = {
    page: 1,
    count: 10
};
params.appid = "202010102020";
params.timestamp = parseInt(Date.now() / 1000);
params.nonce = nonce(8);
params['sign'] = sign(params, 'D8PMQ1BHYCGbvVxcScLrjRi3fbq7OkOP');

console.log('请求参数：');
console.log(params);
axios.get('/finance/transaction?' + qs.stringify(params))
    .then(function (response) {
        console.log('返回数据');
        console.log(response.data);
    })
    .catch(function (error) {
        console.log(error);
    });
```
#### POST 请求
```js
var body = {
    mobile: '18515220153',
    password: '123456'
};
var params = {
    appid: "202010102020",
    timestamp: parseInt(Date.now() / 1000),
    nonce: nonce(8),
    body: md5(JSON.stringify(body)),
};
params['sign'] = sign(params, 'D8PMQ1BHYCGbvVxcScLrjRi3fbq7OkOP');

console.log('请求参数：');
console.log(params);
axios({
    method: 'POST',
    data: body,
    url: '/auth/login?' + qs.stringify(params),
}).then(function (response) {
    console.log('返回数据');
    console.log(response.data);
}).catch(function (error) {
    console.log(error);
});
```
#### form-data
```js
var params = {
    appid: "202010102020",
    timestamp: parseInt(Date.now() / 1000),
    nonce: nonce(8),
};
params['sign'] = sign(params, 'D8PMQ1BHYCGbvVxcScLrjRi3fbq7OkOP');

console.log('请求参数：');
console.log(params);

var data = new FormData();
data.append('image', 'ADD');

axios({
    method: 'POST',
    data: data,
    url: '/common/upload/image?' + qs.stringify(params),
    headers: {
        'Content-Type': 'multipart/form-data'
    }
}).then(function (response) {
    console.log('返回数据');
    console.log(response.data);
}).catch(function (error) {
    console.log(error);
});
```

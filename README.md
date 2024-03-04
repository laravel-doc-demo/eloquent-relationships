## 一對一
一對一  
在兩個 table 中  
一張表的 record 在另張表的的中僅有一筆關聯 record。  

比如：
一個 User model 與一個 Phone model 關聯。

### hasOne
```php
use App\Models\User
User::find(2)->phone;
```
[file](app/Models/User.php)

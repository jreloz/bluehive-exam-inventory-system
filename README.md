<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Bluehive Exam:

- Code cleanliness
- Migration
- Security
- API

1. Registration and Login via Laravel Web and API Auth.
2. Invoice Form
3. List of invoices
4. CRUD operation for Invoices
5. Github url: 


**API Routes: (Uses JSON Web Token for API Guards)**
```
  *(POST) api/register
  *(POST) api/login   
  *(GET)  api/inventory
  *(POST) api/inventory/store
  *(GET)  api/inventory/{id}
  *(POST) api/inventory/update/{id}
```





**API JSON Request Format**

User registration:
```
{
  "name":"",
  "email":"",
  "password":""
}
```


User login
```
{
  "email":"",
  "password":""
}
```


Save/Update inventory entry:
```
{
  "invoiceno": "",
  "invoicedate": "",
  "customername": "",
  "itemsarray": [
    {
      "name":"",
      "quantity":"",
      "price":"",
      "subtotal":""
    }
  ]
}
```

**Downside**
1. All user can see all the inventory recorded by each user.

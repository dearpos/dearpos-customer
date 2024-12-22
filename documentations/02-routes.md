# Customer Management Routes

## Deskripsi
Dokumentasi ini menjelaskan semua route yang tersedia untuk modul manajemen pelanggan.

## Route Groups

### Customer Groups (`/customer-groups`)

| Method | URI | Action | Middleware | Description |
|--------|-----|--------|------------|-------------|
| GET | `/customer-groups` | CustomerGroupController@index | auth:sanctum | Menampilkan daftar grup pelanggan |
| POST | `/customer-groups` | CustomerGroupController@store | auth:sanctum | Membuat grup pelanggan baru |
| GET | `/customer-groups/{id}` | CustomerGroupController@show | auth:sanctum | Menampilkan detail grup pelanggan |
| PUT/PATCH | `/customer-groups/{id}` | CustomerGroupController@update | auth:sanctum | Memperbarui grup pelanggan |
| DELETE | `/customer-groups/{id}` | CustomerGroupController@destroy | auth:sanctum | Menghapus grup pelanggan |

### Customers (`/customers`)

| Method | URI | Action | Middleware | Description |
|--------|-----|--------|------------|-------------|
| GET | `/customers` | CustomerController@index | auth:sanctum | Menampilkan daftar pelanggan |
| POST | `/customers` | CustomerController@store | auth:sanctum | Membuat pelanggan baru |
| GET | `/customers/{id}` | CustomerController@show | auth:sanctum | Menampilkan detail pelanggan |
| PUT/PATCH | `/customers/{id}` | CustomerController@update | auth:sanctum | Memperbarui data pelanggan |
| DELETE | `/customers/{id}` | CustomerController@destroy | auth:sanctum | Menghapus pelanggan |

## Route Parameters

### Customer Groups
- `id`: UUID dari grup pelanggan

### Customers
- `id`: UUID dari pelanggan

## Middleware

Semua route dilindungi oleh middleware berikut:
1. `auth:sanctum`: Memastikan request telah terotentikasi menggunakan Laravel Sanctum
2. `api`: Middleware grup untuk API routes

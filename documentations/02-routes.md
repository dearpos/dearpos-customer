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

### Customer Addresses (`/customers/{customer}/addresses`)

| Method | URI | Action | Middleware | Description |
|--------|-----|--------|------------|-------------|
| GET | `/customers/{customer}/addresses` | CustomerAddressController@index | auth:sanctum | Menampilkan daftar alamat pelanggan |
| POST | `/customers/{customer}/addresses` | CustomerAddressController@store | auth:sanctum | Menambah alamat baru |
| GET | `/customers/{customer}/addresses/{address}` | CustomerAddressController@show | auth:sanctum | Menampilkan detail alamat |
| PUT/PATCH | `/customers/{customer}/addresses/{address}` | CustomerAddressController@update | auth:sanctum | Memperbarui alamat |
| DELETE | `/customers/{customer}/addresses/{address}` | CustomerAddressController@destroy | auth:sanctum | Menghapus alamat |

### Customer Contacts (`/customers/{customer}/contacts`)

| Method | URI | Action | Middleware | Description |
|--------|-----|--------|------------|-------------|
| GET | `/customers/{customer}/contacts` | CustomerContactController@index | auth:sanctum | Menampilkan daftar kontak pelanggan |
| POST | `/customers/{customer}/contacts` | CustomerContactController@store | auth:sanctum | Menambah kontak baru |
| GET | `/customers/{customer}/contacts/{contact}` | CustomerContactController@show | auth:sanctum | Menampilkan detail kontak |
| PUT/PATCH | `/customers/{customer}/contacts/{contact}` | CustomerContactController@update | auth:sanctum | Memperbarui kontak |
| DELETE | `/customers/{customer}/contacts/{contact}` | CustomerContactController@destroy | auth:sanctum | Menghapus kontak |

### Customer Credits (`/customers/{customer}/credits`)

| Method | URI | Action | Middleware | Description |
|--------|-----|--------|------------|-------------|
| GET | `/customers/{customer}/credits` | CustomerCreditController@index | auth:sanctum | Menampilkan riwayat kredit pelanggan |
| POST | `/customers/{customer}/credits` | CustomerCreditController@store | auth:sanctum | Menambah transaksi kredit baru |
| GET | `/customers/{customer}/credits/{credit}` | CustomerCreditController@show | auth:sanctum | Menampilkan detail transaksi kredit |

## Route Parameters

### Customer Groups
- `id`: UUID dari grup pelanggan

### Customers
- `id`: UUID dari pelanggan

### Customer Addresses
- `customer`: UUID dari pelanggan
- `address`: UUID dari alamat

### Customer Contacts
- `customer`: UUID dari pelanggan
- `contact`: UUID dari kontak

### Customer Credits
- `customer`: UUID dari pelanggan
- `credit`: UUID dari transaksi kredit

## Middleware

Semua route dilindungi oleh middleware berikut:
1. `auth:sanctum`: Memastikan request telah terotentikasi menggunakan Laravel Sanctum
2. `api`: Middleware grup untuk API routes

# Customer Management Controllers

## Deskripsi
Modul ini menangani semua operasi CRUD dan logika bisnis terkait manajemen pelanggan.

## Controllers

### CustomerGroupController

#### Methods

##### index()
- **HTTP Method**: GET
- **Path**: `/customer-groups`
- **Description**: Menampilkan daftar grup pelanggan
- **Request Parameters**:
  - `search` (string, optional): Filter berdasarkan nama
  - `status` (string, optional): Filter berdasarkan status
  - `per_page` (integer, optional): Jumlah item per halaman
- **Response**: CustomerGroupCollection (Paginated)

##### store()
- **HTTP Method**: POST
- **Path**: `/customer-groups`
- **Description**: Membuat grup pelanggan baru
- **Request**: CustomerGroupRequest
  ```php
  {
      "name": "string|required|max:100|unique:customer_groups,name",
      "description": "nullable|string",
      "discount_percentage": "numeric|min:0|max:100",
      "is_active": "boolean"
  }
  ```
- **Response**: CustomerGroupResource

##### show()
- **HTTP Method**: GET
- **Path**: `/customer-groups/{id}`
- **Description**: Menampilkan detail grup pelanggan
- **Parameters**: 
  - `id` (UUID): ID grup pelanggan
- **Response**: CustomerGroupResource

##### update()
- **HTTP Method**: PUT/PATCH
- **Path**: `/customer-groups/{id}`
- **Description**: Memperbarui grup pelanggan
- **Parameters**:
  - `id` (UUID): ID grup pelanggan
- **Request**: CustomerGroupRequest
- **Response**: CustomerGroupResource

##### destroy()
- **HTTP Method**: DELETE
- **Path**: `/customer-groups/{id}`
- **Description**: Menghapus grup pelanggan
- **Parameters**:
  - `id` (UUID): ID grup pelanggan
- **Response**: 204 No Content

### CustomerController

#### Methods

##### index()
- **HTTP Method**: GET
- **Path**: `/customers`
- **Description**: Menampilkan daftar pelanggan
- **Request Parameters**:
  - `search` (string, optional): Filter berdasarkan nama/kode
  - `group_id` (UUID, optional): Filter berdasarkan grup
  - `status` (string, optional): Filter berdasarkan status
  - `per_page` (integer, optional): Jumlah item per halaman
- **Response**: CustomerCollection (Paginated)

##### store()
- **HTTP Method**: POST
- **Path**: `/customers`
- **Description**: Membuat pelanggan baru
- **Request**: CustomerRequest
  ```php
  {
      "group_id": "uuid|exists:customer_groups,id",
      "code": "string|required|max:50|unique:customers,code",
      "name": "string|required|max:100",
      "email": "email|nullable|unique:customers,email",
      "phone": "string|nullable|max:20",
      "mobile": "string|nullable|max:20",
      "tax_number": "string|nullable|max:50",
      "credit_limit": "numeric|min:0",
      "notes": "string|nullable",
      "status": "in:active,inactive,blocked"
  }
  ```
- **Response**: CustomerResource

##### show()
- **HTTP Method**: GET
- **Path**: `/customers/{id}`
- **Description**: Menampilkan detail pelanggan
- **Parameters**:
  - `id` (UUID): ID pelanggan
- **Response**: CustomerResource

##### update()
- **HTTP Method**: PUT/PATCH
- **Path**: `/customers/{id}`
- **Description**: Memperbarui data pelanggan
- **Parameters**:
  - `id` (UUID): ID pelanggan
- **Request**: CustomerRequest
- **Response**: CustomerResource

##### destroy()
- **HTTP Method**: DELETE
- **Path**: `/customers/{id}`
- **Description**: Menghapus pelanggan
- **Parameters**:
  - `id` (UUID): ID pelanggan
- **Response**: 204 No Content

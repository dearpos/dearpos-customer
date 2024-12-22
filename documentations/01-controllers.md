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

### CustomerAddressController

#### Methods

##### index()
- **HTTP Method**: GET
- **Path**: `/customers/{customer}/addresses`
- **Description**: Menampilkan daftar alamat pelanggan
- **Parameters**:
  - `customer` (UUID): ID pelanggan
  - `type` (string, optional): Filter berdasarkan tipe alamat
  - `per_page` (integer, optional): Jumlah item per halaman
- **Response**: CustomerAddressCollection (Paginated)

##### store()
- **HTTP Method**: POST
- **Path**: `/customers/{customer}/addresses`
- **Description**: Menambah alamat baru untuk pelanggan
- **Parameters**:
  - `customer` (UUID): ID pelanggan
- **Request**: CustomerAddressRequest
  ```php
  {
      "address_type": "enum:billing,shipping,both",
      "address_line_1": "string|required|max:255",
      "address_line_2": "string|nullable|max:255",
      "city": "string|required|max:100",
      "state": "string|required|max:100",
      "postal_code": "string|required|max:20",
      "country": "string|required|max:100",
      "is_default": "boolean"
  }
  ```
- **Response**: CustomerAddressResource

##### show()
- **HTTP Method**: GET
- **Path**: `/customers/{customer}/addresses/{address}`
- **Description**: Menampilkan detail alamat
- **Parameters**:
  - `customer` (UUID): ID pelanggan
  - `address` (UUID): ID alamat
- **Response**: CustomerAddressResource

##### update()
- **HTTP Method**: PUT/PATCH
- **Path**: `/customers/{customer}/addresses/{address}`
- **Description**: Memperbarui alamat
- **Parameters**:
  - `customer` (UUID): ID pelanggan
  - `address` (UUID): ID alamat
- **Request**: CustomerAddressRequest
- **Response**: CustomerAddressResource

##### destroy()
- **HTTP Method**: DELETE
- **Path**: `/customers/{customer}/addresses/{address}`
- **Description**: Menghapus alamat
- **Parameters**:
  - `customer` (UUID): ID pelanggan
  - `address` (UUID): ID alamat
- **Response**: 204 No Content

### CustomerContactController

#### Methods

##### index()
- **HTTP Method**: GET
- **Path**: `/customers/{customer}/contacts`
- **Description**: Menampilkan daftar kontak pelanggan
- **Parameters**:
  - `customer` (UUID): ID pelanggan
  - `per_page` (integer, optional): Jumlah item per halaman
- **Response**: CustomerContactCollection (Paginated)

##### store()
- **HTTP Method**: POST
- **Path**: `/customers/{customer}/contacts`
- **Description**: Menambah kontak baru untuk pelanggan
- **Parameters**:
  - `customer` (UUID): ID pelanggan
- **Request**: CustomerContactRequest
  ```php
  {
      "name": "string|required|max:100",
      "position": "string|nullable|max:100",
      "phone": "string|nullable|max:20",
      "mobile": "string|nullable|max:20",
      "email": "email|nullable|max:100",
      "is_primary": "boolean"
  }
  ```
- **Response**: CustomerContactResource

##### show()
- **HTTP Method**: GET
- **Path**: `/customers/{customer}/contacts/{contact}`
- **Description**: Menampilkan detail kontak
- **Parameters**:
  - `customer` (UUID): ID pelanggan
  - `contact` (UUID): ID kontak
- **Response**: CustomerContactResource

##### update()
- **HTTP Method**: PUT/PATCH
- **Path**: `/customers/{customer}/contacts/{contact}`
- **Description**: Memperbarui kontak
- **Parameters**:
  - `customer` (UUID): ID pelanggan
  - `contact` (UUID): ID kontak
- **Request**: CustomerContactRequest
- **Response**: CustomerContactResource

##### destroy()
- **HTTP Method**: DELETE
- **Path**: `/customers/{customer}/contacts/{contact}`
- **Description**: Menghapus kontak
- **Parameters**:
  - `customer` (UUID): ID pelanggan
  - `contact` (UUID): ID kontak
- **Response**: 204 No Content

### CustomerCreditController

#### Methods

##### index()
- **HTTP Method**: GET
- **Path**: `/customers/{customer}/credits`
- **Description**: Menampilkan riwayat kredit pelanggan
- **Parameters**:
  - `customer` (UUID): ID pelanggan
  - `type` (string, optional): Filter berdasarkan tipe transaksi
  - `reference_type` (string, optional): Filter berdasarkan tipe referensi
  - `per_page` (integer, optional): Jumlah item per halaman
- **Response**: CustomerCreditCollection (Paginated)

##### store()
- **HTTP Method**: POST
- **Path**: `/customers/{customer}/credits`
- **Description**: Menambah transaksi kredit baru
- **Parameters**:
  - `customer` (UUID): ID pelanggan
- **Request**: CustomerCreditRequest
  ```php
  {
      "transaction_type": "enum:increase,decrease,adjustment",
      "amount": "numeric|required",
      "reference_type": "enum:sales_order,payment,credit_note,manual",
      "reference_id": "uuid|nullable",
      "notes": "string|nullable"
  }
  ```
- **Response**: CustomerCreditResource

##### show()
- **HTTP Method**: GET
- **Path**: `/customers/{customer}/credits/{credit}`
- **Description**: Menampilkan detail transaksi kredit
- **Parameters**:
  - `customer` (UUID): ID pelanggan
  - `credit` (UUID): ID transaksi kredit
- **Response**: CustomerCreditResource

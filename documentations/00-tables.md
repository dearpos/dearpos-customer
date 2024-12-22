# Customer Management

## Deskripsi
Modul ini mengelola semua data yang berkaitan dengan pelanggan, termasuk grup pelanggan, data pribadi, alamat, dan kontak.

## Tables

### Customer Groups (`customer_groups`)

#### Columns
-   `id` - UUID, Primary Key
-   `name` - String(100)
-   `description` - Text, Nullable
-   `discount_percentage` - Decimal(5,2), Default 0
-   `is_active` - Boolean, Default true
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Memiliki banyak customers (one-to-many)

#### Indexes
- `customer_groups_name_unique` pada kolom `name`

#### Business Rules
- Nama grup harus unik
- Persentase diskon tidak boleh negatif dan maksimal 100%
- Setidaknya harus ada satu grup default untuk pelanggan baru

#### Sample Data
```php
[
    [
        'name' => 'Regular',
        'description' => 'Regular customers without special discount',
        'discount_percentage' => 0,
        'is_active' => true
    ],
    [
        'name' => 'VIP',
        'description' => 'VIP customers with special discount',
        'discount_percentage' => 10,
        'is_active' => true
    ]
]
```

### Customers (`customers`)

#### Columns
-   `id` - UUID, Primary Key
-   `group_id` - UUID, Nullable, Foreign Key to customer_groups
-   `code` - String(50), Unique
-   `name` - String(100)
-   `email` - String(100), Nullable, Unique
-   `phone` - String(20), Nullable
-   `mobile` - String(20), Nullable
-   `tax_number` - String(50), Nullable
-   `credit_limit` - Decimal(15,4), Default 0
-   `current_balance` - Decimal(15,4), Default 0
-   `notes` - Text, Nullable
-   `status` - Enum ['active', 'inactive', 'blocked']
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to customer_groups
- Has many customer_addresses
- Has many customer_contacts

#### Indexes
- `customers_code_unique` pada kolom `code`
- `customers_email_unique` pada kolom `email`
- `customers_group_id_index` pada kolom `group_id`

#### Business Rules
- Kode pelanggan harus unik
- Email harus valid jika diisi
- Credit limit harus lebih besar atau sama dengan 0
- Current balance tidak boleh melebihi credit limit
- Status default adalah 'active'

#### Sample Data
```php
[
    [
        'group_id' => '[UUID dari Regular Group]',
        'code' => 'CUST001',
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '021-5555555',
        'mobile' => '08123456789',
        'tax_number' => '123456789',
        'credit_limit' => 5000000,
        'current_balance' => 0,
        'status' => 'active'
    ]
]
```

### Customer Addresses (`customer_addresses`)

#### Columns
-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
-   `address_type` - Enum ['billing', 'shipping', 'both']
-   `address_line_1` - String(255)
-   `address_line_2` - String(255), Nullable
-   `city` - String(100)
-   `state` - String(100)
-   `postal_code` - String(20)
-   `country` - String(100)
-   `is_default` - Boolean, Default false
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to customers

#### Indexes
- `customer_addresses_customer_id_index` pada kolom `customer_id`

#### Business Rules
- Setiap pelanggan harus memiliki minimal satu alamat
- Hanya boleh ada satu alamat default per tipe alamat per pelanggan
- Jika alamat terakhir, tidak bisa dihapus

#### Sample Data
```php
[
    [
        'customer_id' => '[UUID dari Customer]',
        'address_type' => 'both',
        'address_line_1' => 'Jl. Sudirman No. 1',
        'city' => 'Jakarta',
        'state' => 'DKI Jakarta',
        'postal_code' => '12190',
        'country' => 'Indonesia',
        'is_default' => true
    ]
]
```

### Customer Contacts (`customer_contacts`)

#### Columns
-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
-   `name` - String(100)
-   `position` - String(100), Nullable
-   `phone` - String(20), Nullable
-   `mobile` - String(20), Nullable
-   `email` - String(100), Nullable
-   `is_primary` - Boolean, Default false
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to customers

#### Indexes
- `customer_contacts_customer_id_index` pada kolom `customer_id`
- `customer_contacts_email_index` pada kolom `email`

#### Business Rules
- Setiap pelanggan hanya boleh memiliki satu kontak primer
- Email harus valid jika diisi
- Setidaknya salah satu dari phone atau mobile harus diisi

#### Sample Data
```php
[
    [
        'customer_id' => '[UUID dari Customer]',
        'name' => 'Jane Doe',
        'position' => 'Purchasing Manager',
        'phone' => '021-5555556',
        'mobile' => '08123456780',
        'email' => 'jane.doe@example.com',
        'is_primary' => true
    ]
]
```

### Customer Credit History (`customer_credit_history`)

#### Columns
-   `id` - UUID, Primary Key
-   `customer_id` - UUID, Foreign Key to customers
-   `transaction_type` - Enum ['increase', 'decrease', 'adjustment']
-   `amount` - Decimal(15,4)
-   `reference_type` - Enum ['sales_order', 'payment', 'credit_note', 'manual']
-   `reference_id` - UUID, Nullable
-   `notes` - Text, Nullable
-   `created_by` - UUID, Foreign Key to users
-   `created_at` - Timestamp
-   `updated_at` - Timestamp
-   `deleted_at` - Timestamp, Nullable

#### Relationships
- Belongs to customers
- Belongs to users

#### Indexes
- `customer_credit_history_customer_id_index` pada kolom `customer_id`
- `customer_credit_history_reference_id_index` pada kolom `reference_id`

#### Business Rules
- Setiap transaksi harus memiliki jenis transaksi yang valid
- Jumlah transaksi harus lebih besar dari 0
- Referensi harus valid jika diisi
- Catatan harus diisi jika transaksi jenis 'adjustment'

#### Sample Data
```php
[
    [
        'customer_id' => '[UUID dari Customer]',
        'transaction_type' => 'increase',
        'amount' => 1000000,
        'reference_type' => 'sales_order',
        'reference_id' => '[UUID dari Sales Order]',
        'notes' => 'Pembayaran sales order',
        'created_by' => '[UUID dari User]'
    ]
]
```

### Customer Audits (`customer_audits`)

#### Columns
-   `id` - UUID, Primary Key
-   `auditable_type` - String(100) # customers, customer_groups, etc.
-   `auditable_id` - UUID
-   `event` - Enum ['created', 'updated', 'deleted', 'status_changed', 'credit_changed']
-   `old_values` - JSON, Nullable
-   `new_values` - JSON, Nullable
-   `user_id` - UUID, Foreign Key to users
-   `created_at` - Timestamp

#### Relationships
- Belongs to users

#### Indexes
- `customer_audits_auditable_id_index` pada kolom `auditable_id`
- `customer_audits_user_id_index` pada kolom `user_id`

#### Business Rules
- Setiap perubahan harus memiliki jenis perubahan yang valid
- Nilai lama dan baru harus diisi jika perubahan jenis 'updated'
- Pengguna harus diisi jika perubahan jenis 'created' atau 'updated'

#### Sample Data
```php
[
    [
        'auditable_type' => 'customers',
        'auditable_id' => '[UUID dari Customer]',
        'event' => 'updated',
        'old_values' => '{"name": "John Doe", "email": "john.doe@example.com"}',
        'new_values' => '{"name": "Jane Doe", "email": "jane.doe@example.com"}',
        'user_id' => '[UUID dari User]'
    ]
]
```

# Customer Management Testing

## Deskripsi
Dokumentasi ini menjelaskan pengujian yang harus dilakukan untuk modul manajemen pelanggan.

## Unit Tests

### CustomerTest

#### Test Cases
1. `test_can_create_customer()`
   - Memastikan pelanggan baru dapat dibuat dengan data valid
   - Memverifikasi semua atribut tersimpan dengan benar

2. `test_cannot_create_customer_with_duplicate_code()`
   - Memastikan sistem menolak pembuatan pelanggan dengan kode yang sudah ada
   - Memverifikasi error yang sesuai ditampilkan

3. `test_can_update_customer()`
   - Memastikan data pelanggan dapat diperbarui
   - Memverifikasi perubahan tersimpan dengan benar

4. `test_can_delete_customer()`
   - Memastikan pelanggan dapat dihapus (soft delete)
   - Memverifikasi data tidak dapat diakses setelah dihapus

5. `test_can_manage_customer_balance()`
   - Memastikan saldo pelanggan dapat diperbarui
   - Memverifikasi validasi credit limit berfungsi

### CustomerGroupTest

#### Test Cases
1. `test_can_create_group()`
   - Memastikan grup pelanggan baru dapat dibuat
   - Memverifikasi atribut tersimpan dengan benar

2. `test_cannot_create_group_with_duplicate_name()`
   - Memastikan sistem menolak nama grup yang duplikat
   - Memverifikasi error yang sesuai

3. `test_can_update_group()`
   - Memastikan data grup dapat diperbarui
   - Memverifikasi perubahan tersimpan dengan benar

4. `test_cannot_delete_group_with_customers()`
   - Memastikan grup dengan pelanggan aktif tidak dapat dihapus
   - Memverifikasi error yang sesuai

## Feature Tests

### CustomerApiTest

#### Test Cases
1. `test_can_list_customers()`
   - Memverifikasi endpoint GET /customers berfungsi
   - Memastikan paginasi berfungsi
   - Memastikan filter berfungsi

2. `test_can_create_customer_via_api()`
   - Memverifikasi endpoint POST /customers berfungsi
   - Memastikan validasi request berfungsi
   - Memastikan response sesuai format

3. `test_can_update_customer_via_api()`
   - Memverifikasi endpoint PUT /customers/{id} berfungsi
   - Memastikan validasi request berfungsi
   - Memastikan response sesuai format

4. `test_can_delete_customer_via_api()`
   - Memverifikasi endpoint DELETE /customers/{id} berfungsi
   - Memastikan soft delete berfungsi

### CustomerGroupApiTest

#### Test Cases
1. `test_can_list_groups()`
   - Memverifikasi endpoint GET /customer-groups berfungsi
   - Memastikan paginasi berfungsi
   - Memastikan filter berfungsi

2. `test_can_create_group_via_api()`
   - Memverifikasi endpoint POST /customer-groups berfungsi
   - Memastikan validasi request berfungsi
   - Memastikan response sesuai format

3. `test_can_update_group_via_api()`
   - Memverifikasi endpoint PUT /customer-groups/{id} berfungsi
   - Memastikan validasi request berfungsi
   - Memastikan response sesuai format

4. `test_can_delete_group_via_api()`
   - Memverifikasi endpoint DELETE /customer-groups/{id} berfungsi
   - Memastikan validasi bisnis berfungsi

## Integration Tests

### CustomerServiceTest

#### Test Cases
1. `test_customer_creation_with_group()`
   - Memastikan pembuatan pelanggan dengan grup berfungsi
   - Memverifikasi relasi tersimpan dengan benar

2. `test_customer_balance_updates()`
   - Memastikan update saldo memperhatikan credit limit
   - Memverifikasi perhitungan saldo akurat

3. `test_customer_soft_delete_cascade()`
   - Memastikan soft delete tidak menghapus data terkait
   - Memverifikasi data dapat direstorasi

## Command Tests

### CustomerCommandTest

#### Test Cases
1. `test_customer_import_command()`
   - Memastikan import dari CSV berfungsi
   - Memverifikasi validasi data import

2. `test_customer_export_command()`
   - Memastikan export ke CSV berfungsi
   - Memverifikasi format output sesuai

3. `test_customer_cleanup_command()`
   - Memastikan pembersihan data berfungsi
   - Memverifikasi kriteria pembersihan tepat

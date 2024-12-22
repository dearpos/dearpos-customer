# Customer Management Functions

## Deskripsi
Dokumentasi ini menjelaskan fungsi-fungsi helper yang tersedia dalam modul manajemen pelanggan.

## Facade Functions

### Customer Facade

#### getCustomerById(string $id): ?Customer
- **Deskripsi**: Mengambil data pelanggan berdasarkan ID
- **Parameters**:
  - `$id` (string): UUID pelanggan
- **Returns**: Customer|null
- **Throws**: CustomerNotFoundException

#### getCustomerByCode(string $code): ?Customer
- **Deskripsi**: Mengambil data pelanggan berdasarkan kode
- **Parameters**:
  - `$code` (string): Kode pelanggan
- **Returns**: Customer|null
- **Throws**: CustomerNotFoundException

#### createCustomer(array $data): Customer
- **Deskripsi**: Membuat pelanggan baru
- **Parameters**:
  - `$data` (array): Data pelanggan
- **Returns**: Customer
- **Throws**: CustomerValidationException

#### updateCustomer(string $id, array $data): Customer
- **Deskripsi**: Memperbarui data pelanggan
- **Parameters**:
  - `$id` (string): UUID pelanggan
  - `$data` (array): Data yang akan diupdate
- **Returns**: Customer
- **Throws**: CustomerNotFoundException, CustomerValidationException

#### deleteCustomer(string $id): bool
- **Deskripsi**: Menghapus pelanggan
- **Parameters**:
  - `$id` (string): UUID pelanggan
- **Returns**: bool
- **Throws**: CustomerNotFoundException

#### updateCustomerBalance(string $id, float $amount): Customer
- **Deskripsi**: Memperbarui saldo pelanggan
- **Parameters**:
  - `$id` (string): UUID pelanggan
  - `$amount` (float): Jumlah perubahan saldo
- **Returns**: Customer
- **Throws**: CustomerNotFoundException, InsufficientCreditException

### CustomerGroup Facade

#### getGroupById(string $id): ?CustomerGroup
- **Deskripsi**: Mengambil data grup pelanggan berdasarkan ID
- **Parameters**:
  - `$id` (string): UUID grup
- **Returns**: CustomerGroup|null
- **Throws**: CustomerGroupNotFoundException

#### createGroup(array $data): CustomerGroup
- **Deskripsi**: Membuat grup pelanggan baru
- **Parameters**:
  - `$data` (array): Data grup
- **Returns**: CustomerGroup
- **Throws**: CustomerGroupValidationException

#### updateGroup(string $id, array $data): CustomerGroup
- **Deskripsi**: Memperbarui data grup pelanggan
- **Parameters**:
  - `$id` (string): UUID grup
  - `$data` (array): Data yang akan diupdate
- **Returns**: CustomerGroup
- **Throws**: CustomerGroupNotFoundException, CustomerGroupValidationException

#### deleteGroup(string $id): bool
- **Deskripsi**: Menghapus grup pelanggan
- **Parameters**:
  - `$id` (string): UUID grup
- **Returns**: bool
- **Throws**: CustomerGroupNotFoundException, GroupHasCustomersException

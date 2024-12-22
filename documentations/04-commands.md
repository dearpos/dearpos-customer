# Customer Management Commands

## Deskripsi
Dokumentasi ini menjelaskan command-command Artisan yang tersedia dalam modul manajemen pelanggan.

## Available Commands

### customer:create
- **Signature**: `customer:create {name} {--code=} {--email=} {--group=}`
- **Deskripsi**: Membuat pelanggan baru melalui command line
- **Arguments**:
  - `name`: Nama pelanggan (required)
- **Options**:
  - `--code`: Kode pelanggan (optional)
  - `--email`: Email pelanggan (optional)
  - `--group`: ID grup pelanggan (optional)
- **Example**:
  ```bash
  php artisan customer:create "John Doe" --code=CUST001 --email=john@example.com --group=uuid
  ```

### customer:import
- **Signature**: `customer:import {file} {--format=csv}`
- **Deskripsi**: Mengimpor data pelanggan dari file
- **Arguments**:
  - `file`: Path ke file import (required)
- **Options**:
  - `--format`: Format file (default: csv)
- **Example**:
  ```bash
  php artisan customer:import customers.csv
  ```

### customer:export
- **Signature**: `customer:export {file} {--format=csv}`
- **Deskripsi**: Mengekspor data pelanggan ke file
- **Arguments**:
  - `file`: Path untuk file output (required)
- **Options**:
  - `--format`: Format file (default: csv)
- **Example**:
  ```bash
  php artisan customer:export customers.csv
  ```

### customer:cleanup
- **Signature**: `customer:cleanup {--days=30}`
- **Deskripsi**: Membersihkan data pelanggan yang sudah dihapus (soft delete)
- **Options**:
  - `--days`: Jumlah hari sejak penghapusan (default: 30)
- **Example**:
  ```bash
  php artisan customer:cleanup --days=60
  ```

### customer:sync-balance
- **Signature**: `customer:sync-balance`
- **Deskripsi**: Menyinkronkan saldo pelanggan berdasarkan transaksi
- **Example**:
  ```bash
  php artisan customer:sync-balance
  ```

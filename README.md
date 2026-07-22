# Quản lý Danh mục (MiniShop CSE485)

## 📌 Thông tin Cơ sở dữ liệu
- **Database Name**: `minishop_cse485`
- **User**: `root`
- **Password**: `` (để trống - mặc định trên XAMPP)
- **Host**: `127.0.0.1`

---

## 🛠️ Hướng dẫn Import CSDL (`schema.sql`)

### Cách 1: Sử dụng phpMyAdmin
1. Mở phpMyAdmin (`http://localhost/phpmyadmin`).
2. Nhấp vào tab **Import** ở menu trên cùng.
3. Chọn file `schema.sql` và nhấn **Go**.

### Cách 2: Sử dụng dòng lệnh MySQL CLI
```bash
mysql -u root -p < schema.sql

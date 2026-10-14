# Tập huấn công nghệ số và AI trong quản lý trường học

Trang tương tác cho 3 buổi, 18 phần nội dung, do thầy giáo Nguyễn Hồng Dân trình bày.

## Chức năng

- Nội dung, mô hình, tình huống, khảo sát và bài thực hành.
- Quản trị mở/ẩn từng phần, nhận bài, công bố kết quả và chọn sản phẩm chia sẻ.
- Học viên truy cập bằng link; đồng bộ trạng thái khoảng 5 giây.
- Chế độ trình chiếu, đồng hồ, thông báo, bản nháp và xuất CSV.
- Giao diện trên điện thoại/máy tính; không cần khóa API AI.

## Triển khai nhanh

1. Tải mã nguồn vào một thư mục mới trên hosting PHP.
2. Sao chép `config.example.php` thành `config.php` trên hosting. Đặt `setup_key` riêng, ngẫu nhiên, ít nhất 24 ký tự; không sử dụng giá trị mẫu.
3. PHP cần có quyền ghi thư mục dữ liệu. Có thể đặt `data_dir` ngoài thư mục web.
4. Mở `index.html`, chọn **Quản trị**, dùng `setup_key` và đặt mật khẩu ít nhất 12 ký tự.
5. Mở nội dung rồi gửi link `index.html` cho học viên.

**Cần hosting chạy PHP. GitHub Pages chỉ phục vụ tệp tĩnh, không chạy API PHP của ứng dụng này.**

Xem [HUONG-DAN.md](HUONG-DAN.md) để cài đặt, kiểm tra và điều hành lớp.

## Cấu hình riêng

Không đưa `config.php`, mật khẩu, dữ liệu học viên hoặc bản sao lưu lên GitHub. `.gitignore` đã loại các tệp này. Repository chỉ chứa cấu hình mẫu.

## Kiểm tra

Đã kiểm tra logic giao diện và chức năng API bằng PHP 8.2 WebAssembly; cú pháp PHP được kiểm tra ở mức PHP 5.6. Cần thử session, quyền ghi, phiên bản PHP và giao diện trên hosting trước lớp thật.

Dữ liệu, văn bản chỉ đạo và ghi chép họp dùng trong bài tập là giả lập.

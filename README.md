# Tập huấn AI — màn điều khiển và màn trình chiếu

Báo cáo viên Nguyễn Hồng Dân. Trang dành cho chương trình tập huấn cán bộ quản lý trường phổ thông, 3 buổi / 18 phần, có nội dung tự tạo.

## Ba địa chỉ

- `control.html`: màn điều khiển của báo cáo viên, cần đăng nhập quản trị.
- `screen.html`: màn trình chiếu, mở trên máy chiếu/màn hình lớn; tự đồng bộ khoảng 2 giây.
- `index.html`: trang học viên. QR đưa tới `index.html?checkin=1`.

Trên hosting của trường:

- https://noitruxinman.edu.vn/taphuan/control.html
- https://noitruxinman.edu.vn/taphuan/screen.html
- https://noitruxinman.edu.vn/taphuan/

## Chức năng

- Maket: tải ảnh/video lên hosting, phủ kín hoặc hiện trọn màn hình; phát, dừng, phát lại và bật/tắt âm.
- Kiểm diện bằng QR: bắt buộc họ tên, chức vụ, đơn vị, số điện thoại; lưu xong tự đăng nhập.
- Tài khoản = số điện thoại; mật khẩu ban đầu = tên gọi không dấu, viết thường + 3 số cuối điện thoại.
- Nguyễn Hồng Dân + 0888770799 → tài khoản 0888770799, mật khẩu dan799. Hệ thống dùng đúng số đã nhập.
- Đăng nhập lại, chặn tạo trùng số điện thoại, quản trị đặt lại mật khẩu và xuất danh sách CSV.
- Tự tạo khảo sát, câu hỏi trò chơi 2–6 phương án; mở nhận, tính giờ, công bố đáp án/phân bố và bảng điểm.
- Tự soạn văn bản, tải ảnh/PDF/TXT/DOCX, chia trang bằng dòng `---`, điều khiển trang PDF.
- Giữ nội dung 3 buổi và các phản hồi cũ; chiếu từng phần nội dung, tình huống, thực hành, câu lệnh.
- Footer nhỏ trên cả ba trang theo nội dung thầy yêu cầu.

## Cập nhật cPanel

`Update from Remote` → `Deploy HEAD Commit`.

`.cpanel.yml` triển khai vào `/home/capnachi/noitruxinman.edu.vn/taphuan/`, sao chép cả `assets/`. Không ghi đè `config.php`, không xóa `workshop-data/` hoặc `workshop-media/` đã có.

GitHub Pages không chạy API PHP; cần hosting PHP. Không đưa cấu hình riêng, mật khẩu, dữ liệu học viên hoặc tệp tải lên vào GitHub.

Xem [HUONG-DAN.md](HUONG-DAN.md) để cài đặt và sử dụng. QR được tạo tại trình duyệt bằng qrcode-generator; không gọi dịch vụ QR bên ngoài. Thông tin giấy phép trong `assets/THIRD-PARTY.txt`.

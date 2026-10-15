# Tập huấn AI — phiên bản 4, khảo sát thực trạng và phân tích AI

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

- Giao diện xanh sáng, thẻ thống kê, biểu tượng SVG và họa tiết tech/AI chìm; ba màn hình dùng chung phong cách.
- Nút Chiếu cho từng ý nội dung, mô hình, nhiệm vụ, sản phẩm, công cụ, tình huống và câu lệnh; trình chiếu bản nháp AI.
- Cài đặt AI dùng một khóa API Gemini hoặc OpenAI cho toàn bộ bảng điều khiển. Khóa mã hóa trên hosting; không đưa vào GitHub hay phản hồi học viên.
- AI hỗ trợ soạn/chỉnh nội dung, lời dẫn maket, khảo sát, câu hỏi trò chơi, phân tích kết quả và tổ chức lớp. Bản nháp đưa vào biểu mẫu mới để duyệt rồi lưu.
- Mọi khảo sát/trò chơi yêu cầu tài khoản kiểm diện; quản trị xem danh sách đã/chưa trả lời từ chính các tài khoản đó.

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

## Bật trợ lý AI

Điều khiển → Cài đặt AI → chọn Gemini/OpenAI → dán khóa API → Lưu cài đặt → Kiểm tra kết nối. Model đã điền sẵn và có thể đổi theo quyền của khóa. Hosting cần PHP cURL, OpenSSL và kết nối HTTPS tới nhà cung cấp. Có thể dùng các chức năng tập huấn không có AI khi chưa nhập khóa. AI maket cung cấp lời dẫn/kịch bản/gợi ý hình ảnh; không tự sinh tệp ảnh hay video.

## Khảo sát thực trạng 15 câu (bản 4)

Mục **Khảo sát thực trạng** đã có sẵn bộ 15 câu, 4 nhóm: bức tranh hiện tại; thuận lợi/nguồn lực; khó khăn/điểm nghẽn; giải pháp/ưu tiên. Học viên dùng tài khoản kiểm diện để gửi một phiếu đầy đủ, có thể cập nhật khi còn mở. Câu chọn nhiều cho phép 1–3 phương án, câu cuối chia sẻ thực tế.

Báo cáo viên: **Chiếu mở đầu → Mở nhận 15 câu → Kết thúc & tự phân tích AI**. Giữ trang điều khiển mở để khởi chạy yêu cầu AI. Dữ liệu thống kê được tổng hợp ngay; khóa AI hiện có được dùng để tạo và lưu báo cáo 7 phần. Có biểu đồ từng câu, danh sách đã/chưa gửi, xuất CSV thống kê, tải báo cáo TXT và nút chiếu từng phần. Lỗi API không làm mất phiếu, có nút thử lại.

Không có cron/chạy nền khi mọi trang điều khiển đều đóng. Có thể mở lại điều khiển để xử lý tác vụ đang chờ. Phiếu và báo cáo lưu trên hosting, không đưa vào GitHub.

## Sửa lỗi model/phiên bản API (bản 5)

Cập nhật trên cPanel rồi vào **Cài đặt AI → Tự chọn model & kiểm tra**. Nếu khóa đã lưu, giữ ô khóa trống. Model `auto` lấy danh sách thực từ nhà cung cấp: Gemini chỉ chọn model Flash ổn định có `generateContent`, không tự chuyển sang Pro; OpenAI chọn model nhỏ trong danh sách hỗ trợ của ứng dụng khi được API liệt kê. Không bảo đảm quyền/hạn mức chỉ từ danh sách, vì vậy phải thử kết nối.

Có **Lưu & tải danh sách model** để chọn thủ công. **Lưu & kiểm tra kết nối** luôn dùng cấu hình vừa nhập, hiển thị model thực tế hoặc lỗi HTTP/chi tiết nhà cung cấp đã che khóa. Cấu hình cũ không bị ghi đè khi deploy; bấm nút tự chọn để chuyển model đang lưu sang `auto`.

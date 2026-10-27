# Cổng tập huấn AI

Website tập huấn dành cho cán bộ quản lý trường phổ thông. Một giao diện thống nhất cho năm mục, không sử dụng màn chiếu riêng.

## Năm mục chính

1. **Trang chủ:** lời chào, tên đợt tập huấn, giới thiệu, báo cáo viên, đơn vị tổ chức, thời gian, địa điểm và thông báo. Quản trị sửa trực tiếp trên website.
2. **Kiểm diện:** mã QR dẫn đến popup điểm danh. Chọn trường có một người sẽ tự điền tên/chức vụ; trường có nhiều người cho chọn đúng người. Thông tin còn thiếu được nhập bổ sung. Nhập số điện thoại rồi bấm Điểm danh để tự vào tài khoản. Danh sách bổ sung được lưu trên hosting và xuất hiện trên thiết bị khác/lần sau. Điểm danh lại bằng cùng tên, trường và số điện thoại dùng lại tài khoản, giữ nguyên phiếu khảo sát.
3. **Khảo sát:** giữ bộ 15 câu hiện có (câu chọn một/chọn nhiều và một câu chia sẻ thực tế), mỗi tài khoản một phiếu, cập nhật khi còn mở. Quản trị có danh sách đã/chưa gửi, biểu đồ từng câu, tỷ lệ hoàn thành, xuất CSV, công bố/ẩn kết quả và phân tích AI.
4. **Nội dung tập huấn:** khởi tạo 18 chuyên đề từ nội dung 3 buổi hiện có, phân nhóm, tìm kiếm, xem nội dung và sao chép câu lệnh. Quản trị thêm/sửa/xóa, đặt thứ tự, thời lượng và công bố/giữ nháp. AI điền bản nháp vào biểu mẫu để người dùng kiểm tra trước khi lưu.
5. **Công cụ:** danh sách công cụ, liên kết, hướng dẫn và câu lệnh mẫu; có thư viện câu lệnh theo chuyên đề. Quản trị thêm/sửa/xóa.

## Địa chỉ

- `index.html`: cổng tập huấn; nút **Quản trị** để đăng nhập.
- `control.html`: địa chỉ quản trị cũ vẫn mở cùng cổng mới.
- `index.html?checkin=1`: popup điểm danh tự mở khi chưa vào tài khoản; được dùng cho QR.
- `screen.html`: tự chuyển về `index.html`, không còn chế độ màn chiếu.

## Cài đặt và nâng cấp cPanel

Hosting cần PHP có session, JSON, OpenSSL, password_hash, hash_equals và quyền ghi thư mục dữ liệu. AI cần thêm PHP cURL và kết nối HTTPS tới Gemini/OpenAI. Không chạy API này bằng GitHub Pages.

1. Lần đầu: sao chép `config.example.php` thành `config.php`, thay `setup_key` bằng chuỗi riêng ít nhất 24 ký tự. Mở website → Quản trị → khởi tạo mật khẩu ít nhất 12 ký tự.
2. Khi nâng cấp: sao lưu `config.php`, `workshop-data/`, `workshop-media/` bằng chức năng backup của hosting. Cập nhật mã nguồn bằng **Update from Remote → Deploy HEAD Commit** sau khi thay đổi được gộp vào nhánh triển khai.
3. `.cpanel.yml` có sẵn đường dẫn triển khai của trường. Nếu dùng hosting khác, sửa đường dẫn trong tệp này trước khi triển khai.
4. Deploy giữ `config.php`, không xóa thư mục dữ liệu hoặc tệp tải lên. Các tệp mới `portal.php` và `roster-seed.php` được triển khai cùng mã nguồn.
5. Tải lại trang để dùng tài nguyên `v=8`. Vào Quản trị → Trang chủ → Sửa thông tin để điền thời gian, địa điểm và đơn vị tổ chức.

Dữ liệu chuyên đề, công cụ và thông tin đợt tập huấn được khởi tạo khi mở cổng mới và lưu cùng trạng thái ở lần ghi tiếp theo. Nội dung gốc được đọc từ `course.php`; danh sách trường/người gốc từ `roster-seed.php`. Khi đã khởi tạo, dữ liệu biên tập trên hosting là dữ liệu chính, không bị thay bằng nội dung gốc mỗi lần deploy. Phiếu khảo sát, tài khoản và phản hồi cũ không bị xóa.

## AI

Quản trị → Cài đặt AI → chọn Gemini/OpenAI → nhập khóa → Lưu & kiểm tra kết nối. Để model `auto` hoặc tải danh sách để chọn. Khóa mã hóa trên hosting, không gửi về học viên. Chưa cấu hình AI vẫn sử dụng được kiểm diện, khảo sát, chuyên đề và công cụ.

Tại Nội dung tập huấn → Tạo bằng AI, nhập yêu cầu và bấm Tạo bản nháp vào biểu mẫu. Chỉnh sửa, đánh dấu Công bố nếu muốn, rồi Lưu thay đổi. AI không tự lưu hoặc công bố chuyên đề.

Khi kết thúc khảo sát, trang đã đăng nhập quản trị sẽ khởi chạy phân tích AI nếu có phản hồi. Giữ trang mở để xử lý; không có cron/chạy nền khi đóng mọi trang quản trị. Nếu lỗi khóa/hạn mức, dữ liệu khảo sát vẫn được giữ, có thể cấu hình lại và thử lại. Báo cáo AI cần được thẩm định trước khi công bố.

## Quyền và dữ liệu

- Thông tin công khai trong danh sách chọn trường chỉ gồm trường, họ tên và chức vụ; số điện thoại chỉ trả cho chính tài khoản và quản trị.
- Chỉ quản trị được sửa thông tin, chuyên đề, công cụ, điều khiển khảo sát và gọi AI.
- Mọi thao tác ghi kiểm tra CSRF. Nội dung hiển thị được escape; liên kết chỉ nhận HTTP/HTTPS; CSV xử lý ô bắt đầu bằng ký tự công thức.
- Khi nhiều quản trị cùng sửa, phiên bản cũ bị từ chối để tránh ghi đè nội dung vừa thay đổi.
- Không đưa `config.php`, `workshop-data/`, `workshop-media/` hay khóa API vào GitHub.

## Kiểm thử

Node.js 18+ và PHP CLI:

```bash
node tests/renderers.cjs
PHP_BIN=/path/to/php node tests/integration.cjs
```

Kiểm thử API tự tạo bản sao và dữ liệu giả trong thư mục tạm, không đọc/ghi cấu hình thật. Phạm vi: nâng cấp dữ liệu cũ, điểm danh mới/lại, chống trùng số điện thoại, lưu danh sách, gửi/cập nhật khảo sát theo tài khoản, quyền truy cập, CRUD và xung đột phiên bản. Kiểm thử kết xuất: năm mục, biểu mẫu 15 câu, thống kê, escape nội dung/liên kết và các trường hợp tự điền theo trường. Không gọi API AI thật.

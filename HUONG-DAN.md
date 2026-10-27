# Hướng dẫn cổng tập huấn

## Dành cho học viên

1. Mở website và chọn **Kiểm diện**, hoặc quét mã QR để mở popup trên điện thoại.
2. Chọn đúng trường. Nếu trường có một người, tên và chức vụ tự điền. Nếu trường có nhiều người, chọn đúng tên mình.
3. Nếu chưa có tên, chọn **Bổ sung người chưa có tên**; nếu trường chưa có người hoặc người chưa có chức vụ, nhập phần còn thiếu. Nếu chưa có trường, chọn **Trường khác / Bổ sung trường**.
4. Nhập số điện thoại 10 chữ số bắt đầu bằng 0 (cũng nhận +84), bấm **Điểm danh**. Website tự vào tài khoản và lưu thông tin bổ sung cho lần sau.
5. Vào **Khảo sát**, trả lời đủ 15 câu và bấm **Gửi toàn bộ 15 câu**. Mỗi tài khoản có một phiếu; được sửa khi quản trị còn mở nhận.
6. Vào **Nội dung tập huấn** để đọc chuyên đề, thực hành và sao chép câu lệnh. Mục **Công cụ** có liên kết và các mẫu câu lệnh.

Điểm danh lại: sử dụng đúng trường, tên và số điện thoại đã đăng ký để vào lại cùng tài khoản. Nếu có thông tin sai hoặc thay số điện thoại, nhờ quản trị hỗ trợ; không tạo một người khác để thay tài khoản cũ. Khi dùng chung thiết bị, bấm tên ở góc trên → Đổi người / Đăng xuất.

## Dành cho quản trị

Mở `control.html` hoặc dùng nút **Quản trị** trên cổng. Lần đầu cần mã khởi tạo trong `config.php` và mật khẩu mới ít nhất 12 ký tự. Các lần sau chỉ nhập mật khẩu quản trị.

### Trang chủ

Bấm **Sửa thông tin** để đổi lời chào, tên chương trình, giới thiệu ngắn, báo cáo viên, đơn vị tổ chức, thời gian, địa điểm, nội dung giới thiệu và thông báo. Lưu xong các thiết bị nhận thông tin mới khi đồng bộ.

### Kiểm diện

Mã QR dùng địa chỉ website đang mở, dẫn tới `index.html?checkin=1`. Chia sẻ bằng **Sao chép liên kết**. Danh sách quản trị hiển thị người đã điểm danh, chức vụ, trường, số điện thoại và trạng thái khảo sát. Có bộ lọc và xuất CSV.

Nếu đã vào tài khoản trên thiết bị, quét QR không tạo người mới; bấm tên để xem tài khoản hoặc đổi người.

### Khảo sát

- **Mở nhận khảo sát:** cho phép gửi/cập nhật, giữ phiếu cũ khi mở lại.
- **Kết thúc khảo sát:** dừng nhận và công bố thống kê; khởi chạy phân tích AI khi có phiếu. Có thể ẩn kết quả với học viên bằng nút tương ứng.
- **Tiến độ theo tài khoản:** lọc tất cả / đã khảo sát / chưa khảo sát, xuất CSV danh sách.
- **Kết quả:** biểu đồ từng câu ghi số người chọn và tỷ lệ. Câu chọn nhiều có tổng tỷ lệ vượt 100%; tỷ lệ tính theo người trả lời, không phải theo số trường.
- **Phân tích AI:** giữ trang quản trị mở để xử lý. Chưa có khóa hoặc bị giới hạn API có thể cấu hình lại rồi bấm Phân tích bằng AI. Kiểm chứng báo cáo và dùng **Công bố báo cáo AI** nếu muốn học viên xem.
- **Xuất thống kê CSV:** kết quả tổng hợp theo từng câu, không xuất nguyên văn phần chia sẻ cá nhân.

Bộ hiện có gồm câu chọn một, câu chọn nhiều 1–3 phương án và câu 15 chia sẻ thực tế. Giữ cấu trúc này để dùng được phiếu đã thu từ phiên bản trước.

### Nội dung tập huấn

Chuyên đề ban đầu được lấy từ 18 phần của chương trình 3 buổi cũ. Tìm theo tên, nhóm nội dung hoặc giới thiệu. Mỗi chuyên đề gồm tên, nhóm, giới thiệu, thời lượng, thứ tự, nội dung và câu lệnh thực hành.

- **Thêm chuyên đề / Sửa:** biên tập rồi Lưu thay đổi. Đánh dấu **Công bố cho học viên** để đưa ra cổng; bỏ chọn để giữ nháp.
- **Tạo bằng AI:** nhập yêu cầu → Tạo bản nháp vào biểu mẫu → kiểm tra/chỉnh sửa → Lưu. Cần cấu hình khóa trước; AI không tự lưu/công bố.
- **Xóa:** xác nhận tên chuyên đề trước khi xóa.
- Tên nhóm nhập tự do hoặc chọn từ gợi ý; thứ tự tăng dần quyết định vị trí danh sách.

### Công cụ

Thêm/sửa/xóa công cụ, đặt nhóm, liên kết HTTP/HTTPS, mô tả và câu lệnh. Có thể chỉ thêm một mẫu câu lệnh mà không cần liên kết. Thư viện câu lệnh theo chuyên đề tự cập nhật từ các chuyên đề đang công bố.

### Cài đặt AI

Chọn nhà cung cấp, nhập khóa và model (`auto` để tự chọn), bấm **Lưu & kiểm tra kết nối**. Nếu đã lưu khóa, để ô khóa trống để giữ nguyên. Khi đổi nhà cung cấp cần nhập khóa tương ứng. Dùng **Lưu & tải danh sách model** để chọn model có trong tài khoản.

## Cập nhật và bảo toàn dữ liệu

Xem [README.md](README.md) để cài đặt, deploy cPanel và chạy kiểm thử. Sao lưu cấu hình và hai thư mục dữ liệu/tệp tải lên trước khi nâng cấp. Không chép dữ liệu học viên hoặc khóa API lên GitHub. `screen.html` chỉ chuyển về cổng, không còn màn chiếu riêng.

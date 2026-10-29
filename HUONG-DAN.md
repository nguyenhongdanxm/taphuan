# Hướng dẫn cổng tập huấn

## Dành cho học viên

1. Khi quản trị mở điểm danh, quét mã QR đang hiển thị trực tiếp. Mã thay đổi mỗi 20 giây; mã cũ không mở được phiếu. Nếu báo hết hạn, quét lại mã mới.
2. Popup ban đầu **chỉ có danh sách chọn trường**. Chọn đúng trường để hiện tên và chức vụ. Nếu trường có nhiều người, chọn tên mình.
3. Nếu chưa có tên/chức vụ, ô mời nhập phần thiếu sẽ xuất hiện. Thông tin bổ sung được lưu để lần sau tự hiện.
4. Khi đã có đủ tên và chức vụ, ô **Mời nhập số điện thoại** và nút **Điểm danh** mới xuất hiện. Số điện thoại là tài khoản đăng nhập cho lần sau. Có thể nhập số 10 chữ số bắt đầu bằng 0 hoặc +84.
5. Bấm **Điểm danh** để ghi nhận có mặt cho đúng buổi và tự vào tài khoản. Lần đầu có thông báo mật khẩu ban đầu; lưu lại để đăng nhập lần sau. Cùng một tài khoản điểm danh lại không tạo thêm người trong buổi.
6. Vào **Khảo sát** để gửi/cập nhật bộ 15 câu khi còn mở; vào **Nội dung tập huấn** và **Công cụ** để học và thực hành.

Sau khi quét hợp lệ, thầy/cô có 10 phút để điền popup. Không cần quét lại chỉ vì QR ngoài màn hình đã đổi. Nếu quá thời gian hoặc quản trị đã kết thúc buổi, quét mã mới của buổi đang mở.

Buổi tiếp theo vẫn cần quét QR mới để điểm danh, kể cả đang đăng nhập. Đăng nhập tài khoản bằng số điện thoại và mật khẩu chỉ để vào học, không tự ghi nhận có mặt. Mật khẩu ban đầu là tên gọi không dấu viết thường + 3 số cuối điện thoại. Khi dùng chung thiết bị, bấm tên → Đổi người / Đăng xuất. Nếu thay số điện thoại, nhờ quản trị hỗ trợ thay vì tạo tài khoản khác.

## Dành cho quản trị

Mở `control.html` hoặc dùng nút **Quản trị** trên cổng. Lần đầu cần mã khởi tạo trong `config.php` và mật khẩu mới ít nhất 12 ký tự. Các lần sau chỉ nhập mật khẩu quản trị.

### Trang chủ

Bấm **Sửa thông tin** để đổi lời chào, tên chương trình, giới thiệu ngắn, báo cáo viên, đơn vị tổ chức, thời gian, địa điểm, nội dung giới thiệu và thông báo. Lưu xong các thiết bị nhận thông tin mới khi đồng bộ.

### Kiểm diện theo buổi

1. Vào **Kiểm diện** → **Tạo buổi tập huấn**; nhập tên (ví dụ Buổi 1 – Sáng 28/10) và ngày → **Tạo buổi & mở QR**.
2. QR hiện ngay trong mục Kiểm diện, tự đổi sau mỗi 20 giây và có đồng hồ đếm ngược. Có thể **Phóng to QR** ngay trên trang.
3. Học viên quét và hoàn tất popup. Danh sách đã điểm danh cập nhật khi đồng bộ. Mỗi buổi có tổng dự kiến, đã/chưa điểm danh, thời điểm và CSV riêng.
4. Bấm **Kết thúc điểm danh** để đóng buổi, thu hồi QR và các popup chưa gửi. **Mở lại điểm danh** giữ số liệu nhưng cấp mã mới; mã/phiếu chưa gửi từ lượt mở trước không dùng được.
5. Dùng danh sách chọn buổi để xem lại lịch sử. Tạo/mở buổi khác tự đóng buổi đang mở.

Danh sách dự kiến được chụp khi tạo buổi, gồm những người đã có tên trong danh sách lớp. Người tự bổ sung chỉ được thêm vào buổi họ điểm danh, không làm đổi danh sách dự kiến các buổi cũ. Tài khoản cũ không tự được tính có mặt trong buổi mới.

Không dùng liên kết QR cố định. Mã có chữ ký và hết hạn được kiểm tra tại máy chủ. Mã ngắn hạn giảm việc gửi liên kết dùng lâu; người khác vẫn có thể chuyển tiếp mã ngay khi còn hạn, vì vậy báo cáo viên vẫn cần kiểm tra hiện diện khi cần.

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

## Reset/xóa điểm danh và thống kê mở rộng

- **Kiểm diện → chọn buổi → Xuất CSV trước nếu cần → Reset điểm danh buổi / Xóa buổi → gõ đúng tên buổi → xác nhận.** Reset giữ buổi để dùng lại, xóa buổi bỏ toàn bộ buổi được chọn. Tài khoản, phiếu khảo sát và các buổi khác được giữ nguyên. Buổi reset sẽ đóng; mở lại để tạo QR mới.
- **Khảo sát → Bức tranh khảo sát:** chọn buổi (nhóm người có mặt), trường hoặc chức vụ rồi Áp dụng. Đọc mẫu số, tỷ lệ hoàn thành, thuận lợi/điểm nghẽn/nhu cầu, tiến độ nhóm, ngày cập nhật phiếu và 15 biểu đồ. Bỏ bộ lọc để xem toàn đợt; Xuất thống kê đang xem CSV để lấy dữ liệu đúng phạm vi. Danh sách tài khoản phía dưới vẫn là danh sách toàn đợt.
- **Mode:** phương án được chọn nhiều nhất; các phương án cùng số lượt được ghi đồng hạng. Câu tự luận không tính mode.
- **Model AI:** bảng thông tin phân biệt model cấu hình với model thực tế của báo cáo, có thời điểm và mẫu phân tích. Cảnh báo dữ liệu đã đổi thì phân tích lại trước khi dùng kết luận. AI phân tích toàn đợt, không phải nhóm lọc. TXT và Sao chép báo cáo có kèm thông tin model.

## Thao tác mới v13

- Reset khảo sát: vào Quản trị → Khảo sát → Reset kết quả khảo sát → gõ **RESET KHAO SAT** → xác nhận. Nếu cần lưu số liệu cũ, xuất CSV trước. Sau reset bấm Mở nhận khảo sát để thu lại. Thao tác xóa phiếu, thống kê và báo cáo AI, giữ câu hỏi, tài khoản và điểm danh.
- Sửa/xóa từng người: Kiểm diện → chọn buổi → người đã điểm danh → Sửa / Xóa. Sửa thông tin ghi nhận chỉ áp dụng cho buổi đó; không đổi tài khoản học viên. Xóa cần gõ đúng họ tên để xác nhận.
- Trên điện thoại, khảo sát chia bốn nhóm. Dùng Trước/Tiếp theo hoặc chạm tên nhóm, điền đủ và Gửi toàn bộ ở nhóm cuối. Nếu thiếu câu sẽ chuyển về nhóm cần bổ sung. Không đóng tab trước khi gửi thành công. Quản trị chạm tiêu đề nhóm biểu đồ/danh sách để mở hoặc thu gọn.

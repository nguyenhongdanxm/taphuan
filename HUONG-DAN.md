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
- **Phân tích AI:** giữ trang quản trị mở để xử lý. Chưa có khóa hoặc bị giới hạn API có thể cấu hình lại rồi bấm Phân tích bằng AI. Báo cáo AI toàn đợt chỉ dành cho quản trị; học viên xem thống kê và nhận định thuộc trường mình.
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

## Quyền xem khảo sát v14

- **Cá nhân:** khi thống kê được công bố, chỉ xem số người trả lời, biểu đồ và nhận định thuộc trường đã đăng ký. Không xem báo cáo AI tổng hợp hoặc dữ liệu các trường khác.
- **Quản trị:** xem toàn đợt, tổng số đã/chưa trả lời, nhận định tự động, biểu đồ, bộ lọc và báo cáo AI. Nút Công bố thống kê trường chỉ mở quyền xem đúng phạm vi trường cho mỗi học viên.
- **Nhận định tự động** có số lượng/mẫu số và giới hạn dữ liệu; không phải xếp loại trường hoặc kết luận thẩm định. Báo cáo AI toàn đợt được quản trị xem và kiểm chứng riêng.

## Điều chỉnh danh sách tập huấn v15

1. Đăng nhập **Quản trị → Danh sách tập huấn**; dùng tìm kiếm hoặc lọc theo trường.
2. **Thêm người / Sửa:** chọn hoặc gõ tên trường, họ tên, chức vụ, số điện thoại rồi Lưu danh sách. Người chưa có tài khoản được phép để trống chức vụ/số điện thoại. Nếu điền đủ số điện thoại và chức vụ, hệ thống tạo tài khoản (chưa tính điểm danh).
3. **Thêm trường:** tạo tên trường trước khi biết tên người. Mở phần **Quản lý tên trường / đơn vị** để đổi tên trường cho danh sách và các tài khoản hiện thuộc trường đó.
4. **Xuất danh sách CSV:** xuất danh sách dự kiến và người đã có tài khoản, gồm cả trường chưa có người.

Sửa hồ sơ giữ ID và các phiếu khảo sát. Đổi số điện thoại đổi tên đăng nhập nhưng giữ mật khẩu hiện tại. Chuyển trường sẽ đổi phạm vi thống kê trường mà tài khoản được xem. Danh sách dự kiến/lượt điểm danh các buổi cũ không bị viết lại; nếu cần sửa một bản ghi lịch sử, vào Kiểm diện → đúng buổi → Sửa lượt điểm danh.


### Danh sách tập huấn v16
- Chọn từng người hoặc chọn tất cả người đang hiển thị sau khi tìm/lọc. Có thể tiếp tục chọn ở trường khác; bộ đếm là tổng đã chọn. Nhấn Xoá người đã chọn, xem tên và nhập `XOA <số người>` để xác nhận.
- Xoá chỉ bỏ tên khỏi danh sách chọn điểm danh. Tài khoản, quyền đăng nhập, số liệu khảo sát và lịch sử điểm danh vẫn giữ. Có thể khôi phục tên bằng cách thêm lại hoặc nhập Excel cùng hồ sơ.
- Tải mẫu Excel ngay trong Quản trị → Danh sách tập huấn. Xoá dòng minh hoạ; điền bốn cột `Trường`, `Họ và tên`, `Chức vụ`, `Số điện thoại`. Giữ điện thoại dạng văn bản. Chỉ nhập trang tính đầu tiên của file `.xlsx`, tối đa 200 người và 2 MB mỗi file. File `.xls` cần lưu thành `.xlsx`. Không dùng công thức ở bốn cột.
- Nhập Excel → xem trước → xác nhận. Bắt buộc trường và họ tên. Chưa có chức vụ/số điện thoại có thể để trống. Có điện thoại phải có chức vụ, tạo tài khoản với quy tắc mật khẩu hiện tại nhưng không tự điểm danh.
- Người đã có được bỏ qua nếu dữ liệu khớp; khác thông tin sẽ báo lỗi để sửa trực tiếp. Trùng tên cùng trường, trùng điện thoại hoặc dòng lỗi sẽ chặn toàn bộ lần nhập. Nếu dữ liệu thay đổi sau bước xem trước, phải xem trước lại.
- Bộ đọc/ghi XLSX tích hợp, không phụ thuộc CDN; giải nén cần trình duyệt hiện đại hỗ trợ DecompressionStream (Chrome/Edge/Safari/Firefox mới).

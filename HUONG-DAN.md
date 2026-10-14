# Hướng dẫn vận hành tập huấn AI — bản hai màn hình

## 1. Các địa chỉ

**Báo cáo viên:** https://noitruxinman.edu.vn/taphuan/control.html
**Máy chiếu:** https://noitruxinman.edu.vn/taphuan/screen.html
**Học viên:** https://noitruxinman.edu.vn/taphuan/

Có thể mở màn chiếu trên thiết bị khác, hoặc kéo tab trình chiếu sang màn hình ngoài khi máy tính đang dùng chế độ mở rộng màn hình. Trên màn chiếu bấm Toàn màn hình. Màn điều khiển chỉ có tác dụng sau khi đăng nhập quản trị; màn chiếu không hiển thị bảng điều khiển hay số điện thoại học viên.

## 2. Cập nhật từ GitHub

cPanel → Git Version Control → Manage → Pull or Deploy → Update from Remote → Deploy HEAD Commit.

Đường dẫn triển khai: /home/capnachi/noitruxinman.edu.vn/taphuan/.

Gói sao chép index.html, control.html, screen.html, api.php, studio.php, course.php, config.example.php, sample-data.csv, .htaccess và assets/. Giữ nguyên config.php, workshop-data/ và workshop-media/. Cấu hình mẫu chỉ được sao chép thành config.php nếu chưa có tệp đó. Không đổi Document Root hay sửa hệ thống CDS.

Sau khi deploy, tải lại cả màn điều khiển/màn chiếu/học viên để nhận giao diện mới. Không chỉnh tệp trong bản checkout Git ở cPanel, để Update from Remote tiếp tục hoạt động.

## 3. Cài đặt lần đầu

PHP có session, JSON, OpenSSL (hoặc random_bytes), password_hash, hash_equals, fileinfo; hỗ trợ cú pháp PHP 5.6 trở lên. DOCX cần ZipArchive. Không cần khóa API AI. JavaScript cần trình duyệt hiện đại.

Sao chép config.example.php thành config.php trên hosting, đặt setup_key riêng ít nhất 24 ký tự. Mở control.html, nhập mã khởi tạo và đặt mật khẩu quản trị ít nhất 12 ký tự. Sau này chỉ đăng nhập bằng mật khẩu quản trị; mật khẩu đã tạo trước nâng cấp được giữ nguyên.

PHP cần quyền ghi workshop-data/ và workshop-media/. Có thể đặt data_dir ngoài thư mục web để bảo quản dữ liệu. Không cấp quyền 777 tùy tiện. Mặc định tối đa 200 đăng ký, thiết kế cho một khóa nhỏ/vừa; không phải cam kết tải 200 người đồng thời. Nếu dùng nhiều khóa/lưu lượng lớn, cần chuyển dữ liệu sang cơ sở dữ liệu và kiểm tra tải trên hosting.

Nếu API bị NukeViet chặn GET /api.php, áp dụng ngoại lệ chính xác /taphuan/api.php như hướng dẫn đã thực hiện trên .htaccess website chính. .htaccess ứng dụng dùng DirectoryIndex index.html và RewriteEngine Off để tách quy tắc rewrite tại thư mục ứng dụng. Không xóa quy tắc bảo vệ toàn website.

## 4. Kiểm diện và tài khoản

Điều khiển → Kiểm diện → Chiếu mã QR.

QR chứa địa chỉ trang học viên có checkin=1. Tạo QR ngay trên trình duyệt, không gửi thông tin tới dịch vụ QR bên ngoài. Học viên nhập đủ họ tên, chức vụ, đơn vị, số điện thoại. Điện thoại chuẩn hóa 10 chữ số bắt đầu 0; +84 được đổi sang 0. Lưu xong tạo tài khoản và tự đăng nhập.

Quy tắc mật khẩu ban đầu: lấy từ cuối của họ tên, bỏ dấu tiếng Việt, viết thường, nối 3 số cuối điện thoại. Nguyễn Hồng Dân + 0888770799 → dan799. Nếu nhập 0888770699 thì mật khẩu là dan699. Tên và số điện thoại được lấy từ biểu mẫu, không tự sửa theo ví dụ.

Học viên thấy tài khoản/mật khẩu của chính mình sau đăng ký; ghi lại để dùng trên thiết bị khác. Số điện thoại đã có không tạo lại; dùng Đã có tài khoản để đăng nhập. Quản trị có thể đặt lại mật khẩu về quy tắc ban đầu trong danh sách học viên.

Danh sách tên/chức vụ/đơn vị và số lượng có thể chiếu trong màn kiểm diện. Số điện thoại chỉ hiện với chính chủ tài khoản và quản trị; bảng điểm trò chơi không có số điện thoại. Không chia sẻ CSV danh sách ra ngoài phạm vi khóa học.

Học viên từ bản cũ chưa có điện thoại được yêu cầu hoàn thành kiểm diện; nếu còn phiên cũ, hồ sơ được bổ sung tại cùng mã học viên để giữ phản hồi trước đó. Không tự ghép người chỉ dựa trên tên giống nhau.

## 5. Maket ảnh/video

Điều khiển → Maket → Tạo nội dung.

Nhập tiêu đề, chọn ảnh/video → Tải tệp lên hosting → chọn tư liệu → Lưu nội dung → Trình chiếu.

Định dạng: JPG, JPEG, PNG, WEBP, GIF, MP4, WEBM. Chọn Phủ kín màn hình nếu muốn lấp đầy; chọn Hiện trọn nếu cần giữ toàn bộ ảnh/video, có thể có viền đen. Tiêu đề dùng để quản lý, không đè lên maket.

Điều khiển nhanh có phát/tạm dừng, phát lại, bật/tắt âm. Khi mới mở màn chiếu, trình duyệt có thể yêu cầu tương tác trực tiếp để phát video/âm thanh: bấm Bật âm thanh / video trên màn chiếu một lần. Đây là giới hạn trình duyệt, không thể bỏ bằng lệnh từ thiết bị khác. Chân trang nhỏ vẫn hiển thị theo yêu cầu.

Tệp tối đa 50 MB trong ứng dụng; hosting có thể đặt upload_max_filesize/post_max_size thấp hơn. Nếu tải không được, kiểm tra giới hạn PHP. Tên tệp trên hosting được tạo ngẫu nhiên; loại tệp được kiểm tra. Không nhận PHP, HTML hoặc SVG tải lên.

## 6. Tự tạo nội dung tập huấn

Chọn Nội dung văn bản hoặc Tài liệu & hình ảnh trong biểu mẫu tạo nội dung. Dán nội dung chữ vào ô, tải tư liệu nếu cần. Dùng một dòng riêng chỉ chứa --- để chia văn bản thành các trang. Sau Trình chiếu, Trang trước/Trang tiếp đổi trang từ màn điều khiển.

PDF được nhúng để xem trực tiếp; Trang trước/Trang tiếp đổi trang PDF. Hành vi trình xem PDF phụ thuộc trình duyệt; kiểm tra máy chiếu trước buổi học. TXT mở ở tab khác, hoặc dán nội dung vào biểu mẫu để chiếu. DOCX được tải để xem bằng Word; muốn chiếu nhiều trang trực tiếp, xuất Word thành PDF trước. Không có chuyển đổi DOCX sang PDF trên máy chủ.

18 phần nội dung gốc vẫn ở mục Nội dung tập huấn. Chọn buổi, Xem, rồi Chiếu. Chọn Nội dung / Tình huống / Thực hành / Câu lệnh để đưa đúng trang lên màn chiếu. Mở nhận bài và công bố gợi ý riêng cho từng phần; bài cũ được giữ.

Có thể sửa nội dung tự tạo chưa nhận phản hồi. Khi đã có phản hồi, dùng Nhân bản để tạo phiên bản mới; không sửa câu hỏi/đáp án rồi thay đổi điểm đã nhận. Ẩn chỉ đóng hiển thị/nhận, không xóa dữ liệu. Giới hạn 100 nội dung tự tạo cho một khóa.

## 7. Khảo sát

Tạo loại Khảo sát; nhập câu hỏi, lời dẫn, 2–6 phương án (mỗi dòng một phương án). Trình chiếu → Mở nhận khảo sát. Học viên đã kiểm diện gửi lựa chọn trên trang của mình. Mỗi tài khoản có một lựa chọn hiện tại và có thể cập nhật khi còn nhận.

Quản trị xem phân bố trước khi công bố; học viên/màn chiếu chỉ thấy biểu đồ khi Công bố kết quả. Công bố tự đóng nhận trả lời. Các phương án không có đúng/sai. Đóng nhận có thể dùng riêng mà chưa công bố.

## 8. Trò chơi

Tạo loại Trò chơi, 2–6 phương án, chọn đáp án A–F tương ứng thứ tự, thời gian 10–300 giây, giải thích. Trình chiếu → Bắt đầu → học viên trả lời → Công bố kết quả.

Mỗi tài khoản trả lời một lần mỗi câu. Máy chủ kiểm tra hạn; không nhận khi chưa bắt đầu, hết giờ, đóng nhận hoặc đã công bố. Trả lời đúng được 100 điểm, sai 0 điểm, không chấm theo tốc độ. Điểm cộng qua các câu trò chơi đã tạo, bảng điểm xuất hiện khi công bố một câu trò chơi. Người cùng điểm không có ưu tiên thắng dựa trên tốc độ. Muốn chơi lại câu đã trả lời, Nhân bản thành câu mới.

Đáp án/giải thích/điểm cá nhân không được gửi cho học viên trước công bố. Đồng hồ hiển thị dựa trên giờ máy chủ; công bố kết quả do báo cáo viên chủ động.

## 9. Dữ liệu và bàn giao

Nâng cấp bổ sung studio vào dữ liệu cũ, giữ mật khẩu quản trị, hồ sơ và phản hồi cũ. Tệp tải lên lưu workshop-media/; metadata, nội dung, khảo sát, điểm, hồ sơ lưu workshop-data/. Không xóa hai thư mục khi deploy. Có một bản dự phòng trước lần ghi gần nhất; cần sao lưu hosting sau từng buổi để có lịch sử đầy đủ.

Tư liệu tải lên được phục vụ theo URL ngẫu nhiên; ai có URL tư liệu có thể mở. Không dùng hệ thống này để cất giữ tài liệu mật. Ai có link học viên có thể xem nội dung đã mở; không có OTP xác minh số điện thoại hoặc xác thực danh tính độc lập.

API không trả mật khẩu băm trong hồ sơ công khai hay danh sách quản trị. Mật khẩu đăng ký/đặt lại chỉ hiện trong phản hồi cho người đăng ký hoặc quản trị. Tài khoản AI của bên thứ ba không được lưu trong ứng dụng.

## 10. Kiểm tra trước khi tập huấn

Mở control.html, screen.html và index.html ở các trình duyệt/thiết bị riêng. Thử QR kiểm diện, đủ bốn trường, số trùng, đăng nhập lại, ảnh/video, phát/tạm dừng, âm thanh, PDF đổi trang, chữ chia trang, khảo sát nhận/công bố, trò chơi hết giờ, điểm và dữ liệu cũ.

Môi trường kiểm tra mã nguồn: cú pháp PHP 5.6; API chạy trong PHP 8.2 WebAssembly; logic giao diện và QR chạy trong Node. Chưa kiểm tra trực quan trên hosting thật; cần thử giới hạn upload, quyền ghi, âm thanh và trình xem PDF trên thiết bị trình chiếu của thầy sau triển khai.

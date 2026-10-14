# Trang tập huấn công nghệ số và AI — 3 buổi

Báo cáo viên: Thầy giáo Nguyễn Hồng Dân.

## 1. Các tệp

- index.html: giao diện học viên và bảng điều khiển quản trị, có CSS/JavaScript bên trong, không tải thư viện ngoài.
- api.php: đồng bộ nội dung mở/ẩn, đăng ký, khảo sát và bài thực hành.
- course.php: toàn bộ nội dung 3 buổi / 18 phần. API chỉ gửi các phần đã mở tới học viên.
- config.example.php: cấu hình mẫu; sao chép thành config.php và đặt mã khởi tạo riêng trên hosting. config.php không được lưu lên GitHub.
- .htaccess: hạn chế truy cập trực tiếp vào tệp cấu hình/nội dung trên Apache.
- sample-data.csv: dữ liệu giả lập; giao diện cũng tự tạo bản CSV tương đương để tải.
- HUONG-DAN.md: tài liệu này; giữ trên máy, không cần đưa lên hosting.

HTML tĩnh riêng lẻ không đồng bộ quyền mở nội dung trên nhiều thiết bị. Vì vậy cần đặt index.html cùng các tệp PHP trên hosting. Mở HTML trực tiếp trên máy sẽ chỉ thấy khung và thông báo chưa kết nối.

## 2. Yêu cầu hosting

PHP có OpenSSL, session, JSON, password_hash, hash_equals; mã sử dụng cú pháp PHP 5.6 trở lên. Ưu tiên hosting PHP được nhà cung cấp duy trì. Không cần MySQL hoặc API key AI. Trang chỉ giới thiệu/cung cấp câu lệnh và liên kết công cụ; không gọi AI thay học viên.

Trình duyệt hiện đại trên điện thoại/máy tính; bật JavaScript và cookie. Clipboard hoạt động thuận tiện với HTTPS, có phương án sao chép thủ công nếu không được phép.

Dữ liệu mặc định lưu tại workshop-data, tự tạo khi API chạy. PHP phải có quyền ghi thư mục này. Không cấp quyền 777 tùy tiện; dùng quyền phù hợp tài khoản hosting. Có thể sửa data_dir trong config.php thành đường dẫn tuyệt đối ngoài public_html để tách dữ liệu khỏi thư mục web. Tệp dữ liệu có tiền tố PHP exit và thư mục được tạo .htaccess chặn truy cập; Nginx không đọc .htaccess nên ưu tiên đặt data_dir ngoài thư mục web hoặc cấu hình chặn thư mục dữ liệu.

Thiết kế cho một khóa quy mô nhỏ/vừa, mặc định tối đa 200 đăng ký theo cấu hình. Đây là giới hạn đăng ký, không phải cam kết 200 người truy cập đồng thời. Dữ liệu tệp dùng khóa và ghi thay thế; với nhiều khóa hoặc lưu lượng lớn nên chuyển API sang cơ sở dữ liệu. Không liên kết hoặc thay đổi hệ thống CDS đang vận hành.

## 3. Cài đặt

1. Tạo thư mục mới, ví dụ public_html/taphuan-ai/; không ghi đè tệp của hệ thống hiện tại.
2. Tải lên index.html, api.php, course.php, config.example.php và .htaccess. Sao chép config.example.php thành config.php trên hosting, thay setup_key bằng chuỗi ngẫu nhiên riêng ít nhất 24 ký tự (ưu tiên 48 ký tự hex). Không dùng nguyên giá trị mẫu, không commit config.php. sample-data.csv là tùy chọn.
3. Truy cập https://ten-mien-cua-thay/taphuan-ai/index.html.
4. Nếu hiện lỗi API: mở /taphuan-ai/api.php?action=state để xem thông báo JSON; kiểm tra PHP, quyền ghi và nhật ký lỗi hosting. Đừng công khai nội dung config.php hoặc mật khẩu để nhờ hỗ trợ.
5. Nếu Apache báo 500 vì không cho phép Options/FilesMatch, nhờ nhà cung cấp điều chỉnh hoặc bỏ dòng Options -Indexes; giữ biện pháp bảo vệ cấu hình. Nếu máy chủ không xử lý PHP thì không triển khai gói này lên đó.

## 4. Khởi tạo quản trị

1. Trong trình quản lý tệp hosting, mở config.php và lấy giá trị setup_key. Giá trị do thầy đặt riêng trên hosting; không nằm trong HTML hoặc repository.
2. Trên trang chọn ⚙ Quản trị lớp học.
3. Nhập mã khởi tạo và đặt mật khẩu ít nhất 12 ký tự; không có mật khẩu mặc định.
4. Sau khi khởi tạo, mã không thể tạo lại quản trị. Những lần sau chỉ đăng nhập bằng mật khẩu.
5. Đổi mật khẩu trong bảng điều khiển khi cần. Nếu quên, không xóa dữ liệu; khôi phục bằng phương án quản trị hosting phù hợp sau khi sao lưu.
6. Phiên quản trị hết hạn sau 8 giờ không hoạt động; đăng xuất sau buổi học.

Giới hạn đăng nhập/khởi tạo sai: 8 lần trong 15 phút theo địa chỉ IP. IP được băm trong dữ liệu giới hạn thử, không đưa vào báo cáo lớp học. Cookie quản trị sử dụng HttpOnly; bật Secure khi PHP nhận HTTPS. Nếu dùng reverse proxy, đảm bảo cấu hình HTTPS tới PHP chính xác.

## 5. Điều hành lớp học

- Mặc định mọi phần đều khóa với học viên. Quản trị có thể xem toàn bộ để chuẩn bị.
- Hiện nội dung: mở một phần hoặc cả buổi.
- Nhận lựa chọn & bài nộp: bật riêng sau khi đã mở phần. Mở nội dung không tự mở nhận bài.
- Công bố kết quả & gợi ý: bật khi muốn cho lớp xem phân bố lựa chọn và gợi ý xử lý. Đáp án không được gửi tới học viên trước đó.
- Đưa lên màn hình: chọn phần đang trình bày. Học viên bật “Theo nhịp báo cáo viên” sẽ chuyển theo; có thể tắt để tự xem phần đã mở.
- Trình chiếu: ẩn thanh bên, tăng cỡ chữ; mũi tên trái/phải chuyển phần. Đây là chế độ bố cục trình bày, không tự ép trình duyệt toàn màn hình.
- Đồng hồ: nhập phút, bắt đầu/dừng; mọi thiết bị nhận cùng mốc kết thúc. Đồng hồ không tự đóng bài, quản trị chủ động tắt nhận bài.
- Thông báo: gửi chỉ dẫn cho lớp.
- Học viên cập nhật trạng thái trong khoảng 5 giây khi trang đang mở. Chuyển lại tab sẽ tải trạng thái mới.
- Đóng một phần sẽ tắt nhận bài và công bố kết quả của phần đó. Nội dung đã đọc không thể thu hồi khỏi trí nhớ, ảnh chụp hoặc bản đã lưu của người dùng.

Link học viên chính là link index.html. Sao chép trong bảng điều khiển rồi gửi theo kênh của thầy. Không có yêu cầu tạo tài khoản hệ thống cho học viên; đăng ký tên hiển thị/đơn vị để gửi phản hồi. Ai có link đều có thể đọc phần đã mở. Nếu cần giới hạn người xem, cần thêm lớp xác thực riêng trên hosting.

## 6. Khảo sát, bài thực hành và sản phẩm

- Học viên chọn “Vào lớp”, nhập tên hiển thị/đơn vị/vai trò và xác nhận lưu thông tin.
- Chọn phương án trong Tình huống & khảo sát. Phần đầu là khảo sát nhu cầu, không có đáp án đúng/sai.
- Soạn bài trong Thực hành; có thể thêm liên kết http/https. Trang không nhận tải tệp trực tiếp.
- Lựa chọn tình huống và bài thực hành gửi cùng một bản ghi. Một người/một phần có một bản ghi hiện tại; gửi lại cập nhật bản ghi, không tạo thêm lượt.
- Bản nháp lưu cục bộ trên trình duyệt. Lưu tập trung chỉ xảy ra khi gửi thành công. Khi quản trị đóng nhận bài, vẫn soạn nháp được nhưng không gửi được.
- Không nhập dữ liệu thật nhạy cảm, mật khẩu hoặc đường dẫn có token bí mật.
- Chỉ bài được học viên đồng ý chia sẻ mới có thể được quản trị chọn đưa lên thư viện chung. Gửi lại bài tự bỏ trạng thái được chọn để quản trị rà soát lại.
- Xuất CSV gồm đăng ký và phản hồi hiện tại, UTF-8 BOM; ô có nguy cơ bị bảng tính hiểu thành công thức được trung hòa. CSV là bảng dữ liệu, không phải Excel có định dạng màu.

## 7. Nội dung và lịch học

Mỗi buổi 180 phút dự kiến, có thể điều chỉnh trong course.php. Không có nghỉ giải lao cố định; báo cáo viên chủ động bố trí trong hoạt động.

Buổi 1: khảo sát vướng mắc; hiểu phần mềm/tự động hóa/AI; phân công trách nhiệm; vận hành dữ liệu/sự cố; mô hình ứng dụng; lựa chọn sản phẩm và kế hoạch 30 ngày.
Buổi 2: giao nhiệm vụ AI; văn bản/kế hoạch; họp/giao việc; quản lý chuyên môn; phân tích dữ liệu; ra quyết định.
Buổi 3: tài khoản/thao tác nền; nội dung truyền thông; thiết kế slide/infographic; hỏi–đáp trên nguồn; đa phương tiện; xưởng sản phẩm.

Mỗi phần có: nội dung, mô hình, tình huống, lựa chọn, giải thích, nhiệm vụ, sản phẩm, tiêu chí, câu lệnh, công cụ. Gợi ý dẫn lớp chỉ gửi tới quản trị.

Các công cụ mở ở tab riêng, không nhúng tài khoản và không gọi API AI. Tính năng/gói tài khoản có thể khác nhau; kiểm tra trước buổi học. Ưu tiên một AI chủ lực, các công cụ còn lại là lựa chọn. Giới thiệu CDS trên dữ liệu thử đã kiểm tra, không dùng lớp đang vận hành để thao tác thử.

Tài liệu chỉ đạo và ghi chép họp đi kèm là GIẢ LẬP; không có số hiệu pháp lý, không dùng làm căn cứ ban hành. Nếu bổ sung chủ trương/quy định thật, kiểm tra nguồn chính thức, ngày, hiệu lực và phạm vi áp dụng trước tập huấn.

## 8. Sao lưu và bảo trì

Sao lưu cả mã nguồn và thư mục dữ liệu sau mỗi buổi; chứa mật khẩu băm và phản hồi nên không phát cho học viên. previous.php là một bản trước lần ghi gần nhất, không thay thế lịch sử sao lưu của hosting. Khi phục hồi, dừng ghi, sao lưu hiện trạng rồi thay đúng tệp dữ liệu và kiểm tra trên bản thử. Không sửa trực tiếp JSON đang được dùng.

Để mở khóa mới độc lập, tạo thư mục triển khai mới với data_dir riêng và setup_key mới. Mẫu này quản lý một khóa; không có tính năng tự xóa toàn bộ bài trong giao diện.

## 9. Kiểm tra trước buổi học

Dùng trình duyệt quản trị và một trình duyệt riêng/ẩn danh làm học viên:
1. Trước mở: học viên chỉ thấy tiêu đề phần, không thấy nội dung/câu lệnh.
2. Quản trị mở một phần: học viên thấy trong khoảng 5 giây.
3. Chưa nhận bài: gửi bị chặn; mở nhận bài: học viên đăng ký và gửi được.
4. Chưa công bố: học viên không thấy gợi ý/biểu đồ; công bố: thấy đúng kết quả.
5. Chọn phần đang trình bày và thử theo nhịp/tắt theo nhịp.
6. Thử đồng hồ, thông báo, gửi lại bài, xuất CSV.
7. Thử công khai bài có đồng ý; bài không đồng ý không được chọn.
8. Đăng xuất quản trị; gọi chức năng điều khiển phải bị từ chối.
9. Kiểm tra điện thoại, máy chiếu, mạng và việc mở liên kết sản phẩm.
10. Mở /config.php, /course.php và /workshop-data/state.php trực tiếp: không được hiện mã, nội dung hoặc dữ liệu lớp.

## 10. Phạm vi kiểm tra của bản bàn giao

Đã kiểm tra cú pháp JavaScript và chạy kiểm tra logic giao diện: khóa/mở, nhận phản hồi, công bố, mã hóa nội dung khi hiển thị, liên kết an toàn, xuất CSV và cấu trúc 18 phần. Cập nhật trạng thái, xác thực và lưu tập trung được triển khai trong API PHP.

Đã kiểm tra cú pháp PHP 5.6 bằng parser và chạy kiểm tra chức năng API trong PHP 8.2 WebAssembly: khởi tạo/đăng nhập, CSRF, quyền quản trị, khóa nội dung/đáp án, đăng ký, gửi/cập nhật bài, tổng hợp, đồng ý chia sẻ, đóng phần học, trình bày, đồng hồ, thông báo, đổi mật khẩu, đăng xuất và tệp dữ liệu không phát nội dung trực tiếp. Chưa chạy trên PHP native của hosting hoặc kiểm tra trực quan bằng trình duyệt trên hosting; cần thử quyền ghi, session và hai trình duyệt sau khi tải lên.

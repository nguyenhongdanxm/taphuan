# Hướng dẫn vận hành tập huấn AI — bản 4, khảo sát thực trạng và phân tích AI

## 1. Các địa chỉ

**Báo cáo viên:** https://noitruxinman.edu.vn/taphuan/control.html
**Máy chiếu:** https://noitruxinman.edu.vn/taphuan/screen.html
**Học viên:** https://noitruxinman.edu.vn/taphuan/

Có thể mở màn chiếu trên thiết bị khác, hoặc kéo tab trình chiếu sang màn hình ngoài khi máy tính đang dùng chế độ mở rộng màn hình. Trên màn chiếu bấm Toàn màn hình. Màn điều khiển chỉ có tác dụng sau khi đăng nhập quản trị; màn chiếu không hiển thị bảng điều khiển hay số điện thoại học viên.

## 2. Cập nhật từ GitHub

cPanel → Git Version Control → Manage → Pull or Deploy → Update from Remote → Deploy HEAD Commit.

Đường dẫn triển khai: /home/capnachi/noitruxinman.edu.vn/taphuan/.

Gói sao chép index.html, control.html, screen.html, api.php, studio.php, ai.php, survey.php, course.php, config.example.php, sample-data.csv, .htaccess và assets/. Giữ nguyên config.php, workshop-data/ và workshop-media/. Cấu hình mẫu chỉ được sao chép thành config.php nếu chưa có tệp đó. Không đổi Document Root hay sửa hệ thống CDS.

Sau khi deploy, tải lại cả màn điều khiển/màn chiếu/học viên để nhận giao diện mới. Không chỉnh tệp trong bản checkout Git ở cPanel, để Update from Remote tiếp tục hoạt động.

## 3. Cài đặt lần đầu

PHP có session, JSON, OpenSSL (hoặc random_bytes), password_hash, hash_equals, fileinfo; hỗ trợ cú pháp PHP 5.6 trở lên. DOCX cần ZipArchive. Các chức năng lớp học dùng được khi chưa nhập khóa AI. Trợ lý AI cần khóa API riêng và PHP cURL/OpenSSL, mạng HTTPS tới Gemini hoặc OpenAI. JavaScript cần trình duyệt hiện đại.

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

18 phần nội dung gốc vẫn ở mục Nội dung tập huấn. Chọn buổi, Xem, rồi Chiếu. Chọn Nội dung / Tình huống / Thực hành / Câu lệnh để đưa đúng trang lên màn chiếu. Từng ý nội dung, mô hình, nhiệm vụ, sản phẩm cần hoàn thành và công cụ đều có nút Chiếu riêng. Sản phẩm học viên đã được chọn chia sẻ cũng có nút Chiếu ở bảng điều khiển. Mở nhận bài và công bố gợi ý riêng cho từng phần; bài cũ được giữ.

Có thể sửa nội dung tự tạo chưa nhận phản hồi. Khi đã có phản hồi, dùng Nhân bản để tạo phiên bản mới; không sửa câu hỏi/đáp án rồi thay đổi điểm đã nhận. Ẩn chỉ đóng hiển thị/nhận, không xóa dữ liệu. Giới hạn 100 nội dung tự tạo cho một khóa.

## 7. Khảo sát

Tạo loại Khảo sát; nhập câu hỏi, lời dẫn, 2–6 phương án (mỗi dòng một phương án). Trình chiếu → Mở nhận khảo sát. Học viên đã kiểm diện gửi lựa chọn trên trang của mình. Danh sách người tham gia lấy từ tài khoản kiểm diện, không nhập tên riêng cho khảo sát. Trong Điều khiển nhanh, mở Học viên kiểm diện để xem đã/chưa trả lời; danh sách này chỉ dành cho quản trị. Các tình huống/khảo sát trong 18 phần nội dung gốc cũng yêu cầu tài khoản có số điện thoại. Mỗi tài khoản có một lựa chọn hiện tại và có thể cập nhật khi còn nhận.

Quản trị xem phân bố trước khi công bố; học viên/màn chiếu chỉ thấy biểu đồ khi Công bố kết quả. Công bố tự đóng nhận trả lời. Các phương án không có đúng/sai. Đóng nhận có thể dùng riêng mà chưa công bố.

## 8. Trò chơi

Tạo loại Trò chơi, 2–6 phương án, chọn đáp án A–F tương ứng thứ tự, thời gian 10–300 giây, giải thích. Trình chiếu → Bắt đầu → học viên trả lời → Công bố kết quả.

Người chơi dùng chính tài khoản kiểm diện; không nhập biệt danh hoặc tạo danh sách riêng. Mỗi tài khoản trả lời một lần mỗi câu. Máy chủ kiểm tra hạn; không nhận khi chưa bắt đầu, hết giờ, đóng nhận hoặc đã công bố. Trả lời đúng được 100 điểm, sai 0 điểm, không chấm theo tốc độ. Điểm cộng qua các câu trò chơi đã tạo, bảng điểm xuất hiện khi công bố một câu trò chơi. Người cùng điểm không có ưu tiên thắng dựa trên tốc độ. Muốn chơi lại câu đã trả lời, Nhân bản thành câu mới.

Đáp án/giải thích/điểm cá nhân không được gửi cho học viên trước công bố. Đồng hồ hiển thị dựa trên giờ máy chủ; công bố kết quả do báo cáo viên chủ động.

## 9. Dữ liệu và bàn giao

Nâng cấp bổ sung studio vào dữ liệu cũ, giữ mật khẩu quản trị, hồ sơ và phản hồi cũ. Tệp tải lên lưu workshop-media/; metadata, nội dung, khảo sát, điểm, hồ sơ lưu workshop-data/. Không xóa hai thư mục khi deploy. Có một bản dự phòng trước lần ghi gần nhất; cần sao lưu hosting sau từng buổi để có lịch sử đầy đủ.

Tư liệu tải lên được phục vụ theo URL ngẫu nhiên; ai có URL tư liệu có thể mở. Không dùng hệ thống này để cất giữ tài liệu mật. Ai có link học viên có thể xem nội dung đã mở; không có OTP xác minh số điện thoại hoặc xác thực danh tính độc lập.

API không trả mật khẩu băm trong hồ sơ công khai hay danh sách quản trị. Mật khẩu đăng ký/đặt lại chỉ hiện trong phản hồi cho người đăng ký hoặc quản trị. Khóa API của báo cáo viên được mã hóa riêng trong workshop-data/ai-secret.php; không lưu tài khoản/mật khẩu ChatGPT hoặc Gemini của học viên. Khóa không có trong state, CSV hay dữ liệu quản trị xuất qua API. Giữ setup_key ổn định; nếu đổi setup_key, cần nhập lại khóa AI. Sao lưu cấu hình riêng và dữ liệu trên hosting, không đưa lên GitHub.

## 10. Kiểm tra trước khi tập huấn

Mở control.html, screen.html và index.html ở các trình duyệt/thiết bị riêng. Thử QR kiểm diện, đủ bốn trường, số trùng, đăng nhập lại, ảnh/video, phát/tạm dừng, âm thanh, PDF đổi trang, chữ chia trang, khảo sát nhận/công bố, trò chơi hết giờ, điểm và dữ liệu cũ.

Môi trường kiểm tra mã nguồn: cú pháp PHP 5.6; API chạy trong PHP 8.2 WebAssembly; logic giao diện và QR chạy trong Node. Chưa kiểm tra trực quan trên hosting thật; cần thử giới hạn upload, quyền ghi, âm thanh và trình xem PDF trên thiết bị trình chiếu của thầy sau triển khai.

## 11. Cài đặt và dùng AI

Điều khiển → Cài đặt AI → chọn Google Gemini hoặc OpenAI → dán khóa API → Lưu cài đặt → Kiểm tra kết nối. Ô khóa không hiển thị lại khóa đã lưu; để trống khi lưu cùng nhà cung cấp thì giữ khóa cũ. Đổi nhà cung cấp phải nhập khóa tương ứng. Model mặc định Gemini gemini-2.5-flash hoặc OpenAI gpt-4.1-mini; có thể sửa theo model tài khoản được cấp quyền.

Một khóa áp dụng cho toàn bộ nút AI hỗ trợ: tổng điều khiển, maket, kiểm diện, khảo sát, trò chơi, nội dung 3 buổi, công cụ và biểu mẫu soạn bài. Chọn nút AI, nhập yêu cầu/tài liệu nguồn, bấm Tạo với AI. Sau khi nhận kết quả, chọn Đưa vào biểu mẫu, Chiếu bản nháp hoặc Sao chép. Đưa vào biểu mẫu tạo nội dung mới để kiểm tra rồi lưu; không thay câu hỏi/điểm đã có. AI không tự bấm mở nhận hoặc công bố đáp án.

AI hỗ trợ maket bằng lời dẫn, kịch bản và gợi ý thiết kế/prompt; muốn có ảnh/video, thầy tạo bằng công cụ phù hợp rồi tải lên. AI hiện đọc nội dung chữ đã nhập và bối cảnh tổng hợp; không tự trích toàn bộ PDF/Word/ảnh/video đã tải. Khi cần phân tích tài liệu, dán phần văn bản cần xử lý vào yêu cầu.

Bối cảnh tự động chỉ gồm số người kiểm diện, nhóm chức vụ/đơn vị, nội dung đang chọn và phân bố trả lời. Không tự gửi tên/số điện thoại học viên. Văn bản thầy nhập vào ô yêu cầu được gửi tới nhà cung cấp đã chọn. Kiểm tra số liệu, căn cứ và tính phù hợp của kết quả trước khi sử dụng.

Khóa API cần hạn mức và quyền dùng model; thuê bao ChatGPT/Gemini cá nhân không mặc nhiên cấp hạn mức API. Hosting cần bật cURL và OpenSSL. Nếu kiểm tra báo lỗi 401: kiểm tra khóa; 403/404: kiểm tra quyền/tên model; 429: kiểm tra hạn mức rồi thử lại. Lời gọi AI tách khóa phiên trước khi đợi nhà cung cấp để màn chiếu tiếp tục đồng bộ.

## 12. Kiểm tra bản 3

Đã kiểm tra API bằng PHP 8.2 WebAssembly, cú pháp tương thích PHP 5.6 và logic giao diện/QR trong Node: nâng cấp dữ liệu cũ, kiểm diện, khảo sát, điểm trò chơi, danh sách đã/chưa trả lời, nút chiếu từng ý, chiếu văn bản tùy chọn, điều khiển video không khởi động lại khi tạm dừng. Kiểm tra AI dùng phản hồi mô phỏng của Gemini/OpenAI để xác nhận định dạng yêu cầu, xử lý bản nháp, quyền quản trị, CSRF và mã hóa/không lộ khóa. Chưa gọi API AI thật bằng khóa của thầy và chưa kiểm tra trực quan trên hosting. Sau deploy, nhập khóa và thử Kiểm tra kết nối, tạo một câu khảo sát, lưu, chiếu và trả lời bằng tài khoản kiểm diện trên thiết bị khác.

## 13. Khảo sát thực trạng 15 câu và tự phân tích AI

Sau Update from Remote → Deploy HEAD Commit, tải lại các trang để nhận tài nguyên ?v=4. Vào Điều khiển → Khảo sát thực trạng. Bộ câu hỏi có sẵn, không phải nhập thủ công:

| Nhóm | Câu | Nội dung |
| --- | --- | --- |
| I. Bức tranh hiện tại | 1–3 | Mức ứng dụng; tần suất dùng AI; công việc đang ứng dụng |
| II. Thuận lợi và nguồn lực | 4–7 | Hạ tầng; đội ngũ hỗ trợ; thuận lợi nổi bật; chỉ đạo/phối hợp |
| III. Khó khăn và điểm nghẽn | 8–11 | Rào cản lớn; nhập dữ liệu trùng; cơ chế quản trị; chất lượng dữ liệu |
| IV. Giải pháp và ưu tiên | 12–15 | Giải pháp đang thực hiện; chuyển biến tự đánh giá; ưu tiên hỗ trợ; chia sẻ thực tế |

**Quy trình tổ chức:**

1. Chiếu mở đầu: màn chào có QR, mục đích, 4 nhóm và hướng dẫn. QR đưa học viên thẳng tới mục khảo sát sau kiểm diện.
2. Mở nhận 15 câu: mỗi tài khoản kiểm diện điền đủ 15 câu rồi gửi toàn bộ. Có thể cập nhật cùng phiếu khi còn mở; không tăng số phiếu. Câu chọn nhiều tối đa 3 phương án; phương án Chưa có/Chưa ứng dụng chọn riêng. Câu 15 tối đa 1.000 ký tự, không ghi thông tin định danh.
3. Có thể Chiếu từng câu để giải thích, dùng Câu trước/Câu tiếp. Danh sách đã/chưa gửi lấy từ tài khoản kiểm diện.
4. Bấm **Kết thúc & tự phân tích AI**: khóa nhận phiếu và công bố thống kê; trang điều khiển tự gọi khóa AI đã lưu. Giữ trang điều khiển mở cho đến khi tác vụ khởi chạy. Không có cron/background worker khi mọi trang điều khiển đều đóng. Nếu đóng trước khi chạy, mở lại điều khiển để tiếp tục tác vụ đang chờ.
5. Chiếu kết quả từng câu hoặc chiếu từng phần phân tích. AI không tự chiếu báo cáo chưa được báo cáo viên chọn. Dùng nút Thử lại nếu lỗi dịch vụ; dữ liệu khảo sát vẫn giữ. Nếu yêu cầu đang chạy bị gián đoạn, chờ hơn 2 phút rồi thử lại.
6. Xuất thống kê CSV (không xuất danh tính và chia sẻ nguyên văn), sao chép hoặc tải báo cáo TXT. Mở lại khảo sát giữ nguyên phiếu, cho phép cập nhật; báo cáo cũ ngừng công bố và phải tổng hợp lại khi kết thúc đợt bổ sung.

**Báo cáo AI có 7 phần:** quy mô/giới hạn; thuận lợi; khó khăn; giải pháp/mức chuyển biến; ưu tiên tập huấn 3 buổi; hành động 30–60–90 ngày; vấn đề cần kiểm chứng/thảo luận. Kết quả lưu trên hosting để xem lại. Một yêu cầu đang xử lý không gọi lại trùng ngay; kết quả cùng nguồn dữ liệu được dùng lại. Thay đổi khảo sát trong khi AI xử lý khiến kết quả cũ bị loại, tránh ghi đè báo cáo của phiên mới.

**Cách đọc số liệu:** tỷ lệ theo người trả lời từng câu, không phải tỷ lệ trường. Nhiều cán bộ một trường vẫn là nhiều người trả lời. Số đơn vị chỉ là số tên đơn vị tự khai khác nhau, chưa chuẩn hóa. Câu chọn nhiều có tổng tỷ lệ có thể trên 100%. Không chấm điểm/xếp loại nhà trường; ưu tiên và giải pháp là gợi ý cần thảo luận.

Bối cảnh AI không tự lấy tên và số điện thoại hồ sơ. Câu 15 được che chuỗi số điện thoại/email theo mẫu trước khi gửi, nhưng người nhập vẫn cần tránh mọi thông tin định danh. Để giới hạn độ dài, AI đọc tối đa 50 chia sẻ đầu, mỗi chia sẻ tối đa 600 ký tự; báo cáo phải nêu phạm vi mẫu văn bản này. Thống kê định lượng dùng toàn bộ phiếu hợp lệ.

**Bố cục trình chiếu:** phần học có đề mục đánh số, thẻ nội dung, luồng mô hình; khảo sát có màn mở đầu QR, lựa chọn A–G, biểu đồ ngang và các trang báo cáo AI riêng. Nội dung dài có thể cuộn, nên thử độ phân giải máy chiếu trước buổi tập huấn.

Đã kiểm tra API khảo sát trên PHP 8.2 WebAssembly, cú pháp PHP 5.6 và logic giao diện Node: đủ 15 câu, tài khoản kiểm diện, chọn nhiều/chọn riêng, cập nhật phiếu, thống kê, phân quyền, tự khởi chạy AI, lưu báo cáo, dùng lại kết quả, thử lại khi lỗi và loại kết quả cũ. AI kiểm tra bằng phản hồi mô phỏng; cần thử một lần với khóa thực trên hosting sau triển khai. Chưa kiểm tra trực quan trên máy chiếu thật.

## 14. Khi báo model hoặc phiên bản không hỗ trợ

1. cPanel → Update from Remote → Deploy HEAD Commit; tải lại màn điều khiển để nhận app.js?v=5.
2. Mở Cài đặt AI, chọn đúng nhà cung cấp. Nếu khóa đã lưu, để trống ô khóa; nếu đổi nhà cung cấp, nhập khóa tương ứng.
3. Bấm **Tự chọn model & kiểm tra**. Hệ thống lưu `auto`, truy vấn danh sách model qua chính khóa này và thử một yêu cầu tạo văn bản. Sau thành công sẽ hiện model thực tế đã dùng. Không tự đổi model cũ khi deploy.
4. Nếu cần chọn cụ thể: **Lưu & tải danh sách model** → bấm vào ô Model chọn tên → **Lưu & kiểm tra kết nối**. Với Gemini, chấp nhận tên có tiền tố models/ và tự chuẩn hóa. Danh sách được lọc cho tác vụ văn bản, không xác nhận hạn mức hoặc mọi tính năng; vẫn cần kiểm tra kết nối.
5. Khi còn lỗi, đọc thông báo ngay dưới các nút: HTTP 400 là tham số/model không phù hợp; 401 là khóa không hợp lệ; 403 là quyền/dịch vụ/khóa bị chặn; 404 là model/phiên bản không có; 429 là hạn mức/tốc độ. Thông báo có chi tiết từ nhà cung cấp và che khóa. Có thể gửi nguyên dòng lỗi để hỗ trợ tiếp, không cần gửi khóa.

Chế độ auto của Gemini truy vấn /v1beta/models, lọc supportedGenerationMethods có generateContent và model văn bản. Ưu tiên Flash ổn định; không tự chọn Pro. OpenAI truy vấn /v1/models, dùng model nhỏ được liệt kê trong nhóm ứng dụng hỗ trợ; nếu không tìm thấy, yêu cầu chọn thủ công. Không thử liên tiếp nhiều model để tránh phát sinh yêu cầu không cần thiết.

Đã kiểm tra bằng mô phỏng: GET danh sách không gửi body, phân trang, loại model ảnh/âm thanh/embedding, chọn model, lưu trước khi kiểm tra, chuẩn hóa tên, JSON có code fence, che khóa trong lỗi và tên model thực tế. Chưa thử bằng khóa thật trên hosting của thầy.

## 15. Sửa lỗi OpenAI yêu cầu từ JSON trong input

Bản tài nguyên v6 thêm chỉ dẫn JSON trực tiếp vào input gửi tới Responses API, ngoài hướng dẫn hệ thống. Khắc phục HTTP 400: Response input messages must contain the word json ... json_object. Sau deploy tải lại màn điều khiển. Giữ nguyên khóa và model đã cấu hình; không cần đổi khóa vì lỗi này. Dòng trạng thái tạo bản nháp cũng được cập nhật khi thất bại.

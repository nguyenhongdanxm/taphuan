# Cổng tập huấn AI

Website tập huấn dành cho cán bộ quản lý trường phổ thông. Một giao diện thống nhất cho năm mục, không sử dụng màn chiếu riêng.

## Năm mục chính

1. **Trang chủ:** lời chào, tên đợt tập huấn, giới thiệu, báo cáo viên, đơn vị tổ chức, thời gian, địa điểm và thông báo. Quản trị sửa trực tiếp trên website.
2. **Kiểm diện theo buổi:** quản trị tạo buổi (tên, ngày), mở QR có chữ ký máy chủ tự đổi mỗi 20 giây. Khi quét mã còn hiệu lực, popup ban đầu chỉ có chọn trường; sau đó hiện tên/chức vụ, mời bổ sung phần thiếu, cuối cùng mới hiện số điện thoại và nút Điểm danh. Mỗi người một bản ghi trong mỗi buổi. Có danh sách đã/chưa điểm danh, thời điểm và xuất CSV theo buổi.
3. **Khảo sát:** giữ bộ 15 câu hiện có (câu chọn một/chọn nhiều và một câu chia sẻ thực tế), mỗi tài khoản một phiếu, cập nhật khi còn mở. Quản trị có danh sách đã/chưa gửi, biểu đồ từng câu, tỷ lệ hoàn thành, xuất CSV, công bố/ẩn kết quả và phân tích AI.
4. **Nội dung tập huấn:** khởi tạo 18 chuyên đề từ nội dung 3 buổi hiện có, phân nhóm, tìm kiếm, xem nội dung và sao chép câu lệnh. Quản trị thêm/sửa/xóa, đặt thứ tự, thời lượng và công bố/giữ nháp. AI điền bản nháp vào biểu mẫu để người dùng kiểm tra trước khi lưu.
5. **Công cụ:** danh sách công cụ, liên kết, hướng dẫn và câu lệnh mẫu; có thư viện câu lệnh theo chuyên đề. Quản trị thêm/sửa/xóa.

## Địa chỉ

- `index.html`: cổng tập huấn; nút **Quản trị** để đăng nhập.
- `control.html`: địa chỉ quản trị cũ vẫn mở cùng cổng mới.
- `index.html?attendance=…&slot=…&signature=…`: đường dẫn do QR có thời hạn tạo ra; không dùng liên kết cố định để điểm danh. `?checkin=1` cũ chỉ mở thông tin tài khoản/đăng nhập khi không có quyền quét hợp lệ.
- `screen.html`: tự chuyển về `index.html`, không còn chế độ màn chiếu.

## Cài đặt và nâng cấp cPanel

Hosting cần PHP có session, JSON, OpenSSL, password_hash, hash_equals và quyền ghi thư mục dữ liệu. AI cần thêm PHP cURL và kết nối HTTPS tới Gemini/OpenAI. Không chạy API này bằng GitHub Pages.

1. Lần đầu: sao chép `config.example.php` thành `config.php`, thay `setup_key` bằng chuỗi riêng ít nhất 24 ký tự. Mở website → Quản trị → khởi tạo mật khẩu ít nhất 12 ký tự.
2. Khi nâng cấp: sao lưu `config.php`, `workshop-data/`, `workshop-media/` bằng chức năng backup của hosting. Cập nhật mã nguồn bằng **Update from Remote → Deploy HEAD Commit** sau khi thay đổi được gộp vào nhánh triển khai.
3. `.cpanel.yml` có sẵn đường dẫn triển khai của trường. Nếu dùng hosting khác, sửa đường dẫn trong tệp này trước khi triển khai.
4. Deploy giữ `config.php`, không xóa thư mục dữ liệu hoặc tệp tải lên. Các tệp mới `portal.php`, `attendance.php` và `roster-seed.php` được triển khai cùng mã nguồn.
5. Tải lại trang để dùng tài nguyên `v=9`. Vào Quản trị → Trang chủ → Sửa thông tin để điền thời gian, địa điểm và đơn vị tổ chức.

Dữ liệu chuyên đề, công cụ và thông tin đợt tập huấn được khởi tạo khi mở cổng mới và lưu cùng trạng thái ở lần ghi tiếp theo. Nội dung gốc được đọc từ `course.php`; danh sách trường/người gốc từ `roster-seed.php`. Khi đã khởi tạo, dữ liệu biên tập trên hosting là dữ liệu chính, không bị thay bằng nội dung gốc mỗi lần deploy. Phiếu khảo sát, tài khoản và phản hồi cũ không bị xóa.

## Điểm danh theo buổi và QR 20 giây

Quản trị → Kiểm diện → Tạo buổi tập huấn → điền tên/ngày → Tạo buổi & mở QR. Tạo/mở một buổi sẽ đóng buổi đang mở, giữ nguyên thống kê. Chọn buổi trong danh sách để xem thống kê hoặc mở lại; nút Kết thúc điểm danh thu hồi mã và các popup chưa hoàn tất của buổi đó. Có nút phóng to QR ngay trên trang, không cần màn chiếu riêng.

QR gồm mã buổi, chu kỳ 20 giây và chữ ký HMAC. Máy chủ chỉ nhận chu kỳ hiện tại của buổi còn mở; sửa số chu kỳ hoặc gửi mã cũ không vượt được kiểm tra chữ ký/thời hạn. Chỉ quản trị được lấy QR mới. Khi quét hợp lệ, trình duyệt được cấp quyền điền phiếu trong 10 phút; người dùng không phải quét lại mỗi 20 giây trong lúc nhập. Quyền này chỉ dùng cho buổi vừa quét, bị thu hồi khi đóng/mở lại buổi và được dùng hết sau khi điểm danh thành công. Liên kết QR được xóa khỏi thanh địa chỉ sau khi xử lý.

Người đã đăng nhập vẫn cần quét QR mới và bấm điểm danh cho từng buổi. Đăng nhập tài khoản (số điện thoại + mật khẩu) chỉ vào nội dung học, không ghi nhận có mặt. Sau điểm danh lần đầu, giao diện hiển thị mật khẩu ban đầu để lưu cho lần đăng nhập sau. Cùng trường, tên và số điện thoại dùng lại tài khoản, giữ phiếu khảo sát; không tăng số người khi điểm danh lại cùng buổi.

Danh sách dự kiến là ảnh chụp danh sách trường/người khi tạo buổi; người tự bổ sung được thêm vào chính buổi đang điểm danh. Tài khoản/phiếu cũ không bị chuyển thành có mặt ở buổi mới. QR ngắn hạn giảm việc chia sẻ liên kết cố định; vẫn có thể bị chuyển tiếp ngay khi còn hạn, nên không thay việc kiểm tra hiện diện của báo cáo viên.

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
php -n tests/attendance.php
PHP_BIN=/path/to/php node tests/integration.cjs
```

Kiểm thử API tự tạo bản sao và dữ liệu giả trong thư mục tạm, không đọc/ghi cấu hình thật. Phạm vi: nâng cấp dữ liệu cũ, điểm danh mới/lại, chống trùng số điện thoại, lưu danh sách, gửi/cập nhật khảo sát theo tài khoản, quyền truy cập, CRUD và xung đột phiên bản. Kiểm thử kết xuất: năm mục, biểu mẫu 15 câu, thống kê, escape nội dung/liên kết và các trường hợp tự điền theo trường. Bổ sung kiểm thử chu kỳ QR đúng 20 giây, mã hết hạn/sai chữ ký/sai buổi, thu hồi khi đóng hoặc mở lại, quyền điền phiếu hết hạn, thống kê riêng từng buổi, đăng nhập không tạo điểm danh và hiển thị từng bước. Không gọi API AI thật.

## Quản lý lại điểm danh và thống kê khảo sát (v11)

Trong Kiểm diện, chọn đúng buổi rồi dùng **Reset điểm danh buổi** hoặc **Xóa buổi**. Reset xóa các lượt ghi nhận, giữ tên/ngày và danh sách dự kiến; xóa buổi bỏ cả buổi đó. Cả hai cần gõ đúng tên buổi, đóng/thu hồi mã QR cũ và giữ nguyên tài khoản, phiếu khảo sát, các buổi khác. Nếu dữ liệu thay đổi sau khi mở xác nhận, máy chủ từ chối để người quản trị kiểm tra lại. Nên xuất CSV trước; không có nút hoàn tác. Chỉ quản trị được thực hiện.

Khảo sát có bảng tổng quan và bộ lọc theo nhóm người đã điểm danh một buổi, trường, chức vụ; biểu đồ vòng tiến độ; biểu đồ thuận lợi, điểm nghẽn, nhu cầu; tỷ lệ gửi theo trường/chức vụ; phân bố phiếu theo ngày cập nhật cuối; 15 biểu đồ câu hỏi theo phạm vi và xuất CSV. Lọc buổi không tạo khảo sát riêng cho từng buổi: dùng phiếu toàn đợt của những người có mặt trong buổi đã chọn. Nhóm chưa có người/phiếu hiển thị 0, không suy ra mức độ hoặc xếp loại trường. Mỗi câu ghi mẫu số; câu chọn nhiều có thể cộng vượt 100%. Mode hiển thị đầy đủ các phương án đồng hạng có tần suất cao nhất, không coi là đáp án đúng.

Báo cáo hiển thị provider/model thực tế đã dùng, thời điểm hoàn tất, quy mô mẫu và cảnh báo khi dữ liệu thay đổi; tách biệt với cấu hình model hiện tại (auto chỉ là lựa chọn tự động). Thông tin này đi kèm bản TXT và nội dung sao chép. Báo cáo AI là toàn đợt, không thay đổi theo bộ lọc biểu đồ. Báo cáo AI và metadata toàn đợt chỉ dành cho quản trị; tài khoản học viên chỉ nhận thống kê và nhận định tự động của trường đã đăng ký. Không cần khóa AI để tính biểu đồ. Đường dẫn tài nguyên đổi sang v11 để tải giao diện mới.

## Reset khảo sát, sửa/xóa từng lượt và giao diện điện thoại (v13)

**Khảo sát → Reset kết quả khảo sát → gõ RESET KHAO SAT → xác nhận.** Xóa toàn bộ phiếu của bộ 15 câu, thống kê và báo cáo AI; trở về chưa mở, ẩn mọi công bố. Giữ bộ câu hỏi, tài khoản, điểm danh và các phản hồi chuyên đề khác. Xuất CSV trước nếu cần; không có nút hoàn tác. Xác nhận cũ bị từ chối khi có dữ liệu mới. Phiếu mở trước lần reset không gửi lại được vào đợt mới, kể cả khi đã mở nhận lại; phải tải giao diện và điền phiếu mới. Bấm Mở nhận khảo sát để bắt đầu thu lại. Đây là chức năng quản trị, deploy mã nguồn không tự reset dữ liệu thật.

Trong danh sách điểm danh từng buổi, mỗi người đã có mặt có nút **Sửa / Xóa**. Sửa họ tên, trường, chức vụ, số điện thoại ghi nhận, thời điểm (giờ Việt Nam), ghi chú; chỉ đổi bản ghi buổi này, không sửa tài khoản gốc. Xóa cần gõ đúng họ tên, người đó trở về chưa điểm danh. Không tác động phiếu khảo sát hoặc buổi khác. Bản ghi đã bị thay đổi/xóa ở phiên khác không cho ghi đè. CSV buổi có ghi chú. Ghi nhận lại bằng QR không tự ghi đè chỉnh sửa quản trị.

Học viên xem khảo sát theo bốn nhóm, chuyển Trước/Tiếp theo hoặc chọn nhóm trực tiếp; câu trả lời được giữ trong biểu mẫu khi đổi nhóm. Có tiến độ và thanh điều hướng ở cuối màn hình; gửi toàn bộ ở nhóm cuối, thiếu câu nào sẽ chuyển về nhóm chứa câu đó. Bản nháp trong trang không thay thế việc gửi phiếu và không bảo đảm giữ sau khi đóng/tải lại tab. Trang quản trị đưa điều khiển lên đầu, các nhóm biểu đồ/câu hỏi, danh sách và báo cáo có thể thu gọn. Điện thoại hiển thị điểm danh thành thẻ, nút chạm tối thiểu 44px và ô nhập 16px để hạn chế phóng to tự động. Tài nguyên dùng v13.

## Thống kê theo quyền và đáp án gọn (v14)

Tài khoản cá nhân chỉ nhận thống kê, tiến độ và nhận định của đúng tên trường lưu trong tài khoản, sau khi quản trị công bố thống kê. Người chưa đăng nhập hoặc chưa có trường hợp lệ không nhận số liệu khảo sát. Việc lọc thực hiện trên máy chủ ở cả portal_state và đường đọc state cũ; tham số trường từ trình duyệt không thay đổi phạm vi tài khoản. Không trả báo cáo AI toàn đợt, model/source toàn đợt hay danh sách trường khác cho học viên, kể cả từng bật cờ công bố báo cáo cũ. Chỉnh thông tin bản ghi điểm danh từng buổi không làm thay đổi trường trong tài khoản và quyền xem thống kê.

Quản trị xem đầy đủ số đã/chưa trả lời, tổng kết toàn đợt, biểu đồ, bộ lọc và báo cáo AI. Phần nhận định tự động mô tả tỷ lệ tham gia, lựa chọn nổi bật về thuận lợi/điểm nghẽn/nhu cầu (giữ đồng hạng) và hướng sử dụng kết quả; có mẫu số, không chấm điểm hoặc xếp loại trường. Nhận định này tính trực tiếp từ số liệu, tách khỏi báo cáo diễn giải AI. Nhóm chưa có phiếu không sinh nhận định nội dung.

Các đáp án dùng khoảng cách 4px, dòng 1.35 và phần đệm gọn; điện thoại vẫn giữ vùng chạm tối thiểu 44px. Biểu đồ có màu phân biệt thuận lợi, điểm nghẽn, nhu cầu; nhãn tỷ lệ và số lượng rõ ràng, thẻ nhận định dễ đọc. Dùng tài nguyên v14 sau khi deploy.

## Quản lý danh sách tập huấn (v15)

Quản trị → **Danh sách tập huấn** (hoặc Kiểm diện → Quản lý danh sách). Có tìm kiếm không dấu theo tên/trường/chức vụ/số điện thoại, lọc trường, thêm/sửa người, thêm/đổi tên trường và xuất CSV cả người chưa điểm danh. Người chưa biết chức vụ/số điện thoại có thể để trống để bổ sung khi quét QR. Trường trống vẫn xuất hiện trong danh sách chọn trường.

Nếu nhập số điện thoại và chức vụ cho người chưa có tài khoản, hệ thống tạo tài khoản và hiển thị mật khẩu ban đầu cho quản trị; việc này không ghi nhận có mặt. Sửa người đã có tài khoản giữ nguyên ID, mật khẩu và liên kết phiếu khảo sát. Đổi số điện thoại đổi tên đăng nhập, không đổi mật khẩu. Đổi trường đổi phạm vi thống kê mà tài khoản được xem. Lịch sử điểm danh/snapshot danh sách dự kiến của các buổi đã tạo giữ nguyên; buổi tạo mới dùng danh sách đã chỉnh. Không tự gộp các trường/người trùng, không nhận số điện thoại thuộc tài khoản khác, từ chối bản sửa đã cũ khi có cập nhật đồng thời.

Danh sách biên tập lưu cùng dữ liệu hosting, không sửa file seed mỗi lần và không bị deploy ghi đè. Chỉ quản trị nhận dữ liệu số điện thoại/tài khoản trong mục này; danh sách chọn trường công khai vẫn chỉ có tên trường, họ tên, chức vụ. `roster.php` được bảo vệ và thêm vào deploy; giao diện dùng v15.


### Danh sách tập huấn v18
- Xoá người là xoá vĩnh viễn hồ sơ/tài khoản, phiếu khảo sát, lượt điểm danh, danh sách dự kiến liên quan, phản hồi và lượt bình chọn. Xoá trường xoá toàn bộ các dữ liệu liên quan của trường. Báo cáo khảo sát AI bị huỷ để không giữ nội dung từ người đã xoá. Xác nhận bằng `XOA <số người>` hoặc `XOA <số trường> TRUONG`. Có thể dùng lại số điện thoại để nhập và tạo tài khoản mới, không khôi phục dữ liệu cũ.
- Khi nâng cấp, các mục đã được ẩn/xoá theo v16–17 được tự xoá vĩnh viễn ở lần truy cập đầu. Bản sao `previous.php` do ứng dụng quản lý cũng được ghi lại bằng dữ liệu sau xoá. Bản sao lưu bên ngoài ứng dụng/hosting không do mã nguồn này quản lý.
- Excel `.xlsx` tối đa 200 dòng / 2 MB. Dùng các cột Trường, Họ và tên, Chức vụ, Số điện thoại; có thể thiếu cột hoặc để trống ô, đổi thứ tự cột. Mỗi dòng chỉ cần một thông tin; dòng trống bỏ qua. Dòng chỉ có tên trường tạo trường rỗng. Hồ sơ thiếu thông tin được lưu để quản trị bổ sung sau, không tạo tài khoản cho đến khi đủ cả bốn mục. Số điện thoại nếu nhập cần hợp lệ.
- Có mẫu riêng cho danh sách người và tên trường. Xem trước số tài khoản mới, hồ sơ chờ bổ sung, trường mới và mục bỏ qua rồi xác nhận. Trùng dữ liệu/điện thoại hoặc xung đột dữ liệu sẽ báo lỗi trước khi lưu. Không tự ghi nhận điểm danh.


### Câu khảo sát tài khoản AI v19
Bổ sung câu 16: “Thầy cô đang dùng tài khoản AI nào sau đây?” gồm 18 gói theo ChatGPT, Google Gemini, Claude, Microsoft Copilot, Perplexity AI, Grok và lựa chọn riêng “Chưa dùng chat AI nào”. Cho chọn nhiều gói, không áp dụng giới hạn 3 của các câu cũ; lựa chọn chưa dùng loại trừ các gói còn lại.

Phiếu cũ 15 câu giữ nguyên, không tự điền câu 16. Học viên có thể bổ sung khi quản trị mở nhận. Thống kê, biểu đồ và CSV câu mới chỉ tính trên người đã trả lời câu đó; không diễn giải phiếu thiếu thành “chưa dùng”. AI nhận câu hỏi và số liệu mới; báo cáo đã tạo trước đó được đánh dấu cũ nếu khác dữ liệu hiện tại. Tên gói giữ theo danh mục yêu cầu của đợt tập huấn.

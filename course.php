<?php
// Không phục vụ dữ liệu trực tiếp. Chỉ API đã kiểm tra quyền mới dùng nội dung này.
return json_decode(<<<'COURSE'
{
  "title": "Quản trị trường học trong thời đại AI",
  "presenter": "Thầy giáo Nguyễn Hồng Dân",
  "sessions": [
    {
      "id": 1,
      "eyebrow": "BUỔI 01 · HIỂU & TỔ CHỨC",
      "title": "Quản trị công nghệ số và AI",
      "subtitle": "Cơ chế quản lý, vận hành, sử dụng và các mô hình ứng dụng",
      "color": "mint",
      "outcome": "Một mô hình triển khai tại trường, có quy trình và người chịu trách nhiệm."
    },
    {
      "id": 2,
      "eyebrow": "BUỔI 02 · ỨNG DỤNG & KIỂM CHỨNG",
      "title": "AI trong quản lý và điều hành",
      "subtitle": "Tổng hợp, phân tích dữ liệu và hỗ trợ ra quyết định",
      "color": "blue",
      "outcome": "Một kế hoạch có bảng giao việc và một báo cáo quản trị có bằng chứng."
    },
    {
      "id": 3,
      "eyebrow": "BUỔI 03 · TRẢI NGHIỆM & SÁNG TẠO",
      "title": "Xưởng thực hành sản phẩm AI",
      "subtitle": "Công cụ, hướng dẫn, hỗ trợ và chia sẻ sản phẩm",
      "color": "gold",
      "outcome": "Một sản phẩm hoàn chỉnh, câu lệnh và kế hoạch sử dụng tại trường."
    }
  ],
  "sections": [
    {
      "id": "s1-1",
      "session": 1,
      "title": "Nhà trường đang vướng ở đâu?",
      "level": "Cơ bản",
      "minutes": 15,
      "lead": "Chọn một công việc đang mất thời gian hoặc khó kiểm soát để làm bài toán xuyên suốt.",
      "points": [
        [
          "Bắt đầu từ việc thật",
          "Ghi rõ ai đang làm, tần suất, thời gian, lỗi thường gặp và người sử dụng kết quả."
        ],
        [
          "Tách biểu hiện và nguyên nhân",
          "Báo cáo chậm có thể do dữ liệu thiếu, cách tính khác nhau hoặc chưa rõ trách nhiệm; cần kiểm tra trước khi chọn công cụ."
        ],
        [
          "Đặt mục tiêu kiểm chứng được",
          "Ví dụ mục tiêu thử nghiệm: giảm số lần nhập lại và rút ngắn thời gian tổng hợp. Đo trước và sau bằng cùng một cách."
        ]
      ],
      "model": [
        "Nhận diện việc",
        "Tìm nguyên nhân",
        "Chọn ưu tiên",
        "Đặt mục tiêu"
      ],
      "case": {
        "title": "Bốn phần mềm, một báo cáo",
        "story": "Trường Minh Sơn (tình huống giả lập) có bốn hệ thống. Mỗi tháng tổ trưởng vẫn tổng hợp Excel rồi gửi lại ban giám hiệu. Báo cáo thường chậm hai ngày.",
        "question": "Vướng mắc lớn nhất ở trường thầy/cô hiện nay là gì?"
      },
      "question": "Vướng mắc lớn nhất ở trường thầy/cô hiện nay là gì?",
      "options": [
        "Nhập dữ liệu lặp lại",
        "Không thống nhất số liệu",
        "Khó theo dõi nhiệm vụ",
        "Thiếu hỗ trợ sử dụng"
      ],
      "answer": null,
      "explanation": "Đây là khảo sát nhu cầu, không có đáp án đúng/sai. Chọn vấn đề sẽ dùng làm bài toán thực hành.",
      "task": [
        "Viết tên một công việc cụ thể.",
        "Mô tả cách làm hiện tại và điểm đang vướng.",
        "Chọn một chỉ số để đo hiệu quả."
      ],
      "deliverable": "Phiếu bài toán quản lý: việc – vướng mắc – mục tiêu – người phụ trách.",
      "rubric": [
        "Vấn đề cụ thể",
        "Có dữ liệu để kiểm tra",
        "Mục tiêu đo được"
      ],
      "prompt": "Hãy giúp tôi phân tích công việc [tên việc] tại một trường phổ thông. Hiện trạng: [mô tả]. Hãy hỏi tôi tối đa 5 câu để làm rõ nguyên nhân; chưa đề xuất mua phần mềm. Sau đó lập bảng vấn đề, bằng chứng cần có, mục tiêu thử nghiệm và người phụ trách.",
      "tools": [
        "forms",
        "sheets"
      ],
      "facilitator": "Khảo sát trước khi nói; dùng kết quả để chọn ví dụ. Không khẳng định đây là thống kê đại diện ngành."
    },
    {
      "id": "s1-2",
      "session": 1,
      "title": "Hiểu đúng: phần mềm, tự động hóa, AI",
      "level": "Cơ bản",
      "minutes": 25,
      "lead": "Ba loại công cụ có vai trò khác nhau. Người quản lý lựa chọn và kiểm soát kết quả.",
      "points": [
        [
          "Phần mềm quản lý",
          "Lưu hồ sơ, phân quyền, theo dõi trạng thái; tính theo quy tắc đã thiết lập."
        ],
        [
          "Tự động hóa",
          "Chuyển dữ liệu, nhắc hạn và thực hiện bước lặp lại khi có điều kiện rõ."
        ],
        [
          "AI tạo sinh",
          "Hỗ trợ soạn thảo, tóm tắt và gợi ý; có thể sai thông tin, số liệu và nguồn."
        ],
        [
          "Trách nhiệm quản lý",
          "Kết quả ảnh hưởng quyền lợi, đánh giá con người hoặc ban hành chính thức cần người có thẩm quyền xem xét."
        ]
      ],
      "model": [
        "Dữ liệu",
        "Công cụ phù hợp",
        "Kiểm tra",
        "Phê duyệt"
      ],
      "case": {
        "title": "AI viết rất thuyết phục",
        "story": "Một báo cáo AI khẳng định tỷ lệ học sinh chưa đạt là 12%, nhưng bảng tính đã kiểm tra cho kết quả 8%.",
        "question": "Cách xử lý phù hợp nhất là gì?"
      },
      "question": "Cách xử lý phù hợp nhất là gì?",
      "options": [
        "Dùng 12% vì báo cáo viết rõ",
        "Lấy trung bình hai tỷ lệ",
        "Kiểm tra nguồn, mẫu số và cách tính",
        "Bỏ mọi công cụ AI"
      ],
      "answer": 2,
      "explanation": "Ưu tiên dữ liệu nguồn và cách tính được kiểm chứng. Sự trôi chảy của văn bản không chứng minh độ chính xác.",
      "task": [
        "Liệt kê 6 việc của ban giám hiệu.",
        "Phân loại việc phù hợp phần mềm, tự động hóa hoặc AI.",
        "Đánh dấu bước bắt buộc con người duyệt."
      ],
      "deliverable": "Bảng giao đúng việc cho đúng công cụ.",
      "rubric": [
        "Phân biệt được vai trò",
        "Nêu giới hạn",
        "Có bước kiểm tra"
      ],
      "prompt": "Phân loại các việc sau: [danh sách]. Lập bảng: loại công cụ phù hợp, dữ liệu đầu vào, kết quả đầu ra, sai sót cần kiểm tra, người duyệt. Không đề xuất AI tự quyết định đánh giá giáo viên hoặc học sinh.",
      "tools": [
        "gemini",
        "sheets"
      ],
      "facilitator": "Trình diễn một phép tính chuẩn bằng bảng tính và một bản nhận xét AI có lỗi; để học viên phát hiện."
    },
    {
      "id": "s1-3",
      "session": 1,
      "title": "Ai quản lý? Ai vận hành? Ai sử dụng?",
      "level": "Cơ bản",
      "minutes": 30,
      "lead": "Mỗi hệ thống cần chủ trách nhiệm nghiệp vụ, đầu mối kỹ thuật và người thay thế.",
      "points": [
        [
          "Ban giám hiệu",
          "Chọn mục tiêu, quy trình, nguồn lực và tiêu chí đánh giá."
        ],
        [
          "Chủ trách nhiệm nghiệp vụ",
          "Quy định dữ liệu, kiểm tra chất lượng, chốt số liệu và xử lý điều chỉnh."
        ],
        [
          "Đầu mối kỹ thuật",
          "Tài khoản, quyền truy cập, phối hợp sự cố, sao lưu và bàn giao."
        ],
        [
          "Người dùng và người thay thế",
          "Cập nhật đúng hạn, kiểm tra kết quả; người thay thế được hướng dẫn trước khi cần tiếp nhận."
        ]
      ],
      "model": [
        "BGH chỉ đạo",
        "Nghiệp vụ chịu trách nhiệm",
        "Kỹ thuật hỗ trợ",
        "Người dùng thực hiện"
      ],
      "case": {
        "title": "Một người giữ tất cả",
        "story": "Giáo viên phụ trách công nghệ chuyển công tác. Tài khoản quản trị và hướng dẫn vận hành chưa được bàn giao.",
        "question": "Cách phòng ngừa bền vững nhất là gì?"
      },
      "question": "Cách phòng ngừa bền vững nhất là gì?",
      "options": [
        "Để mọi người dùng chung tài khoản",
        "Có phân công, tài khoản riêng và quy trình bàn giao",
        "Chỉ lưu số điện thoại người cũ",
        "Mua phần mềm khác ngay"
      ],
      "answer": 1,
      "explanation": "Phân công và khả năng bàn giao giúp nhà trường chủ động; tài khoản riêng giúp xác định trách nhiệm.",
      "task": [
        "Chọn một phần mềm trường đang dùng.",
        "Lập bảng người quản lý nghiệp vụ, kỹ thuật, người dùng, người thay thế.",
        "Xác định quyền xem/sửa/duyệt/xuất dữ liệu theo nhiệm vụ."
      ],
      "deliverable": "Bảng phân công và phân quyền.",
      "rubric": [
        "Có chủ trách nhiệm",
        "Quyền phù hợp nhiệm vụ",
        "Có người thay thế"
      ],
      "prompt": "Thiết kế bảng phân công cho [hệ thống] ở trường [bối cảnh]. Các vai trò: [danh sách]. Với mỗi vai trò nêu quyền tối thiểu cần thiết, trách nhiệm dữ liệu, người thay thế và nội dung bàn giao. Không đưa mật khẩu vào bảng.",
      "tools": [
        "drive",
        "docs"
      ],
      "facilitator": "Làm mẫu chia sẻ một thư mục thử nghiệm; mời học viên giải thích vì sao cần quyền sửa."
    },
    {
      "id": "s1-4",
      "session": 1,
      "title": "Vận hành dữ liệu, tài khoản và sự cố",
      "level": "Trung cấp",
      "minutes": 30,
      "lead": "Dữ liệu đúng và khả năng tiếp tục công việc quan trọng như các chức năng trên màn hình.",
      "points": [
        [
          "Nguồn dữ liệu chính thức",
          "Thống nhất mã, người cập nhật, thời điểm chốt và cách sửa; tránh danh sách mỗi nơi một kiểu."
        ],
        [
          "Quản lý tài khoản",
          "Dùng tài khoản theo vai trò; thu hồi quyền khi bàn giao; bật xác thực nhiều bước nếu công cụ hỗ trợ."
        ],
        [
          "Sao lưu và phục hồi",
          "Có lịch sao lưu, nơi lưu phù hợp, người kiểm tra; thử khôi phục trên môi trường an toàn."
        ],
        [
          "Báo lỗi và tiếp tục công việc",
          "Ghi thao tác, thời điểm, thông báo, ảnh minh chứng; xác định cách nhập tạm và đối chiếu lại."
        ]
      ],
      "model": [
        "Nhập",
        "Kiểm tra",
        "Duyệt",
        "Khai thác",
        "Lưu & phục hồi"
      ],
      "case": {
        "title": "Hệ thống lỗi ngày chốt báo cáo",
        "story": "Đến hạn báo cáo, phần mềm không truy cập được. Có bản sao lưu nhưng chưa ai từng thử khôi phục.",
        "question": "Việc nên chuẩn bị từ trước là gì?"
      },
      "question": "Việc nên chuẩn bị từ trước là gì?",
      "options": [
        "Chờ nhà cung cấp tự xử lý",
        "Có quy trình sự cố, dữ liệu dự phòng và thử phục hồi",
        "Yêu cầu nhập lại toàn bộ",
        "Chụp màn hình thay mọi bản sao lưu"
      ],
      "answer": 1,
      "explanation": "Cần phương án duy trì công việc và kiểm tra khả năng khôi phục. Ảnh chụp không thay thế dữ liệu có thể phục hồi.",
      "task": [
        "Mô tả một lỗi bằng 4 thông tin: bước làm, thời điểm, kết quả mong muốn, kết quả thực tế.",
        "Thiết kế phương án làm việc tạm.",
        "Xác định cách kiểm tra dữ liệu khi hệ thống hoạt động lại."
      ],
      "deliverable": "Phiếu xử lý sự cố và kế hoạch sao lưu.",
      "rubric": [
        "Báo lỗi tái hiện được",
        "Có người xử lý",
        "Có cách đối chiếu lại"
      ],
      "prompt": "Lập phương án khi [hệ thống] ngừng hoạt động trong [thời gian]. Nêu: công việc ưu tiên, người liên hệ, cách lưu dữ liệu tạm, kiểm tra sao lưu, cách đối chiếu sau phục hồi. Không giả định có thể phục hồi nếu chưa kiểm tra.",
      "tools": [
        "drive",
        "sheets"
      ],
      "facilitator": "Dùng dữ liệu giả lập. Không thay đổi tài khoản hay phục hồi hệ thống đang vận hành trong lớp."
    },
    {
      "id": "s1-5",
      "session": 1,
      "title": "Ba mô hình ứng dụng trong nhà trường",
      "level": "Trung cấp",
      "minutes": 35,
      "lead": "Nhìn luồng dữ liệu và trách nhiệm để hiểu mô hình; chọn mô hình phù hợp quy mô trường.",
      "points": [
        [
          "Điều hành số",
          "Văn bản → nhiệm vụ → người phụ trách → thời hạn → minh chứng → hoàn thành."
        ],
        [
          "Chuyên môn dùng chung dữ liệu",
          "Phân công → thời khóa biểu → thực hiện → kiểm tra tiến độ → điều chỉnh."
        ],
        [
          "AI dựa trên tài liệu nguồn",
          "Tài liệu đã chọn → hỏi/đáp hoặc dự thảo → kiểm tra nguồn → người có thẩm quyền duyệt."
        ],
        [
          "Minh họa CDS",
          "Báo cáo viên trình diễn một luồng trên dữ liệu thử, nêu rõ phần đã vận hành và phần đang thử nghiệm."
        ]
      ],
      "model": [
        "Một nguồn",
        "Nhiều nghiệp vụ",
        "Phân quyền",
        "Theo dõi",
        "Cải tiến"
      ],
      "case": {
        "title": "Không thể sao chép nguyên mô hình",
        "story": "Một trường muốn áp dụng nguyên hệ thống của trường nội trú, nhưng không có nghiệp vụ báo ăn, kho thuốc hoặc quản lý phòng ở.",
        "question": "Nên chọn cách triển khai nào?"
      },
      "question": "Nên chọn cách triển khai nào?",
      "options": [
        "Bật mọi chức năng cho đầy đủ",
        "Chọn luồng phù hợp và thử trên một bộ phận",
        "Yêu cầu giáo viên nhập dữ liệu không dùng",
        "Chờ hệ thống hoàn hảo rồi mới dùng"
      ],
      "answer": 1,
      "explanation": "Mô hình cần phù hợp nghiệp vụ, điều kiện và nguồn lực; triển khai từng luồng giúp kiểm tra hiệu quả.",
      "task": [
        "Chọn một trong ba mô hình.",
        "Vẽ luồng dữ liệu và người phụ trách mỗi bước.",
        "Nêu điều kiện triển khai và điểm cần kiểm tra."
      ],
      "deliverable": "Sơ đồ mô hình ứng dụng của trường.",
      "rubric": [
        "Phù hợp nghiệp vụ",
        "Dữ liệu có nguồn",
        "Có người kiểm tra"
      ],
      "prompt": "Tôi chọn mô hình [tên] cho trường [bối cảnh]. Hãy giúp mô tả từng bước: dữ liệu vào, thao tác, vai trò, dữ liệu ra và điểm kiểm tra. Phân biệt phần mềm xử lý theo quy tắc với AI hỗ trợ suy luận.",
      "tools": [
        "cds",
        "notebooklm"
      ],
      "facilitator": "Chọn một luồng CDS: TKB → sổ đầu bài → tiến độ. Trình bày trên dữ liệu thử đã kiểm tra trước buổi học."
    },
    {
      "id": "s1-6",
      "session": 1,
      "title": "Lựa chọn sản phẩm và kế hoạch 30 ngày",
      "level": "Nâng cao",
      "minutes": 45,
      "lead": "Đánh giá sản phẩm bằng nhiệm vụ thật, khả năng bàn giao và kết quả đo được.",
      "points": [
        [
          "Yêu cầu trước trình diễn",
          "Nêu nghiệp vụ, số người dùng, thiết bị, điều kiện mạng, dữ liệu và báo cáo cần có."
        ],
        [
          "Đánh giá vòng đời",
          "Kiểm tra quyền dữ liệu, khả năng xuất, chi phí duy trì, hỗ trợ, sao lưu, chuyển đổi và chấm dứt sử dụng."
        ],
        [
          "Quy tắc AI nội bộ",
          "Thống nhất công cụ, dữ liệu được sử dụng, cách kiểm chứng và trách nhiệm duyệt."
        ],
        [
          "30 ngày thử nghiệm",
          "Tuần 1 chọn việc; tuần 2 chuẩn hóa; tuần 3 thử nhỏ; tuần 4 đánh giá và quyết định mở rộng."
        ]
      ],
      "model": [
        "Yêu cầu",
        "Thử nghiệm",
        "Đánh giá",
        "Mở rộng"
      ],
      "case": {
        "title": "Sản phẩm đẹp nhưng khó chuyển dữ liệu",
        "story": "Nhà cung cấp trình diễn hấp dẫn nhưng chưa giải thích cách xuất toàn bộ dữ liệu khi trường ngừng sử dụng.",
        "question": "Trước khi lựa chọn cần làm gì?"
      },
      "question": "Trước khi lựa chọn cần làm gì?",
      "options": [
        "Bỏ qua vì giao diện đẹp",
        "Làm rõ xuất dữ liệu, hỗ trợ, chi phí và thử nghiệp vụ",
        "Chỉ hỏi giảm giá",
        "Dùng trước rồi tính sau"
      ],
      "answer": 1,
      "explanation": "Tính chủ động dữ liệu và chi phí vận hành cần được đánh giá ngay từ đầu.",
      "task": [
        "Lập 5 tiêu chí đánh giá một sản phẩm.",
        "Chọn một bài toán thử nghiệm 30 ngày.",
        "Nêu chỉ số trước–sau và người chịu trách nhiệm."
      ],
      "deliverable": "Kế hoạch áp dụng 30 ngày.",
      "rubric": [
        "Có tiêu chí nghiệm thu",
        "Có nguồn lực",
        "Có kết quả đo được"
      ],
      "prompt": "Lập kế hoạch thử nghiệm 30 ngày cho [bài toán]. Đầu vào: [điều kiện]. Trình bày theo tuần, người phụ trách, sản phẩm, chỉ số trước–sau, rủi ro thực tế và điều kiện mở rộng. Không tự tạo số liệu hiệu quả.",
      "tools": [
        "docs",
        "sheets"
      ],
      "facilitator": "Cho các nhóm phản biện tiêu chí; tránh dùng số lượng tài khoản làm chỉ số hiệu quả duy nhất."
    },
    {
      "id": "s2-1",
      "session": 2,
      "title": "Giao nhiệm vụ rõ cho AI",
      "level": "Cơ bản",
      "minutes": 20,
      "lead": "Một yêu cầu tốt giúp AI làm đúng hướng; kết quả vẫn cần kiểm chứng.",
      "points": [
        [
          "Nhiệm vụ",
          "Nói rõ cần soạn, tóm tắt, đối chiếu hay đề xuất."
        ],
        [
          "Bối cảnh và nguồn",
          "Cung cấp đối tượng, mục tiêu, điều kiện trường và tài liệu đủ dùng."
        ],
        [
          "Tiêu chí đầu ra",
          "Độ dài, bố cục, giọng văn, bảng cần có và thông tin không được tự điền."
        ],
        [
          "Chỉnh qua nhiều lượt",
          "Yêu cầu hỏi lại, sửa từng phần, nêu điểm còn thiếu; lưu phiên bản đã kiểm tra."
        ]
      ],
      "model": [
        "Giao việc",
        "Cung cấp nguồn",
        "Đặt tiêu chí",
        "Sửa",
        "Kiểm tra"
      ],
      "case": {
        "title": "Câu lệnh quá rộng",
        "story": "Người dùng gõ “Viết kế hoạch thật hay”. AI tạo kế hoạch dài, nhưng không biết thời gian, đối tượng và nguồn lực trường.",
        "question": "Nên bổ sung gì trước tiên?"
      },
      "question": "Nên bổ sung gì trước tiên?",
      "options": [
        "Thêm từ chuyên nghiệp nhiều lần",
        "Nhiệm vụ, bối cảnh, nguồn và đầu ra mong muốn",
        "Yêu cầu dài hơn",
        "Yêu cầu không cần kiểm tra"
      ],
      "answer": 1,
      "explanation": "Tài liệu và điều kiện cụ thể có giá trị hơn các tính từ chung chung.",
      "task": [
        "Viết câu lệnh ban đầu.",
        "Bổ sung nguồn và tiêu chí.",
        "So sánh hai kết quả theo bảng kiểm."
      ],
      "deliverable": "Một câu lệnh có thể dùng lại.",
      "rubric": [
        "Nhiệm vụ rõ",
        "Nguồn rõ",
        "Có yêu cầu kiểm chứng"
      ],
      "prompt": "Bạn hỗ trợ ban giám hiệu trường phổ thông. Nhiệm vụ: [việc]. Bối cảnh: [đối tượng, thời gian, nguồn lực]. Chỉ sử dụng tài liệu tôi cung cấp. Đầu ra: [bố cục]. Không tự tạo căn cứ, số liệu, tên người. Hỏi lại những thông tin cần thiết trước khi soạn.",
      "tools": [
        "gemini",
        "chatgpt"
      ],
      "facilitator": "Làm hai câu lệnh với cùng tài liệu và để nhóm đánh giá bằng tiêu chí."
    },
    {
      "id": "s2-2",
      "session": 2,
      "title": "Từ văn bản chỉ đạo đến kế hoạch",
      "level": "Cơ bản",
      "minutes": 35,
      "lead": "AI hỗ trợ đọc và soạn; người quản lý đối chiếu nguồn, thẩm quyền và tính khả thi.",
      "points": [
        [
          "Đọc có mục tiêu",
          "Trích nhiệm vụ, đối tượng, thời hạn, yêu cầu sản phẩm; ghi vị trí trong tài liệu để kiểm tra."
        ],
        [
          "Soạn dự thảo",
          "Tách yêu cầu bắt buộc và đề xuất của trường; chừa thông tin chưa xác minh."
        ],
        [
          "Kiểm tra bốn điểm",
          "Nguồn, số liệu, thẩm quyền, điều kiện thực tế."
        ],
        [
          "Hoàn thiện văn bản",
          "Biên tập trong Word/Docs; rà soát bố cục, bảng, tên đơn vị và phiên bản."
        ]
      ],
      "model": [
        "Đọc",
        "Trích nhiệm vụ",
        "Soạn",
        "Đối chiếu",
        "Hoàn thiện"
      ],
      "case": {
        "title": "Một căn cứ không có trong nguồn",
        "story": "AI thêm số hiệu văn bản vào kế hoạch, nhưng tài liệu cung cấp không có số hiệu đó.",
        "question": "Cần xử lý thế nào?"
      },
      "question": "Cần xử lý thế nào?",
      "options": [
        "Giữ vì trông đúng thể thức",
        "Loại bỏ hoặc xác minh bằng nguồn chính thức",
        "Đổi số hiệu khác",
        "Chỉ sửa phông chữ"
      ],
      "answer": 1,
      "explanation": "Không dùng căn cứ chưa xác minh. Định dạng đúng không bảo đảm nội dung đúng.",
      "task": [
        "Đọc văn bản giả lập trong phần tài nguyên.",
        "Tạo bảng nhiệm vụ và thời hạn.",
        "Soạn kế hoạch rồi kiểm tra từng căn cứ."
      ],
      "deliverable": "Kế hoạch dự thảo kèm bảng đối chiếu.",
      "rubric": [
        "Căn cứ có nguồn",
        "Thông tin thiếu được đánh dấu",
        "Nhiệm vụ khả thi"
      ],
      "prompt": "Dựa vào tài liệu đính kèm, lập bảng: nhiệm vụ, đối tượng, thời hạn, sản phẩm, vị trí nguồn. Sau đó soạn dự thảo kế hoạch cho trường [bối cảnh]. Mục chưa đủ thông tin ghi [CẦN BỔ SUNG]. Tách yêu cầu từ văn bản và đề xuất của trường.",
      "tools": [
        "notebooklm",
        "gemini",
        "docs"
      ],
      "facilitator": "Dùng văn bản giả lập có nhãn; văn bản thực phải kiểm tra hiệu lực trước khi tập huấn."
    },
    {
      "id": "s2-3",
      "session": 2,
      "title": "Từ cuộc họp đến bảng giao việc",
      "level": "Trung cấp",
      "minutes": 25,
      "lead": "Kết luận cần trở thành nhiệm vụ có người phụ trách và thời hạn.",
      "points": [
        [
          "Chuẩn bị họp",
          "Nêu vấn đề cần quyết định, dữ liệu, phương án và câu hỏi thảo luận."
        ],
        [
          "Ghi chép có cấu trúc",
          "Phân biệt ý kiến, kết luận và việc còn chờ xác nhận."
        ],
        [
          "Giao việc",
          "Mỗi việc có người chính, người phối hợp, hạn, sản phẩm và trạng thái."
        ],
        [
          "Theo dõi",
          "Lọc việc chậm hạn, kiểm tra minh chứng; nhắc việc theo thỏa thuận, không tự suy diễn người chịu trách nhiệm."
        ]
      ],
      "model": [
        "Chuẩn bị",
        "Ghi nhận",
        "Kết luận",
        "Giao việc",
        "Theo dõi"
      ],
      "case": {
        "title": "AI tự điền người thực hiện",
        "story": "Ghi chép họp nói cần rà soát chuyên cần nhưng chưa giao người. AI tự chọn một giáo viên làm đầu mối.",
        "question": "Nên để trạng thái nào?"
      },
      "question": "Nên để trạng thái nào?",
      "options": [
        "Coi như đã giao chính thức",
        "Chờ người có thẩm quyền xác nhận người phụ trách",
        "Gửi ngay cho giáo viên đó",
        "Xóa nhiệm vụ"
      ],
      "answer": 1,
      "explanation": "Gợi ý chưa được xác nhận phải giữ là đề xuất; không biến thành quyết định đã ban hành.",
      "task": [
        "Tóm tắt ghi chép họp mẫu.",
        "Tạo bảng 5 nhiệm vụ.",
        "Đánh dấu thông tin cần xác nhận và việc quá hạn."
      ],
      "deliverable": "Bảng giao việc sau họp.",
      "rubric": [
        "Không nhầm ý kiến với kết luận",
        "Có hạn và sản phẩm",
        "Không tự gán trách nhiệm"
      ],
      "prompt": "Từ ghi chép này [nội dung], tách: ý kiến, kết luận đã xác nhận, vấn đề chưa quyết định. Lập bảng giao việc gồm nhiệm vụ, người chính, phối hợp, thời hạn, sản phẩm, trạng thái. Chưa rõ người hoặc hạn ghi CẦN XÁC NHẬN.",
      "tools": [
        "gemini",
        "sheets",
        "calendar"
      ],
      "facilitator": "Không thu âm người học khi chưa thông báo và có điều kiện phù hợp; dùng ghi chép mẫu để thực hành."
    },
    {
      "id": "s2-4",
      "session": 2,
      "title": "Kiểm tra tiến độ và hỗ trợ chuyên môn",
      "level": "Trung cấp",
      "minutes": 30,
      "lead": "Dùng dữ liệu để chọn việc cần kiểm tra; xác minh nguyên nhân trước khi đánh giá.",
      "points": [
        [
          "Đối chiếu nghiệp vụ",
          "So sánh kế hoạch, lịch dạy, thực hiện và trạng thái duyệt theo cùng tuần/lớp/môn."
        ],
        [
          "Phát hiện bất thường",
          "Thiếu tiết có thể do chưa nhập, thay đổi lịch, chưa duyệt hoặc dữ liệu lỗi."
        ],
        [
          "Hỗ trợ học sinh",
          "Phân tích nhóm cần bồi dưỡng cùng chuyên cần và tham gia hoạt động; tránh gắn nhãn từ một chỉ số."
        ],
        [
          "Theo dõi điều chỉnh",
          "Giao người xác minh, thống nhất phương án và kiểm tra lại sau thời gian cụ thể."
        ]
      ],
      "model": [
        "Đối chiếu",
        "Phát hiện",
        "Xác minh",
        "Hỗ trợ",
        "Kiểm tra lại"
      ],
      "case": {
        "title": "TKB có, sổ theo dõi chưa thấy",
        "story": "Thời khóa biểu có ba tiết nhưng báo cáo thực hiện chỉ ghi hai. Chưa có xác nhận về tiết còn lại.",
        "question": "Kết luận đầu tiên phù hợp là gì?"
      },
      "question": "Kết luận đầu tiên phù hợp là gì?",
      "options": [
        "Giáo viên bỏ tiết",
        "Có chênh lệch cần đối chiếu và xác minh",
        "Học sinh nghỉ toàn bộ",
        "AI chắc chắn biết nguyên nhân"
      ],
      "answer": 1,
      "explanation": "Dữ liệu thiếu chưa chứng minh không thực hiện. Kiểm tra lịch, đồng bộ, cập nhật và xác nhận trước khi kết luận.",
      "task": [
        "Lập bảng chênh lệch từ dữ liệu mẫu.",
        "Nêu 3 giả thuyết và bằng chứng cần kiểm tra.",
        "Đề xuất cách hỗ trợ và lịch kiểm tra lại."
      ],
      "deliverable": "Phiếu kiểm tra chuyên môn có bằng chứng.",
      "rubric": [
        "Nêu đúng chênh lệch",
        "Không quy kết vội",
        "Có việc xác minh"
      ],
      "prompt": "Phân tích bảng [dữ liệu]. Chỉ mô tả chênh lệch đã thấy; tách giả thuyết nguyên nhân. Với mỗi giả thuyết nêu dữ liệu cần kiểm tra, người xác minh và phương án hỗ trợ sau xác nhận. Không kết luận lỗi của cá nhân khi chưa có bằng chứng.",
      "tools": [
        "cds",
        "sheets",
        "gemini"
      ],
      "facilitator": "Liên hệ luồng CDS buổi 1; không công khai dữ liệu hoặc tên thật của giáo viên."
    },
    {
      "id": "s2-5",
      "session": 2,
      "title": "Làm sạch và phân tích dữ liệu",
      "level": "Trung cấp",
      "minutes": 40,
      "lead": "Tính bằng công cụ phù hợp, kiểm tra mẫu số và dùng AI hỗ trợ diễn giải.",
      "points": [
        [
          "Chuẩn hóa",
          "Đồng nhất tên lớp/môn, kiểu ngày, mã; kiểm tra trùng và ô trống trước tổng hợp."
        ],
        [
          "Tính có thể đối chiếu",
          "Dùng hàm và bảng tổng hợp; tỷ lệ cần mẫu số, thời điểm, đối tượng rõ ràng."
        ],
        [
          "Đọc biểu đồ",
          "So sánh theo cùng định nghĩa; số lượt và số người là hai đại lượng khác nhau."
        ],
        [
          "Kiểm chứng AI",
          "Yêu cầu nêu dòng/bảng làm bằng chứng; kiểm tra ít nhất các số quan trọng và không tự bù dữ liệu thiếu."
        ]
      ],
      "model": [
        "Làm sạch",
        "Tổng hợp",
        "Vẽ biểu đồ",
        "Nhận xét",
        "Đối chiếu"
      ],
      "case": {
        "title": "20 lượt có phải 20 học sinh?",
        "story": "Bảng có 20 lượt học sinh tham gia bồi dưỡng. Một học sinh có thể tham gia nhiều môn.",
        "question": "Có thể kết luận ngay có 20 học sinh không?"
      },
      "question": "Có thể kết luận ngay có 20 học sinh không?",
      "options": [
        "Có, mỗi dòng là một học sinh khác nhau",
        "Không; cần đếm mã học sinh duy nhất",
        "Có nếu AI nói vậy",
        "Lấy 20 chia số môn"
      ],
      "answer": 1,
      "explanation": "Đếm người cần mã duy nhất; đếm lượt dùng dòng hoặc sự kiện theo định nghĩa.",
      "task": [
        "Tải CSV giả lập.",
        "Phát hiện mã trùng và tên lớp cần chuẩn hóa.",
        "Tính tỷ lệ chưa đạt theo lớp, đếm người và lượt."
      ],
      "deliverable": "Bảng tổng hợp và biểu đồ có chú thích.",
      "rubric": [
        "Đơn vị đo đúng",
        "Mẫu số rõ",
        "Số liệu kiểm tra được"
      ],
      "prompt": "Đọc dữ liệu [bảng]. Trước tiên liệt kê lỗi trùng/thiếu/không nhất quán. Không tự sửa thông tin nhận diện. Đề xuất công thức tổng hợp theo lớp; phân biệt số người duy nhất và số lượt. Khi nhận xét, nêu bảng và phép tính làm bằng chứng.",
      "tools": [
        "sheets",
        "chatgpt",
        "gemini"
      ],
      "facilitator": "Mở CSV bằng nhập UTF-8; định nghĩa mã duy nhất trước khi xóa trùng để không mất lượt hợp lệ."
    },
    {
      "id": "s2-6",
      "session": 2,
      "title": "Từ báo cáo đến quyết định có căn cứ",
      "level": "Nâng cao",
      "minutes": 30,
      "lead": "AI gợi ý phương án. Quyết định dựa trên bằng chứng, nguồn lực và thẩm quyền.",
      "points": [
        [
          "Ba lớp phát biểu",
          "Sự kiện dữ liệu cho thấy; giả thuyết cần xác minh; đề xuất hành động."
        ],
        [
          "So sánh phương án",
          "Lợi ích, nguồn lực, thời gian, giới hạn, người thực hiện và cách theo dõi."
        ],
        [
          "Báo cáo một trang",
          "Vấn đề → bằng chứng → điều chưa biết → phương án → đề xuất → bước tiếp theo."
        ],
        [
          "Kiểm tra sau quyết định",
          "Đặt mốc đánh giá; xem kết quả thực tế và điều chỉnh, không coi đề xuất AI là bảo đảm thành công."
        ]
      ],
      "model": [
        "Bằng chứng",
        "Phương án",
        "Thẩm định",
        "Quyết định",
        "Theo dõi"
      ],
      "case": {
        "title": "Chuyên cần giảm, điểm cũng giảm",
        "story": "Một lớp có chuyên cần và điểm trung bình đều giảm. Chưa có dữ liệu về độ khó bài kiểm tra, thời gian nghỉ hoặc điều kiện học tập.",
        "question": "Nhận định phù hợp nhất là gì?"
      },
      "question": "Nhận định phù hợp nhất là gì?",
      "options": [
        "Chuyên cần chắc chắn là nguyên nhân duy nhất",
        "Có liên hệ cần kiểm tra thêm trước kết luận nguyên nhân",
        "Không cần xem dữ liệu nữa",
        "AI tự quyết định xử lý học sinh"
      ],
      "answer": 1,
      "explanation": "Hai chỉ số cùng thay đổi chưa chứng minh quan hệ nhân quả. Cần dữ liệu bổ sung và xem xét bối cảnh.",
      "task": [
        "Viết báo cáo một trang.",
        "So sánh hai phương án theo 4 tiêu chí.",
        "Chọn bước xác minh và chỉ số theo dõi."
      ],
      "deliverable": "Báo cáo quản trị có đề xuất hành động.",
      "rubric": [
        "Bằng chứng rõ",
        "Giới hạn rõ",
        "Hành động khả thi"
      ],
      "prompt": "Dựa vào số liệu đã kiểm tra [dữ liệu], viết báo cáo một trang. Tách sự kiện, giả thuyết và đề xuất. So sánh 2 phương án theo lợi ích, nguồn lực, thời gian và điều kiện thực hiện. Không khẳng định quan hệ nhân quả nếu dữ liệu chưa đủ.",
      "tools": [
        "docs",
        "gemini"
      ],
      "facilitator": "Cho nhóm khác đóng vai người duyệt: hỏi nguồn, phép tính và khả năng thực hiện."
    },
    {
      "id": "s3-1",
      "session": 3,
      "title": "Tài khoản và thao tác nền",
      "level": "Cơ bản",
      "minutes": 20,
      "lead": "Mỗi học viên có không gian làm việc riêng; biết truy cập, lưu và tìm lại sản phẩm.",
      "points": [
        [
          "Chuẩn bị",
          "Thiết bị, mạng, tài khoản, bộ tệp mẫu; kiểm tra công cụ trước buổi học."
        ],
        [
          "Tài khoản",
          "Dùng tài khoản cá nhân hoặc quyền nhóm phù hợp công cụ; không phát chung mật khẩu quản trị."
        ],
        [
          "Thao tác nền",
          "Tạo cuộc trò chuyện; nhập câu lệnh; đưa tài liệu thử; chỉnh sửa và lưu kết quả."
        ],
        [
          "Dữ liệu thực hành",
          "Dùng dữ liệu giả lập hoặc đã loại thông tin nhận diện; không tải hồ sơ nhạy cảm chỉ để thử."
        ]
      ],
      "model": [
        "Truy cập",
        "Thử nhiệm vụ",
        "Chỉnh",
        "Lưu",
        "Tìm lại"
      ],
      "case": {
        "title": "Công cụ không có nút AI như màn hình mẫu",
        "story": "Một học viên mở Sheets nhưng không thấy nút Gemini. Tài khoản và quyền truy cập khác tài khoản trình diễn.",
        "question": "Nên làm gì để tiếp tục học?"
      },
      "question": "Nên làm gì để tiếp tục học?",
      "options": [
        "Khẳng định mọi tài khoản đều có nút đó",
        "Kiểm tra quyền; dùng AI ở cửa sổ riêng làm phương án thay thế",
        "Yêu cầu nhập mật khẩu của báo cáo viên",
        "Dừng toàn bộ lớp"
      ],
      "answer": 1,
      "explanation": "Tính năng phụ thuộc điều kiện công cụ và tài khoản. Cần phương án thực hành tương đương đã chuẩn bị.",
      "task": [
        "Mở công cụ AI đã chọn.",
        "Thử tóm tắt một đoạn văn mẫu.",
        "Lưu kết quả vào thư mục của mình."
      ],
      "deliverable": "Không gian thực hành và sản phẩm thử.",
      "rubric": [
        "Truy cập được",
        "Lưu được",
        "Biết tìm lại"
      ],
      "prompt": "Tóm tắt đoạn sau trong 5 ý, không thêm thông tin: [đoạn]. Nếu có chỗ chưa rõ, nêu câu hỏi cần kiểm tra.",
      "tools": [
        "gemini",
        "chatgpt",
        "drive"
      ],
      "facilitator": "Phân nhóm cần hỗ trợ; không yêu cầu học viên đưa mật khẩu cho trợ giảng."
    },
    {
      "id": "s3-2",
      "session": 3,
      "title": "Một nguồn, nhiều nội dung truyền thông",
      "level": "Cơ bản",
      "minutes": 20,
      "lead": "Tạo nội dung phù hợp người nhận từ cùng một bộ thông tin đã kiểm tra.",
      "points": [
        [
          "Nguồn chung",
          "Tên hoạt động, mục tiêu, thời gian, địa điểm, đối tượng và người liên hệ."
        ],
        [
          "Điều chỉnh đối tượng",
          "Thông báo GV cần việc phải làm; phụ huynh cần thông tin và cách phối hợp; phát thanh cần câu ngắn dễ nghe."
        ],
        [
          "Biên tập",
          "Kiểm tra tên riêng, ngày giờ, giọng văn và nội dung cần xác nhận."
        ],
        [
          "Chia sẻ",
          "Lưu bản nguồn và bản đã duyệt; đặt tên rõ để tránh dùng nhầm dự thảo."
        ]
      ],
      "model": [
        "Nguồn",
        "Đối tượng",
        "Dự thảo",
        "Biên tập",
        "Chia sẻ"
      ],
      "case": {
        "title": "Ba người nhận, một bài viết",
        "story": "Thông báo gửi giáo viên được sao chép nguyên văn làm bài phát thanh cho học sinh, có nhiều câu hành chính dài.",
        "question": "Cách cải thiện phù hợp là gì?"
      },
      "question": "Cách cải thiện phù hợp là gì?",
      "options": [
        "Thêm nhiều khẩu hiệu",
        "Giữ thông tin cốt lõi, đổi cách diễn đạt theo người nhận",
        "Bỏ ngày giờ",
        "Để AI tự thêm thành tích"
      ],
      "answer": 1,
      "explanation": "Thông tin thống nhất nhưng cách diễn đạt cần phù hợp đối tượng và kênh.",
      "task": [
        "Chọn nguồn mẫu.",
        "Tạo thông báo 150 từ hoặc bài phát thanh 2 phút.",
        "Đọc và sửa tên, thời gian, lời kêu gọi."
      ],
      "deliverable": "Nội dung truyền thông đã biên tập.",
      "rubric": [
        "Thông tin đúng",
        "Đúng đối tượng",
        "Dễ sử dụng"
      ],
      "prompt": "Từ thông tin sau [nguồn], tạo [loại nội dung] cho [đối tượng]. Giữ nguyên tên, ngày, địa điểm; không thêm thành tích hoặc phát biểu chưa có. Giọng văn [yêu cầu], độ dài [mức]. Liệt kê thông tin cần xác nhận.",
      "tools": [
        "gemini",
        "docs"
      ],
      "facilitator": "Mời học viên đọc 30 giây để kiểm tra tính tự nhiên; kiểm tra tốc độ đọc trước khi gọi là bài 2 phút."
    },
    {
      "id": "s3-3",
      "session": 3,
      "title": "Slide, infographic và áp phích",
      "level": "Trung cấp",
      "minutes": 30,
      "lead": "Nội dung và khả năng đọc quyết định chất lượng; thiết kế hỗ trợ thông điệp.",
      "points": [
        [
          "Chọn cấu trúc",
          "Slide: một ý chính mỗi trang; infographic: nhóm thông tin; áp phích: thông điệp và hành động nổi bật."
        ],
        [
          "Tạo bằng AI",
          "Yêu cầu dàn ý trước, chọn mẫu rồi chỉnh nội dung; giới hạn trang và chữ."
        ],
        [
          "Kiểm tra thiết kế",
          "Tương phản, cỡ chữ, dấu tiếng Việt, tên riêng, bố cục và hình phù hợp."
        ],
        [
          "Xuất sản phẩm",
          "Chọn định dạng phù hợp nơi sử dụng; mở lại tệp đã xuất để kiểm tra."
        ]
      ],
      "model": [
        "Nội dung",
        "Dàn ý",
        "Thiết kế",
        "Chỉnh",
        "Xuất"
      ],
      "case": {
        "title": "Áp phích đẹp, ngày sai",
        "story": "Ảnh AI tạo chữ tiếng Việt sai và ghi nhầm ngày tổ chức.",
        "question": "Cách hoàn thiện nên là gì?"
      },
      "question": "Cách hoàn thiện nên là gì?",
      "options": [
        "Dùng luôn vì hình đẹp",
        "Sửa chữ bằng công cụ biên tập và đối chiếu nguồn",
        "Che ngày bằng hình trang trí",
        "Cho rằng người xem sẽ tự hiểu"
      ],
      "answer": 1,
      "explanation": "Chữ và thông tin cần biên tập, kiểm tra; hình tạo sinh có thể không giữ đúng văn bản.",
      "task": [
        "Chọn 5 slide hoặc một áp phích.",
        "Tạo dàn ý rồi thiết kế.",
        "Xuất và kiểm tra trên màn hình điện thoại."
      ],
      "deliverable": "Slide/infographic/áp phích đã xuất.",
      "rubric": [
        "Đúng nội dung",
        "Đọc rõ",
        "Bố cục có trọng tâm"
      ],
      "prompt": "Thiết kế dàn ý [5 slide/infographic] từ [nội dung]. Mỗi phần có tiêu đề, thông điệp chính và gợi ý hình. Không thêm số liệu. Giữ chữ ngắn, ưu tiên dễ đọc trên màn hình.",
      "tools": [
        "canva",
        "gemini"
      ],
      "facilitator": "Làm mẫu 1 trang; cho học viên tự làm phần còn lại. Không yêu cầu mọi người dùng tính năng trả phí."
    },
    {
      "id": "s3-4",
      "session": 3,
      "title": "Bộ hỏi–đáp dựa trên tài liệu",
      "level": "Trung cấp",
      "minutes": 20,
      "lead": "Tạo trợ giúp tra cứu nội dung nguồn và kiểm tra từng câu trả lời.",
      "points": [
        [
          "Chọn nguồn",
          "Tài liệu cần đầy đủ, phù hợp, có ngày và phiên bản; tránh nguồn chưa xác minh."
        ],
        [
          "Hỏi có giới hạn",
          "Yêu cầu chỉ trả lời điều nguồn hỗ trợ; nêu khi chưa có thông tin."
        ],
        [
          "Kiểm tra trích dẫn",
          "Mở vị trí được trích, đọc cả ngữ cảnh; trích dẫn không thay thế kiểm tra hiệu lực."
        ],
        [
          "Chia sẻ đúng quyền",
          "Kiểm tra người nhận có quyền xem và nguồn có phù hợp để chia sẻ không."
        ]
      ],
      "model": [
        "Chọn nguồn",
        "Đặt câu hỏi",
        "Kiểm tra",
        "Biên tập",
        "Chia sẻ"
      ],
      "case": {
        "title": "Có trích dẫn nhưng nguồn đã cũ",
        "story": "Câu trả lời có trích dẫn chính xác một tài liệu cũ, trong khi đã có bản cập nhật.",
        "question": "Cần kiểm tra thêm điều gì?"
      },
      "question": "Cần kiểm tra thêm điều gì?",
      "options": [
        "Không cần vì có trích dẫn",
        "Ngày, phiên bản và phạm vi áp dụng của nguồn",
        "Chỉ cỡ chữ",
        "Số lượng câu trả lời"
      ],
      "answer": 1,
      "explanation": "Trích dẫn giúp truy vết, không tự bảo đảm nguồn còn phù hợp.",
      "task": [
        "Đưa tài liệu mẫu vào công cụ.",
        "Tạo 10 câu hỏi thường gặp.",
        "Kiểm tra 3 câu và một câu không có câu trả lời trong nguồn."
      ],
      "deliverable": "Bộ hỏi–đáp có nguồn.",
      "rubric": [
        "Truy được nguồn",
        "Không bịa thông tin thiếu",
        "Quyền chia sẻ phù hợp"
      ],
      "prompt": "Dựa trên nguồn đã cung cấp, tạo 10 câu hỏi–đáp cho cán bộ quản lý. Mỗi câu nêu vị trí nguồn nếu công cụ hỗ trợ. Chưa có thông tin thì ghi CHƯA CÓ TRONG NGUỒN; không dùng kiến thức ngoài để lấp chỗ thiếu.",
      "tools": [
        "notebooklm",
        "docs"
      ],
      "facilitator": "Chuẩn bị một câu hỏi ngoài phạm vi để kiểm tra khả năng từ chối suy diễn."
    },
    {
      "id": "s3-5",
      "session": 3,
      "title": "Ảnh, âm thanh và video ngắn",
      "level": "Nâng cao",
      "minutes": 20,
      "lead": "Trình diễn quy trình sản phẩm đa phương tiện; chọn công cụ đã thử trước và phù hợp tài khoản.",
      "points": [
        [
          "Ảnh minh họa",
          "Mô tả chủ thể, bối cảnh, tỷ lệ, phong cách; thêm chữ chính xác bằng công cụ biên tập."
        ],
        [
          "Âm thanh",
          "Soạn lời, kiểm tra phát âm tên địa phương; chọn giọng và nghe lại toàn bộ."
        ],
        [
          "Video",
          "Lập kịch bản theo cảnh, hình, lời và thời lượng; biên tập bằng các tài nguyên được phép dùng."
        ],
        [
          "Kiểm tra trước chia sẻ",
          "Nội dung, nhận diện, quyền dùng hình/giọng, phụ đề, âm lượng và thông tin trên khung hình."
        ]
      ],
      "model": [
        "Kịch bản",
        "Tài nguyên",
        "Biên tập",
        "Kiểm tra",
        "Xuất"
      ],
      "case": {
        "title": "Video quảng bá dùng hình học sinh thật",
        "story": "Nhóm muốn dùng ảnh học sinh và nhân bản giọng một giáo viên để tạo video mà chưa làm rõ quyền sử dụng.",
        "question": "Bước nên làm trước là gì?"
      },
      "question": "Bước nên làm trước là gì?",
      "options": [
        "Tạo ngay rồi hỏi sau",
        "Làm rõ quyền sử dụng; chọn hình/giọng phù hợp",
        "Đổi tên tệp là đủ",
        "Chỉ giảm âm lượng"
      ],
      "answer": 1,
      "explanation": "Cần làm rõ quyền và điều kiện sử dụng hình, giọng; có thể chọn tài nguyên minh họa phù hợp thay thế.",
      "task": [
        "Viết kịch bản 30–60 giây.",
        "Chọn ảnh minh họa hoặc tài nguyên mẫu.",
        "Kiểm tra nội dung và ghi nguồn tài nguyên."
      ],
      "deliverable": "Kịch bản video hoặc ảnh minh họa đã biên tập.",
      "rubric": [
        "Thông tin đúng",
        "Tài nguyên phù hợp",
        "Có bước nghe/xem lại"
      ],
      "prompt": "Viết kịch bản video 45 giây giới thiệu [hoạt động]. Dữ liệu: [nguồn]. Lập bảng cảnh, hình gợi ý, lời đọc, thời lượng dự kiến. Không tạo lời phát biểu của người thật. Tên và thời gian phải giữ nguyên.",
      "tools": [
        "canva",
        "gemini"
      ],
      "facilitator": "Phần nâng cao là trình diễn; không hứa mọi tài khoản tạo được video/giọng. Chuẩn bị tệp mẫu dự phòng."
    },
    {
      "id": "s3-6",
      "session": 3,
      "title": "Xưởng sản phẩm và kế hoạch áp dụng",
      "level": "Theo năng lực",
      "minutes": 70,
      "lead": "Hoàn thành một sản phẩm có thể sử dụng, biết kiểm tra và làm lại sau khóa học.",
      "points": [
        [
          "Chọn nhiệm vụ",
          "Văn bản, báo cáo dữ liệu, slide, infographic, hỏi–đáp hoặc kịch bản truyền thông."
        ],
        [
          "Hoàn thiện",
          "Tạo bản đầu → chỉnh → kiểm tra nguồn/nội dung → xuất → mở lại."
        ],
        [
          "Phản hồi chéo",
          "Một nhóm dùng sản phẩm, một nhóm kiểm tra; góp ý dựa trên tiêu chí."
        ],
        [
          "Đưa vào công việc",
          "Nêu nơi dùng, người duyệt, thời điểm áp dụng và cách đo kết quả."
        ]
      ],
      "model": [
        "Chọn",
        "Tạo",
        "Kiểm tra",
        "Chia sẻ",
        "Áp dụng"
      ],
      "case": {
        "title": "Thế nào là sản phẩm hoàn thành?",
        "story": "Một nhóm đã có bản AI đầu tiên nhưng chưa sửa tên trường, kiểm tra số liệu và xuất tệp.",
        "question": "Điều kiện hoàn thành phù hợp là gì?"
      },
      "question": "Điều kiện hoàn thành phù hợp là gì?",
      "options": [
        "Có câu trả lời AI là đủ",
        "Đã kiểm tra, chỉnh sửa, xuất và xác định cách sử dụng",
        "Có nhiều hiệu ứng",
        "Dùng công cụ đắt nhất"
      ],
      "answer": 1,
      "explanation": "Sản phẩm hoàn thành cần phù hợp công việc, kiểm chứng và có thể sử dụng; bản đầu mới là bước khởi đầu.",
      "task": [
        "Chọn một sản phẩm gắn với bài toán buổi 1.",
        "Hoàn thiện theo bảng kiểm.",
        "Nộp liên kết, mô tả và câu lệnh; không nộp dữ liệu nhạy cảm.",
        "Trình bày 2 phút: việc gì, nguồn gì, đã kiểm tra gì, áp dụng ra sao."
      ],
      "deliverable": "Sản phẩm hoàn chỉnh và kế hoạch áp dụng.",
      "rubric": [
        "Đúng",
        "Dùng được",
        "Làm lại được"
      ],
      "prompt": "Đóng vai người phản biện sản phẩm [mô tả]. Đánh giá theo đúng thông tin, phù hợp người dùng, dễ đọc/dùng, nguồn dữ liệu và khả năng áp dụng. Nêu 3 điểm cần sửa ưu tiên; không khen chung chung.",
      "tools": [
        "canva",
        "docs",
        "sheets",
        "gemini"
      ],
      "facilitator": "Chia nhóm theo sản phẩm; ưu tiên hỗ trợ nhóm cơ bản. Chỉ mở thư viện bài nộp sau khi rà soát và chọn công khai."
    }
  ],
  "tools": [
    {
      "id": "drive",
      "name": "Google Drive",
      "url": "https://drive.google.com",
      "use": "Hồ sơ dùng chung, chia sẻ và phân quyền",
      "tier": "Cốt lõi"
    },
    {
      "id": "docs",
      "name": "Google Docs / Word",
      "url": "https://docs.google.com",
      "use": "Biên tập văn bản, góp ý và hoàn thiện",
      "tier": "Cốt lõi"
    },
    {
      "id": "forms",
      "name": "Google Forms",
      "url": "https://forms.google.com",
      "use": "Thu thập thông tin ngoài lớp học này",
      "tier": "Cơ bản"
    },
    {
      "id": "sheets",
      "name": "Google Sheets / Excel",
      "url": "https://sheets.google.com",
      "use": "Làm sạch, tính toán và tổng hợp dữ liệu",
      "tier": "Cốt lõi"
    },
    {
      "id": "gemini",
      "name": "Gemini",
      "url": "https://gemini.google.com",
      "use": "Công cụ AI chủ lực: soạn, chỉnh và hỗ trợ phân tích",
      "tier": "Cốt lõi"
    },
    {
      "id": "chatgpt",
      "name": "ChatGPT",
      "url": "https://chatgpt.com",
      "use": "Công cụ AI thay thế hoặc đối chiếu",
      "tier": "Lựa chọn"
    },
    {
      "id": "notebooklm",
      "name": "NotebookLM",
      "url": "https://notebooklm.google.com",
      "use": "Hỏi–đáp và kiểm tra theo tài liệu nguồn",
      "tier": "Trung cấp"
    },
    {
      "id": "canva",
      "name": "Canva",
      "url": "https://www.canva.com",
      "use": "Slide, infographic, áp phích và biên tập",
      "tier": "Cốt lõi buổi 3"
    },
    {
      "id": "calendar",
      "name": "Google Calendar",
      "url": "https://calendar.google.com",
      "use": "Lịch và nhắc việc theo thiết lập",
      "tier": "Mở rộng"
    },
    {
      "id": "cds",
      "name": "Hệ sinh thái CDS Xín Mần",
      "url": "https://cds.noitruxinman.edu.vn",
      "use": "Trường hợp minh họa do báo cáo viên trình diễn",
      "tier": "Mô hình thực tế"
    }
  ]
}
COURSE
, true);

<?php
$arrActivityType = array(
    1 => FSText::_('Tập huấn'),
    2 => FSText::_('Hội thảo'),
    3 => FSText::_('Hội chợ bán buôn'),
    4 => FSText::_('Hội chợ bán lẻ'),
    5 => FSText::_('Đoàn ra'),
    6 => FSText::_('Đoàn vào'),
    7 => FSText::_('Phát triển sản phẩm'),
    8 => FSText::_('Truyền thông, Quảng bá'),
    9 => FSText::_('Đối thoại chính sách'),
    11 => FSText::_('Họp nhóm công tác'),
    10 => FSText::_('Khác')
);

$arrIndustries = array(
    1 => FSText::_('Quả vải'),
    2 => FSText::_('Chè xanh'),
    3 => FSText::_('Tiêu'),
    4 => FSText::_('Cá ngừ'),
    5 => FSText::_('Cá tra'),
    6 => FSText::_('Trái cây tươi'),
    7 => FSText::_('Thủ công mỹ nghệ'),
    8 => FSText::_('LOGISTICS'),
    9 => FSText::_('Du lịch'),
    10 => FSText::_('Thương hiệu'),
    11 => FSText::_('TOT'),
    12 => FSText::_('Khác')
);

$arrRegions = array(
    0 => FSText::_('Toàn quốc'),
    1 => FSText::_('Miền Bắc'),
    2 => FSText::_('Miền Trung'),
    3 => FSText::_('Miền Nam')
);

$arrMemType = array(
    1 => FSText::_('XTTM'),
    2 => FSText::_('PMU'),
    3 => FSText::_('Tư vấn phụ trách'),
    4 => FSText::_('Tư vấn ngành hàng'),
    5 => FSText::_('Doanh nghiệp')
);

$arrProgram = array(
    1 => FSText::_('Hỗ trợ DN nhỏ và vừa'),
    2 => FSText::_('XTTM Quốc gia'),
    4 => FSText::_('Korea - Vietnam Design Sharing Program'),
    5 => FSText::_('CBI'),
    3 => FSText::_('Khác')
);

$arrOperationalStatus = array(
    1 => FSText::_('Đã thực hiện'),
    2 => FSText::_('Thay đổi hoạt động'),
    3 => FSText::_('Hủy bỏ'),
    4 => FSText::_('Trì hoãn')
);

$arrActivityKeyTime = array(
    'after',
    'after1month',
    'after1quarter',
    'after2quarter',
    'after3quarter',
    'after4quarter',
    'empirical',
    'challenge'
);

$arrBusinessResults = array(
    'export_sales' => FSText::_('Doanh thu xuất khẩu').' ('.FSText::_('triệu đồng').')',
    'sales' => FSText::_('Doanh số bán hàng').' ('.FSText::_('triệu đồng').')',
    'new_markets' => FSText::_('Số thị trường mới mở'),
    'new_clients' => FSText::_('Số khách hàng mới'),
    'named_limited_view' => FSText::_('Nêu tên'),
    'marketing_foreign_language' => FSText::_('Số cán bộ marketing mới có ngoại ngữ'),
    'new_products' => FSText::_('Số sản phẩm mới'),
    'number_employees' => FSText::_('Số lao động'),
    'outcome' => FSText::_('Bài học kinh nghiệm')
);

$arrCapacityBuilding = array(
    'officials_knowledge' => FSText::_('Số cán bộ của đơn vị có kiến thức về ngành hàng xuất khẩu chủ đạo của địa phương'),
    'officials_xttm' => FSText::_('Số cán bộ của đơn vị có kỹ năng XTTM'),
    'officials_customer' => FSText::_('Số cán bộ của đơn vị có kỹ năng quản lý khách hàng'),
    'dnvvn' => FSText::_('Số DNNVV trong tỉnh'),
    'dnvvn_export' => FSText::_('Số DNNVV có xuất khẩu trực tiếp trong tỉnh'),
    'provincial_building_strategy' => FSText::_('Tỉnh xây dựng được Chiến lược XTTM phù hợp với tình hình địa phương, có tham vấn doanh nghiệp và các bên liên quan'),
    'business_organizations' => FSText::_('Đơn vị mở rộng được mạng lưới với các tổ chức ở nước ngoài'),
    'business_survey' => FSText::_('Đơn vị triển khai khảo sát doanh nghiệp'),
    'business_complete_database' => FSText::_('Đơn vị xây dựng và hoàn chỉnh cơ sở dữ liệu phục vụ quản lý danh mục khách hàng'),
    'business_benchmarking'=> FSText::_('Đơn vị sử dụng mô hình Benchmarking để tự đánh giá'),
    'xttm_open_new' => FSText::_('Số lượng danh mục sản phẩm, dịch vụ XTTM mới mở thêm trong năm'),
    'business_receiving_support' => FSText::_('Đơn vị nhận được thêm đề nghị hỗ trợ từ doanh nghiệp với số lượng là (DN)'),
    'business_user_products' => FSText::_('Số lượng doanh nghiệp sử dụng các sản phẩm, dịch vụ của đơn vị'),
    'business_satisfaction' => FSText::_('Tỷ lệ Doanh nghiệp trong tỉnh hài lòng với sản phẩm, dịch vụ của đơn vị (%)')
);
$arrCapacityBuildingNote = array(
    'officials_knowledge' => '',
    'officials_xttm' => '',
    'officials_customer' => '',
    'dnvvn' => '',
    'dnvvn_export' => '',
    'provincial_building_strategy' => FSText::_('Chi tiết, quy mô cách làm, bài học kinh nghiệm'),
    'business_organizations' => FSText::_('Chi tiết về số lượng mới mở rộng'),
    'business_survey' => FSText::_('Chi tiết về số lượng DN, cách làm'),
    'business_complete_database' => FSText::_('Mô tả những cải tiến, đổi mới'),
    'business_benchmarking' => FSText::_('Chi tiết, quy mô cách làm, bài học kinh nghiệm'),
    'xttm_open_new' => FSText::_('Chi tiết, bài học kinh nghiệm về cách làm- danh mục năm trước, tên sản phẩm, dịch vụ mới'),
    'business_receiving_support' => FSText::_('Chi tiết về cách thức thống kê'),
    'business_user_products' => FSText::_('Chi tiết về cách thức thống kê'),
    'business_satisfaction' => FSText::_('Chi tiết về cách thức khảo sát, thống kê')
);

$arrRiskType = array(
    2 => FSText::_('Development risk'),
    3 => FSText::_('Reputational risk'),
    4 => FSText::_('Fiduciary risk'),
    5 => FSText::_('Financial risk'),
    6 => FSText::_('Environmental risk'),
    7 => FSText::_('Social risk'),
    1 => FSText::_('Other')
);

$arrEdp = array(
    1 => FSText::_('Đã nộp hồ sơ đăng ký'),
    2 => FSText::_('Đang làm EDP'),
    3 => FSText::_('Đã hoàn thiện EDP'),
    4 => FSText::_('Đang tham gia dự án'),
);
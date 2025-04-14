<?php

/**
 * search
 * 
 * 
 * 
 */

// fetch bootloader
require('bootloader.php'); // Nạp tệp bootloader.php để khởi động cấu hình, session, và kết nối cơ sở dữ liệu

// user access
if ($user->_logged_in || !$system['system_public']) {
  user_access();  // Nếu người dùng đã đăng nhập hoặc website không phải public, kiểm tra quyền truy cập người dùng
}

// valid inputs
$_GET['tab'] = ($_GET['tab'] == "") ? "posts" : $_GET['tab'];  // Nếu tab rỗng, mặc định gán là 'posts'
if (!in_array($_GET['tab'], ["posts", "articles", "users", "pages", "groups", "events"])) {
  _error(404);  // Nếu tab không hợp lệ, trả về lỗi 404
}

try {

  // search
  if (isset($_GET['query'])) {
    /* get results */
    $results = $user->search($_GET['query'], $_GET['tab']);  // Gọi hàm search với từ khóa và tab, trả về kết quả phù hợp

    /* assign variables */
    $smarty->assign('query', htmlentities($_GET['query'], ENT_QUOTES, 'utf-8'));  // Gán biến 'query' vào template, chống XSS bằng htmlentities
    $smarty->assign('hashtag', (isset($_GET['hashtag']) && $_GET['hashtag'] == '1') ? true : false);  // Kiểm tra nếu có hashtag thì gán giá trị true
    $smarty->assign('results', $results);  // Gán kết quả tìm kiếm vào template
  }

  $smarty->assign('tab', $_GET['tab']);  // Gán tên tab vào template để hiển thị giao diện đúng với nội dung tìm kiếm

  // get ads campaigns
  $ads_campaigns = $user->ads_campaigns();  // Lấy danh sách chiến dịch quảng cáo
  /* assign variables */
  $smarty->assign('ads_campaigns', $ads_campaigns);  // Gán chiến dịch quảng cáo vào template

  // get ads
  $ads = $user->ads('search');  // Lấy danh sách quảng cáo dành cho trang search
  /* assign variables */
  $smarty->assign('ads', $ads);  // Gán quảng cáo vào template

  // get widgets
  $widgets = $user->widgets('search');  // Lấy danh sách widget (tiện ích) cho trang search
  /* assign variables */
  $smarty->assign('widgets', $widgets);  // Gán widget vào template

} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());  // Nếu có lỗi trong quá trình tìm kiếm hoặc lấy dữ liệu, hiển thị thông báo lỗi
}

// page header
page_header(__("Search") . ' | ' . __($system['system_title']));  // Hiển thị tiêu đề trang tìm kiếm với tên hệ thống

// page footer
page_footer('search');  // Hiển thị phần chân trang (footer) cho trang tìm kiếm

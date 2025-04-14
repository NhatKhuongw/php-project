<?php

/**
 * messages
 * 
 * 
 * 
 */

// fetch bootloader
require('bootloader.php');  // Nạp file bootloader.php để khởi tạo cấu hình, session, kết nối database

// user access
user_access();  // Kiểm tra quyền truy cập, nếu chưa đăng nhập thì sẽ điều hướng sang trang login

// page header
page_header(__("Messages"));  // Thiết lập tiêu đề trang là "Messages" (Tin nhắn)

try {

  // check the view
  $view = (!isset($_GET['view'])) ? 'message' : 'new';  // Nếu không có view, mặc định là 'message', nếu có thì là 'new'

  // get view content
  if ($view == 'message') {  // Nếu view là message (trò chuyện đã có)

    if (!isset($_GET['cid'])) {  // Nếu không có cid (conversation_id) nào được gửi lên URL
      if ($user->_data['conversations']) {  // Kiểm tra nếu người dùng có cuộc trò chuyện nào
        $conversation = $user->_data['conversations'][0];  // Lấy cuộc trò chuyện đầu tiên
        $conversation['messages'] = $user->get_conversation_messages($conversation['conversation_id']);  // Lấy tin nhắn của cuộc trò chuyện này
      }
    } else {  // Nếu URL có cid
      /* check cid is valid */
      if (is_empty($_GET['cid']) || !is_numeric($_GET['cid'])) {  // Kiểm tra cid có hợp lệ không, nếu không thì trả về lỗi 404
        _error(404);
      }
      $conversation = $user->get_conversation($_GET['cid']);  // Lấy thông tin cuộc trò chuyện theo cid
      $conversation['messages'] = $user->get_conversation_messages($conversation['conversation_id']);  // Lấy tin nhắn của cuộc trò chuyện
    }
    // assign variables
    $smarty->assign('conversation', $conversation);  // Gán cuộc trò chuyện vào template để hiển thị

  } elseif ($view == 'new') {  // Nếu view là 'new' (tạo cuộc trò chuyện mới)

    /* get recipient */
    if (isset($_GET['uid'])) {  // Nếu URL có gửi user_id người nhận
      $get_recipient = $db->query(sprintf(
        "SELECT user_id, user_name, CONCAT(users.user_firstname,' ',users.user_lastname) as user_fullname FROM users WHERE user_id = %s",
        secure($_GET['uid'], 'int')
      )) or _error('SQL_ERROR_THROWEN');  // Truy vấn thông tin người nhận từ cơ sở dữ liệu, kiểm tra lỗi SQL

      if ($get_recipient->num_rows > 0) {  // Nếu tìm thấy user
        $recipient = $get_recipient->fetch_assoc();  // Lấy dữ liệu user

        $recipient["user_fullname"] = ($system['show_usernames_enabled'])
          ? $recipient['user_name']
          : $recipient['user_fullname'];  // Nếu cấu hình bật "show usernames", hiển thị username, ngược lại hiển thị fullname

        /* assign variables */
        $smarty->assign('recipient', $recipient);  // Gán thông tin người nhận vào template
      }
    }
  }

  //check
  /* assign variables */
  $smarty->assign('view', $view);  // Gán biến 'view' cho template, để template biết đang hiển thị giao diện nào (message hoặc new)

} catch (Exception $e) {
  _error(__("Error"), $e->getMessage());  // Nếu có lỗi, hiển thị thông báo lỗi ra giao diện
}

// page footer
page_footer('messages');  // Hiển thị phần footer cho trang tin nhắn

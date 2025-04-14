<?php

/**
 * photo
 * 
 * This script handles the display of a single photo page, including fetching the photo details,
 * handling user access, and rendering ads and widgets. It also manages privacy and error handling.
 * 
 * @author [Original Author]
 * @version [Version Number]
 * @since [Creation Date]
 * 
 */

// fetch bootloader
require('bootloader.php');

// user access
// Check if the user is logged in or if the system is not public, then enforce user access control
if ($user->_logged_in || !$system['system_public']) {
  user_access();
}

// valid inputs
// Validate that photo_id is provided and is numeric, otherwise return a 404 error
if (!isset($_GET['photo_id']) || !is_numeric($_GET['photo_id'])) {
  _error(404);
}

try {

  // upload photo
  // Enable privacy error handling and fetch the photo by ID with full details
  define('PRIVACY_ERRORS', true);
  $photo = $user->get_photo($_GET['photo_id'], true);
  if (!$photo) {
    _error(404); // Return 404 if photo is not found
  }
  /* assign variables */
  // Assign photo data to the Smarty template engine
  $smarty->assign('photo', $photo);

  // get ads campaigns
  // Fetch the user's ad campaigns
  $ads_campaigns = $user->ads_campaigns();
  /* assign variables */
  // Assign ad campaigns to the Smarty template
  $smarty->assign('ads_campaigns', $ads_campaigns);

  // get ads
  // Fetch ads specific to the photo page
  $ads = $user->ads('photo');
  /* assign variables */
  // Assign ads to the Smarty template
  $smarty->assign('ads', $ads);

  // get widgets
  // Fetch widgets for the photo page
  $widgets = $user->widgets('photo');
  /* assign variables */
  // Assign widgets to the Smarty template
  $smarty->assign('widgets', $widgets);
} catch (PrivacyException $e) {
  // Handle privacy-related errors by redirecting to a permission error page
  _error('PERMISSION');
} catch (Exception $e) {
  // Handle general errors by displaying an error page with the exception message
  _error(__("Error"), $e->getMessage());
}

// page header
// Set the page header with Open Graph metadata (title, description, image)
page_header($photo['og_title'], $photo['og_description'], $photo['og_image']);

// page footer
// Render the page footer
page_footer('photo');

?>
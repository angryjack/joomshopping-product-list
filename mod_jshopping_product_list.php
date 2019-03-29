<?php
defined('_JEXEC') or die('Access denied');
error_reporting(error_reporting() & ~E_NOTICE);

if (!file_exists(JPATH_SITE . '/components/com_jshopping/jshopping.php')) {
    JError::raiseError(500, "Please install component \"joomshopping\"");
}

require_once(JPATH_SITE . '/components/com_jshopping/lib/factory.php');
require_once(JPATH_SITE . '/components/com_jshopping/lib/functions.php');

JSFactory::loadCssFiles();
JSFactory::loadLanguageFile();

$document = JFactory::getDocument();
$jshopConfig = JSFactory::getConfig();

/** @var jshopProduct $product */
$product = JTable::getInstance('product', 'jshop');
$layout = $params->get('layout', 'default');

$type = (int)$params->get('type');
$count = $params->get('count', 5);

$filters = array();
if ($type === 0) {
    $category = $params->get('category');
    $filters['categorys'] = [$category];
    $url_params = "&category_id=$category";
} else {
    $label = $params->get('label');
    $filters['labels'] = [$label];
    $url_params = "&label_id=$label";
}
$rows = $product->getAllProducts($filters, null, null, 0, $count);

addLinkToProducts($rows, 0, 1);

$load_more = $params->get('load_more');
$product_count = $product->getCountAllProducts($filters);
if ($load_more && $product_count > $count && $count > 0) {
    $button_title = $params->get('button_title');
    $document->addScript(JURI::base() . 'modules/mod_jshopping_product_list/js/main.js');
    $link = SEFLink("index.php?option=com_jshopping&controller=products&task=view$url_params");
    $limit = $count;
    $remain_products = $product_count - $count;
    if ($remain_products < $count) {
        $limit = $remain_products;
    }
}

$enable_addon = $params->get('enable_addon', 1);
if ($enable_addon) {
    JPluginHelper::importPlugin('jshoppingproducts');
    $dispatcher = JDispatcher::getInstance();
    $dispatcher->trigger('onBeforeDisplayProductList', array(&$rows));
    $view = new stdClass();
    $view->rows = $rows;
    $dispatcher->trigger('onBeforeDisplayProductListView', array(&$view));
    $rows = $view->rows;
}

$noimage = $jshopConfig->image_product_live_path . "/noimage.gif";
$shippinginfo = SEFLink($jshopConfig->shippinginfourl, 1);

$show_image = $params->get('show_image', 1);
$show_old_price = $params->get('show_old_price', 0);
$show_image_label = $params->get('show_image_label', 0);
$allow_review = $params->get('allow_review', 0);
$short_description = $params->get('short_description', 0);
$manufacturer_name = $params->get('manufacturer_name', 0);
$product_quantity = $params->get('product_quantity', 0);
$product_old_price = $params->get('product_old_price', 0);
$product_price_default = $params->get('product_price_default', 0);
$display_price = $params->get('display_price', 1);
$show_tax_product = $params->get('show_tax_product', 0);
$show_plus_shipping_in_product = $params->get('show_plus_shipping_in_product', 0);
$basic_price_info = $params->get('basic_price_info', 0);
$product_weight = $params->get('product_weight', 0);
$delivery_time = $params->get('delivery_time', 0);
$extra_field = $params->get('extra_field', 0);
$vendor = $params->get('vendor', 0);
$product_list_qty_stock = $params->get('product_list_qty_stock', 0);
$show_button = $params->get('show_button', 1);
$show_button_buy = $params->get('show_button_buy', 0);
$show_button_detal = $params->get('show_button_detal', 1);

require(JModuleHelper::getLayoutPath('mod_jshopping_product_list', $layout));
?>

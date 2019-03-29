<?php
$data = json_decode($module->params);
?>
<div class="jshop<?= ($data->moduleclass_sfx) ?? '' ?> joomshopping-products
    <?= ($category) ? "category-$category" : "label-$label"; ?>">

    <?php if ($module->showtitle) : ?>

        <<?= $data->header_tag ?? 'h3' ?> class="<?= $data->header_class ?? '' ?>">
                <?= $module->title ?>
        </<?= $data->header_tag ?? 'h3' ?>>

    <?php endif; ?>

<div class="list-product">
    <?php foreach ($rows as $product) : ?>
        <?= $product->_tmp_var_start ?>
        <div class="block_item">
            <?php if ($show_image && $product->image) : ?>
                <div class="image">
                    <div class="image_block">
                        <?= $product->_tmp_var_image_block; ?>
                        <?php if ($product->label_id && $show_image_label) : ?>
                            <div class="product_label">
                                <?php if ($product->_label_image) : ?>
                                    <img src="<?= $product->_label_image ?>"
                                         alt="<?= htmlspecialchars($product->_label_name) ?>"/>
                                <?php else : ?>
                                    <span class="label_name"><?= $product->_label_name; ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <a href="<?= $product->product_link ?>">
                            <img class="jshop_img" src="<?= $product->image ? $product->image : $noimage; ?>"
                                 alt="<?= htmlspecialchars($product->name); ?>"/>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($allow_review) : ?>
                <table class="review_mark">
                    <tr>
                        <td><?= showMarkStar($product->average_rating); ?></td>
                    </tr>
                </table>
                <div class="count_commentar">
                    <?= sprintf(_JSHOP_X_COMENTAR, $product->reviews_count); ?>
                </div>
            <?php endif; ?>

            <?= $product->_tmp_var_bottom_foto; ?>

            <div class="name">
                <a href="<?= $product->product_link ?>"><?= $product->name ?></a>
                <?php if ($jshopConfig->product_list_show_product_code) : ?>
                    <span class="jshop_code_prod">
                            (<?= _JSHOP_EAN ?>:<span><?= $product->product_ean; ?></span>)
                        </span>
                <?php endif; ?>
            </div>

            <?php if ($short_description) : ?>
                <div class="description">
                    <?= $product->short_description ?>
                </div>
            <?php endif; ?>

            <?php if ($product->manufacturer->name && $manufacturer_name) : ?>
                <div class="manufacturer_name">
                    <?= _JSHOP_MANUFACTURER; ?>:
                    <span><?= $product->manufacturer->name ?></span>
                </div>
            <?php endif; ?>

            <?php if ($product->product_quantity <= 0
                && !$jshopConfig->hide_text_product_not_available
                && $product_quantity) : ?>
                <div class="not_available">
                    <?= _JSHOP_PRODUCT_NOT_AVAILABLE; ?>
                </div>
            <?php endif; ?>

            <?php if ($product_old_price) : ?>
                <?php if ($product->product_old_price > 0) : ?>
                    <div class="old_price">
                        <?= ($jshopConfig->product_list_show_price_description) ? _JSHOP_OLD_PRICE . ": " : '' ?>
                        <span><?= formatprice($product->product_old_price) ?></span>
                    </div>
                <?php endif; ?>
                <?= $product->_tmp_var_bottom_old_price; ?>
            <?php endif; ?>

            <?php if ($product->product_price_default > 0
                && $jshopConfig->product_list_show_price_default
                && $product_price_default) : ?>
                <div class="default_price">
                    <?= _JSHOP_DEFAULT_PRICE . ": "; ?>
                    <span><?= formatprice($product->product_price_default) ?></span>
                </div>
            <?php endif; ?>

            <?php if ($display_price) : ?>
                <?php if ($product->_display_price) : ?>
                    <div class="jshop_price">
                        <?= ($jshopConfig->product_list_show_price_description) ? _JSHOP_PRICE . ": " : '' ?>
                        <?= ($product->show_price_from) ? _JSHOP_FROM . " " : '' ?>
                        <span><?= formatprice($product->product_price); ?></span>
                    </div>
                <?php endif; ?>
                <?= $product->_tmp_var_bottom_price; ?>
            <?php endif; ?>

            <?php if ($jshopConfig->show_tax_in_product && $product->tax > 0 && $show_tax_product) : ?>
                <span class="taxinfo">
                        <?= productTaxInfo($product->tax); ?>
                    </span>
            <?php endif; ?>

            <?php if ($jshopConfig->show_plus_shipping_in_product && $show_plus_shipping_in_product) : ?>
                <span class="plusshippinginfo">
                        <?= sprintf(_JSHOP_PLUS_SHIPPING, $shippinginfo); ?>
                    </span>
            <?php endif; ?>

            <?php if ($product->basic_price_info['price_show'] && $basic_price_info) : ?>
                <div class="base_price">
                    <?= _JSHOP_BASIC_PRICE ?>: <?= ($product->show_price_from) ? _JSHOP_FROM : '' ?>
                    <span><?= formatprice($product->basic_price_info['basic_price']) ?> / <?= $product->basic_price_info['name']; ?></span>
                </div>
            <?php endif; ?>

            <?php if ($jshopConfig->product_list_show_weight && $product->product_weight > 0 && $product_weight) : ?>
                <div class="productweight">
                    <?= _JSHOP_WEIGHT ?>:
                    <span><?= formatweight($product->product_weight) ?></span>
                </div>
            <?php endif; ?>

            <?php if ($product->delivery_time != '' && $delivery_time) : ?>
                <div class="deliverytime">
                    <?= _JSHOP_DELIVERY_TIME ?>:
                    <span><?= $product->delivery_time ?></span>
                </div>
            <?php endif; ?>

            <?php if (is_array($product->extra_field) && $extra_field) : ?>
                <div class="extra_fields">
                    <?php foreach ($product->extra_field as $extra_field) : ?>
                        <div><?= $extra_field['name']; ?>: <?= $extra_field['value']; ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($product->vendor && $vendor) : ?>
                <div class="vendorinfo">
                    <?= _JSHOP_VENDOR ?>:
                    <a href="<?= $product->vendor->products ?>">
                        <?= $product->vendor->shop_name ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($jshopConfig->product_list_show_qty_stock && $product_list_qty_stock) : ?>
                <div class="qty_in_stock">
                    <?= _JSHOP_QTY_IN_STOCK ?>:
                    <span><?= sprintQtyInStock($product->qty_in_stock) ?></span>
                </div>
            <?php endif; ?>

            <?php if ($show_button) : ?>
                <?= $product->_tmp_var_top_buttons; ?>

                <div class="buttons">
                    <?php if ($product->buy_link && $show_button_buy) : ?>
                        <a class="button_buy" href="<?= $product->buy_link ?>"><?= _JSHOP_BUY ?></a> &nbsp;
                    <?php endif; ?>
                    <?php if ($show_button_detal) : ?>
                        <a class="button_detail" href="<?= $product->product_link ?>"><?= _JSHOP_DETAIL ?></a>
                    <?php endif; ?>
                    <?= $product->_tmp_var_buttons; ?>
                </div>

                <?= $product->_tmp_var_bottom_buttons; ?>
            <?php endif; ?>
        </div>

        <?= $product->_tmp_var_end ?>

    <?php endforeach; ?>
</div>
<?php if ($link) : ?>
    <button class="load-more"
            data-link="<?= $link ?>"
            data-limit="<?= $limit ?>"
            data-start="<?= $count ?>"
            data-count="<?= $product_count ?>">
        <?= $button_title ?>
    </button>
<?php endif; ?>
</div>
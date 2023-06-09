<?php
if (!class_exists('Pass_Delivery_Woocommerce_Admin_Panel')) {
    class Pass_Delivery_Woocommerce_Admin_Panel
    {
        public static $parent_slug = 'pass-orders';

        public function __construct()
        {
            $this->id = PASS_METHOD_ID;
            $this->method_title = PASS_METHOD_TITLE;
            $this->method_description = PASS_METHOD_DESC;

            add_action('admin_menu', array($this, 'admin_menu_items'));
            add_filter('plugin_action_links_' . PASS_PLUGIN_BASENAME, array($this, 'action_links'));

            $this->add_extra_items();
        }

        /**
         * @since 1.0.0
         */
        public function admin_menu_items()
        {
            $mainTitle = 'Pass delivery';

            add_menu_page($mainTitle, $mainTitle, 'manage_options', self::$parent_slug, null, plugins_url('pass-delivery-woocommerce/admin/assets/img/icon.png'), '55.6');

            $this->manage_orders();
            $this->manage_incomplete_orders();
            $this->manage_settings();
            $this->manage_support();

        }

        private function manage_orders()
        {
            require_once __DIR__ . '/class-pass-delivery-woocommerce-menuitem-orders.php';
            new Pass_Delivery_Woocommerce_Menuitem_Orders();
        }

        private function manage_incomplete_orders()
        {
            require_once __DIR__ . '/class-pass-delivery-woocommerce-menuitem-incomplete-orders.php';
            new Pass_Delivery_Woocommerce_Menuitem_Incomplete_Orders();
        }

        private function manage_settings()
        {
            require_once __DIR__ . '/class-pass-delivery-woocommerce-menuitem-setting.php';
            new Pass_Delivery_Woocommerce_Menuitem_Setting();
        }

        private function manage_support()
        {
            require_once __DIR__ . '/class-pass-delivery-woocommerce-menuitem-support.php';
            new Pass_Delivery_Woocommerce_Menuitem_Support();
        }

        /**
         * @since  1.0.0
         * @param  array $links
         * @return array
         */
        public function action_links( $links ) {

            GLOBAL $pdHelper;
            $plugin_links[] = '<a href="' . $pdHelper->get_settings_url() . '">' . __('Settings', PASS_TRANSLATE_ID) . '</a>';
            $plugin_links[] = '<a href="' . $pdHelper->get_support_url() . '">' . __('Support', PASS_TRANSLATE_ID) . '</a>';
            $plugin_links[] = '<a href="https://passdelivery.readme.io/reference/getting-started">Documentation</a>';

            return array_merge( $plugin_links, $links );

        }
        private function add_extra_items()
        {
            $this->orders_status();
        }
        private function orders_status()
        {
            require_once __DIR__ . '/class-pass-delivery-woocommerce-order-status.php';
            new Pass_Delivery_Woocommerce_Order_Status();
        }
    }
}
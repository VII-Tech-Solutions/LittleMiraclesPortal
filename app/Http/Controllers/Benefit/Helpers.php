<?php

namespace App\Http\Controllers\Benefit;

class Helpers
{

    /**
     * Get Alias
     * @return string|null
     */
    static function get_alias() {
        $alias_path = Helpers::get_auth_folder_path() . "alias.txt";
        return file_get_contents($alias_path);
    }

    /**
     * Get Auth Folder Path
     *
     * @return string|null
     */
    function get_auth_folder_path() {
        $prefix = getenv('benefit_auth_folder');
        return "$prefix/";
    }

    /**
     * Generate Big Rand
     * @param int $len
     *
     * @return string
     */
    function generate_big_rand( $len = 9 ) {
        $rand   = '';
        while( !( isset( $rand[$len-1] ) ) ) {
            $rand   .= mt_rand( );
        }
        return substr( $rand , 0 , $len );
    }

    /**
     * Get Order Row by UID
     *
     * @param $order_uid
     *
     * @return null|array
     */
    function get_order_row ($order_uid) {
        require 'pdo.php';
        $order_sql = "select * from `orders` where uid = ?";
        $order_pdo = $pdo->prepare($order_sql);

        $order_pdo->execute([$order_uid]);
        if ($order_pdo->rowCount() == 1) {
            return $order_pdo->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

}

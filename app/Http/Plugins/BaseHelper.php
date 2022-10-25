<?php
namespace App\Http\Plugins;

/**
 * BaseHelper class
 * @version 1.0.0
 */
class BaseHelper
{
    public function __construct()
    {

    }
    /**
     * _debug function
     *
     * @param mixed $obj
     * @param bool $stop
     * @return detail obj
     */
    public static function _debug($obj, $stop = true) {
        echo '<pre>';
        print_r($obj);
        echo '</pre>';
        if ($stop) {
            exit();
        }
    }

    /**
     * function clean_data.
     * @param string , array $e element of array clear tag xss clean
     * @return $e element of array.
     */
    public static function clean_data($e)
    {
        if (is_object($e)) {
            $e = (array) $e;
        }
        if (is_array($e)) {
            return array_map(array(__CLASS__, 'clean_data'), $e);
        }
        $e = trim( strip_tags( htmlspecialchars($e) ) );
        $e = BaseHelper::xss_clean($e);
        return $e;
    }

    /**
     * xss_clean function
     *
     * @param string $data
     * @return string clean xss
     */
    public static function xss_clean($data)
    {
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do
        {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);

        // we are done...
        return $data;
    }

    /**
     * checkDatetime function check string valid datetime format
     *
     * @param [string] $strDate
     * @return boolean
     */
    public static function checkDatetime($strDate)
    {
        if (empty($strDate)) {
            return false;
        }
        if (!strtotime($strDate)) {
            return false;
        }
        if (in_array($strDate, array('0000-00-00 00:00:00', '1970-01-01 00:00:00', '0000-00-00', '1970-01-01'))) {
            return false;
        }
        return true;
    }

    /**
     * ajaxResponse function: echo ajax response and die
     *
     * @param string $msg
     * @param boolean $status
     * @param array $data
     * @return void
     */
    public static function ajaxResponse($msg = '', $status = false, $data = array()){
        echo json_encode(array(
            'status' => $status,
            'msg'    => $msg,
            'data'   => $data
        )); die();
    }

    /**
     * getStringBetween function get string between two string
     *
     * @param string $string
     * @param string $start
     * @param string $end
     * @return string $result
     */
    public static function getStringBetween($string = '', $start = '', $end = ''){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * callHepApi function - call hep_api
     *
     * @param string $method
     * @param string $url
     * @param array $param
     * @return array result or bool
     */
//    public static function callHepApi($method = 'GET', $url = '', $param = [], $debug = false)
//    {
//        if (empty($method) || empty($url)) {
//            return false;
//        }
//        $di     = Phalcon\DI::getDefault();
//        $hepApi = $di->getConfig()->hmApi;
//        $client = new \GuzzleHttp\Client();
//        $method = strtoupper($method);
//
//        $sendData  = [
//            'headers' => [
//                'api-token' => $hepApi['token'],
//            ]
//        ];
//
//        if ($method == 'GET' ) {
//            $sendData['query'] = $param;
//        } else {
//            $sendData['body'] = json_encode($param);
//        }
//
//        $apiUrl   = $hepApi['url'] . str_replace('//', '/',  '/' . $url);
//        $response = $client->request($method, $apiUrl, $sendData);
//
//        if ($debug) {
//            return $response->getBody()->getContents();
//        }
//
//        $results  = json_decode($response->getBody()->getContents(), true);
//        if (JSON_ERROR_NONE !== json_last_error()) {
//            return false;
//        }
//
//        return $results;
//    }
    /**
     * slugify function - gen url friendly from string
     */
    public static function slugify($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-_]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return $str;
    }
}

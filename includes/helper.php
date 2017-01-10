<?php
class Helper {

    // Modified version of http://stackoverflow.com/a/32664523
    public static function executeCommand($cmd, $printLiveResult = false) {
        while (ob_end_flush());

        $proc = popen($cmd.' 2>&1 ; echo Exit: $?', 'r');
        $live_output = '';
        $complete_output = '';

        while (!feof($proc)) {
            $live_output = fread($proc, 4096);
            $complete_output .= $live_output;
            if ($printLiveResult) {
                echo $live_output;
            }
            flush();
        }
        pclose($proc);

        // get exit status
        preg_match('/[0-9]+$/', $complete_output, $matches);

        // return exit status and intended output
        return array(
            'exit' => intval($matches[0]),
            'output' => str_replace('Exit: '.$matches[0], '', $complete_output)
        );
    }

    public static function isTargetPathExist($username, $path) {
        return is_readable(self::getTargetPath($username, $path).'/composer.json');
    }

    public static function getTargetPath($username, $path) {
        $path = rtrim($path, '/');
        return '/home/'.$username.'/domains/'.$path;
    }

    public static function jsRedirect($url) {
        return '<script>window.location.href = "'.$url.'";</script>';
    }

    public static function getAlertsHtml($message, $level = 'info') {
        $html = '<div class="alert alert-'.$level.' alert-dismissible" role="alert">';
        $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        $html .= $message;
        $html .= '</div>';
        return $html;
    }

    // https://help.directadmin.com/item.php?id=289
    public static function parseGET() {
        $_GET = array();
        $QUERY_STRING = getenv('QUERY_STRING');
        if ($QUERY_STRING != '') {
            parse_str(html_entity_decode($QUERY_STRING), $get_array);
            foreach ($get_array as $key => $value) {
                $_GET[urldecode($key)] = urldecode($value);
            }
        }
        return $_GET;
    }

    // Modified version of https://help.directadmin.com/item.php?id=289
    public static function parsePOST() {
        $_POST = array();
        $POST_STRING = getenv('POST');
        if ($POST_STRING != '') {
            parse_str(html_entity_decode($POST_STRING), $post_array);
            foreach ($post_array as $key => $value) {
                if (is_array($value)) {
                    $_POST[urldecode($key)] = array();
                    foreach ($value as $valueKey => $arrayValue) {
                        $_POST[urldecode($key)][$valueKey] = urldecode($arrayValue);
                    }
                } else {
                    $_POST[urldecode($key)] = urldecode($value);
                }
            }
        }
        return $_POST;
    }
}
?>

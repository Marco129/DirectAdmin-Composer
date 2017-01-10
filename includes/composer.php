<?php
class Composer {

    const COMPOSERPATH = '/usr/local/directadmin/plugins/directadmin-composer/data';
    const COMPOSERFILENAME = 'composer.phar';

    public static function isInstalled() {
        return file_exists(self::COMPOSERPATH.'/'.self::COMPOSERFILENAME);
    }

    public static function getVersion() {
        $result = Helper::executeCommand('php '.self::COMPOSERPATH.'/'.self::COMPOSERFILENAME.' -V');
        if ($result['exit'] === 0) {
            return trim($result['output']);
        } else {
            return null;
        }
    }

    public static function exec($action, $option = array()) {
        $cmd = 'php '.self::COMPOSERPATH.'/'.self::COMPOSERFILENAME;
        switch ($action) {
            case 'install':
                $result = Helper::executeCommand($cmd.' '.$action.' '.self::parseOption($option));
                break;
            default:
                return false;
        }
        return $result['exit'] === 0;
    }

    private static function parseOption($option) {
        $cmd = '';
        if (count($option) < 1) {
            return $cmd;
        }
        foreach ($option as $value) {
            if (!self::isValidOption($value)) continue;
            $cmd .= ' --'.$value;
        }
        return $cmd;
    }

    private static function isValidOption($optionName) {
        $validOption = array('no-dev', 'optimize-autoloader');
        return in_array($optionName, $validOption);
    }
}
?>

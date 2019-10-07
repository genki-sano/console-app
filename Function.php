<?php
declare(strict_types = 1);

/**
 * var_dump改良版（デバッグ用）
 */
function d()
{
    foreach (func_get_args() as $v) {
        var_dump($v);
    }
}

/**
 * var_dump改良版を行った後に終了させる（デバッグ用）
 */
function dx()
{
    $bt = debug_backtrace();
    $file = $bt[0]['file'];
    $line = $bt[0]['line'];
    echo $file . ':' . $line . PHP_EOL;

    $args = func_get_args();
    call_user_func_array('d', $args);
    exit();
}

/**
 * htmlspecialchars()の呼び出し表記簡略＆配列対応版
 * @param        $text
 * @param bool   $double
 * @param string $charset
 * @return array|string
 */
function h($text, $double = true, $charset = 'UTF-8')
{
    if (is_array($text)) {
        $texts = array();
        foreach ($text as $k => $t) {
            $texts[$k] = h($t, $double, $charset);
        }
        return $texts;
    } elseif (is_object($text)) {
        if (method_exists($text, '__toString')) {
            $text = (string)$text;
        } else {
            $text = '(object)' . get_class($text);
        }
    } elseif (is_bool($text)) {
        return $text;
    }

    if (is_string($double)) {
        $charset = $double;
    }

    return htmlspecialchars($text, ENT_QUOTES, $charset, $double);
}

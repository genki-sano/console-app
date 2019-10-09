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

/**
 * プロジェクトルートの完全パスを返却
 * 指定されたプロジェクトルートディレクトリからの相対パスから絶対パスを生成
 * @param string $path
 * @return string
 */
function base_path($path = '')
{
    return __DIR__ . ($path ? DIRECTORY_SEPARATOR . $path : $path);
}

/**
 * strip_tags改良版（改行コードも削除）
 * @param      $str
 * @param null $allowable_tags
 * @return mixed|string
 */
function strip_tags_lf($str, $allowable_tags = null)
{
    $tmpStr = strip_tags((string)$str, $allowable_tags);
    $tmpStr = strip_lf($tmpStr);
    return $tmpStr;
}

/**
 * 改行コード(linefeed)を削除
 * @param mixed $text
 * @return mixed
 */
function strip_lf($text)
{
    return str_replace(["\r\n", "\n", "\r"], '', $text);
}

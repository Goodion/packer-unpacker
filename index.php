<?php

function unpacker(String $string) :String
{
    if (is_numeric($string)) {
        throw new Exception(sprintf ('Строка %s состоит из цифр', $string));
    }

    $arr = mb_str_split($string);
    $previousItem = null;
    $result = null;
    $slashFlag = false;
    $arrLength = count($arr);

    for($i = 0; $i <= $arrLength; $i++) {

        if (isset($arr[$i])) {
            if ($slashFlag) {
                $previousItem = $arr[$i];
                $slashFlag = false;
                continue;
            } elseif ($arr[$i] == '\\') {
                $slashFlag = true;
            }

            if (is_numeric($arr[$i])) {
                if ($previousItem) {
                    for ($j = 0; $j < $arr[$i]; $j++) {
                        $result .= $previousItem;
                    }
                    $previousItem = '';
                } else {
                    continue;
                }
            } else {
                if ($previousItem) {
                    $result .= $previousItem;
                }
                $previousItem = $arr[$i];
            }
        } else {
            $result .= $previousItem;
        }
    }
    return $result;
}


$str = <<<'EOD'
a\aa\\a\a4\\4
EOD;

$str1 = <<<'EOD'
qwe\4\5
EOD;

$str2 = <<<'EOD'
qwe\45
EOD;

$str3 = <<<'EOD'
qwe\\5
EOD;

$str4 = 'a4bc2d5e';

$str5 = 'abcd';

$str6 = '45';

$str7 = '';

try {
    var_dump(unpacker($str));
    var_dump(unpacker($str1));
    var_dump(unpacker($str2));
    var_dump(unpacker($str3));
    var_dump(unpacker($str4));
    var_dump(unpacker($str5));
    var_dump(unpacker($str6));
    var_dump(unpacker($str7));
} catch (Exception $e) {
    echo 'Ошибка: ', $e->getMessage();
}

$str8 = <<<'EOD'
aaa\aaaaa\\\\
EOD;

$str9 = <<<'EOD'
qwe45
EOD;

$str10 = <<<'EOD'
qwe44444
EOD;

$str11 = <<<'EOD'
qwe\\\\\
EOD;

$str12 = 'aaaabccddddde';

$str13 = 'abcd';

$str14 = '45';

$str15 = '';

$str16 = <<<'EOD'
\\\\\a
EOD;

function packer (String $string) :String
{
    $arr = mb_str_split($string);
    $previousItem = null;
    $result= null;
    $counter = 1;
    $arrLength =  count($arr);

    for($i = 0; $i <= $arrLength; $i++) {
        if (isset($previousItem) && $previousItem === $arr[$i]) {
            $counter++;
            continue;
        } else {
            if (is_numeric($previousItem) || $previousItem === '\\') {
                $result .= '\\';
            }

            $result .= $previousItem;
            if ($counter !== 1) {
                $result .= $counter;
            }
            $counter = 1;
        }
        $previousItem = $arr[$i];
    }

    return $result;
}

var_dump(packer($str8));
var_dump(packer($str9));
var_dump(packer($str10));
var_dump(packer($str11));
var_dump(packer($str12));
var_dump(packer($str13));
var_dump(packer($str14));
var_dump(packer($str15));
var_dump(packer($str16));

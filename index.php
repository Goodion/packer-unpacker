<?php

function unpacker($string)
{
    if (is_numeric($string)) {
        throw new Exception(sprintf ('Строка %s состоит из цифр', $string));
    }

    $arr = str_split($string);
    $previousItem = null;
    $resultArr = [];
    $slashFlag = false;

    for($i = 0; $i <= count($arr) + 1; $i++) {

        if ($slashFlag) {
            $previousItem = $arr[$i];
            $slashFlag = ! $slashFlag;
            continue;
        } elseif ($arr[$i] == '\\') {
            $slashFlag = ! $slashFlag;
        }

        if (is_numeric($arr[$i])) {
            if ($previousItem) {
                $resultArr += array_fill(count($resultArr), $arr[$i], $previousItem);
                $previousItem = '';
            } else {
                continue;
            }
        } else {
            if ($previousItem) {
                $resultArr[] = $previousItem;
            }
            $previousItem = $arr[$i];
        }
    }

    return implode('', $resultArr);
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

function packer ($string)
{
    $arr = str_split($string);
    $previousItem = null;
    $resultArr = [];
    $counter = 1;

    for($i = 0; $i <= count($arr) + 1; $i++) {
        if ($previousItem === $arr[$i]) {
            $counter++;
            continue;
        } else {
            if (is_numeric($previousItem) || $previousItem === '\\') {
                $resultArr[] = '\\';
            }

            $resultArr[] = $previousItem;
            if ($counter !== 1) {
                $resultArr[] = $counter;
            }
            $counter = 1;
        }
        $previousItem = $arr[$i];
    }

    return implode('', $resultArr);
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

# packer-unpacker
Packs/unpacks string

Examples:

* "a4bc2d5e" => "aaaabccddddde"
* "abcd" => "abcd"
* "45" => "" (incorrect string)
* "" => ""
* `qwe\4\5` => `qwe45`
* `qwe\45` => `qwe44444`
* `qwe\\5` => `qwe\\\\\`

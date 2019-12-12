<?php
require_once('class.converter.php');

$tmp = $_FILES['file']['tmp_name'];
$file_name = '../file/'.$_FILES['file']['name'];

$converter = new Converter($tmp, $file_name);

// 入力されたファイルを移動させる
$converter->move_file();

// ファイルを読み込む
$html = $converter->read_file();

// 変換用のデータを生成
$data = $converter->get_add_data($html);

// JSONデータの出力
// $converter->write_json($data);

echo '<pre>';
var_dump($data);
echo '</pre>';
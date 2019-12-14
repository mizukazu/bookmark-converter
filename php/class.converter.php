<?php
/**
 * ブックマークが記載されたHTMLファイルをJSON形式に変換するクラス
 */
class Converter {
  /**
   * プロパティ
   */
  private $tmp;
  private $file_name;

  /**
   * コンストラクタ
   */
  function __construct($tmp, $file_name) {
    $this->tmp = $tmp;
    $this->file_name = $file_name;
  }

  /**
   * 送信されたファイルを指定ディレクトリへ移動させるメソッド
   */
  public function move_file() {
    if(is_uploaded_file($this->tmp)) {
      if(move_uploaded_file($this->tmp, $this->file_name)) {
        echo $this->file_name . "をアップロードしました。";
      } else {
        echo 'ファイルの送信に失敗しました。';
      }
    } else {
        return '不正な操作です。';
    }
  }

  /**
   * ファイルを読み込むメソッド
   * @return $html
   */
  public function read_file() {
    $file = file_get_contents($this->file_name);
    $html = mb_convert_encoding($file, 'HTML-ENTITIES', 'UTF-8');
    return $html;
  }

  /**
   * 登録用のデータを抽出するメソッド
   * @param $html
   * @return $add_data
   */
  public function get_add_data($html) {
    $dom = new DOMDocument();
    @$dom->loadHTML($html);

    $a_tag = $dom->getElementsByTagName('a');

    $add_data = [];
    foreach($a_tag as $a) {
      $add_data[] = [
        'name' => $a->nodeValue,
        'url'  => $a->getAttribute('href'),
        'tag'  => ''
      ];
    }
    return $add_data;
  }

  /**
   * JSONファイルを作成するメソッド
   * @param $data
   */
  public function write_json($data) {
    $output_url = '../data.json';

    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    file_put_contents($output_url, $json);
  }
}
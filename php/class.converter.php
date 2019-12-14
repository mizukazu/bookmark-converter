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
  private $output_url = '../file/data.json';

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
    $path_info = pathinfo($this->file_name);
    // htmlファイル以外のファイルが送信されたときにはリダイレクト
    if($path_info['extension'] != 'html') {
      $error = 'htmlファイルのみ送信することが出来ます。';
      header('location: ../index.php?error='.$error);
    }
    
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
    if($file = file_get_contents($this->file_name)) {;
      $html = mb_convert_encoding($file, 'HTML-ENTITIES', 'UTF-8');
    } else {
      //エラー処理
      if(count($http_response_header) > 0) {
      //「$http_response_header[0]」にはステータスコードがセットされているのでそれを取得
      $status_code = explode(' ', $http_response_header[0]);  //「$status_code[1]」にステータスコードの数字のみが入る

      //エラーの判別
      switch($status_code[1]) {
        //404エラーの場合
        case 404:
          echo "指定したページが見つかりませんでした";
          break;
        //500エラーの場合
        case 500:
          echo "指定したページがあるサーバーにエラーがあります";
          break;
        //その他のエラーの場合
        default:
          echo "何らかのエラーによって指定したページのデータを取得できませんでした";
      }
      } else {
        //タイムアウトの場合 or 存在しないドメインだった場合
        echo "タイムエラー or URLが間違っています";
      }
    }
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
    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    file_put_contents($this->output_url, $json);
  }

  /**
   * ファイルのダウンロードを行うメソッド
   * @param $path
   * @param $mime_type
   */
  public function download($path, $mime_type = null) {
    // ファイルが読めなかったら処理を終了させる
    if(!is_readable($path)) { die($path . 'を読み込めませんでした。'); }

    if(isset($mime_type)) {
      $mime = $mime_type;
    } else {
      $mime = (new finfo(FILEINFO_MIME_TYPE))->file($path);
    }

    if(!preg_match('/\A\S+?\/\S+/', $mime)) {
      $mime = 'application/octet-stream';
    }

    header('Conten-Type:' . $mime);
    header('X-Content-Type-Options: nosniff');
    header('Content-Disposition: attachment; filename="'.basename($path).'"');
    header('Cnnection: close');

    while(ob_get_level()) { ob_end_clean(); }

    // ファイルのダウンロード後にファイルを削除する
    if(readfile($path) > 0) {
      if(file_exists($path)) {
        unlink($path);
        if(file_exists($this->file_name)) {
          unlink($this->file_name);
        }
      }
    }
    exit;
  }

  /**
   * 変換後のjsonファイルのURLを取得するメソッド
   */
  public function get_output_url() { return $this->output_url; }
}
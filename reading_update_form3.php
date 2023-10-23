<HTML>
<HEAD>
  <TITLE>読み方データ更新フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

読み方データ 更新フォーム<BR><BR>

<FORM ACTION="reading_update.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// 引数の字体と読み方を取得
$letter = $_GET[ letter ];
$reading = $_GET[ reading ];

// データベースに接続
$conn = pg_connect( "dbname=akyw9019" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// 指定された字体と読み方の情報を取得するSQLを作成
$sql = sprintf( "select letter, reading from reading where letter='%s' and reading='%s'", $letter, $reading );

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 字体が見つからなければエラーメッセージを表示
if ( pg_num_rows( $result ) == 0 )
{
	print( "指定された字体のデータが見つかりません。<BR>\n" );
	exit;
}

// 検索結果の開放
pg_free_result( $result );

// 字体と読み方を更新スクリプトに渡す
printf( "<INPUT TYPE=hidden NAME=letter1 VALUE=%s>\n", $letter );
printf( "<INPUT TYPE=hidden NAME=reading1 VALUE=%s>\n", $reading );

// データベースへの接続を解除
pg_close( $conn );

// 字体の入力フィールドを出力
print( "<BR>\n" );
print( "字体：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=letter2 VALUE=\"%s\">\n", $letter );
print( "　\n" );

// 読み方の入力フィールドを出力
print( "読み方：\n" );
printf( "<INPUT TYPE=text SIZE=12 NAME=reading2 VALUE=%s>\n", $reading );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>

<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>

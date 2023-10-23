<HTML>
<HEAD>
  <TITLE>読み方の削除フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

読み方データ 削除フォーム<BR><BR>

<FORM ACTION="reading_delete.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

$letter = $_GET[ letter ];

// データベースに接続
$conn = pg_connect( "dbname=akyw9019" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

print( "「" );
print($letter);
print("」の削除したい読み方を選択して送信ボタンを押してください。<BR><BR>" );

// SQLを作成
$sql = "select reading from reading where letter = '$letter'";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 読み方の数だけ選択肢を出力
print( "読み方：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	// 読み方と選択のためのラジオボタンを表示
	$reading = pg_fetch_result( $result, $i, 0 );
	print( "<INPUT TYPE=\"radio\" NAME=\"reading\" VALUE=\"$reading\"> $reading </INPUT>\n" );
}

// 検索結果の開放
pg_free_result( $result );

// 字体を更新スクリプトに渡す
printf( "<INPUT TYPE=hidden NAME=letter VALUE=%s>\n", $letter );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

<BR>
<A HREF="kanji_menu.html">操作メニューに戻る</A>

</CENTER>

</BODY>
</HTML>

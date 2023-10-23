<HTML>
<HEAD>
  <TITLE>読み方の削除フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

読み方データ 削除フォーム<BR><BR>

削除したい読み方を選択して送信ボタンを押してください。<BR><BR>

<FORM ACTION="reading_delete_form2.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// データベースに接続
$conn = pg_connect( "dbname=akyw9019" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// SQLを作成
$sql = "select distinct letter from reading";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 字体の数だけ選択肢を出力
print( "字体：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	// 字体と選択のためのラジオボタンを表示
	$letter = pg_fetch_result( $result, $i, 0 );
	print( "<INPUT TYPE=\"radio\" NAME=\"letter\" VALUE=\"$letter\"> $letter </INPUT>\n" );
}

// 検索結果の開放
pg_free_result( $result );

// SQLを作成
$sql = "select * from reading";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数・列数を取得
$rows = pg_num_rows( $result );

// 検索結果をテーブルとして表示
print( "<TABLE BORDER=1>\n" );

// 各列の名前を表示
print( "<TR>" );
print( "<TH>字体</TH>" );
print( "<TH>読み方</TH>" );
print( "</TR>\n" );

// 各行のデータを表示
for ( $j=0; $j<$rows; $j++ )
{
	print( "<TR>" );
	
	// 字体を表示
	$letter = pg_fetch_result( $result, $j, 0 );
	print( "<TD> $letter </TD>\n" );
	
	// 読み方を表示
	$reading = pg_fetch_result( $result, $j, 1 );
	print( "<TD> $reading </TD>" );
	
	print( "</TR>\n" );
}

// ここまででテーブル終了
print( "</TABLE>" );
print( "<BR>\n" );

// 検索件数を表示
print( "以上、$rows 個の読み方が登録されています。<BR>\n" );

// 検索結果の開放
pg_free_result( $result );

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

<HTML>
<HEAD>
  <TITLE>漢字の検索フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

<CENTER>

漢字データ 検索フォーム<BR><BR>

検索したい漢字の検定級を選択して送信ボタンを押してください。<BR><BR>

<FORM ACTION="kanji_search_result.php" METHOD="GET">

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
$sql = "select grade from kanken";

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 検索結果を選択肢として表示
for ( $i=0; $i<$rows; $i++ )
{
	// 検定級の選択のためのラジオボタンを表示
	$grade = pg_fetch_result( $result, $i, 0 );
	print( "<INPUT TYPE=\"radio\" NAME=\"grade\" VALUE=\"$grade\"> $grade </INPUT></BR>\n" );
}

// 全ての検定級の選択肢のラジオボタンを表示
print( "<INPUT TYPE=\"radio\" NAME=\"grade\" VALUE=\"ALL\" CHECKED>全ての検定級</INPUT></BR>\n" );

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

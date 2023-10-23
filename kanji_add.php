</HEAD>
<BODY>

<!-- ここからPHPのスクリプト始まり -->
<?php

// フォームから渡された引数を取得
$letter = $_GET[ letter ];
$radical = $_GET[ radical ];
$str_num = $_GET[ str_num ];
$grade = $_GET[ grade ];

// データベースに接続
$conn = pg_connect( "dbname=akyw9019" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// データ挿入のSQLを作成
$sql = sprintf( "insert into kanji( letter, radical, str_num, grade ) values( '%s', '%s', '%s', '%s' );", $letter, $radical, $str_num, $grade );

// 確認用のメッセージ表示
print( "クエリー「" );
print( $sql );
print( "」を実行します。<BR>" );

// Queryを実行して検索結果をresultに格納
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

?>
<!-- ここまででPHPのスクリプト終わり -->

データの追加処理が完了しました。<BR>
<BR>
<A HREF="kanji_menu.html">操作メニューに戻る</A>

</BODY>
</HTML>

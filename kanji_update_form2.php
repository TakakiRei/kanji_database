<HTML>
<HEAD>
  <TITLE>漢字データ更新フォーム</TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
</HEAD>
<BODY>

漢字データ 更新フォーム<BR><BR>

<FORM ACTION="kanji_update.php" METHOD="GET">

<!-- ここからPHPのスクリプト始まり -->
<?php

// 引数の字体を取得
$letter = $_GET[ letter ];

// データベースに接続
$conn = pg_connect( "dbname=akyw9019" );

// 接続が成功したかどうか確認
if ( $conn == null )
{
	print( "データベース接続処理でエラーが発生しました。<BR>" );
	exit;
}

// 指定された字体の漢字の情報を取得するSQLを作成
$sql = sprintf( "select radical, str_num, grade from kanji where letter='%s'", $letter );

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 漢字が見つからなければエラーメッセージを表示
if ( pg_num_rows( $result ) == 0 )
{
	print( "指定された字体のデータが見つかりません。<BR>\n" );
	exit;
}

// 検索結果の漢字の情報を変数に記録
$curr_radical = pg_fetch_result( $result, 0, 0 );
$curr_str_num = pg_fetch_result( $result, 0, 1 );
$curr_grade = pg_fetch_result( $result, 0, 2 );

// 検索結果の開放
pg_free_result( $result );

// 字体を更新スクリプトに渡す
printf( "<INPUT TYPE=hidden NAME=letter VALUE=%s>\n", $letter );


// 検定級一覧を取得するSQLの作成
$sql = "select grade, level from kanken";

// Queryを実行して検索結果をresultに記録
$result = pg_query( $conn, $sql );
if ( $result == null )
{
	print( "クエリー実行処理でエラーが発生しました。<BR>" );
	exit;
}

// 検索結果の行数を取得
$rows = pg_num_rows( $result );

// 検定級の数だけ選択肢を出力
print( "検定級：\n" );
for ( $i=0; $i<$rows; $i++ )
{
	$grade = pg_fetch_result( $result, $i, 0 );
	$level = pg_fetch_result( $result, $i, 1 );
	
	if ( $grade == $curr_grade )
		$checked = "CHECKED";
	else
		$checked = "";
	
	printf( "<INPUT TYPE=radio NAME=grade VALUE=%s %s> %s </INPUT>\n", $grade, $checked, $grade );
}

// 検索結果の開放
pg_free_result( $result );

// データベースへの接続を解除
pg_close( $conn );

// 部首の入力フィールドを出力
print( "<BR>\n" );
print( "部首：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=radical VALUE=\"%s\">\n", $curr_radical );
print( "　\n" );

// 画数の入力フィールドを出力
print( "画数：\n" );
printf( "<INPUT TYPE=text SIZE=4 NAME=str_num VALUE=%s>\n", $curr_str_num );

?>
<!-- ここまででPHPのスクリプト終わり -->

<BR>

<BR><BR>
<INPUT TYPE="submit" VALUE="送信"><BR>

</FORM>

</BODY>
</HTML>

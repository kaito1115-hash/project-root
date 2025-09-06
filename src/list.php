<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>保存済みレシピ一覧 - レシピ管理アプリ</title>
</head>
<body>
   <h1>保存済みレシピ一覧</h1>
   
   <?php
   // 保存成功メッセージの表示
   if (isset($_GET['saved'])) {
       echo '<p>✓ レシピ「' . htmlspecialchars($_GET['saved'], ENT_QUOTES) . '」が正常に保存されました</p>';
   }
   ?>
   
   <p><a href="index.html">新しいレシピを追加する</a></p>

   <?php
   $dsn = 'mysql:host=db;dbname=recipe_db;charset=utf8';
   $user = 'root';
   $pass = 'example';
   
   try {
       $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
       $sql = 'SELECT * FROM recipes ORDER BY created_at DESC';
       $stmt = $pdo->query($sql);
       $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
       if (count($result) > 0) {
           echo '<table border="1">';
           echo '<tr>';
           echo '<th>ID</th><th>料理名</th><th>カテゴリ</th><th>難易度</th><th>予算</th><th>作り方</th><th>登録日時</th>';
           echo '</tr>';
           
           foreach ($result as $row) {
               echo '<tr>';
               echo '<td>' . htmlspecialchars($row['id'], ENT_QUOTES) . '</td>';
               echo '<td>' . htmlspecialchars($row['recipe_name'], ENT_QUOTES) . '</td>';
               
               $category_text = match ($row['category']) {
                   1 => '和食',
                   2 => '洋食',
                   3 => '中華',
                   default => '未設定'
               };
               echo '<td>' . $category_text . '</td>';
               
               $difficulty_text = match ($row['difficulty']) {
                   1 => '簡単',
                   2 => '普通',
                   3 => '難しい',
                   default => '未設定'
               };
               echo '<td>' . $difficulty_text . '</td>';
               echo '<td>' . number_format($row['budget']) . '円</td>';
               echo '<td>' . nl2br(htmlspecialchars($row['howto'], ENT_QUOTES)) . '</td>';
               echo '<td>' . date('Y-m-d H:i:s', strtotime($row['created_at'])) . '</td>';
               echo '</tr>';
           }
           echo '</table>';
           
           echo '<p>総レシピ数: ' . count($result) . '件</p>';
       } else {
           echo '<p>保存されているレシピはありません。</p>';
           echo '<p><a href="index.html">最初のレシピを追加してみましょう</a></p>';
       }
       
   } catch (PDOException $e) {
       // エラーが発生した場合は何も表示しない
   }
   ?>

</body>
</html>
<?php
// レシピ保存専用処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dsn = 'mysql:host=db;dbname=recipe_db;charset=utf8';
    $user = 'root';
    $pass = 'example';
    
    try {
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        
        $recipe_name = $_POST['recipe_name'] ?? '';
        $category = $_POST['category'] ?? '';
        $difficulty = $_POST['difficulty'] ?? 2;
        $budget = $_POST['budget'] ?? 0;
        $howto = $_POST['howto'] ?? '';
        
        $sql = "INSERT INTO recipes (recipe_name, category, difficulty, budget, howto) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$recipe_name, $category, $difficulty, $budget, $howto]);
        
        // 保存成功後、レシピ一覧ページにリダイレクト
        header("Location: ../list.php?saved=" . urlencode($recipe_name));
        exit;
        
    } catch (PDOException $e) {
        // エラー時もレシピ一覧ページにリダイレクト
        header("Location: ../list.php");
        exit;
    }
} else {
    // GETアクセス時は新規レシピ追加ページにリダイレクト
    header("Location: ../index.html");
    exit;
}
?>
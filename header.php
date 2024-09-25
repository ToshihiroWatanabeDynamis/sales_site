<?php require_once 'session_manager.php'; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="CDshop">
		<title>CDshop</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="styles.css">
		<link rel="stylesheet" href="about_item.css">
</head>

<header class="site-header">

		<div class="logo">
				<a href="index.php"><h1>CDshop</h1></a>
		</div>

		<div class="search-options">
				<form method="GET" action="search_result.php" class="search-form">
						<select id="genre-filter" name="genre">
								<option value="">すべてのジャンル</option>
								<option value="Rock">Rock</option>
								<option value="Metal">Metal</option>
								<option value="Rap">Rap</option>
								<option value="Folk/Country">Folk/Country</option>
								<option value="Electronic">Electronic</option>
								<option value="Jazz">Jazz</option>
								<option value="POP/R&B">POP/R&B</option>
						</select>
						<select id="sort-by" name="sort-by">
								<option value="average_rating DESC">並び替え</option>
								<option value="release_date DESC">発売日が新しい順</option>
								<option value="release_date ASC">発売日が古い順</option>
								<option value="average_rating DESC">評価が高い順</option>
								<option value="average_rating ASC">評価が低い順</option>
						</select>
						<input type="text" id="search-bar" name="search-term" placeholder="商品を検索...">
						<input type="submit" value="検索">
				</form>
		</div>

		<nav class="main-nav">
				<ul>
						<?= isLoggedIn() ?
						'<li><a href="dashboard.php">ダッシュボード</a></li>' :
						'<li><a href="login.php">ログイン</a></li>' ?>
						<li><a href="wishlist.php">ほしい物リスト</a></li>
						<li><a href="cart.php">カート</a></li>
				</ul>
		</nav>

</header>

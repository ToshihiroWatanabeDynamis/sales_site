<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="CDshop">
		<title>CDshop</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="styles.css">
</head>

<body>
		<header class="site-header">

				<div class="logo">
						<h1>CDshop</h1>
				</div>

				<div class="filter-options">
						<select id="category-filter">
								<option value="all">すべてのジャンル</option>
								<option value="rock">ROCK</option>
								<option value="metal">METAL</option>
								<option value="rap">RAP</option>
								<option value="fork/country">FORK/COUNTRY</option>
								<option value="electronic">ELECTRONIC</option>
								<option value="jazz">JAZZ</option>
								<option value="pop/r&b">POP/R&B</option>
						</select>
						<select id="price-filter">
								<option value="all">すべての価格帯</option>
								<option value="low">¥1,000以下</option>
								<option value="medium">¥1,000〜¥3,000</option>
								<option value="high">¥3,000以上</option>
						</select>
						<input type="text" id="search-bar" placeholder="商品を検索...">
						<button onclick="applyFilters()">検索</button>
				</div>

				<nav class="main-nav">
						<ul>
								<li><a href="#">ログイン</a></li>
								<li><a href="#">欲しいものリスト</a></li>
								<li><a href="#">カート</a></li>
						</ul>
				</nav>

		</header>

		<main class="content">

				<section class="hero">
						<div class="hero-content">
								<h2>Best Albums of All Time</h2>
						</div>
				</section>

				<section class="album-grid">
						<?php
						$albums = [
								["title" => "Revolver", "artist" => "The Beatles", "genre" => "Pop Rock, Psychedelic Pop", "image" => "img/Revolver 1.jpg"],
								["title" => "Rumours", "artist" => "Fleetwood Mac", "genre" => "Pop Rock, Soft Rock", "image" => "img/Rumours 1.webp"],
								["title" => "Highway 61 Revisited" , "artist" => "Bob Dylan", "genre" => "Folk Rock, Singer-Songwriter", "image" => "img/Highway 61 Revisited.webp"],
								["title" => "The Rise and Fall of Ziggy Stardust and the Spiders from Mars", "artist" => "David Bowie", "genre" => "Glam Rock, Pop Rock", "image" => "img/Ziggy Stardust Rise Fall.webp"],
								["title" => "Led Zeppelin IV", "artist" => "Led Zeppelin", "genre" => "Hard Rock", "image" => "img/Led Zeppelin IV.jpg"],
								["title" => "Doolittle", "artist" => "Pixies", "genre" => "Indie Rock, Alternative Rock", "image" => "img/Doolittle 1.webp"],
								["title" => "Rubber Soul", "artist" => "The Beatles", "genre" => "Pop Rock", "image" => "img/rubber-soul-1.webp"],
								["title" => "Abbey Road", "artist" => "The Beatles", "genre" => "Pop Rock", "image" => "img/Abbey Road 1.jpg"],
								["title" => "Graceland", "artist" => "Paul Simon", "genre" => "Pop Rock, Singer-Songwriter", "image" => "img/6511-graceland-1.webp"],
								["title" => "Songs of Leonard Cohen", "artist" => "Leonard Cohen", "genre" => "Contemporary Folk, Singer-Songwriter", "image" => "img/6079-songs-of-leonard-cohen-1.webp"],
						];
						foreach ($albums as $album) {
								echo "<article class='album-item'>";
								echo "<img src='{$album['image']}' alt='{$album['title']}'>";
								echo "<div class='album-info'>";
								echo "<h3>{$album['title']}</h3>";
								echo "<p>{$album['artist']}</p>";
								echo "<p>{$album['genre']}</p>";
								echo "</div>";
								echo "</article>";
						}
						?>
				</section>

		</main>

		<footer class="site-footer">
				<div class="footer-inner">
						<p>&copy; 2024 CDshop. All rights reserved.</p>
				</div>
		</footer>

</body>
</html>


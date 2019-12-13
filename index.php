<!DOCTYPE html>
<html>
	<head>
		<title>ブックマーク変換ツール</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	</head>
	<body>
		<div class="container">
			<header>
				<h1 style="padding: 10px 0;">ブックマーク変換ツール</h1>
				<p>
					このサイトではChromeのブックマークをJSON形式のデータに変換することが出来ます。<br>
					<a href="http://mizukazu.com/bookmark-management/">ブックマーク管理システム</a>で使用します。
				</p>
			</header>
			<hr>
			<div class="row">
				<div class="col-lg-6">
					<form action="php/main.php" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="customFile" name='file' required>
								<label class="custom-file-label" for="customFile">ファイルを選択</label>
							</div>
							<input class="btn btn-primary mt-2" type="submit">
							<?php
							if(isset($_GET['error'])) {
								echo '<h2 class="mt-3">エラー</h2>';
								echo '<p class="text-danger" style="font-weight: 700;">';
								echo '※'.$_GET['error'];
								echo '</p>';
							}
							?>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
		<script src="js/index.js"></script>
	</body>
</html>
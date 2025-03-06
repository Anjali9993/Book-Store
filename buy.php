<?php
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-buybook.php";
$buybooks = get_all_buybooks($conn);

# author helper function
include "php/func-buyauthor.php";
$buyauthors = get_all_buyauthor($conn);

# Category helper function
include "php/func-buycategory.php";
$buycategories = get_all_buycategories($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Buy</title>

	<!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

	<!-- bootstrap 5 Js bundle CDN-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
		</script>

	<script>
		var imageIndex = 0;
		var Images = ["img/ban1.jpg",
			"img/bani2.jpg",
			"img/ban3.png",
			"img/bani4.jpg",
			"img/ban5.webp"
		]
		nextImage(1);
		function nextImage(no = 1) {
			var curImage = document.getElementById("banImage");
			if (no == 1 && imageIndex == 4)
				imageIndex = 0;
			else if (no == -1 && imageIndex == 0)
				imageIndex = 4;
			else
				imageIndex = imageIndex + no;

			curImage.src = Images[imageIndex];
			setTimeout(nextImage, 2000);

		}
	</script>

	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/styles.css">

</head>

<body>

	<div class="container">
		<section id="home">
			<div id="logo">
				<img src="img/logo.png" alt="bce">
			</div>
			<div>
				<h1 class="h-primary" id="heading"><u>PUSTAKALAYA</u></h1>
			</div>
			<div id="logo">
				<a href="index.html" target=”_blank”><img src="img/profile.png" alt="Profile"></a>
			</div>
		</section>
		<hr />

		<nav class="navbar navBar navbar-expand-lg navbar-light bg-light" id="navbars">
			<div class="container-fluid">
				<a class="navbar-brand" href="index.php">Online Book Store</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
					data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
					aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="index.php">Store</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="about.php">About us</a>
						</li>
						
						<li class="nav-item">
							<?php if (isset($_SESSION['user_id'])) { ?>
								<a class="nav-link" href="buyadmin.php">Buy-Admin</a>
							<?php } else { ?>
								<a class="nav-link" href="login.php">Admin-login</a>
							<?php } ?>

						</li>
					</ul>
				</div>
			</div>
		</nav>
		<hr />

		<!-- Banner -->
		<div class="banSection">
			<img src="img/bani3.jpg" id="banImage" />
			<img onclick="nextImage(1);" class="arrowBtn" style="left:9%;top:80%" src="img/left-arrow.png" />
			<img onclick="nextImage(1);" class="arrowBtn" style="right: 9%;top:80%" src="img/right-arrow.png" />
		</div>
		<hr />

		<form action="buysearch.php" method="get" style="width: 100%; max-width: 30rem">

			<div class="input-group my-4" id="search">
				<input type="text" class="form-control" name="key" placeholder="Search Book..."
					aria-label="Search Book..." aria-describedby="basic-addon2">

				<button class="input-group-text
						 btn btn-primary" id="basic-addon2">
					<img src="img/buysearch.png" width="20">

				</button>
			</div>
		</form>
		<div class="d-flex pt-3">
			<?php if ($buybooks == 0) { ?>
				<div class="alert alert-warning 
						text-center p-5" role="alert">
					<img src="img/empty.png" width="100">
					<br>
					There is no book in the database
				</div>
			<?php } else { ?>
				<div class="pdf-list d-flex flex-wrap">
					<?php foreach ($buybooks as $buybook) { ?>
						<div class="card m-1">
							<img src="uploads/buycover/<?= $buybook['buycover'] ?>" class="card-img-top">
							<div class="card-body">
								<h5 class="card-title">
									<?= $buybook['buytitle'] ?>
								</h5>
								<p class="card-text">
									<i><b>By:
											<?php foreach ($buyauthors as $buyauthor) {
												if ($buyauthor['id'] == $buybook['buyauthor_id']) {
													echo $buyauthor['name'];
													break;
												}
												?>

											<?php } ?>
											<br>
										</b></i>
									<?= $buybook['buydescription'] ?>
									<br><i><b>Category:
											<?php foreach ($buycategories as $buycategory) {
												if ($buycategory['id'] == $buybook['buycategory_id']) {
													echo $buycategory['name'];
													break;
												}
												?>

											<?php } ?>
											<br>
										</b></i>
								</p>
								<a href="uploads/buycover/<?= $buybook['buycover'] ?>" class="btn btn-success">Open</a>

								<a href="<?= $buybook['link'] ?>" class="btn btn-primary">Buy</a>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>

			<div class="category">
				<!-- List of categories -->
				<div class="list-group">
					<?php if ($buycategories == 0) {
					// do nothing
				} else { ?>
						<a href="#" class="list-group-item list-group-item-action active">Buy-Category</a>
						<?php foreach ($buycategories as $buycategory) { ?>

							<a href="buycategory.php?id=<?= $buycategory['id'] ?>" class="list-group-item list-group-item-action">
								<?= $buycategory['name'] ?>
							</a>
						<?php }
				} ?>
				</div>

				<!-- List of authors -->
				<div class="list-group mt-5">
					<?php if ($buyauthors == 0) {
					// do nothing
				} else { ?>
						<a href="#" class="list-group-item list-group-item-action active">Buy-Author</a>
						<?php foreach ($buyauthors as $buyauthor) { ?>

							<a href="buyauthor.php?id=<?= $buyauthor['id'] ?>" class="list-group-item list-group-item-action">
								<?= $buyauthor['name'] ?>
							</a>
						<?php }
				} ?>
				</div>
			</div>
		</div>

		<br />
		<footer>
			<div class="center">
				| Copyright © www.pustakalaya.com All rights reserved|
			</div>
		</footer>

	</div>
</body>

</html>
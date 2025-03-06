<?php
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Book Store</title>

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
							<a class="nav-link" href="#contact">Contact us</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="about.php">About us</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="buy.php">Buy</a>
						</li>
						<li class="nav-item">
							<?php if (isset($_SESSION['user_id'])) { ?>
								<a class="nav-link" href="admin.php">Admin</a>
							<?php } else { ?>
								<a class="nav-link" href="login.php">Login</a>
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

		<form action="search.php" method="get" style="width: 100%; max-width: 30rem">

			<div class="input-group my-4" id="search">
				<input type="text" class="form-control" name="key" placeholder="Search Book..."
					aria-label="Search Book..." aria-describedby="basic-addon2">

				<button class="input-group-text
						 btn btn-primary" id="basic-addon2">
					<img src="img/search.png" width="20">

				</button>
			</div>
		</form>
		<div class="d-flex pt-3">
			<?php if ($books == 0) { ?>
				<div class="alert alert-warning 
						text-center p-5" role="alert">
					<img src="img/empty.png" width="100">
					<br>
					There is no book in the database
				</div>
			<?php } else { ?>
				<div class="pdf-list d-flex flex-wrap">
					<?php foreach ($books as $book) { ?>
						<div class="card m-1">
							<img src="uploads/cover/<?= $book['cover'] ?>" class="card-img-top">
							<div class="card-body">
								<h5 class="card-title">
									<?= $book['title'] ?>
								</h5>
								<p class="card-text">
									<i><b>By:
											<?php foreach ($authors as $author) {
												if ($author['id'] == $book['author_id']) {
													echo $author['name'];
													break;
												}
												?>

											<?php } ?>
											<br>
										</b></i>
									<?= $book['description'] ?>
									<br><i><b>Category:
											<?php foreach ($categories as $category) {
												if ($category['id'] == $book['category_id']) {
													echo $category['name'];
													break;
												}
												?>

											<?php } ?>
											<br>
										</b></i>
								</p>
								<a href="uploads/files/<?= $book['file'] ?>" class="btn btn-success">Open</a>

								<a href="uploads/files/<?= $book['file'] ?>" class="btn btn-primary"
									download="<?= $book['title'] ?>">Download</a>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } ?>

			<div class="category">
				<!-- List of categories -->
				<div class="list-group">
					<?php if ($categories == 0) {
					// do nothing
				} else { ?>
						<a href="#" class="list-group-item list-group-item-action active">Category</a>
						<?php foreach ($categories as $category) { ?>

							<a href="category.php?id=<?= $category['id'] ?>" class="list-group-item list-group-item-action">
								<?= $category['name'] ?>
							</a>
						<?php }
				} ?>
				</div>

				<!-- List of authors -->
				<div class="list-group mt-5">
					<?php if ($authors == 0) {
					// do nothing
				} else { ?>
						<a href="#" class="list-group-item list-group-item-action active">Author</a>
						<?php foreach ($authors as $author) { ?>

							<a href="author.php?id=<?= $author['id'] ?>" class="list-group-item list-group-item-action">
								<?= $author['name'] ?>
							</a>
						<?php }
				} ?>
				</div>
			</div>
		</div>

		<br />

		<section id="contact" style="background: url('img/3.jpg') no-repeat center center/cover;">
			<h1 class=" h-primary center"><u>Contact Us</u></h1>
			<div id="contact-box">
				<form>
					<div class="form-group">
						<label for="name">Name : </label>
						<input type="text" name="name" id="name" placeholder="Enter your name">
					</div>
					<div class="form-group">
						<label for="email">Email : </label>
						<input type="email" name="name" id="email" placeholder="Enter your Email Id">
					</div>
					<div class="form-group">
						<label for="password">Password : </label>
						<input type="password" name="name" id="password" placeholder="Enter your password">
					</div>
					<div class="form-group">
						<label for="phone">Phone : </label>
						<input type="phone" name="name" id="phone" placeholder="Enter your Phone number">
					</div>
					<div class="form-group">
						<label for="address">Address : </label>
						<input type="address" name="name" id="address" placeholder="Enter your Home address">
					</div>
					<div class="form-group v">
						<label for="feedback">Feedback : </label>
						<textarea name="Feedback" id="feedback" placeholder="Please give your Valuable feedback"
							rows="5"></textarea>
					</div>
					<div class="form-group v">
						<button onclick="loginmessage()" class="btn1">Submit</button>
					</div>

				</form>
			</div>
		</section>

		<section class="client-section" style="background: url('img/image.jpg') no-repeat center center/cover;">
			<h1 class="h-primary center"><u>Our Connections</u></h1>
			<div id="clients">
				<div class="client-items">
					<a href="https://www.amazon.in/kindle-dbs/storefront?storeType=browse&node=1634753031"
						target="_blank"><img src="img/amazon1.webp" alt="our clients"></a>
				</div>
				<div class="client-items">
					<a href="https://www.flipkart.com/" target="_blank"><img src="img/flipkart2.png"
							alt="our clients"></a>
				</div>
				<div class="client-items">
					<a href="https://www.abebooks.com/" target="_blank"><img src="img/abebook.png"
							alt="our clients"></a>
				</div>
				<div class="client-items">
					<a href="https://www.snapdeal.com/products/books" target="_blank"><img src="img/snapdeal.png"
							alt="our clients"></a>
				</div>
			</div>
		</section>
		<footer>
			<div class="center">
				| Copyright © www.pustakalaya.com All rights reserved|
			</div>
		</footer>

	</div>
</body>

</html>
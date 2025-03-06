<?php
session_start();

# If the admin is logged in
if (
	isset($_SESSION['user_id']) &&
	isset($_SESSION['user_email'])
) {

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
		<title>BUY-ADMIN</title>

		<!-- bootstrap 5 CDN-->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
			integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

		<!-- bootstrap 5 Js bundle CDN-->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
			crossorigin="anonymous"></script>
		<link rel="stylesheet" href="css/style.css">

	</head>

	<body>
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="container-fluid">
					<a class="navbar-brand" href="buyadmin.php">Buy-Admin</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
						data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
						aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<li class="nav-item">
								<a class="nav-link" aria-current="page" href="buy.php">Store</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="add-buybook.php" target="_blank">Add-Book</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="add-buycategory.php"target="_blank">Add-Category</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="add-buyauthor.php"target="_blank">Add-Author</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="logout.php">Logout</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<form action="buysearch.php" method="get" style="width: 100%; max-width: 30rem">

				<div class="input-group my-5">
					<input type="text" class="form-control" name="key" placeholder="Search Book..."
						aria-label="Search Book..." aria-describedby="basic-addon2">

					<button class="input-group-text
						 btn btn-primary" id="basic-addon2">
						<img src="img/search.png" width="20">

					</button>
				</div>
			</form>
			<div class="mt-5"></div>
			<?php if (isset($_GET['error'])) { ?>
				<div class="alert alert-danger" role="alert">
					<?= htmlspecialchars($_GET['error']); ?>
				</div>
			<?php } ?>
			<?php if (isset($_GET['success'])) { ?>
				<div class="alert alert-success" role="alert">
					<?= htmlspecialchars($_GET['success']); ?>
				</div>
			<?php } ?>


			<?php if ($buybooks == 0) { ?>
				<div class="alert alert-warning 
						text-center p-5" role="alert">
					<img src="img/empty.png" width="100">
					<br>
					There is no book in the database
				</div>
			<?php } else { ?>


				<!-- List of all buybooks -->
				<h4>All Books</h4>
				<table class="table table-bordered shadow">
					<thead>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th>Author</th>
							<th>Description</th>
							<th>Category</th>
							<th>Purchase Link</th>
							<th>Action</th>	
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 0;
						foreach ($buybooks as $buybook) {
							$i++;
							?>
							<tr>
								<td>
									<?= $i ?>
								</td>
								<td>
									<img width="100" src="uploads/buycover/<?= $buybook['buycover'] ?>">
									<a class="link-dark d-blocktext-center" 
									href="uploads/link/<?= $buybook['link'] ?>"> 
										<?= $buybook['buytitle'] ?>
									</a>

								</td>
								<td>
									<?php if ($buyauthors == 0) {
										echo "Undefined";
									} else {

										foreach ($buyauthors as $buyauthor) {
											if ($buyauthor['id'] == $buybook['buyauthor_id']) {
												echo $buyauthor['name'];
											}
										}
									}
									?>

								</td>
								<td>
									<?= $buybook['buydescription'] ?>
								</td>
								<td>
									<?php if ($buycategories == 0) {
										echo "Undefined";
									} else {

										foreach ($buycategories as $buycategory) {
											if ($buycategory['id'] == $buybook['buycategory_id']) {
												echo $buycategory['name'];
											}
										}
									}
									?>
								</td>
								
								<td>
									<?= $buybook['link'] ?>
								</td>
								<td>
									<a href="edit-buybook.php?id=<?= $buybook['id'] ?>" class="btn btn-warning">
										Edit</a>

									<a href="php/delete-buybook.php?id=<?= $buybook['id'] ?>" class="btn btn-danger">
										Delete</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>

			<?php if ($buycategories == 0) { ?>
				<div class="alert alert-warning 
						text-center p-5" role="alert">
					<img src="img/empty.png" width="100">
					<br>
					There is no category in the database
				</div>
			<?php } else { ?>
				<!-- List of all categories -->
				<h4 class="mt-5">All Categories</h4>
				<table class="table table-bordered shadow">
					<thead>
						<tr>
							<th>#</th>
							<th>Category Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$j = 0;
						foreach ($buycategories as $buycategory) {
							$j++;
							?>
							<tr>
								<td>
									<?= $j ?>
								</td>
								<td>
									<?= $buycategory['name'] ?>
								</td>
								<td>
									<a href="edit-buycategory.php?id=<?= $buycategory['id'] ?>" class="btn btn-warning">
										Edit</a>

									<a href="php/delete-buycategory.php?id=<?= $buycategory['id'] ?>" class="btn btn-danger">
										Delete</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>

			<?php if ($buyauthors == 0) { ?>
				<div class="alert alert-warning 
						text-center p-5" role="alert">
					<img src="img/empty.png" width="100">
					<br>
					There is no author in the database
				</div>
			<?php } else { ?>
				<!-- List of all Authors -->
				<h4 class="mt-5">All Authors</h4>
				<table class="table table-bordered shadow">
					<thead>
						<tr>
							<th>#</th>
							<th>Author Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$k = 0;
						foreach ($buyauthors as $buyauthor) {
							$k++;
							?>
							<tr>
								<td>
									<?= $k ?>
								</td>
								<td>
									<?= $buyauthor['name'] ?>
								</td>
								<td>
									<a href="edit-buyauthor.php?id=<?= $buyauthor['id'] ?>" class="btn btn-warning">
										Edit</a>

									<a href="php/delete-buyauthor.php?id=<?= $buyauthor['id'] ?>" class="btn btn-danger">
										Delete</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</body>

	</html>

<?php } else {
	header("Location: login.php");
	exit;
} ?>
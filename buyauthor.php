<?php 
session_start();

# If not author ID is set
if (!isset($_GET['id'])) {
	header("Location: index.php");
	exit;
}

# Get author ID from GET request
$id = $_GET['id'];

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-buybook.php";
$buybooks = get_buybooks_by_buyauthor($conn, $id);

# author helper function
include "php/func-buyauthor.php";
$buyauthors = get_all_buyauthor($conn);
$buycurrent_author = get_buyauthor($conn, $id);


# Category helper function
include "php/func-buycategory.php";
$buycategories = get_all_buycategories($conn);


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$buycurrent_author['name']?></title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="index.php">Online Book Store</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link active" 
		             aria-current="page" 
		             href="buy.php">Store</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="contact.php">Contact</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="about.php">About</a>
		        </li>
		        <li class="nav-item">
		          <?php if (isset($_SESSION['user_id'])) {?>
		          	<a class="nav-link" 
		             href="buyadmin.php">Buy-Admin</a>
		          <?php }else{ ?>
		          <a class="nav-link" 
		             href="login.php">Login</a>
		          <?php } ?>

		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
		<h1 class="display-4 p-3 fs-3"> 
			<a href="buy.php"
			   class="nd">
				<img src="img/back-arrow.PNG" 
				     width="35">
			</a>
		   <?=$buycurrent_author['name']?>
		</h1>
		<div class="d-flex pt-3">
			<?php if ($buybooks == 0){ ?>
				<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/empty.png" 
        	          width="100">
        	     <br>
			    There is no book in the database
		       </div>
			<?php }else{ ?>
			<div class="pdf-list d-flex flex-wrap">
				<?php foreach ($buybooks as $buybook) { ?>
				<div class="card m-1">
					<img src="uploads/buycover/<?=$buybook['buycover']?>"
					     class="card-img-top">
					<div class="card-body">
						<h5 class="card-title">
							<?=$buybook['buytitle']?>
						</h5>
						<p class="card-text">
							<i><b>By:
								<?php foreach($buyauthors as $buyauthor){ 
									if ($buyauthor['id'] == $buybook['buyauthor_id']) {
										echo $buyauthor['name'];
										break;
									}
								?>

								<?php } ?>
							<br></b></i>
							<?=$buybook['buydescription']?>
							<br><i><b>Category:
								<?php foreach($buycategories as $buycategory){ 
									if ($buycategory['id'] == $buybook['buycategory_id']) {
										echo $buycategory['name'];
										break;
									}
								?>

								<?php } ?>
							<br></b></i>
						</p>
                       <a href="uploads/buycover/<?=$buybook['buycover']?>"
                          class="btn btn-success">Open</a>

                        <a href="uploads/link/<?=$buybook['link']?>"
                          class="btn btn-primary">Buy</a>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php } ?>

		<div class="category">
			<!-- List of categories -->
			<div class="list-group">
				<?php if ($buycategories == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Category</a>
				   <?php foreach ($buycategories as $buycategory ) {?>
				  
				   <a href="buycategory.php?id=<?=$buycategory['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$buycategory['name']?></a>
				<?php } } ?>
			</div>

			<!-- List of authors -->
			<div class="list-group mt-5">
				<?php if ($buyauthors == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Author</a>
				   <?php foreach ($buyauthors as $buyauthor ) {?>
				  
				   <a href="buyauthor.php?id=<?=$buyauthor['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$buyauthor['name']?></a>
				<?php } } ?>
			</div>
		</div>
		</div>
	</div>
</body>
</html>
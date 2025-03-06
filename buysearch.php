<?php 
session_start();

# If search key is not set or empty
if (!isset($_GET['key']) || empty($_GET['key'])) {
	header("Location: buy.php");
	exit;
}
$key = $_GET['key'];

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-buybook.php";
$buybooks = search_buybooks($conn, $key);

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
	<title>Buy Book Store</title>

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
		             href="about.php">About us</a>
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
		</nav><br>
		Search result for <b><?=$key?></b>

		<div class="d-flex pt-3">
			<?php if ($buybooks == 0){ ?>
				<div class="alert alert-warning 
        	            text-center p-5 pdf-list" 
        	     role="alert">
        	     <img src="img/empty-search.png" 
        	          width="100">
        	     <br>
				  The key <b>"<?=$key?>"</b> didn't match to any record
		           in the database
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

                        <a href="<?=$buybook['link']?>"
                          class="btn btn-primary">Buy</a>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php } ?>
		</div>
	</div>
</body>
</html>
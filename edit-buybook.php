<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# If book ID is not set
	if (!isset($_GET['id'])) {
		#Redirect to admin.php page
        header("Location: buyadmin.php");
        exit;
	}

	$id = $_GET['id'];

	# Database Connection File
	include "db_conn.php";

	# Book helper function
	include "php/func-buybook.php";
    $buybook = get_buybook($conn, $id);
    
    # If the ID is invalid
    if ($buybook == 0) {
    	#Redirect to admin.php page
        header("Location: buyadmin.php");
        exit;
    }

    # Category helper function
	include "php/func-buycategory.php";
    $buycategories = get_all_buycategories($conn);

    # author helper function
	include "php/func-buyauthor.php";
    $buyauthors = get_all_buyauthor($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit buy Book</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</head>
<body>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="buyadmin.php">Buy-Admin</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link" 
		             aria-current="page" 
		             href="buy.php">Store</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-buybook.php" target="_blank">Add-Book</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-buycategory.php"target="_blank">Add-Category</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-buyauthor.php"target="_blank">Add-Author</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="logout.php">Logout</a>
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
     <form action="php/edit-buybook.php"
           method="post"
           enctype="multipart/form-data" 
           class="shadow p-4 rounded mt-5"
           style="width: 90%; max-width: 50rem;">

     	<h1 class="text-center pb-5 display-4 fs-3">
     		Edit Book
     	</h1>
     	<?php if (isset($_GET['error'])) { ?>
          <div class="alert alert-danger" role="alert">
			  <?=htmlspecialchars($_GET['error']); ?>
		  </div>
		<?php } ?>
		<?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
			  <?=htmlspecialchars($_GET['success']); ?>
		  </div>
		<?php } ?>
     	<div class="mb-3">
		    <label class="form-label">
		           Book Title
		           </label>
		    <input type="text" 
		           hidden
		           value="<?=$buybook['id']?>" 
		           name="buybook_id">

		    <input type="text" 
		           class="form-control"
		           value="<?=$buybook['buytitle']?>" 
		           name="buybook_title">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Description
		           </label>
		    <input type="text" 
		           class="form-control" 
		           value="<?=$buybook['buydescription']?>"
		           name="buybook_description">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Author
		           </label>
		    <select name="buybook_author"
		            class="form-control">
		    	    <option value="0">
		    	    	Select author
		    	    </option>
		    	    <?php 
                    if ($buyauthors == 0) {
                    	# Do nothing!
                    }else{
		    	    foreach ($buyauthors as $buyauthor) { 
		    	    	if ($buybook['buyauthor_id'] == $buyauthor['id']) { ?>
		    	    	<option 
		    	    	  selected
		    	    	  value="<?=$buyauthor['id']?>">
		    	    	  <?=$buyauthor['name']?>
		    	        </option>
		    	        <?php }else{ ?>
						<option 
							value="<?=$buyauthor['id']?>">
							<?=$buyauthor['name']?>
						</option>
		    	   <?php }} } ?>
		    </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Category
		           </label>
		    <select name="buybook_category"
		            class="form-control">
		    	    <option value="0">
		    	    	Select category
		    	    </option>
		    	    <?php 
                    if ($buycategories == 0) {
                    	# Do nothing!
                    }else{
		    	    foreach ($buycategories as $buycategory) { 
		    	    	if ($buybook['buycategory_id'] == $buycategory['id']) { ?>
		    	    	<option 
		    	    	  selected
		    	    	  value="<?=$buycategory['id']?>">
		    	    	  <?=$buycategory['name']?>
		    	        </option>
		    	        <?php }else{ ?>
						<option 
							value="<?=$buycategory['id']?>">
							<?=$buycategory['name']?>
						</option>
		    	   <?php }} } ?>
		    </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Book Cover
		           </label>
		    <input type="file" 
		           class="form-control" 
		           name="buybook_cover">

		     <input type="text" 
		           hidden
		           value="<?=$buybook['buycover']?>" 
		           name="buycurrent_cover">

		    <a href="uploads/buycover/<?=$buybook['buycover']?>"
		       class="link-dark">Current Cover</a>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           Purchase link
		           </label>
		    <input type="url" 
		           class="form-control" 
		           name="link">

		     <input type="text" 
		           hidden
		           value="<?=$buybook['link']?>" 
		           name="buycurrent_link">

		    <a href="<?=$buybook['link']?>" target="_blank"
		       class="link-dark">Current link</a>
		</div>

	    <button type="submit" 
	            class="btn btn-primary">
	            Update</button>
     </form>
	</div>
</body>
</html>

<?php }else{
  header("Location: login.php");
  exit;
} ?>
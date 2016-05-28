<?php
	require_once 'functions.php';
	session_start();

	$getPosts = $database->prepare('SELECT posts.*, users.username, users.profilePicture FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE user_id IN (SELECT followed FROM follows WHERE follower = :userid) OR user_id = :userid2 ORDER BY date DESC');
	$success = $getPosts->execute([
				':userid' => $_SESSION['user']['id'],
				':userid2' => $_SESSION['user']['id']
				]);

	if($success){
		$posts = $getPosts->fetchAll(PDO::FETCH_ASSOC);
		//var_dump($posts);
		//echo '<br><br>'	;
		//var_dump($_SESSION);		
	}
	else {
		echo 'NO POST!';
	}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Instagram</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<header>
		<div class="myHeader">
			<ul>
				<img src="images/logo.png">
			</ul>
		</div>
	</header>
	<section>
		<div class="middle">
		<?php
			foreach ($posts as $value) {
		?>
			<div class="post">
				<div class="post_header">
					<img src="<?php 
						if($value['profilePicture'] == "") {
							echo 'images/egg.png';
						}else {
							echo '/uploads/' . $value['profilePicture'];
						} ?>">
					<div class="post_user"> <a href="<?php echo 'userProfile.php?user_id='.$value['user_id']; ?>"><?php echo $value['username']; ?></a> </div>
					<div class="post_date"> <?php echo $value['date']; ?> </div>
				</div>
				<img src="/uploads/<?php echo $value['image'] ?> ">
				<div class="likes">
							<a href="<?php echo 'feed.php?post_id=' . $value['id']; ?>">Like</a>
				</div>

				<div class="description"> <?php echo $value['description']; ?> </div>
				<?php
			}
		?>
			</div>
	</section>
	<footer>
		
	</footer>

	<script type="text/javascript">
		function myFunction(){

		}
	</script>

</body>
</html>
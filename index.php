<link href="../css/Style.css" rel="stylesheet">
 <link href="../css/all.css" rel="stylesheet">

<?php 
session_start();
require_once('includes/connect.php');
include('includes/header.php');
include('includes/navigation.php'); 

// get number of per page results from settings table
$rppsql = "SELECT * FROM settings WHERE name='resultsperpage'";
$rppresult = $db->prepare($rppsql);
$rppresult->execute();
$rpp = $rppresult->fetch(PDO::FETCH_ASSOC);
$perpage = $rpp['value'];

if(isset($_GET['page']) & !empty($_GET['page'])){
  $curpage = $_GET['page'];
}else{
  $curpage = 1;
}
// get the number of total posts from posts table
$sql = "SELECT * FROM posts WHERE status='published'";
$result = $db->prepare($sql);
$result->execute();
$totalres = $result->rowCount();
// create startpage, nextpage, endpage variables with values
$endpage = ceil($totalres/$perpage);
$startpage = 1;
$nextpage = $curpage + 1;
$previouspage = $curpage - 1;
$start = ($curpage * $perpage) - $perpage;


// fetch the results
$sql = "SELECT * FROM posts WHERE status='published' and header='toppost' and news='football' ORDER BY created DESC LIMIT $start, $perpage";
$result = $db->prepare($sql);
$result->execute();
$posts = $result->fetchAll(PDO::FETCH_ASSOC);
// add the pagination links
?>
<!-- Page Content -->
<div class="container">

  <div class="row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">

      <h1 class="my-4">Top Post</h1>
      <?php
        foreach ($posts as $post) {
      ?>
<!-------------------------- Blog PART ---------------------------------------------------------------------------->
         
          <div class="card mb-4">              <!-----DIVISION FOR THE MAIN BODY---------------------------->
          
            
            
<!-------------------------- Blog PIC PART ---------------------------------------------------------------------------->         
            <?php if(isset($post['pic']) & !empty($post['pic']))
            {?>

              <img class="card-img-top" src="<?php echo $post['pic']; ?>" alt="Card image cap">
            
            <?php }else{  ?>

              <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">

            <?php } ?>


 <!----------------------------------BODY POST-------------------------------------------------------------->           
          <div class="card-body">
            <h2 class="card-title"><?php echo $post['title']; ?></h2>
            <p class="card-text"><?php echo $post['slug']; ?></p>
            <?php
              $sql = "SELECT * FROM comments WHERE pid=? AND status='approved'";
              $result = $db->prepare($sql);
              $result->execute(array($post['id']));
              $commentcount = $result->rowCount();
              if($commentcount >= 0){
            ?>
            <a href="#" class="btn btn-secondary"><?php echo $commentcount; ?> Comments</a>
            <?php } ?>
              <a href= "single.php?id=<?php  echo $post['slug'];    ?>"  class="btn btn-primary">Read the Article &rarr;</a>
            </div>
            
<!---------------------------------DATE AND CREATOR PART---------------------------------------------------->
            
            <div class="card-footer text-muted">
                <?php  echo $post['created'];?>
                <?php 
                
                $usersql = "SELECT * FROM users WHERE id=?";
                $userresult = $db->prepare($usersql);
                $userresult->execute(array($post['uid']));
                $user = $userresult->fetch(PDO::FETCH_ASSOC);
                
                ?>             <!-----Date---------------------->
                <a href="user-posts.php?id=<?php echo $user['id']; ?>"><?php if((isset($user['fname']) || isset($user['lname'])) & (!empty($user['fname']) || !empty($user['lname']))) {echo $user['fname'] . " " . $user['lname']; }else{echo $user['username']; } ?></a>
            </div>
<!-------------------------------------------------------------------------------------------------------------->
      
      </div>

    <?php }  ?>

         

        

          <!----------------------------------- Pagination ----------------------------------------------->

      <ul class="pagination justify-content-center mb-4">
        <?php if($curpage != $startpage){ ?>
        <li class="page-item">
          <a class="page-link" href="?page=<?php echo $startpage; ?>">&larr; Previous</a>
        </li>
        <?php } ?>
        <?php if($curpage != $endpage){ ?>
        <li class="page-item">
          <a class="page-link" href="?page=<?php echo $endpage; ?>">Next &rarr;</a>
        </li>
        <?php } ?>
      </ul>

    </div>



    
      </div>
    </div>
  </div>











  <?php
$rppsql = "SELECT * FROM settings WHERE name='resultsperpage'";
$rppresult = $db->prepare($rppsql);
$rppresult->execute();
$rpp = $rppresult->fetch(PDO::FETCH_ASSOC);
$perpage = $rpp['value'];

if(isset($_GET['page']) & !empty($_GET['page'])){
  $curpage = $_GET['page'];
}else{
  $curpage = 1;
}
// get the number of total posts from posts table
$sql = "SELECT * FROM posts WHERE status='published'";
$result = $db->prepare($sql);
$result->execute();
$totalres = $result->rowCount();
// create startpage, nextpage, endpage variables with values
$endpage = ceil($totalres/$perpage);
$startpage = 1;
$nextpage = $curpage + 1;
$previouspage = $curpage - 1;
$start = ($curpage * $perpage) - $perpage;

$sql = "SELECT * FROM posts WHERE status='published' and header='recent' ORDER BY created DESC LIMIT $start, $perpage";
$result = $db->prepare($sql);
$result->execute();
$posts = $result->fetchAll(PDO::FETCH_ASSOC);
// add the pagination links
?>
<!-- Page Content -->


    <!-- Blog Entries Column -->
    <div class="col-md-8">

      <h1 class="my-4">Recent Articles</h1>
      <?php
        foreach ($posts as $post) {
      ?>
<!-------------------------- Blog PART ---------------------------------------------------------------------------->
         
<div class="card-deck">
  <div class="card">           <!-----DIVISION FOR THE MAIN BODY---------------------------->
          
            
            
<!-------------------------- Blog PIC PART ---------------------------------------------------------------------------->         
            <?php if(isset($post['pic']) & !empty($post['pic']))
            {?>

              <img class="card-img-top" src="<?php echo $post['pic']; ?>" alt="Card image cap">
            
            <?php }else{  ?>

              <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">

            <?php } ?>


 <!----------------------------------BODY POST-------------------------------------------------------------->           
          <div class="card-body">
            <h5 class="card-title"><?php echo $post['title']; ?></h5>
            <p class="card-text"><?php echo $post['slug']; ?></p>
            <?php
              $sql = "SELECT * FROM comments WHERE pid=? AND status='approved'";
              $result = $db->prepare($sql);
              $result->execute(array($post['id']));
              $commentcount = $result->rowCount();
              if($commentcount >= 0){
            ?>
            <a href="#" class="btn btn-secondary"><?php echo $commentcount; ?> Comments</a>
            <?php } ?>
              <a href= "single.php?id=<?php  echo $post['slug'];?>"  class="btn btn-primary">Read the Article </a>
            </div>
            
            
<!---------------------------------DATE AND CREATOR PART---------------------------------------------------->
            
            <div class="card-footer text-muted">
                
                <?php  echo $post['created'];?>
                <?php 
                
                $usersql = "SELECT * FROM users WHERE id=?";
                $userresult = $db->prepare($usersql);
                $userresult->execute(array($post['uid']));
                $user = $userresult->fetch(PDO::FETCH_ASSOC);
                
                ?>             <!-----Date---------------------->
                <a href="user-posts.php?id=<?php echo $user['id']; ?>"><?php if((isset($user['fname']) || isset($user['lname'])) & (!empty($user['fname']) || !empty($user['lname']))) {echo $user['fname'] . " " . $user['lname']; }else{echo $user['username']; } ?></a>
            </div>
<!-------------------------------------------------------------------------------------------------------------->
      
      </div>

    <?php }  ?>

         

        

          <!----------------------------------- Pagination ----------------------------------------------->

      <ul class="pagination justify-content-center mb-4">
        <?php if($curpage != $startpage){ ?>
        <li class="page-item">
          <a class="page-link" href="?page=<?php echo $startpage; ?>">&larr; Previous</a>
        </li>
        <?php } ?>
        <?php if($curpage != $endpage){ ?>
        <li class="page-item">
          <a class="page-link" href="?page=<?php echo $endpage; ?>">Next &rarr;</a>
        </li>
        <?php } ?>
      </ul>

    </div>



    
      </div>
    </div>
  </div>







        <!-- Sidebar Widgets Column -->
        

      
      <!-- /.row -->

   
    <!-- /.container -->

   
<?php include('includes/footer.php'); ?>
<?php 

require_once("../database/database_library.php");
if (!($_SESSION['user']['role_type']=='teacher')) {
    session_destroy();
    header("location:../login.php?class=danger&msg=Unauthorized access");
}
else{
require_once("../general/general_library.php");
$dobj = new database_library();
$obj = new general_library();
$obj->get_outer_header();
$obj->get_outer_navbar();
$user_course = $dobj->search_user_batch_course($_SESSION['user']['user_id']);
// $topic_files =  $dobj->get_topic_files($course_topic['topic_id']);
// var_dump($topic_files =  $dobj->get_topic_files($course_topic['topic_id']));
// die;
?>
                <div class="row mb-5" style="height:100px">
        <div class="col-12 bg-info" style="">
            <div class="card-header bg-light mt-5 mb-1">
                <p><?php echo strtoupper($_SESSION['user']['first_name']." ".$_SESSION['user']['last_name'])."(".$_SESSION['user']['role_type'].")"; ?></p>
                <h3 class="text-info" style="text-align: center;">TEACHER DASHBOARD</h3>
            </div>
        </div>
    </div>
<div class="row">
  <div class="col-3">
      <div class="card m-3 mt-5">
            <div class="card-header bg-info">
            NAVIGATION
            </div>
            <div class="card-body">
            <blockquote class="blockquote mb-0">
            <!-- <p>A well-known quote, contained in a blockquote element.</p> -->
            <p><a href="teacher_dashboard.php">Dashboard</a></p>
            <p><a href="view_students.php?batch_course_id=<?php echo $_REQUEST['batch_course_id']; ?>">Students</a></p>
            <p>Site home</p>
            <p>Site site pages</p>
            <p>my courses</p>
            <footer class="blockquote-footer"><cite title="Source Title"></cite></footer>
            </blockquote>
            </div>
            </div>
  </div>
     <div class="col-6 text-center mt-5">
                        <span><?php if (isset($_GET['msg'])) {
        ?><div class="alert alert-<?php echo $_REQUEST['class']; ?>" role="alert">
          <?php  echo $_GET['msg'];?>
        </div>
      <?php } 
    ?> </span>


<table id="myTable"  width="100%" class=“display” data-page-length="10" data-order="[[ 1, &quot;asc&quot; ]]">
  <?php $course_students = $dobj->get_batch_course_students($_REQUEST['batch_course_id']);
$count = 0;
   ?>
  <thead>
    <tr>

      <th scope="col">S#</th>
      <th scope="col">Profile</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?php 
    while($students = mysqli_fetch_assoc($course_students)){
     ?>
    <tr>
      <td> <?php echo ++$count; ?></td>
      <td><img src="../images/<?php echo $students['image']; ?>"style="width: 25px; height: 25px"></td>
      <td><?php echo $students['first_name']; ?></td>
      <td><?php echo $students['last_name'] ?></td>
      <td><?php echo $students['email'] ?></td>
    </tr>
    <?php 
  }
     ?>
  </tbody>
</table>

      </div>
  <div class="col-3">
 <!--        <div class="card m-3">
        <div class="card-header bg-info">
        STUDENTS
        <?php 
        $course_students = $dobj->get_batch_course_students($_REQUEST['batch_course_id']);
         ?>
            <div class="mb-3" style="overflow-y: scroll;">

            </div>
        </div>
        <div class="card-body" style="overflow-y:scroll">


                        <?php  
              while($students = mysqli_fetch_assoc($course_students)){
            
              ?>
                     <p>
                     <?php 
                     echo $students['first_name'] ?>    
                      <img src="../images/<?php  echo $students['image']; ?>" style="height: 30px; width: 30px" >
                      <?php// echo $students['email'] ?>    
                      <?php //echo $students['gender'] ?>      
                      <?php //echo $students['role_type'] ?></p>
            <?php 
              }
             ?>
        </div>
        </div> -->

</div>
  <!-- </div> -->
</div>




<div class="row">
    <div class="col-12 bottom bg-dark text-light mt-5" style="height: 6rem;">
        <p class="text-center">
            <?php
            if (isset($_SESSION['user'])) {
            echo "you are logged in as ".$_SESSION['user']['role_type'] ."(<a href='../logout.php?action=logout' style='text-decoration:none'onclick='return logout()'>Log out</a>)";
            } else{
            echo "You are not logged in";
            }
        ?>
        </p>
    <img src="">
    <img src="">
    <img src="">
    <p>&copy; hidaya institute of science & technology</p>
    </div>
</div>



<?php
$obj->get_outer_footer();
}

 ?>
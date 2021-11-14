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
// die;
$user_course = $dobj->search_user_batch_course($_SESSION['user']['user_id']);
// var_dump($user_course);
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
            <p>Site home</p>
            <p>Site site pages</p>
            <p>my courses</p>
            <footer class="blockquote-footer"><cite title="Source Title"></cite></footer>
            </blockquote>
            </div>
            </div>
            <div class="card m-3">
            <div class="card-header bg-info ">
            ONLINE USERS
            </div>
            <div class="card-body">
            <!-- <blockquote class="blockquote mb-0"> -->
            <!-- <p>A well-known quote, contained in a blockquote element.</p> -->
            <?php $users =  $dobj->online_users(); 
            while($online_users = mysqli_fetch_assoc($users)){
                // var_dump($online_users);
                // die;
                ?>
                <p>
                <img src="../images/<?php  echo $online_users['image']; ?>" style="height: 20px; width: 20px" >
                <?php
                echo $online_users['first_name']." ".$online_users['last_name'];
                echo"</p>";
            }


            ?>
            <footer class="blockquote-footer"><cite title="Source Title"></cite></footer>
            <!-- </blockquote> -->
            </div>
            </div>
	</div>
	   <div class="col-6 text-center mt-5">
        <div class="card-header">
            <p>Welcome <?php echo strtoupper($_SESSION['user']['first_name']." ".$_SESSION['user']['last_name']); ?></p>
        </div>
        <?php while($view_course = mysqli_fetch_assoc($user_course)){
          ?>
        <div class="card-header bg-light mt-2">
        <!-- <p>Welcome Teacher</p> -->
        <h1><a href="course_view.php?batch_course_id=<?php echo $view_course['batch_course_id']; ?>"> <?php echo $view_course['batch_description']." ".$view_course['course_description']; ?></a></h1>  
        </div>
        <?php
        } 
        ?>








      </div>
	<div class="col-3">
        <div class="card m-3">
        <div class="card-header bg-info">
        PRIVATE FILES
        </div>
        <div class="card-body">
        <blockquote class="blockquote mb-0">
        <!-- <p>A well-known quote, contained in a blockquote element.</p> -->
        <footer class="blockquote-footer"><cite title="Source Title"></cite></footer>
        </blockquote>
        </div>
        </div>
        <div class="card m-3">
        <div class="card-header bg-info">
        CALENDARS
        </div>
        <div class="card-body">
        <blockquote class="blockquote mb-0">
        <!-- <p>A well-known quote, contained in a blockquote element.</p> -->
        <footer class="blockquote-footer"><cite title="Source Title"></cite></footer>
        </blockquote>
        </div>
        </div>
        <div class="card m-3">
        <div class="card-header bg-info">
        UPCOMING EVENTS
        </div>
        <div class="card-body">
        <blockquote class="blockquote mb-0">
        <!-- <p>A well-known quote, contained in a blockquote element.</p> -->
        <footer class="blockquote-footer"><cite title="Source Title"></cite></footer>
        </blockquote>
        </div>
        </div>
        <div class="card m-3">
        <div class="card-header">
        courses
        </div>
        <div class="card-body">
        <blockquote class="blockquote mb-0">
        <!-- <p>A well-known quote, contained in a blockquote element.</p> -->
        <footer class="blockquote-footer"><cite title="Source Title"></cite></footer>
        </blockquote>
        </div>
        </div>
            <div class="card m-3">
                <div class="card-header">
                Topics
                </div>
                <div class="card-body">
                <blockquote class="blockquote mb-0">
                <!-- <p>A well-known quote, contained in a blockquote element.</p> -->
                <footer class="blockquote-footer"><cite title="Source Title"></cite></footer>
                </blockquote>
                </div>
            </div>
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
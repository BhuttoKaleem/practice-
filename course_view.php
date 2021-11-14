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
$user_course = $dobj->search_user_batch_course($_SESSION['user']['user_id'],$_SESSION['user']['user_role_id']);
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
                        <span id="msg"><?php if (isset($_GET['msg'])) {
        ?><div class="alert alert-<?php echo $_REQUEST['class']; ?>" role="alert">
          <?php  echo $_GET['msg'];?>
        </div>
      <?php } 
    ?> </span>
            <div class="card m-3">
                <div class="card-header">
                Topics
                </div>
                <div class="card-body mb-3" style="overflow-y:scroll;">
                <!-- <blockquote class="blockquote mb-0"> -->
                      <?php  
                      $user_course = $dobj->user_course($_SESSION['user']['user_id'],$_REQUEST['batch_course_id']);
                      $count = 0;
                      while($course_topic = mysqli_fetch_assoc($user_course)){
                     // var_dump($course_topic);
                      ?>
                    <div class="accordion mb-5" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header mb-3" id="flush-headingOne">
                    <center>
                    <table>
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"> 
                    Topic #<?php echo ++$count; ?>
                     <tr>
                         
                    <td>   
                    </td>
                    <td class="">
                                            <?php
                  if ($course_topic['status_id']==2) {
                  ?>
                    <input type="hidden" name="" id="status_id" value="<?php echo $course_topic['status_id']; ?>">
                    <a href="process.php?action=update_topic&topic_id=<?php echo $course_topic['topic_id'] ?>
                    &status_id=1&batch_course_id=<?php echo $_REQUEST['batch_course_id']; ?>" class="btn btn-primary"><img src="../assets/icon_topic_active.png" style="height: 50px; width: 50px;"></a>
                  <?php }
                  if ($course_topic['status_id']==1) {
                  ?>
                    <input type="hidden" name="" id="status_id" value="<?php echo $course_topic['status_id']; ?>">
                    <a href="process.php?action=update_topic&topic_id=<?php echo $course_topic['topic_id'] ?>
                    &status_id=2&batch_course_id=<?php echo $_REQUEST['batch_course_id']; ?>" class="btn btn-danger"><img src="../assets/icon_topic_inactive.png" style="height:50px; width:50px;"></a>
                  <?php }
                  ?>
                </td>
                <td align="right" class="mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $course_topic['topic_id'];?>" data-bs-whatever="@getbootstrap"><img src="../assets/icon_add_file.png" style="height:50px; width:50px;"></button>
                </td>
                     
                     </tr>   
                    </table>
                    </center>
                    <p><?php echo $course_topic['topic_title']; ?></p>                    

                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                     <p><?php echo $course_topic['topic_title'].":".$course_topic['topic_description'];?></p> 
                       <center>
                     <table cellspacing="30px" cellpadding="15px">
                           
                     <?php 
                     // die; 
                      $topic_files =  $dobj->get_topic_files($course_topic['topic_id']);
                     while($topic_file = mysqli_fetch_assoc($topic_files)){
                     ?>
                     <tr>
                         
                     <td>
                      <img src="<?php 
                      if($topic_file['file_type']=='doc'){
                        echo "../assets/word_icon.png"; 
                      }
                      else if($topic_file['file_type']=='ppt' || $topic_file['file_type']=='pptx'){
                        echo "../assets/ppt_icon.png";
                      } 
                      else if($topic_file['file_type']=='pdf'){
                        echo "../assets/pdf_icon.png";
                      }
                      else if($topic_file['file_type']=='jpg'||$topic_file['file_type']=='jpeg'||$topic_file['file_type']=='png'){
                        echo "../assets/image_icon.png";
                      }
                      ?>
                      " style="width: 30px;height: 30px;">
                    </td>
                    <td>
                      <a href="<?php echo $topic_file['file_path'].'/'.$topic_file['file_name'] ?>"><?php echo $topic_file['file_name']; ?></a>
                  </td>
                     <td>
                        <?php if($topic_file['status_id']==2){
                    ?>  <a href="process.php?batch_course_id=<?php echo $_REQUEST['batch_course_id']; ?>&action=update_file&topic_file_id=<?php echo $topic_file['topic_file_id']; ?>&status_id=1" class=""><img src="../assets/icon_tick.png" style="height:20px; width: 20px;"></a> 
                    <?php } ?> 
                    <?php if($topic_file['status_id']==1){
                    ?> 
                    <a href="process.php?batch_course_id=<?php echo $_REQUEST['batch_course_id']; ?>&action=update_file&topic_file_id=<?php echo $topic_file['topic_file_id']; ?>&status_id=2" class=""><img src="../assets/icon_cross.png" style="height: 20px; width:20px;"></a>
                     <?php } ?>
                     </td> 
                     </tr>
                  <?php } 
                  ?>
                    <tr>
                    </tr>
                     </table>
                        <p > Topic Status: <?php echo $course_topic['status']; ?> </p>
                       </center>  
                    <!-- <input type="hidden" name="" id="topic_id" value="<?php echo $course_topic['topic_id']; ?>"> -->
                    <!-- <input type="hidden" name="" id="topic_id" value="<?php echo $course_topic['topic_id']; ?>"> -->
                    <!--  status  -->
                  </div>
                </div>
              </div>
            </div>
            <script type="text/javascript">
        function topic_active() {
          var status_id  = document.getElementById('status_id').value;
          var topic_id  = document.getElementById('topic_id').value;
          // alert(topic_id+status_id);
        var obj;
        if (window.XMLHttpRequest) {
            obj = new XMLHttpRequest();
        }
        else{
            obj = new ActiveXObject('Microsoft.XMLHTTP');
        }
        obj.onreadystatechange = function(){

            if (obj.readyState == 4 && obj.status == 200) {
                document.getElementById('msg').innerHTML = obj.responseText;
            }
        }
        obj.open('POST','process.php?action=update_topic&topic_id='+topic_id+'&status_id='+status_id);
        obj.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        obj.send();

        }

                function topic_inactive() {
        var status_id = document.getElementById('status_id').value;
        var topic_id = document.getElementById('topic_id').value;
          // alert(topic_id+status_id);
        
        var obj;
        if (window.XMLHttpRequest) {
            obj = new XMLHttpRequest();
        }
        else{
            obj = new ActiveXObject('Microsoft.XMLHTTP');
        }
        obj.onreadystatechange = function(){

            if (obj.readyState == 4 && obj.status == 200) {
                document.getElementById('msg').innerHTML = obj.responseText;
            }
        }
        obj.open('POST','process.php?action=update_topic&topic_id='+topic_id+'&status_id='+status_id);
        obj.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        obj.send();

        }      
            </script>


                  <div class="modal fade" id="exampleModal<?php echo $course_topic['topic_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Topic file</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="process.php" method="POST" enctype="multipart/form-data">
                              <div class="mb-3">
                                <label for="topic_file" class="col-form-label">Topic File</label>
                                <input type="file" class="form-control" id="topic_file" name="topic_file">
                              </div>
                          </div>
                          <div class="modal-footer">
                            <input type="hidden" name="action" value="upload_topic_file">
                            <input type="hidden" name="batch_course_id" value="<?php echo $_REQUEST['batch_course_id'];?>">
                            <input type="hidden" name="topic_id" value="<?php echo $course_topic['topic_id']; ?>">
                            <input type="submit"  name="upload" class="btn btn-primary" value="Upload">
                          </div>
                            </form>
                        </div>
                      </div>
                    </div>

              <?php  
              }
              ?>
                </div>
        </div>


      </div>
	<div class="col-3">
        <div class="card m-3">
        <div class="card-header bg-info">
        CALENDAR
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
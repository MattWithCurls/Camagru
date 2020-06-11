<?php
  session_start();
  if ($_SESSION[username] && !empty($_SESSION[username])) {
      include_once 'header.php';
  } else {
      header('Location: index.php?err=must be logged in to view this page.');
  }
?>



<script src="js/webcam.js" charset="utf-8"></script>
    <article class="main">
    <div class="videobox">
	<video id="video"></video>
	<img id="image" height="640px" width="480px" style="display: none;"/>
	<div id="canvasvideo"></div>
	    <br/>
      <button class="button" id="snap" onclick="javascript:Shot()">snap</button>
      </br>
      <br/>
    <input type='file' accept="image/*" onchange="readURL(this);" />
    <br/>
    <img id="image" height="640px" width="480px" style="display: none;"/>
  </div>
  </article>
	<form id="img_filter">
	<label for="astro" class="astro">
	  <input type="radio" name="img_filter" value="images/filter/astro.png" id="astro" onchange="myimage('astro')">
	  <img class="img" src="images/filter/astro.png" height="128" width="128">
	</label>
	<label for="face" class="face">
	  <input type="radio" name="img_filter" value="images/filter/face.png" id="face" onchange="myimage('face')">
	  <img class="img" src="images/filter/face.png" height="128" width="128">
	</label>
	<label for="mickey" class="mickey">
	  <input type="radio" name="img_filter" value="images/filter/mickey.png" id="mickey" onchange="myimage('mickey')">
	  <img class="img" src="images/filter/mickey.png" height="128" width="128">
	</label>
	<label for="waves" class="waves">
	  <input type="radio" name="img_filter" value="images/filter/waves.png" id="waves" onchange="myimage('waves')">
	  <img class="img" src="images/filter/waves.png" height="128" width="128">
	</label>
	<br/>
  </form>

  <aside class="aside2">
    <div class="videobox">
    <h3>Overview</h3>
    <div id="canvas"></div>
    <form method='post' accept-charset='utf-8' name='form'>
      <input name='img' id='img' type='hidden'/>
      <input name='user' id='user' type='hidden' value='<?=$_SESSION[username];?>'/>
    </form>
  </div>
  </aside>
<a class='mylink' href = "header.php">back to hompage</a>
	</body>
</html>
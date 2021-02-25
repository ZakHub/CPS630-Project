<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GQZ TRAVELS - Home Page</title>
  <link rel="stylesheet" href="Main.css">
  
  <script>
  var myIndex = 0;
  window.onload = function() {
    slides();
  };

  function slides() {
    var i;
    var x = document.getElementsByClassName("Slides");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
    }
    x[myIndex].style.display = "block";
    myIndex++;
    if (myIndex == x.length) {
      myIndex = 0;
    }
    setTimeout(slides, 3000);
  }
  </script>
</head>

<body>
  <div id="outer">
    <div id="inner" class="floating">

      <!-- Navigation -->
      <?php include('navbar.php') ?>

      <!-- Web Canvas -->
      <section>
        <img class="Slides" src="G.png" style="width:100%" alt="G slide">
        <img class="Slides" src="Q.png" style="width:100%" alt="Q slide">
        <img class="Slides" src="Z.png" style="width:100%" alt="Z slide">
      </section>

      <!--Description -->
      <section style="max-width:600px">
        <h2>GQZ TRAVELS</h2>
        <p><i>GQZ TRAVELS is service that help customers get around the city and
          encourages smart green trips throught ride sharing.</i></p>
      </section>

    </div>
  </div>
</body>
</html>

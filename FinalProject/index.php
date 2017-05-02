<?php
  include_once("includes/header.php");
?>


    <div id="slideShow">
      <div class="mySlides fade">
        <img src="https://designschool.canva.com/wp-content/uploads/sites/2/2016/04/Antique-Map.jpg" >
        <div class="text">Caption Text</div>
      </div>

      <div class="mySlides fade">
        <img src="http://ezramagazine.cornell.edu/SUMMER15/images/FTC.RMC2003.0095-v2.jpg" >
        <div class="text">Caption Two</div>
      </div>

      <div class="mySlides fade">
        <img src="http://geoawesomeness.com/wp-content/uploads/2015/06/submarine-cable-map-2015-l.png">
        <div class="text">Caption Three</div>
      </div>

      <div class="mySlides fade">
        <img src="https://cdn2.vox-cdn.com/uploads/chorus_asset/file/3498618/trademapsubmarinecables.0.jpg">
        <div class="text">Caption Four</div>
      </div>

      <div class="mySlides fade">
        <img src="http://img.microsiervos.com/mapacables2.jpg">
        <div class="text">Caption Five</div>
      </div> 

      <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
      <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

      <!--<div id = "dots">
        <span class="dot" onclick="currentSlide(1)"></span> 
        <span class="dot" onclick="currentSlide(2)"></span> 
        <span class="dot" onclick="currentSlide(3)"></span> 
        <span class="dot" onclick="currentSlide(4)"></span> 
        <span class="dot" onclick="currentSlide(5)"></span> 
      </div>-->

    <div id="contents">
      <div id="articles">
        <div class="division_title">
        <h2>Feature Articles</h2>
        </div>
        <div class = "entry">
          <div class="thumbnail">
            <img src="images/CPRLogo2.jpg">
          </div>
          <div class="article_intro">
            <h3>xxxxxxxxxxxxxxxxx</h3>
          </div>
        </div>

        <div class = "entry">
          <div class="thumbnail">
            <img src="images/CPRLogo2.jpg">
          </div>
          <div class="article_intro">
            <h3>xxxxxxxxxxxxxxxxx</h3>
          </div>
        </div>

        <div class = "entry">
          <div class="thumbnail">
            <img src="images/CPRLogo2.jpg">
          </div>
          <div class="article_intro">
            <h3>xxxxxxxxxxxxxxxxx</h3>
          </div>
        </div>

        <div class = "entry">
          <div class="thumbnail">
            <img src="images/CPRLogo2.jpg">
          </div>
          <div class="article_intro">
            <h3>xxxxxxxxxxxxxxxxx</h3>
          </div>
        </div>

        <div class = "entry">
          <div class="thumbnail">
            <img src="images/CPRLogo2.jpg">
          </div>
          <div class="article_intro">
            <h3>xxxxxxxxxxxxxxxxx</h3>
          </div>
        </div>
         
      </div>

      <div id ="welcome">
          <img src="http://www.thecollegesolution.com/wp-content/uploads/2014/06/Cornell.jpg">
          <div class="message">
            <div class="title-in-box">
              <h2>Editor's Notes</h2>
            </div>
          </div>
      </div>
    </div>
    
<?php
  include_once("includes/footer.php");
?>
		
</div>

<script>

  var slideIndex = 1;
  showSlides(slideIndex);

  function plusSlides(n) {
    showSlides(slideIndex += n);
  }

  function currentSlide(n) {
    showSlides(slideIndex = n);
  }

  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1} 
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; 
    }
    //for (i = 0; i < dots.length; i++) {
    //    dots[i].className = dots[i].className.replace(" active", "");
    //}
    slides[slideIndex-1].style.display = "block"; 
    //dots[slideIndex-1].className += " active";
  }
</script>
	</body>
</html>

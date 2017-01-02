<script type="text/javascript" src=<?php echo base_url("/js/slider/responsiveslides.min.js"); ?> ></script>
<link rel="stylesheet" href="<?php echo base_url() ?>css/slider/slider.css">

<script>
	// You can also use "$(window).load(function() {"
	$(function () {
		// Slideshow 4
		$("#slider3").responsiveSlides({
			auto: true,
			pager: true,
			nav: false,
			speed: 500,
			namespace: "callbacks",
			before: function () {
				$('.events').append("<li>before event fired.</li>");
			},
			after: function () {
				$('.events').append("<li>after event fired.</li>");
			}
		});

	});
</script>
<!--//End-slider-script -->
<div  id="top" class="callbacks_container wow fadeInUp" data-wow-delay="0.5s">
	<ul class="rslides" id="slider3">
		
		<?php if($slides) :?>
			<?php foreach ($slides as $slide): ?>
		
		
			<li>
				<div class="slide">		
					<img src="<?php echo imageresize(base_url ($slide->imageName),1920,700); ?>" alt="">
					<div class="slideText">
					<h1><?php echo $slide->title; ?></h1>
					<p><?php echo $slide->desc; ?></p>
					<!--<a href="<?php echo $slide->link; ?>" class="hvr-shutter-out-horizontal">Read More</a>-->
					</div>
				</div>
			</li>	
		
			<?php endforeach; ?>
			<?php endif;?>	
		
	</ul>
</div>	

<!--<div id="slider">
<figure>
<img src="http://demosthenes.info/assets/images/austin-fireworks.jpg" alt="">
<img src="http://demosthenes.info/assets/images/taj-mahal.jpg" alt="">
<img src="http://demosthenes.info/assets/images/ibiza.jpg" alt="">
<img src="http://demosthenes.info/assets/images/ankor-wat.jpg" alt="">
<img src="http://demosthenes.info/assets/images/austin-fireworks.jpg" alt="">
</figure>
</div>-->
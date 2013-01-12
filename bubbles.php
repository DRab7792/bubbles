<html>
	<head>
		<title>Twitter Bubbles</title>
		<style type="text/css">
		@font-face
	    {
	        font-family: code;
	        src:url('fonts/code.otf');
	        font-weight: bold;
	    }
		.headline{
			width:1167;
			height:80px;
			font-size:96px;
			text-align:center; 
			color:white;
			font-family:code;
			background-color:black;
		}
		.strings{
			z-index:1000;
			width: 90.3px;
			top: 90px;
			height: 380px;
			left: 208px;
			position: absolute;
		}
		</style>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		<?php
			error_reporting(E_ERROR);
			// require_once ("config/phirehose-master/lib/Phirehose.php");
			// require_once ("config/phirehose-master/example/filter-track.php");
			// require_once ("config/config.php");
			// $topics = file_get_contents("https://api.twitter.com/1/trends/2459115.json?exclude=hashtags");
			// $arr = json_decode($topics,true);
			// $trends = array();
			// foreach ($arr[0]['trends'] as $cur){
			// 	$trends[] = $cur['name'];
			// }
			//print_r($arr);
			// set_time_limit(20);
			// $sc = new FilterTrackConsumer($config['twitter']['user'],$config['twitter']['pass'], Phirehose::METHOD_FILTER);
			// $sc->setTrack(array('food'));
			// $sc->consume();
		?>
		<script src="http://cloud.github.com/downloads/processing-js/processing-js/processing-1.4.1.js"></script>
		<script type="text/processing" data-processing-target="base">
			    /* @pjs preload="images/bubblesBase.jpg"; 
			       @pjs preload="images/bubble.png"; 
			       @pjs preload="images/earth.png";
			       @pjs preload="images/jupiter.png";
			       @pjs preload="images/mars.png";
			       @pjs preload="images/mercury.png";
			       @pjs preload="images/moon1.png";
			       @pjs preload="images/pluto.png";
			       @pjs preload="images/rockPlanet.png";
			       @pjs preload="images/uranus.png";*/
			    int framerate = 20;
		    	PImage b, bub;
		    	ArrayList balls;
		    	ArrayList bubbles;
		    	string[] imgs = {
		    		"images/bubble.png",
		    		"images/earth.png",
		    		"images/jupiter.png",
		    		"images/mars.png",
		    		"images/mercury.png",
		    		"images/moon1.png",
		    		"images/pluto.png",
		    		"images/rockPlanet.png",
		    		"images/uranus.png"
		    	};
		    	string[] trends = {
		    		<?php for($i=0;$i<count($trends);$i++){ echo "'".$trends[$i]."'"; echo ($i<(count($trends)-1))?',':'';}?>
		    	};
		    	int num = 2;

		    	b = loadImage("images/bubblesBase.jpg");
		    	ArrayList files;
			    void setup() {
			     	size (1167,384);
			     	files = new ArrayList();
					for (int i=0;i<(imgs.length()+15);i++){
						if (i<imgs.length()){
							files.add(imgs[i]);
						}else{
							files.add(imgs[0]);
						}
					}
			    	frameRate(framerate); 

			    	balls = new ArrayList(); 
			    	bubbles = new ArrayList();
			    	balls.add(new circle());

			 	}
			 	void draw(){

			 		if (random(0,10)>8){
			 		 	balls.add(new circle());
			 		 	//num++;
			 		}
			 		for (int i=0;i<balls.size();i++){
			 			balls.get(i).move();
			 		}
			 		for (int i=0;i<bubbles.size();i++){
			 			bubbles.get(i).move();
			 		}
			 		image(b, 0, 0,width,height);
			 		
			 		for (int i=0;i<balls.size();i++){
			 			if (balls.get(i).getX()<250) {
			 				balls.get(i).display();
			 			}else{
			 				float newY = balls.get(i).getY() + (balls.get(i).getSize() * balls.get(i).getDir());
			 				bubbles.add(new bubble(newY,balls.get(i).getSize(), balls.get(i).getSpeed(), balls.get(i).getDir()));
			 				balls.remove(i);
			 			}
			 		}
			 		for (int i=0;i<bubbles.size();i++){
			 			if (bubbles.get(i).canMove()){
			 				bubbles.get(i).display();
			 			}else if (!bubbles.get(i).canMove() || bubbles.get(i).getSpeed()<1){
			 				bubbles.remove(i);
			 			}
			 		}
			 	}
			 	class bubble{
				 	int x = 250;
				 	int y;
				 	int size;
				 	float speed;
				 	float direction;
				 	int index;
				 	PImage img;
				 	public bubble (int startY, int width, float startSpeed, float startDir){
				 		size = width;
					 	speed = startSpeed;
					 	direction = startDir;
					 	y = startY;
					 	index = int(random(0,(files.size()-1)));
					 	//alert (files.get(0));
					 	img = loadImage(files.get(index));
					 	this.display();
				 	}
				 	void display(){
				 		image (img,x,y,size,size);
				 		if (index<imgs.length()){ 
				 			fill (#FFFFFF,20);
				 			stroke (#FFFFFF,20);
				 			ellipse ((x+(size/2)),(y+(size/2)),size,size);
				 		}
				 		
				 	}
				 	int getX(){
				 		return (x+size);
				 	}
				 	int getMaxY(){
				 		return (y+size);
				 	}
				 	int getMinY(){
				 		return (y-size);
				 	}
				 	boolean canMove(){
				 		return (this.getX()<950 && this.getMinY()>3 && this.getMaxY()<(width-3) && speed>1);
				 	}
				 	void move (){
				 		if (this.canMove()){
					 		x += speed;
					 		y += direction + random(-3,3);	
					 		speed = speed * ((15000.0-(float(x)-250.0))/15000.0);
					 	}
				 	}
				 	float getSpeed(){
				 		return speed;
				 	}
				}
				class circle{
				 	int x=130;
				 	int y=170;
				 	int size;
				 	float speed;
				 	float direction;
				 	public circle (){
				 		size = int(random(20,40));
					 	speed = random (1,20);
					 	direction = random (-1.8,1);
					 	this.display();
				 	}
				 	float getDir(){
				 		return direction;
				 	}
				 	float getSpeed(){
				 		return speed;
				 	}
				 	int getSize(){
				 		return size;
				 	}
				 	void display(){
				 		stroke(#000000); 
				 		fill (#FFFFFF);
				 		ellipse(x,y,size,size);
				 	}
				 	int getX(){
				 		return (x+size);
				 	}
				 	int getY(){
				 		return y;
				 	}
				 	void move (){
				 		if ((x+size)<250){
					 		x += speed;
					 		y += direction + random(-2,2);
					 		
					 		
					 	}
				 	}
				}	 
				
		</script>
	</head>
	<body>
		<div class = "headline">HEAR THE WORLD SPEAK</div>
		<img src="images/strings.png" class="strings">
		<canvas id="base"></canvas>
		
	</body>
</html>
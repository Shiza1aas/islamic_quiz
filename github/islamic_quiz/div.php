
<div>
	<img src="image/ilm.png" alt="Quran" style="width: 100%;height: 200px;margin: 4px auto";/>
	</div> 

<div>

		<nav>
			<ul>

				<li><a href="index.php#">Home</a></li>
				<?php
					if ( isset($_SESSION['user_id']))
					{
						?>
				<li>
		      		<a href="#">Practice <span class="caret"></span></a>
					<div>
						<ul>
							<li><a href="play_quiz.php?level=E">Easy</a><br></li>
							<li><a href="play_quiz.php?level=M">Medium</a><br></li>
							<li><a href="play_quiz.php?level=H">Hard</a><br></li>
						</ul>
									
						
						
					</div>
				</li>
				<li>
		      		<a href="#">Compete <span class="caret"></span></a>
					<div>
						<ul>
							<li>
								<li><a href="online.php">Online</a></li>
								<li><a href="#">Offline</a></li>	
							</li>
						</ul>
					</div>
				</li>

				<li><a href="leader_board.php">Leader Board</a></li>
				
					
					
				<li>
		      		<a href="#">User Section <span class="caret"></span></a>
					<div>
						<ul>
					
							<li><a href="view_score.php">View Score</a><br></li>
							<li><a href="viewprofile.php">View profile</a><br></li>
							<li><a href="editprofile.php">Edit profile</a><br></li>
							<li><a href="submit_ques.php">Submit A Question</a><br></li>
							<li><a href="logout.php">Logout</a><br></li>
						</ul>		
					<?php
				 } 
				else
				{
					?>
						
					
					
					
				<li><a href="leader_board.php">Leader Board</a></li>	
				<li><a href="login.php">Log In</a></li>
				<li><a href="signup.php">Sign Up</a></li>
							
						
					<?php 
					} ?>

				<li><a href="about.html">About Us</a></li>
				<li><a href="help.html">Help</a></li>
			</ul>
		</nav>

	</div>
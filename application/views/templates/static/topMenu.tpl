		<header class="banner">
                    {if $user->authenticate()}
                        {if $user->isAdmin()}
                            <div style="width: 200px; height: 30px; position: absolute; float:left; display:block; background-color: yellow; text-align: center; padding-top:15px; border: 1px solid black;"><span>ADMIN-AREA !!</span></div>
                        {else}
                            <div style="width: 200px; height: 30px; position: absolute; float:left; display:block; background-color: fuchsia; text-align: center; padding-top:15px; border: 1px solid black;"><span>User-Area !!</span></div>
                        {/if}
                    {/if}
                    <img class="banner" src="https://pixabay.com/static/uploads/photo/2015/09/17/10/31/banner-943868_960_720.jpg">
		</header>
		<nav id="hauptnav">
			<ul>
                            <li><a href="/blog/overview">Main</a></li>
				<li><a href="/game/about">Games</a></li>
				<li><a href="">Company</a></li>
				<li><a href="/admin/accountrequests">Besucher-Account-Anfragen</a></li>
				<li id="about-site"><a href="">About</a></li>
			</ul>
		</nav>
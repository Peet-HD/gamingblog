		
                {if $user->authenticate() && $user->isAdmin()}
                    <nav id="hauptnav" class="yellow darken-3">
                      <div class="nav-wrapper">
                        <ul id="nav-mobile" class="left hide-on-med-and-down">
                            <li><span><i class="material-icons small left">build</i> Admin-Navigation</span></li>
                            <li class="adminFirstEntry {if $navActive eq 'visitorsettings'}active{/if}"><a href="/admin/visitorsettings">Besucher-Verwaltung</a></li>
                            <li class="{if $navActive eq 'generalcontent'}active{/if}"><a href="/admin/generalcontent">Allgemeine Seiteninhalte</a></li>
                        </ul>
                      </div>
                    </nav>
                {/if}

                <header class="banner">
                    <img class="banner" src="https://pixabay.com/static/uploads/photo/2015/09/17/10/31/banner-943868_960_720.jpg">
		</header>
                    
                {if !isset($navActive)}
                    {assign "navActive" "d"}
                {/if}
                    
                <nav id="hauptnav" class="cyan">
                  <div class="nav-wrapper">
                    <ul id="nav-mobile" class="left hide-on-med-and-down">
                        <li{if $navActive eq 'main'} class="active"{/if}><a href="/blog/overview">Blog</a></li>
                        <li{if $navActive eq 'game'} class="active"{/if}><a href="/game/about">Game</a></li>
                        <li{if $navActive eq 'company'} class="active"{/if}><a href="">Company</a></li>
                    </ul>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li id="about-site"><a href="">About</a></li>
                    </ul>
                  </div>
                </nav>
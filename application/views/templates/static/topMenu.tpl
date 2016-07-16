		<header class="banner">
                    {if $user->authenticate()}
                        {if $user->isAdmin()}
                            <div style="font-size:24px; position: absolute; float:left; display:block; background-color: yellow; text-align: center; padding: 10px 20px; border: 1px solid black;">
                                <i class="material-icons">vpn_key</i>
                                <span>ADMIN-AREA !!</span>
                            </div>
                        {else}
                            <div style="font-size:24px; position: absolute; float:left; display:block; background-color: fuchsia; text-align: center; padding: 10px 20px; border: 1px solid black;">
                                <i class="material-icons">perm_identity</i>
                                <span>User-Area !!</span>
                            </div>
                        {/if}
                    {/if}
                    <img class="banner" src="https://pixabay.com/static/uploads/photo/2015/09/17/10/31/banner-943868_960_720.jpg">
		</header>
                    
                {if !isset($navActive)}
                    {assign "navActive" "d"}
                {/if}
                    
                <nav id="hauptnav" class="cyan">
                  <div class="nav-wrapper">
                    <ul id="nav-mobile" class="left hide-on-med-and-down">
                        <li{if $navActive eq 'main'} class="active"{/if}><a href="/blog/overview">Main</a></li>
                        <li{if $navActive eq 'game'} class="active"{/if}><a href="/game/about">Game</a></li>
                        <li{if $navActive eq 'company'} class="active"{/if}><a href="">Company</a></li>
                        {if $user->authenticate() && $user->isAdmin()}
                            <li class="adminFirstEntry {if $navActive eq 'visitorsettings'}active{/if}"><a href="/admin/visitorsettings">Besucheraccounts</a></li>
                        {/if}
                    </ul>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li id="about-site"><a href="">About</a></li>
                    </ul>
                  </div>
                </nav>
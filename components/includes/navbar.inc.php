<?php    
    function countMyMatches() {
        // Placeholder for counting matches
        return 0;
    }

    $searchResults = [];
    $search_query = ''; 
    $noofMyMatches = countMyMatches();
    $favMatchesUpdateCounter = 0;
?>
<div style="background-color: #27313b; color: white;"><!--class="border-bottom border-transparent"-->
    <div class="container">
        <header class="d-flex justify-content-between align-items-center mb-0">
            <!-- Social Media Links - Aligned to the Left -->
            <div class="d-none d-md-flex"><!--Hide this part on mobile-->
                <a class="btn btn-outline-dark btn-floating m-1" href="https://www.facebook.com/amazingstakes01" target="_blank" rel="noopener noreferrer" role="button" aria-label="Facebook" style="border-color: #05386B;">
                    <i class="bi bi-facebook text-light"></i>
                </a>
                <a class="btn btn-outline-dark btn-floating m-1" href="https://x.com/amazingstakes" target="_blank" rel="noopener noreferrer" role="button" aria-label="Twitter" style="border-color: #05386B;">
                    <i class="bi bi-twitter text-light"></i>
                </a>
                <a class="btn btn-outline-dark btn-floating m-1" href="https://www.instagram.com/amazingstakes/" target="_blank" rel="noopener noreferrer" role="button" aria-label="Instagram" style="border-color: #05386B;">
                    <i class="bi bi-instagram text-light"></i>
                </a>
            </div>

            <!--Text Link buttons -->
            <div class="dropdown">
                <button class="dropdown-button">Text Link</button>
                <div class="dropdown-content">
                    <a target="_blank" href="https://onblissstreet.com/"> Truc Tiep Bong da Xoilac</a>
              <a target="_blank" href="https://cakhiatv3.mobi/" title="cakhia tv"> cakhia tv</a>
                <a target="_blank" href="https://opaworks.com/" title="Xoilac">Xoilac</a>
                <a target="_blank" href="https://rakhoitv.cfd/" title="trực tiếp bóng đá">trựctiếp bóng đá</a>
                <a target= "_blank" href="https://789win.bio/" title = 789Win> 789Win </a>
                <a target="_blank" href="https://12betno1.me/" title=12BET> 12BET</a>
                <a target="_blank" href="https://junkyardrat.com/" title=Jun88> Jun88</a>
                <a target="_blank" href="https://f8bet.io/" title=F8bet> F8bet</a>
                </div>
            </div>
            
            <!-- Login and Register Links - Aligned to the Right -->
            <div class="d-flex">
                <?php                
                if (isset($_SESSION["logged_in_user"])) {
                    // If user is logged in, show "Logout" and "MyDashboard"
                    echo '<a href="/dashboard" rel="noopener noreferrer" class="btn btn-primary btn-sm m-1" style="white-space: nowrap;">MyDashboard</a>';
                    echo '<button  id="logoutBtn" rel="noopener noreferrer" class="btn btn-danger btn-sm m-1" style="white-space: nowrap;">Logout</button>';
                } else {
                    // If user is not logged in, show "Login" and "Register"
                    echo '<a href="/login" rel="noopener noreferrer" class="btn btn-danger btn-sm m-1" style="white-space: nowrap;">Login</a>';
                    echo '<a href="/register" rel="noopener noreferrer" class="btn btn-danger btn-sm m-1" style="white-space: nowrap;">Register</a>';
                }
                ?>
            </div>

        </header>
    </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark sideNavCustom1" style="background-color:#27313a;">
    <div class="container desktop-container-resize mb-2">
        <div class="d-none d-xl-block d-lg-block mt-2" style="height: 100%; width:19%; display: block;">
            <a class="navbar-brand" href="/">
                <img src="/images/amazingstakeslogo.png" style="width: 100%; height: auto; object-fit: contain;" alt="logo"/>
            </a>
        </div>
        <button class="btn btn-primary d-lg-none" aria-label="menu" id="sidebarToggle" onclick="openSidemenu()" style="background-color: #00000000; border-color: #ffffff1a;">
            <span class="navbar-toggler-icon" role="button" aria-label="Toggle navigation"></span>
        </button>
        <div class="d-lg-none" style="height: auto; width:60%; object-fit: contain;">
            <a class="navbar-brand d-lg-none" href="/">
                <img src="/images/amazingstakeslogo.png" style="width: 100%; height: auto; object-fit: contain;" alt="logo"/>
            </a> 
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#searchBar" aria-controls="navbarSupportedContent" aria-expanded="false" role="button" aria-label="Toggle navigation">
            <i class="bi bi-search" role="button" aria-hidden="true"></i>
        </button>

        <div class="collapse navbar-collapse d-none d-xl-block d-lg-block">
            <ul class="navbar-nav text-center">
                <li class="nav-item">&nbsp;&nbsp;&nbsp;</li>
                <li class="nav-item">&nbsp;&nbsp;&nbsp;</li>
                <li class="nav-item"><a class="nav-link text-light" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="/live-predictions">Livescores</a></li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">
                        <i class="bi bi-star"></i> Favourites&nbsp;
                        <span class="number-circle rounded-square fixturesTextSize" style="background-color: white; color: red; font-weight: bold; font-size:14px;">
                            <?php echo $noofMyMatches; ?>
                        </span>
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link text-light" href="#">Team Comparisons</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="/must-win-teams-today">Top Predictions</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="/jackpot-predictions">Jackpot Predictions</a></li>
            </ul>
        </div>

        <div class="collapse navbar-collapse fixturesTextSize" id="searchBar" style="flex-grow:0;">
            <br/>
            <form class="d-flex" method="POST" action="">
                <input 
                    class="form-control h-100" 
                    type="text" 
                    name="searchInput" 
                    placeholder="Type Min. 3 characters to search..." 
                    id="searchInput" 
                />      

               <!-- Div to Display Results -->
                <div id="searchResultsForm" style="background-color: #202c3c; display: none;"></div>
            </form>
        </div>
    </div>
</nav>

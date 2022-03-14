<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Starter Template</title>
	<link href="https://fonts.googleapis.com/css?family=Crimson+Text&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons&amp;_cacheOverride=1553632958093" rel="stylesheet">
	<link rel="stylesheet" href="<?= BASE_URL ?>css/defiant.css">
	<link rel="stylesheet" href="<?= BASE_URL ?>css/jewellery.css">
</head>
<body>
    <header>
        <div>
            <div><i class="material-icons">my_location</i> Store Locator</div>
            <div><i class="material-icons">account_box</i> Customer Log In</div>
        </div>
        <div>
            <div id="logo">
                <a href="https://defiantcss.com/examples/starter">Goldmine</a>
            </div>
            <div id="descriptor">~ Established in 1872 ~</div>
        </div>
        <div>
            <div>Your Shopping Basket Is Empty</div>
            <div>
                <button class="btn btn-small btn-basket">View Basket <i class="material-icons">shopping_basket</i></button>
            </div>
        </div>
    </header>
	<!-- Navbar -->
	<nav class="navbar">
		<a href="#" class="navbar-link">Gold Jewellery</a>
        <a href="#" class="navbar-link">Silver Jewellery</a>
		<div class="dropdown">
			<button class="navbar-link dropdown-toggle">Rings</button>
			<div class="dropdown-menu">
				<a href="#" class="dropdown-menu-link">Engagement Rings</a>
				<a href="#" class="dropdown-menu-link">Wedding Rings</a>
			</div>
		</div>
		<div class="dropdown">
			<button class="navbar-link dropdown-toggle">Designer Jewellery</button>
			<div class="dropdown-menu">
				<a href="#" class="dropdown-menu-link">Schlukt Von Shangle</a>
				<a href="#" class="dropdown-menu-link">Shambolm</a>
				<a href="#" class="dropdown-menu-link">Julie Andrews</a>
			</div>
		</div>
		<a href="#" class="navbar-link">Watches</a>
		<i class="material-icons nav-toggle">menu</i>
	</nav>

	<!-- Mobile Navigation -->
	<nav class="side-nav">
		<a href="" class="logo">Logo</a>
		<a href="" class="side-nav-link">Home</a>
		<a href="#" class="side-nav-link">About</a>
		<button class="side-nav-link submenu-toggle">Projects<i class="material-icons">chevron_right</i></button>
		<div class="submenu">
			<a href="#" class="submenu-link">Project 1</a>
			<a href="#" class="submenu-link">Project 2</a>
			<a href="#" class="submenu-link">Project 3</a>
		</div>
		<button class="side-nav-link submenu-toggle">Services<i class="material-icons">chevron_right</i></button>
		<div class="submenu">
			<a href="#" class="submenu-link">Service 1</a>
			<a href="#" class="submenu-link">Service 2</a>
			<a href="#" class="submenu-link">Service 3</a>
		</div>
		<a href="index.html" class="side-nav-link">Contact</a>
	</nav>

	<!-- Main Content -->
	<main class="main">

        <section class="showcase">
            <div class="info">
                <div>Luxury</div>
                <div>Watches</div>
                <div><a href="#" class="btn btn-gold btn-pulse btn-large">Explore The Collection</a></div>
            </div>
        </section>

        <section class="top-cards">
            <div><div><a href="x">Discover Gold Jewellery</a></div></div>
            <div><div><a href="x">Explore Our Gents Jewellery</a></div></div>
            <div><div><a href="x">The Springtime Collection Is Here</a></div></div>
            <div><div><a href="x">Exclusive Engagement Rings</a></div></div>
            <div><div><a href="x">Designer Silver Jewellery</a></div></div>
            <div><div><a href="x">Diamond Encrusted Charms</a></div></div>
        </section>

		<!-- Hero class -->
		<section class="hero">
			<h1>The Winter Sale Is Now On</h1>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore molestias maxime deleniti culpa iure, blanditiis voluptate neque distinctio vero ab esse, porro possimus velit a fuga magni commodi! Est, cumque! Labore molestias maxime deleniti culpa iure.</p>
            <div class="top-btns">
			    <a href="#" class="btn btn-gold btn-large">Beat The Rush</a>
                <a href="#" class="btn btn-secondary btn-large">Find Out More</a>
            </div>
		</section>

        <hr class="hr-1">

		<!-- Info Class -->
		<section class="items">
			<div class="card">
				<img src="images/sample_item_pics/offers/item1.jpg">
				<div class="card-body">
					<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
					<a href="#" class="btn btn-secondary">View Item</a>
				</div>
			</div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item2.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item3.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item4.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item5.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item6.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item7.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item8.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item9.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item10.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item11.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>
            <div class="card">
                <img src="images/sample_item_pics/offers/item12.jpg">
                <div class="card-body">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
                    <a href="#" class="btn btn-secondary">View Item</a>
                </div>
            </div>

		</section>
	</main>

	<!-- Footer -->
	<footer class="footer">
		<p>Copyright &copy; <a href="https://martynmasson.com" target="_blank">Martyn Masson</a></p>
		<p>Proudly powered by the <a href="https://trongate.io" target="_blank">Trongate Framework</a></p>
	</footer>
	<script src="<?= BASE_URL ?>js/side-nav.js"></script>
	<script src="<?= BASE_URL ?>js/dropdown.js"></script>
</body>
</html>

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
		<?= Modules::run('store_categories/_draw_categories') ?>

	<!-- Main Content -->
	<main class="main">
    <?= Template::display($data) ?>
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

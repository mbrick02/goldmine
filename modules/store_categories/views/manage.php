<div class="w3-row">
    <div class="w3-container">
        <h1><?= $headline ?></h1>
        <?= flashdata() ?>

        <p>
            <button onclick="openCategoryModal(0)" class="w3-button w3-medium primary">
                <i class="fa fa-pencil"></i> ADD NEW CATEGORY
            </button>
        </p>

        <div id="category-modal" class="w3-modal" style="padding-top: 7em;">
            <div class="w3-modal-content w3-animate-top w3-card-4" style="width: 30%;">
                <header class="w3-container primary w3-text-white">
                    <h4><i class="fa fa-pencil"></i> <span class="mdl-title"></span></h4>
                </header>
                <div class="w3-container">
                    <p id="errorMsg"></p>
                    <p>
                        <label class="w3-text-dark-grey"><b>Category Title</b></label>
                        <input type="text" id="category-title" class="w3-input w3-border w3-sand" placeholder="Enter Category Title">
                    </p>
                    <span class="w3-left">
                        <p class="modal-btns">
                            <button id="delete-category-btn" onclick="deleteCategory()" type="button" class="w3-button w3-small 3-white w3-border w3-red w3-hover-black">
                                <i class="fa fa-trash"></i> DELETE CATEGORY
                            </button> 
                        </p>
                    </span>
                    <span class="w3-right">
                        <p class="modal-btns">
                            <button onclick="document.getElementById('category-modal').style.display='none'" type="button" class="w3-button w3-small 3-white w3-border">CANCEL</button> 
                            <button onclick="submitCategory()" type="button" class="w3-button w3-small primary"><span class="mdl-title"></span></button>
                        </p>
                    </span>
                </div>
            </div>
        </div>


    <div id="dropzone"><?= Modules::run('store_categories/_draw_dropzone_content', $all_categories) ?></div>

    <script>
        var token = '<?= $token ?>';
    </script>
    <script src="<?= BASE_URL ?>store_categories_module/js/drag_and_drop.js"></script>

    <style>
        #dropzone {
            background-color: #eee;
            padding: 1em;
            font-size: 1.4em;
            border: 1px #ccc dashed;
        }

        .node {
            background-color: white;
            padding: 0.4em;
            margin: 0.5em;
            border: 3px skyblue solid;
        }

        #errorMsg {
            color: red;
        }
    </style>        


    </div>
</div>
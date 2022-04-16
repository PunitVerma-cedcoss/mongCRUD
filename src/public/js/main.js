// // meta counter
var metaCtr = isNaN($("#mCtr").val() - 1) ? 0 : $("#mCtr").val() - 1
// // variatoin counter
var varCtr = isNaN($("#vCtr").val() - 1) ? 0 : $("#vCtr").val() - 1
// handle meta click
$(".addMeta").click(function (e) {
    e.preventDefault();
    addMetaField()
});
// handle var click
$(".addVariations").click(function (e) {
    e.preventDefault();
    addVariationField()
});
// handle var add click
$("body").on("click", ".addVariationSets", function (e) {
    e.preventDefault();
    addVariationSetsField($(this))
});

// handle remove Meta fields
$("body").on("click", ".closeMeta", function () {
    $(this).parent().parent().remove()
    metaCtr--
});
// handle remove Variations fields
$("body").on("click", ".closeVariation", function () {
    $(this).parent().parent().remove()
    varCtr--
});

function addMetaField() {
    metaCtr++
    var m = `
    <div class="max-w-fit flex flex-col justify-center items-center">
        <div class="w-full">
            <ion-icon name="close-circle" class="closeMeta cursor-pointer text-2xl hover:text-neutral-600"></ion-icon>
        </div>
        <input type="text" class="rounded-md border-gray-200 shadow-sm text-gray-800 m-1" name="metaField${metaCtr}" placeholder="add Field" required>
        <input type="text" class="rounded-md border-gray-200 shadow-sm text-gray-800 m-1" name="metaValue${metaCtr}" placeholder="add Value" required>
    </div>
    `
    $(".meta").append(m)
}
function addVariationField() {
    varCtr++
    var m = `
    <div class="max-w-fit flex flex-col justify-center items-center">
        <div class="w-full">
            <ion-icon name="close-circle" class="closeVariation cursor-pointer text-2xl hover:text-neutral-600"></ion-icon>
        </div>
        <div class="p-1 flex flex flex-col varset items-center justify-center ml-8">
            <div class="w-full">
                <ion-icon name="add-circle" class="addVariationSets cursor-pointer text-2xl hover:text-neutral-600"></ion-icon>
            </div>
            <input type="text" class="rounded-md border-gray-200 shadow-sm text-gray-800 m-1" name="variationSubField${varCtr}[]" placeholder="Attribute name" required>
            <input type="text" class="rounded-md border-gray-200 shadow-sm text-gray-800 m-1" name="variationSubValue${varCtr}[]" placeholder="Attribute Value" required>
        </div>
        <input type="text" class="rounded-md border-gray-200 shadow-sm text-gray-800 m-1" name="variationPrice${varCtr}[]" placeholder="Price" required>
    </div>
    `
    $(".variations").append(m)
}

function addVariationSetsField(ref) {
    var fieldName = ref.parent().next().attr('name')
    if (fieldName.trim() == '') {
        fieldName = varCtr
    }
    else {
        fieldName = fieldName.substr(fieldName.length - 3, 1)
    }
    var m = `
    <div class="w-full">
        <ion-icon data="${fieldName}" name="add-circle" class="addVariationSets cursor-pointer text-2xl hover:text-neutral-600"></ion-icon>
    </div>
        <input type="text" class="rounded-md border-gray-200 shadow-sm text-gray-800 m-1" name="variationSubField${fieldName}[]" placeholder="Attribute name" required>
        <input type="text" class="rounded-md border-gray-200 shadow-sm text-gray-800 m-1" name="variationSubValue${fieldName}[]" placeholder="Attribute name" required>
    </div>
    `
    ref.parent().parent().append(m)
}


// handle modaal
$('.modaal-open').click(function (e) {
    e.preventDefault();
    // grab the id
    console.log($(".product_url").attr("src", "http://localhost:8080/products/details/" + $(this).attr("data")))
    $(".backdrop").removeClass("hidden")
});
$('.modaal-close').click(function (e) {
    e.preventDefault();
    $(".backdrop").addClass("hidden")
});
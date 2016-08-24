$(document).ready(function () {
    $(document).on('click', '.add_to_favorites_button', function(){
        var productId = $(this).val();
        var buttonId = this.getAttribute('id');

        $.ajax({
            url: Routing.generate('addFavoriteProduct', {'productId' : productId}),
            type: "POST",
            data: {'product_id' : this.getAttribute('id')},
            dataType: "json",
            success:
                function(result) {
                    document.getElementById(buttonId).innerHTML = "Produs adaugat cu success!"
                },
            error:
                function(result) {
                    console.log(result);
                    alert('Eroare la adaugarea produsului ca favorit!');
                }
        });
    });

    var amountScrolled = 300;

    $(window).scroll(function() {
        if ( $(window).scrollTop() > amountScrolled ) {
            $('a.back-to-top').fadeIn('slow');
        } else {
            $('a.back-to-top').fadeOut('slow');
        }
    });

    $('a.back-to-top').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 700);
        return false;
    });
});
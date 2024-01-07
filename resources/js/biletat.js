window.addEventListener('resize', equalizeCardHeights);
window.addEventListener('load', equalizeCardHeights);

function equalizeCardHeights(){
    var cardContainer=document.querySelector('.card-container');
    var cards=document.querySelectorAll('.card');

    var maxCardHeight=0;

    cards.forEach(function (card){
        card.style.height='auto';
        maxCardHeight=Math.max(maxCardHeight, card.offsetHeight);
    });

    cards.forEach(function (card){
        card.style.height=maxCardHeight+'px';
    });
}

let quantity = 0;


function showPurchaseModal() {
    $('#purchaseModal').modal('show');
}
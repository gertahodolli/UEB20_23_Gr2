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

var quantity=0;

function incrementQuantity(button){
    var quantityDisplay=button.parentElement.parentElement.querySelector('.quantity-display');
    var currentQuantity=parseInt(quantityDisplay.textContent);
    quantityDisplay.textContent=currentQuantity+1;
}

function decrementQuantity(button){
    var quantityDisplay = button.parentElement.parentElement.querySelector('.quantity-display');
    var currentQuantity = parseInt(quantityDisplay.textContent);
    if (currentQuantity > 0) {
        quantityDisplay.textContent = currentQuantity - 1;
    }
}

//function updateQuantityDisplay(){
//    document.getElementById('quantity-display').innerText=quantity;
//}

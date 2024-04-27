function togglemenu() {
    var bar = document.querySelector('.barcontent');
    var menu = document.querySelector('.menu');
    var sidebar = document.querySelector('.sidebar');
    if (sidebar&&sidebar.style.left=='0px') {
        toggleSidebar();
    }
    if (bar.style.left === '0px') {
        bar.style.left = '-250px';
        menu.src = '../images/icons/menu.svg';
        menu.alt = 'menu';
        menu.style.boxShadow = '0px 0px 10px 0px rgba(0, 0, 0, 0.5)';
        bar.style.boxShadow='none'
    } else {
        bar.style.left = '0';
        menu.src = '../images/icons/collapse.svg';
        menu.alt = 'collapse';
        menu.style.zIndex='4';
        bar.style.zIndex='3'; 
        menu.style.boxShadow = 'none';
        bar.style.boxShadow='5px 0px 5px 0px rgba(0, 0, 0, 0.2)'
    }
}
//toggles the search bar
function toggleSidebar() {
    var sidebar = document.querySelector('.sidebar');
    var toggleBtn = document.querySelector('.filter');

    if (sidebar.style.left=='0px') {
        sidebar.style.left = '-270px';
        sidebar.style.boxShadow='none';
        toggleBtn.style.boxShadow='0px 0px 10px 0px rgba(0, 0, 0, 0.5)';
        toggleBtn.src = '../images/icons/search.svg'; 
    } else {
        sidebar.style.left = '0px';
        sidebar.style.boxShadow='5px 0px 5px 0px rgba(0, 0, 0, 0.2)';
        toggleBtn.style.boxShadow='none';
        toggleBtn.src = '../images/icons/collapse.svg';
    }
}
function alu(operator, elementId) {
    var productId = document.getElementById(elementId);
    var subTotalElement = document.querySelector("." + elementId+".subTotal");
    var rateElement = document.querySelector(".rate." + elementId);

    if (productId && rateElement) {
        // Use Promises to handle the asynchronous response
        cart(elementId, operator)
            .then(async function (rate) {
                const qty = await cart(elementId, 'q');
                return { rate: rate, qty: qty };
            })
            .then(function (result) {
                var rate = parseFloat(result.rate);
                var qty = result.qty;

                rateElement.innerText = rate.toFixed(2);
                productId.innerText = qty;

                if (subTotalElement) {
                    subTotalElement.innerText = rate * qty;
                    set_total();
                }
            })
            .catch(function (error) {
                console.error('Error in cart function:', error);
            });
    } else {
        console.error("Element not found");
    }
}

function cart(elementId, operator) {
    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.responseType = 'json';

        var url = '../ajax/cart.php?id=' + encodeURIComponent(elementId.slice(1)) + '&f=' + encodeURIComponent(operator);

        xhr.open('GET', url, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Parse the JSON response and resolve the Promise
                    var response = JSON.parse(xhr.response);
                    resolve(response);
                } else {
                    // Reject the Promise with an error message
                    reject('Error in AJAX request. Status: ' + xhr.status);
                }
            }
        };

        // Send the request
        xhr.send();
    });
}
function confirmSignOut() {
    // Display a confirmation dialog
    var result = confirm("Are you sure you want to sign out?");
    
    // Check the user's response
    if (result) {
        // If the user clicks "OK", perform sign out action
        window.location.href='signout.php';
        // Perform sign out action here, like redirecting to a sign out page or clearing session data
    } else {
        // If the user clicks "Cancel", do nothing
        alert("Sign out canceled.");
    }
}
function del(identifier){
    // Get a reference to the elements with the specified class name
    var elementsToRemove = document.getElementsByClassName(identifier);
    cart(identifier,'del')
    notification(getFirstWord(elementsToRemove[0].innerText)+" has been deleted");

    // Remove all elements with the specified class
    while (elementsToRemove.length > 0) {
        elementsToRemove[0].remove();
    }
    set_total();
}
function notification(msg) {
    var newDiv = document.createElement('div');
    newDiv.innerHTML = msg;
    newDiv.classList.add('alert');
    document.body.appendChild(newDiv);
    setTimeout(function () {
        document.body.removeChild(newDiv);
    }, 1500);
}
function getFirstWord(inputString) {
    // Trim leading and trailing spaces and then split the string into an array of words
    var words = inputString.trim().split(/\s+/);

    // Return the first word (or an empty string if there are no words)
    return words.length > 0 ? words[0] : '';
}
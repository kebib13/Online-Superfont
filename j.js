function set_total(){
    var elements = document.getElementsByClassName('subTotal');
    // Initialize a variable to store the sum
    var sum = 0;
    // Loop through each element and extract the number from its text content
    for (var i = 0; i < elements.length; i++) {
        // Extract the number using a regular expression
        var number = parseInt(elements[i].innerText.match(/[\d.]+/));

        // Add the extracted number to the sum (if it's a valid number)
        if (!isNaN(number)) {
            sum += number;
        }
    }
    if(document.getElementById('g_total')){
        document.getElementById('g_total').innerText=sum;
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
                console.log('Received rate:', result.rate);
                console.log('Operator:', operator);
                console.log('Received qty:', result.qty);

                rateElement.innerText = rate;
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

        var url = 'data_entry/ajax.php?id=' + encodeURIComponent(elementId.slice(1)) + '&f=' + encodeURIComponent(operator);

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
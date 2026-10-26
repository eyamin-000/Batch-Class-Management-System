document.addEventListener('submit', function(e) {
    e.preventDefault();
    
    let form = e.target;
    let action = '';
    
    if(form.id === 'signupForm') action = 'signup';
    if(form.id === 'loginForm') action = 'login';
    
    if(!action) return;

    let formData = new FormData(form);
    let messageDiv = document.getElementById('message');
    
    console.log("Submitting " + action + "...");

    fetch('controllers/AuthController.php?action=' + action, {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        messageDiv.style.display = 'block';
        messageDiv.innerText = data.message;
        
        if(data.status === 'success') {
            messageDiv.className = 'msg-success';
            
            if(action === 'signup') {
                setTimeout(() => { 
                    window.location.href = 'index.php'; 
                }, 2000);
            } else {
                window.location.href = 'index.php';
            }
        } else {
            messageDiv.className = 'msg-error';
        }
    })
    .catch(err => {
        console.error("Error:", err);
        messageDiv.style.display = 'block';
        messageDiv.innerText = "Something went wrong. Check Database connection!";
    });
});

// Dashboard quick actions handled via AJAX (future use)
function openAction(actionType) {
    console.log("Opening " + actionType + " form...");

}
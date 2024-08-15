document.addEventListener('DOMContentLoaded', function() {
    const dataDiv = document.getElementById('data');

    fetch('data.php')
        .then(response => response.text())
        .then(data => {
            // Simple XSS prevention by encoding
            const encodedData = data.replace(/</g, '&lt;').replace(/>/g, '&gt;');
            dataDiv.innerHTML = encodedData;
        })
        .catch(error => console.error('Error:', error));
});

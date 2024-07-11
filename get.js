async function getAccountData() {
    const gameName = document.getElementById('gameName').value;
    const tagLine = document.getElementById('tagLine').value;
    try {
        const response = await fetch(`call_API.php?gameName=${gameName}&tagLine=${tagLine}`);
        const data = await response.json();
        if (!response.ok) {
            throw new Error(data.error || 'Unknown error occurred');
        }
        document.getElementById('output').innerText = JSON.stringify(data, null, 2);
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        document.getElementById('output').innerText = 'Error: ' + error.message;
    }
}

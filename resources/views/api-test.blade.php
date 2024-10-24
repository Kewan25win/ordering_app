<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 10px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            height: 100px;
            margin-top: 10px;
        }
        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        pre {
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ddd;
            overflow-x: auto;
        }
    </style>
</head>
<body>

<h1>API Test Interface</h1>

<!-- Form for API requests -->
<form id="api-form">
    <label for="method">Method:</label>
    <select id="method" name="method">
        <option value="GET">GET</option>
        <option value="POST">POST</option>
        <option value="PUT">PUT</option>
        <option value="DELETE">DELETE</option>
    </select>
    
    <label for="endpoint">Endpoint:</label>
    <input type="text" id="endpoint" name="endpoint" placeholder="/api/brands" required>

    <label for="body">Request Body (JSON):</label>
    <textarea id="body" name="body"></textarea>

    <button type="submit">Send Request</button>
</form>

<h2>Response</h2>
<pre id="response"></pre>

<script>
    document.getElementById('api-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const method = document.getElementById('method').value;
        const endpoint = document.getElementById('endpoint').value;
        const body = document.getElementById('body').value;

        const responseElement = document.getElementById('response');
        responseElement.textContent = 'Loading...';

        try {
            const response = await fetch(endpoint, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                },
                body: method !== 'GET' ? body : null,
            });

            const data = await response.json();
            responseElement.textContent = JSON.stringify(data, null, 2);
        } catch (error) {
            responseElement.textContent = 'Error: ' + error.message;
        }
    });
</script>

</body>
</html>